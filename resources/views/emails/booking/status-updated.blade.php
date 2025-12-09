<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status Booking - Cakrawala Bhakti</title>
</head>
<body style="margin:0; padding:0; background:#f5f5f5; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f5f5; padding:40px 20px;">
    <tr>
        <td align="center">
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 6px rgba(0,0,0,0.1);">

                <!-- Header -->
                <tr>
                    <td style="background:linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding:40px 30px; text-align:center;">
                        <img src="{{ asset('img/logo-white.png') }}" width="80" alt="Cakrawala Bhakti Logo" 
                             style="display:block; margin:0 auto 20px auto;">
                        <h1 style="margin:0; font-size:28px; font-weight:700; color:#ffffff; letter-spacing:0.5px;">
                            Status Booking Diperbarui
                        </h1>
                        <p style="margin:10px 0 0 0; font-size:14px; color:#ffffff; opacity:0.95;">
                            Ada perubahan status pada pesanan Anda
                        </p>
                    </td>
                </tr>

                <!-- Status Badge -->
                <tr>
                    <td style="padding:30px 30px 20px 30px; text-align:center;">
                        <div style="display:inline-block; background:#fef3c7; border:2px dashed #fbbf24; border-radius:8px; padding:12px 24px;">
                            <span style="font-size:12px; color:#92400e; font-weight:600; text-transform:uppercase; letter-spacing:1px;">ID Booking</span><br>
                            <span style="font-size:24px; color:#b45309; font-weight:700;">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </td>
                </tr>

                <!-- New Status -->
                <tr>
                    <td style="padding:0 30px 30px 30px; text-align:center;">
                        @if($booking->status === 'approved')
                            <div style="background:#dbeafe; border-radius:12px; padding:24px;">
                                <div style="font-size:48px; margin-bottom:10px;">✅</div>
                                <h2 style="margin:0 0 10px 0; font-size:24px; font-weight:700; color:#1e40af;">Pesanan Disetujui!</h2>
                                <p style="margin:0; font-size:14px; color:#1e3a8a; line-height:1.6;">
                                    Selamat! Pesanan Anda telah disetujui. Tim kami akan segera menghubungi Anda untuk langkah selanjutnya.
                                </p>
                            </div>
                        @elseif($booking->status === 'rejected')
                            <div style="background:#fee2e2; border-radius:12px; padding:24px;">
                                <div style="font-size:48px; margin-bottom:10px;">❌</div>
                                <h2 style="margin:0 0 10px 0; font-size:24px; font-weight:700; color:#991b1b;">Pesanan Ditolak</h2>
                                <p style="margin:0; font-size:14px; color:#7f1d1d; line-height:1.6;">
                                    Mohon maaf, pesanan Anda tidak dapat kami proses. Silakan hubungi kami untuk informasi lebih lanjut.
                                </p>
                            </div>
                        @elseif($booking->status === 'finished')
                            <div style="background:#dcfce7; border-radius:12px; padding:24px;">
                                <div style="font-size:48px; margin-bottom:10px;">🎉</div>
                                <h2 style="margin:0 0 10px 0; font-size:24px; font-weight:700; color:#065f46;">Acara Selesai!</h2>
                                <p style="margin:0; font-size:14px; color:#047857; line-height:1.6;">
                                    Terima kasih telah mempercayai Cakrawala Bhakti. Kami berharap acara Anda berjalan dengan sukses!
                                </p>
                            </div>
                        @else
                            <div style="background:#fef3c7; border-radius:12px; padding:24px;">
                                <div style="font-size:48px; margin-bottom:10px;">📋</div>
                                <h2 style="margin:0 0 10px 0; font-size:24px; font-weight:700; color:#92400e;">Status: {{ ucfirst($booking->status) }}</h2>
                                <p style="margin:0; font-size:14px; color:#78350f; line-height:1.6;">
                                    Pesanan Anda telah diperbarui. Silakan cek detail di bawah.
                                </p>
                            </div>
                        @endif
                    </td>
                </tr>

                <!-- Booking Details Summary -->
                <tr>
                    <td style="padding:0 30px 30px 30px;">
                        <div style="background:#f9fafb; border-radius:8px; padding:20px;">
                            <h3 style="margin:0 0 15px 0; font-size:18px; font-weight:700; color:#1f2937;">📋 Ringkasan Pesanan</h3>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding:8px 0; font-size:14px; color:#6b7280;">Jenis Acara:</td>
                                    <td style="padding:8px 0; font-size:14px; color:#111827; font-weight:600; text-align:right;">
                                        {{ $booking->eventType->name ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; font-size:14px; color:#6b7280;">Nama Acara:</td>
                                    <td style="padding:8px 0; font-size:14px; color:#111827; font-weight:600; text-align:right;">
                                        {{ $booking->event_name ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; font-size:14px; color:#6b7280;">Tanggal:</td>
                                    <td style="padding:8px 0; font-size:14px; color:#111827; font-weight:600; text-align:right;">
                                        {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; font-size:14px; color:#6b7280;">Lokasi:</td>
                                    <td style="padding:8px 0; font-size:14px; color:#111827; font-weight:600; text-align:right;">
                                        {{ $booking->location ?? '-' }}
                                    </td>
                                </tr>
                                <tr style="border-top:2px solid #e5e7eb;">
                                    <td style="padding:12px 0 0 0; font-size:15px; color:#92400e; font-weight:700;">Total Harga:</td>
                                    <td style="padding:12px 0 0 0; font-size:16px; color:#b45309; font-weight:700; text-align:right;">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>

                <!-- Contact Info -->
                <tr>
                    <td style="padding:0 30px 30px 30px;">
                        <div style="background:#eff6ff; border-radius:8px; padding:20px; border-left:4px solid #3b82f6;">
                            <h3 style="margin:0 0 10px 0; font-size:16px; font-weight:700; color:#1e40af;">💬 Butuh Bantuan?</h3>
                            <p style="margin:0; font-size:14px; color:#1e3a8a; line-height:1.6;">
                                Jika ada pertanyaan atau membutuhkan informasi lebih lanjut, jangan ragu untuk menghubungi kami:
                            </p>
                            <p style="margin:10px 0 0 0; font-size:14px; color:#1e3a8a;">
                                📧 <strong>Email:</strong> info@cakrawalabhakti.com<br>
                                📱 <strong>Telepon:</strong> +62 812-3456-7890
                            </p>
                        </div>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#fafafa; padding:30px; text-align:center; border-top:1px solid #e5e7eb;">
                        <img src="{{ asset('img/logo-black.png') }}" width="100" alt="Cakrawala Bhakti" 
                             style="display:block; margin:0 auto 15px auto;">
                        <h3 style="margin:0 0 10px 0; font-size:18px; font-weight:700; color:#1f2937;">Cakrawala Bhakti Event Organizer</h3>
                        <p style="margin:0 0 5px 0; font-size:14px; color:#6b7280;">
                            Mewujudkan Acara Anda Jadi Momen Tak Terlupakan
                        </p>
                        <div style="margin-top:20px; padding-top:20px; border-top:1px solid #e5e7eb;">
                            <p style="margin:0; font-size:12px; color:#9ca3af;">
                                © {{ date('Y') }} Cakrawala Bhakti. All rights reserved.
                            </p>
                            <p style="margin:5px 0 0 0; font-size:11px; color:#9ca3af;">
                                Email ini dikirim otomatis, mohon tidak membalas langsung ke email ini.
                            </p>
                        </div>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
