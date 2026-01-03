<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 12px;
            line-height: 1.6;
            margin: 30px;
        }

        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .subtitle {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .section {
            margin-bottom: 18px;
        }

        .label {
            display: inline-block;
            width: 120px;
        }

        .content {
            margin-left: 20px;
        }

        .list {
            margin-left: 20px;
        }

        .signature-wrapper {
            margin-top: 60px;
            width: 100%;
        }

        .signature-box {
            width: 45%;
            float: right;
            text-align: center;
        }

        .signature-box img {
            width: 160px;
            height: 80px;
            margin: 10px 0;
            border: 1px solid #ccc;
            padding: 5px;
        }

        .clear {
            clear: both;
        }

        .footer {
            margin-top: 40px;
            font-size: 10px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        table th {
            background-color: #f5f5f5;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }

        .approval-status {
            background-color: #f0f9ff;
            padding: 10px;
            margin: 15px 0;
            border-left: 4px solid #0ea5e9;
            font-size: 11px;
        }
    </style>
</head>
<body>

<div class="title">
    Lembar Persetujuan Pekerjaan Event
</div>

<div class="subtitle">
    {{ $booking->event_name }}
</div>

<div class="section content">
    <p><span class="label"><b>Nomor Booking</b></span>: {{ $booking->id }}</p>
    <p><span class="label"><b>Tanggal Dibuat</b></span>: {{ \Carbon\Carbon::parse($booking->created_at)->format('d F Y') }}</p>
</div>

<hr style="margin: 20px 0; border: none; border-top: 1px solid #ccc;">

<h3>📋 Data Pemesan</h3>

<table>
    <tr>
        <td style="width: 30%;"><b>Nama Pemesan</b></td>
        <td>{{ $booking->customer_name }}</td>
    </tr>
    <tr>
        <td><b>Email</b></td>
        <td>{{ $booking->customer_email }}</td>
    </tr>
    <tr>
        <td><b>Telepon</b></td>
        <td>{{ $booking->customer_phone }}</td>
    </tr>
    <tr>
        <td><b>Lokasi Event</b></td>
        <td>{{ $booking->location }}</td>
    </tr>
</table>

<hr style="margin: 20px 0; border: none; border-top: 1px solid #ccc;">

<h3>📅 Detail Event</h3>

<table>
    <tr>
        <td style="width: 30%;"><b>Nama Event</b></td>
        <td>{{ $booking->event_name }}</td>
    </tr>
    <tr>
        <td><b>Tanggal Mulai</b></td>
        <td>{{ \Carbon\Carbon::parse($booking->start_date)->format('d F Y') }}</td>
    </tr>
    <tr>
        <td><b>Tanggal Selesai</b></td>
        <td>{{ \Carbon\Carbon::parse($booking->end_date)->format('d F Y') }}</td>
    </tr>
</table>

<hr style="margin: 20px 0; border: none; border-top: 1px solid #ccc;">

<h3>💰 Rincian Layanan & Harga</h3>

<table>
    <thead>
        <tr>
            <th style="width: 40%;">Jasa / Layanan</th>
            <th style="width: 40%;">Catatan</th>
            <th style="text-align: right; width: 20%;">Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach($booking->details as $detail)
            <tr>
                <td>{{ $detail->service_name }}</td>
                <td>{{ $detail->notes ?? '-' }}</td>
                <td style="text-align: right;"><b>Rp {{ number_format($detail->price, 0, ',', '.') }}</b></td>
            </tr>
        @endforeach
        <tr style="background-color: #f5f5f5; font-weight: bold;">
            <td colspan="2" style="text-align: right;">TOTAL BIAYA:</td>
            <td style="text-align: right;">Rp {{ number_format($total, 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

<hr style="margin: 20px 0; border: none; border-top: 1px solid #ccc;">

<h3>🔐 Pernyataan & Persetujuan</h3>

<div class="section">
    <p>Dengan ini, saya ({{ $booking->customer_name }}) menyatakan bahwa:</p>
    <ul style="margin-left: 20px;">
        <li>Telah membaca dan memahami seluruh rincian layanan yang disediakan.</li>
        <li>Menyetujui total biaya sebesar <b>Rp {{ number_format($total, 0, ',', '.') }}</b>.</li>
        <li>Menyetujui jadwal pengerjaan yang telah ditentukan.</li>
        <li>Siap melanjutkan proses pengerjaan event sesuai dengan kesepakatan.</li>
    </ul>
</div>

<div class="approval-status">
    ✓ <b>Persetujuan Digital</b> - Dokumen ini telah ditandatangani secara digital oleh pemesan.<br>
    📅 Tanggal & Waktu Persetujuan: {{ $approvedDate ?? now()->format('d F Y H:i:s') }}<br>
    🌐 IP Address: {{ $approvedIp ?? '(Belum tercatat)' }}<br>
    ✍️ Nama Pemesan: {{ $booking->customer_name }}
</div>

{{-- TANDA TANGAN --}}
@if($signature)
    <div class="signature-wrapper">
        <div class="signature-box">
            Bengkulu, {{ now()->format('d F Y') }}<br>
            Pemesan (Client)<br><br>

            <img src="{{ $signature }}" alt="Tanda Tangan">

            <br><b>{{ $booking->customer_name }}</b><br>
            <span style="font-size: 10px; color: #666;">Tanda Tangan Digital</span>
        </div>
    </div>
    <div class="clear"></div>
@endif

<div class="footer">
    <p>
        <b>Catatan Keamanan:</b> Dokumen ini merupakan hasil dari persetujuan digital dan sah tanpa tanda tangan basah sesuai dengan Undang-Undang Informasi dan Transaksi Elektronik (ITE).<br>
        Dokumen ini dibuat secara otomatis oleh sistem dan merupakan dokumen resmi. Penyalahgunaan dokumen ini tanpa izin adalah tindakan ilegal.
    </p>
</div>

</body>
</html>
