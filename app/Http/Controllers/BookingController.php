<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\ApprovalService;
use App\Filament\Resources\Bookings\BookingResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BookingController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        return view('pages.booking.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'   => 'required|string|max:255',
            'customer_email'  => 'required|email|max:255',
            'customer_phone'  => 'required|string|max:50',

            'proposal'        => 'required|file|mimes:pdf,doc,docx|max:5120',

            'event_name'      => 'required|string|max:255',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'location'        => 'required|string|max:255',
            'notes'           => 'nullable|string',
        ]);

        $proposalPath = $request->file('proposal')->store(
            'proposals',
            'public'
        );

        $booking = Booking::create([
            'user_id'          => Auth::id(),

            'customer_name'    => $validated['customer_name'],
            'customer_email'   => $validated['customer_email'],
            'customer_phone'   => $validated['customer_phone'],

            'proposal_file'    => $proposalPath,

            'event_name'       => $validated['event_name'],
            'start_date'       => $validated['start_date'],
            'end_date'         => $validated['end_date'],
            'location'         => $validated['location'],

            'notes'            => $validated['notes'] ?? null,

            'admin_status'     => 'review',
            'customer_status'  => 'submitted',
        ]);

        // Dispatch notification to admins
        $adminUsers = \App\Models\User::where('role', 'admin')->orWhere('role', 'manager')->get();
        foreach ($adminUsers as $admin) {
            $admin->notify(new \App\Notifications\BookingCreatedNotification($booking));
        }

        return redirect('/booking/success');
    }

    /**
     * Simple redirects for admin helper routes.
     */
    public function adminReview(Booking $booking)
    {
        return Redirect::to(BookingResource::getUrl('edit', ['record' => $booking]));
    }

    public function detailsInputView(Booking $booking)
    {
        return Redirect::to(BookingResource::getUrl('edit', ['record' => $booking]));
    }

    public function uploadView(Booking $booking)
    {
        return Redirect::to(BookingResource::getUrl('edit', ['record' => $booking]));
    }

    /**
     * Admin: approve initial submission (moves to detail_sent).
     */
    public function adminApprove(Booking $booking)
    {
        $this->authorize('manageWorkflow', $booking);

        $booking->update(['admin_status' => 'detail_sent', 'customer_status' => 'submitted']);

        // Notify customer about status change
        if ($booking->user) {
            $booking->user->notify(new \App\Notifications\BookingStatusUpdatedNotification($booking, 'Booking Anda telah disetujui. Detail layanan akan segera dikirimkan.'));
        }

        return Redirect::back()->with('success', 'Booking disetujui. Silakan kirim rincian ke client.');
    }

    /**
     * Admin: reject booking.
     */
    public function adminReject(Booking $booking)
    {
        $this->authorize('manageWorkflow', $booking);

        $booking->update(['admin_status' => 'rejected', 'customer_status' => 'rejected']);

        // Notify customer about rejection
        if ($booking->user) {
            $booking->user->notify(new \App\Notifications\BookingStatusUpdatedNotification($booking, 'Booking Anda telah ditolak.'));
        }

        return Redirect::back()->with('error', 'Booking ditolak.');
    }

    /**
     * Admin: send service details to customer.
     */
    public function sendDetailsToClient(Request $request, Booking $booking)
    {
        $this->authorize('manageWorkflow', $booking);

        $validated = $request->validate([
            'details' => 'required|array|min:1',
            'details.*.service_name' => 'required|string|max:255',
            'details.*.price' => 'required|numeric|min:0',
            'details.*.notes' => 'nullable|string',
        ]);

        $booking->details()->delete();
        foreach ($validated['details'] as $detail) {
            $booking->details()->create($detail);
        }

        $booking->update([
            'admin_status' => 'detail_sent',
            'customer_status' => 'submitted',
        ]);

        return Redirect::route('booking.client.details', $booking)->with('success', 'Rincian jasa dikirim ke client.');
    }

    /**
     * Customer: view details.
     */
    public function clientViewDetails(Booking $booking)
    {
        $this->authorize('view', $booking);

        // Allow access if admin sent details or approved final document
        abort_unless(in_array($booking->admin_status, ['detail_sent', 'final_approved', 'on_progress', 'finished']), 404);

        // Reload from database with relations to get latest data
        $booking = Booking::with(['details', 'tasks', 'user'])->findOrFail($booking->id);

        return view('pages.profile.booking-detail', ['booking' => $booking]);
    }

    /**
     * Customer: approve details.
     */
    public function clientApproveDetails(Booking $booking)
    {
        $this->authorize('approveDetails', $booking);

        abort_unless($booking->admin_status === 'detail_sent', 404);

        $booking->update(['customer_status' => 'detail_approved']);

        return Redirect::route('booking.client.details', $booking)->with('success', 'Rincian disetujui. Menunggu lembar persetujuan dari admin.');
    }

    /**
     * Customer: reject details.
     */
    public function clientRejectDetails(Booking $booking)
    {
        abort_unless($booking->admin_status === 'detail_sent', 404);

        $booking->update([
            'admin_status' => 'rejected',
            'customer_status' => 'rejected',
        ]);

        return Redirect::route('booking.client.details', $booking)->with('error', 'Anda menolak penawaran ini.');
    }

    /**
     * Preview approval PDF (unsigned) for client.
     */
    public function previewApproval(Booking $booking)
    {
        $pdfContent = ApprovalService::previewApprovalPdf($booking);

        return new StreamedResponse(function () use ($pdfContent) {
            echo $pdfContent;
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="approval_preview.pdf"',
        ]);
    }

    /**
     * Preview signed approval PDF inline (with signature).
     */
    public function previewSignedApproval(Booking $booking)
    {
        abort_unless($booking->approval_file && Storage::disk('public')->exists($booking->approval_file), 404);

        $pdfContent = Storage::disk('public')->get($booking->approval_file);

        return new StreamedResponse(function () use ($pdfContent) {
            echo $pdfContent;
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="approval_' . $booking->id . '.pdf"',
        ]);
    }

    /**
     * Show signature upload form.
     */
    public function signatureUploadForm(Booking $booking)
    {
        // Only allow signature upload when admin_status is final_approved
        abort_unless($booking->admin_status === 'final_approved', 404);

        return view('pages.profile.booking-detail', ['booking' => $booking]);
    }

    /**
     * Customer uploads signature; generate signed PDF.
     */
    public function uploadSignature(Request $request, Booking $booking)
    {
        $this->authorize('uploadSignature', $booking);

        // Guard: must be final_approved status
        abort_unless($booking->admin_status === 'final_approved', 404);

        $request->validate([
            'signature' => 'required|file|mimes:png,jpg,jpeg|max:5120',
        ]);

        $signaturePath = $request->file('signature')->store('signatures', 'public');
        \Log::info('Signature stored at: ' . $signaturePath);
        
        $signedPath = ApprovalService::saveApprovalPdf($booking, $signaturePath);
        \Log::info('Signed PDF saved at: ' . $signedPath);

        $booking->update([
            'signature_file' => $signaturePath,
            'approval_file' => $signedPath,
            'customer_status' => 'final_signed',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'approval_ip' => $request->ip(),
        ]);
        
        \Log::info('Booking updated - Customer Status: final_signed, Approval File: ' . $signedPath);

        return Redirect::route('booking.client.details', $booking)->with('success', 'Tanda tangan diterima. Menunggu admin memulai pengerjaan.');
    }

    /**
     * Client final approval (fallback).
     */
    public function clientFinalApprove(Booking $booking)
    {
        $booking->update(['admin_status' => 'final_approved']);

        return Redirect::route('booking.client.details', $booking);
    }

    /**
     * Download stored file securely.
     */
    public function downloadFile(Booking $booking, string $type)
    {
        $this->authorize('view', $booking);

        $allowed = ['proposal_file', 'approval_file', 'signature_file'];
        abort_unless(in_array($type, $allowed, true), 404);

        $path = $booking->{$type};
        abort_unless($path && Storage::disk('public')->exists($path), 404);

        $fullPath = Storage::disk('public')->path($path);
        $mimeType = Storage::disk('public')->mimeType($path);

        if (request()->boolean('inline')) {
            return response()->file($fullPath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="'.basename($path).'"',
            ]);
        }

        return Storage::disk('public')->download($path, basename($path));
    }
}
