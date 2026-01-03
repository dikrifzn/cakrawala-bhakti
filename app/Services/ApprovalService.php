<?php

namespace App\Services;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ApprovalService
{
    /**
     * Generate approval PDF (without signature)
     */
    public static function generateApprovalPdf(Booking $booking, ?string $signature = null, ?string $approvedDate = null, ?string $approvedIp = null): string
    {
        $total = $booking->details->sum('price') ?? 0;

        $html = view('pdf.approval', [
            'booking' => $booking,
            'total' => $total,
            'signature' => $signature,
            'approvedDate' => $approvedDate,
            'approvedIp' => $approvedIp,
        ])->render();

        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4')
            ->setOption('enable_php', true)
            ->setOption('enable_javascript', true);

        return $pdf->output();
    }

    /**
     * Save approval PDF with signature
     */
    public static function saveApprovalPdf(Booking $booking, string $signaturePath): string
    {
        // Convert signature file to base64 for embedding in PDF
        $signatureFullPath = storage_path('app/public/'.$signaturePath);
        if (! file_exists($signatureFullPath)) {
            throw new \Exception('Signature file not found: '.$signatureFullPath);
        }

        // Detect MIME type from file extension
        $ext = strtolower(pathinfo($signatureFullPath, PATHINFO_EXTENSION));
        $mimeType = $ext === 'jpg' || $ext === 'jpeg' ? 'image/jpeg' : 'image/png';

        $signatureBase64 = 'data:'.$mimeType.';base64,'.base64_encode(file_get_contents($signatureFullPath));

        $total = $booking->details->sum('price') ?? 0;
        $approvedDate = now()->format('d F Y H:i:s');
        $approvedIp = request()?->ip() ?? '0.0.0.0';

        $html = view('pdf.approval', [
            'booking' => $booking,
            'total' => $total,
            'signature' => $signatureBase64,
            'approvedDate' => $approvedDate,
            'approvedIp' => $approvedIp,
        ])->render();

        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4')
            ->setOption('enable_php', true)
            ->setOption('enable_javascript', true);

        $filename = 'approval_'.$booking->id.'_'.now()->timestamp.'.pdf';
        $path = 'approval_files/'.$filename;

        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }

    /**
     * Preview approval PDF (without signature, for client preview)
     */
    public static function previewApprovalPdf(Booking $booking)
    {
        return self::generateApprovalPdf($booking);
    }
}
