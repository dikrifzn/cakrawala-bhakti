<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookingController extends Controller
{
    public function index()
    {
        return view('pages.order.index');
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

        return redirect('/booking/success');
    }
    // ADMIN: Review proposal event
    public function adminReview($id)
    {
        $booking = Booking::findOrFail($id);
        // Render admin review blade for legacy/admin users
        return view('admin.booking.review', compact('booking'));
    }

    // ADMIN: Show input rincian blade
    public function detailsInputView($id)
    {
        $booking = Booking::findOrFail($id);
        return view('admin.booking.details', compact('booking'));
    }

    // ADMIN: Show upload gantt blade
    public function uploadView($id)
    {
        $booking = Booking::findOrFail($id);
        return view('admin.booking.upload', compact('booking'));
    }

    // ADMIN: Approve proposal event
    public function adminApprove(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        // Update status admin dan simpan catatan jika ada
        $booking->admin_status = 'approved';
        $booking->save();
        // Redirect to Filament review page
        return redirect()->to(\App\Filament\Resources\Bookings\BookingResource::getUrl('review', ['record' => $booking->id]))->with('success', 'Proposal disetujui, silakan input rincian jasa.');
    }

    // ADMIN: Reject proposal event
    public function adminReject(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->admin_status = 'rejected';
        $booking->save();
        // Notifikasi ke client bisa ditambahkan di sini
        return redirect()->to(\App\Filament\Resources\Bookings\BookingResource::getUrl('review', ['record' => $booking->id]))->with('error', 'Proposal ditolak.');
    }

    // ADMIN: Kirim rincian jasa ke client
    public function sendDetailsToClient(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->admin_status !== 'approved') {
            return back()->with('error', 'Status booking tidak valid untuk mengirim rincian.');
        }
        $request->validate([
            'details' => 'required|array',
            'details.*.service_name' => 'required|string|max:255',
            'details.*.price' => 'required|numeric|min:0',
            'details.*.notes' => 'nullable|string',
        ]);
        $booking->details()->delete();
        $total = 0;
        foreach ($request->details as $detail) {
            $booking->details()->create($detail);
            $total += $detail['price'];
        }
        $booking->admin_status = 'details_sent';
        // set customer status to 'review' so client can approve/reject
        $booking->customer_status = 'review';
        $booking->save();
        // TODO: Notifikasi ke client (email/alert)
        return redirect()->to(\App\Filament\Resources\Bookings\BookingResource::getUrl('review', ['record' => $booking->id]))->with('success', 'Rincian jasa dikirim ke client.');
    }

    // CLIENT: Lihat rincian jasa dari admin
    public function clientViewDetails($id)
    {
        $booking = Booking::findOrFail($id);
        // Tampilkan rincian jasa, harga, dsb ke client
        return view('pages.order.details', compact('booking'));
    }

    // Secure file download for booking attachments
    public function downloadFile(Request $request, $id, $type)
    {
        $allowed = ['proposal_file', 'gantt_chart', 'approval_file'];
        if (! in_array($type, $allowed)) {
            abort(404);
        }

        $booking = Booking::findOrFail($id);
        $path = $booking->{$type};
        if (! $path) {
            abort(404);
        }

        $disk = Storage::disk('public');
        if (! $disk->exists($path)) {
            abort(404);
        }

        // If ?inline=1 is present, attempt to display the file inline (PDF preview)
        if ($request->query('inline')) {
            $fullPath = storage_path('app/public/' . $path);
            if (! file_exists($fullPath)) {
                abort(404);
            }
            return response()->file($fullPath);
        }

        return $disk->download($path);
    }

    // CLIENT: Approve rincian jasa
    public function clientApproveDetails(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        // Client approving the service details (not final approval of gantt)
        $booking->customer_status = 'details_approved';
        $booking->save();
        // Notifikasi ke admin bisa ditambahkan di sini
        return redirect()->route('profile.booking-detail', $booking->id)->with('success', 'Rincian jasa disetujui. Tunggu admin mengirim jadwal pengerjaan.');
    }

    // CLIENT: Reject rincian jasa
    public function clientRejectDetails(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->customer_status = 'rejected';
        $booking->save();
        // Notifikasi ke admin bisa ditambahkan di sini
        return redirect()->route('profile.booking-detail', $booking->id)->with('error', 'Rincian jasa ditolak.');
    }

    // ADMIN: Upload Gantt chart & lembar persetujuan
    public function uploadGantt(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->admin_status !== 'details_sent') {
            return back()->with('error', 'Status booking tidak valid untuk upload gantt chart.');
        }
        if ($booking->customer_status !== 'details_approved') {
            return back()->with('error', 'Client belum menyetujui rincian jasa sehingga gantt tidak bisa diupload.');
        }
        $request->validate([
            'gantt_chart' => 'required|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'approval_file' => 'required|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'pic_contact' => 'required|string|max:255',
        ]);
        $ganttPath = $request->file('gantt_chart')->store('gantt_charts', 'public');
        $approvalPath = $request->file('approval_file')->store('approval_files', 'public');
        $booking->gantt_chart = $ganttPath;
        $booking->approval_file = $approvalPath;
        $booking->pic_contact = $request->pic_contact;
        $booking->admin_status = 'gantt_uploaded';
        $booking->save();
        // TODO: Notifikasi ke client (email/alert)
        return redirect()->to(\App\Filament\Resources\Bookings\BookingResource::getUrl('review', ['record' => $booking->id]))->with('success', 'Gantt chart & lembar persetujuan diupload.');
    }

    // CLIENT: Final approval (setujui lembar persetujuan)
    public function clientFinalApprove(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->customer_status = 'final_approved';
        $booking->save();
        // Notifikasi ke admin bisa ditambahkan di sini
        return redirect()->route('profile.booking-detail', $booking->id)->with('success', 'Booking dikonfirmasi! Hubungi PIC kami untuk melanjutkan proses.');
    }
}
