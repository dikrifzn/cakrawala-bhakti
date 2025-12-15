<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Booking - Cakrawala Bhakti</title>
</head>
<body style="margin:0; padding:0; background:#f5f5f5; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f5f5; padding:40px 20px;">
    <tr>
        <td align="center">
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 6px rgba(0,0,0,0.1);">

                <!-- Header with Logo and Brand -->
                <tr>
                    <td style="background:linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); padding:40px 30px; text-align:center;">
                        <img src="{{ asset('img/logo-white.png') }}" width="80" alt="Cakrawala Bhakti Logo" 
                             style="display:block; margin:0 auto 20px auto;">
                        <h1 style="margin:0; font-size:28px; font-weight:700; color:#ffffff; letter-spacing:0.5px;">
                            Terima Kasih Atas Pemesanan Anda!
                        </h1>
                        <p style="margin:10px 0 0 0; font-size:14px; color:#ffffff; opacity:0.95;">
                            Pesanan Anda telah kami terima dan sedang diproses
                        </p>
                    </td>
                </tr>

                <!-- Booking ID Badge -->
                <tr>
                    <td style="padding:30px 30px 20px 30px; text-align:center;">
                        <div style="display:inline-block; background:#fef3c7; border:2px dashed #fbbf24; border-radius:8px; padding:12px 24px;">
                            <span style="font-size:12px; color:#92400e; font-weight:600; text-transform:uppercase; letter-spacing:1px;">ID Booking</span><br>
                            <span style="font-size:24px; color:#b45309; font-weight:700;">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </td>
                </tr>

                <!-- Status Badge -->
                <tr>
                    <td style="padding:0 30px 30px 30px; text-align:center;">
                        <span style="display:inline-block; background:#fef9c3; color:#854d0e; padding:8px 20px; border-radius:20px; font-size:13px; font-weight:600;">
                            📋 Status: {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                </tr>

                <!-- Event Information Section -->
                <tr>
                    <td style="padding:0 30px 30px 30px;">
                        <div style="background:#f9fafb; border-radius:8px; padding:20px; border-left:4px solid #fbbf24;">
                            <h2 style="margin:0 0 15px 0; font-size:18px; font-weight:700; color:#1f2937;">
                                📅 Detail Acara
                            </h2>
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
                                    <td style="padding:8px 0; font-size:14px; color:#6b7280;">Tanggal Mulai:</td>
                                    <td style="padding:8px 0; font-size:14px; color:#111827; font-weight:600; text-align:right;">
                                        {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; font-size:14px; color:#6b7280;">Tanggal Selesai:</td>
                                    <td style="padding:8px 0; font-size:14px; color:#111827; font-weight:600; text-align:right;">
                                        {{ $booking->end_date ? \Carbon\Carbon::parse($booking->end_date)->format('d M Y') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; font-size:14px; color:#6b7280;">Durasi:</td>
                                    <td style="padding:8px 0; font-size:14px; color:#111827; font-weight:600; text-align:right;">
                                        {{ $booking->total_days ?? 1 }} hari
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; font-size:14px; color:#6b7280;">Lokasi:</td>
                                    <td style="padding:8px 0; font-size:14px; color:#111827; font-weight:600; text-align:right;">
                                        {{ $booking->location ?? '-' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>

                <!-- Customer Information -->
                <tr>
                    <td style="padding:0 30px 30px 30px;">
                        <div style="background:#f9fafb; border-radius:8px; padding:20px; border-left:4px solid #10b981;">
                            <h2 style="margin:0 0 15px 0; font-size:18px; font-weight:700; color:#1f2937;">
                                👤 Informasi Pemesan
                            </h2>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding:8px 0; font-size:14px; color:#6b7280;">Nama:</td>
                                    <td style="padding:8px 0; font-size:14px; color:#111827; font-weight:600; text-align:right;">
                                        {{ $booking->customer_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; font-size:14px; color:#6b7280;">Email:</td>
                                    <td style="padding:8px 0; font-size:14px; color:#111827; font-weight:600; text-align:right;">
                                        {{ $booking->customer_email }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; font-size:14px; color:#6b7280;">Telepon:</td>
                                    <td style="padding:8px 0; font-size:14px; color:#111827; font-weight:600; text-align:right;">
                                        {{ $booking->customer_phone ?? '-' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>

                <!-- Services Table -->
                <tr>
                    <td style="padding:0 30px 30px 30px;">
                        <h2 style="margin:0 0 15px 0; font-size:18px; font-weight:700; color:#1f2937;">
                            🎯 Layanan yang Dipilih
                        </h2>
                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; border-radius:8px; overflow:hidden;">
                            <thead>
                                <tr style="background:#fbbf24;">
                                    <th style="padding:14px; text-align:left; font-size:13px; font-weight:700; color:#ffffff; text-transform:uppercase; letter-spacing:0.5px;">Layanan</th>
                                    <th style="padding:14px; text-align:center; font-size:13px; font-weight:700; color:#ffffff; text-transform:uppercase; letter-spacing:0.5px;">Qty</th>
                                    <th style="padding:14px; text-align:right; font-size:13px; font-weight:700; color:#ffffff; text-transform:uppercase; letter-spacing:0.5px;">Harga</th>
                                    <th style="padding:14px; text-align:right; font-size:13px; font-weight:700; color:#ffffff; text-transform:uppercase; letter-spacing:0.5px;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $grandTotal = 0; @endphp
                                @foreach($booking->services as $service)
                                    @php
                                        $price = $service->pivot->price ?? $service->price ?? 0;
                                        $quantity = $service->pivot->quantity ?? 1;
                                        $subtotal = $price * $quantity;
                                        $grandTotal += $subtotal;
                                    @endphp
                                    <tr style="border-bottom:1px solid #e5e7eb;">
                                        <td style="padding:14px; font-size:14px; color:#374151;">
                                            <strong>{{ $service->service_name }}</strong>
                                        </td>
                                        <td style="padding:14px; font-size:14px; color:#6b7280; text-align:center;">{{ $quantity }}</td>
                                        <td style="padding:14px; font-size:14px; color:#6b7280; text-align:right;">Rp {{ number_format($price, 0, ',', '.') }}</td>
                                        <td style="padding:14px; font-size:14px; color:#111827; font-weight:600; text-align:right;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="background:#fef3c7;">
                                    <td colspan="3" style="padding:16px; font-size:16px; font-weight:700; color:#92400e; text-align:right;">Total Harga:</td>
                                    <td style="padding:16px; font-size:18px; font-weight:700; color:#b45309; text-align:right;">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>

                @if($booking->include_permit)
                <!-- Permit Section -->
                <tr>
                    <td style="padding:0 30px 30px 30px;">
                        <div style="background:#dbeafe; border-radius:8px; padding:20px; border-left:4px solid #3b82f6;">
                            <h2 style="margin:0 0 15px 0; font-size:18px; font-weight:700; color:#1e40af;">
                                🏛️ Perizinan
                            </h2>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding:8px 0; font-size:14px; color:#1e40af;">Status:</td>
                                    <td style="padding:8px 0; font-size:14px; color:#1e3a8a; font-weight:600; text-align:right;">
                                        @if($booking->permit_price > 0)
                                            Rp {{ number_format($booking->permit_price, 0, ',', '.') }}
                                        @else
                                            <span style="color:#d97706; font-weight:700;">Menunggu Admin</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                @endif

                @if($booking->notes)
                <!-- Notes Section -->
                <tr>
                    <td style="padding:0 30px 30px 30px;">
                        <div style="background:#eff6ff; border-radius:8px; padding:20px; border-left:4px solid #3b82f6;">
                            <h3 style="margin:0 0 10px 0; font-size:16px; font-weight:700; color:#1e40af;">📝 Catatan Tambahan</h3>
                            <p style="margin:0; font-size:14px; color:#1e3a8a; line-height:1.6;">{{ $booking->notes }}</p>
                        </div>
                    </td>
                </tr>
                @endif

                <!-- Next Steps -->
                <tr>
                    <td style="padding:0 30px 30px 30px;">
                        <div style="background:#dcfce7; border-radius:8px; padding:20px; border-left:4px solid #10b981;">
                            <h3 style="margin:0 0 10px 0; font-size:16px; font-weight:700; color:#065f46;">✅ Langkah Selanjutnya</h3>
                            <ul style="margin:0; padding-left:20px; font-size:14px; color:#047857; line-height:1.8;">
                                <li>Pesanan Anda sedang dalam status <strong>{{ ucfirst($booking->status) }}</strong></li>
                                <li>Tim kami akan menghubungi Anda dalam 1x24 jam untuk konfirmasi</li>
                                <li>Simpan email ini sebagai bukti pemesanan</li>
                                <li>Jika ada pertanyaan, hubungi kami di email atau telepon yang tertera di bawah</li>
                            </ul>
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
                            📧 Email: info@cakrawalabhakti.com
                        </p>
                        <p style="margin:0 0 5px 0; font-size:14px; color:#6b7280;">
                            📱 Telepon: +62 812-3456-7890
                        </p>
                        <p style="margin:0 0 20px 0; font-size:14px; color:#6b7280;">
                            🌐 Website: www.cakrawalabhakti.com
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
