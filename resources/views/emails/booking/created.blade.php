<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
</head>
<body style="margin:0; padding:0; background:#f2f2f2; font-family:Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="max-width:650px; margin:0 auto; background:#ffffff;">

    <!-- Header -->
    <tr>
        <td align="center" style="background:#f0c23b; padding:40px 20px; text-align:center;">

            <!-- LOGO -->
            <img src="{{ asset('img/credit.png') }}" width="60" alt="icon" 
                 style="display:block; margin:0 auto 15px auto;">

            <!-- TITLE (Guaranteed Center) -->
            <h1 style="
                margin:0;
                font-size:26px;
                font-weight:700;
                color:#000;
                width:100%;
                text-align:center;
                display:block;
                letter-spacing:0.5px;
            ">
                Thank You.
            </h1>

        </td>
    </tr>

    <!-- Zigzag -->
    <tr>
        <td style="
            height:20px;
            background:repeating-linear-gradient(
                -45deg,
                #f0c23b 0 10px,
                transparent 10px 20px
            );
        "></td>
    </tr>

    <!-- Content -->
    <tr>
        <td style="padding:35px 45px;">

            <!-- Billing Info -->
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td valign="top" width="50%">
                        <div style="font-weight:bold; font-size:14px;">Ditagih ke</div>
                        <div style="font-size:14px; line-height:1.5; margin-top:5px;">
                            {{ $booking->customer_name }} <br>
                            {{ $booking->customer_phone }} <br>
                            {{ $booking->customer_email }}
                        </div>
                    </td>

                    <td valign="top" width="50%" align="right">
                        <div style="font-weight:bold; font-size:14px;">Tanggal Pemesanan</div>
                        <div style="font-size:14px; margin-top:5px;">
                            {{ date('d/m/Y', strtotime($booking->created_at)) }}
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Services -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:30px; border-collapse:collapse;">
                <tr>
                    <th align="left" style="padding:12px; background:#f6f6f6; border-bottom:1px solid #e0e0e0; font-size:14px;">Jasa</th>
                    <th align="right" style="padding:12px; background:#f6f6f6; border-bottom:1px solid #e0e0e0; font-size:14px;">Harga</th>
                </tr>

                @foreach($booking->services as $service)
                <tr>
                    <td style="padding:12px; border-bottom:1px solid #e0e0e0; font-size:14px;">
                        {{ $service->service_name }} x{{ $service->pivot->quantity ?? 1 }}<br>
                        <span style="font-size:12px; color:#555;">
                            Tanggal: {{ $booking->start_date }} — {{ $booking->end_date }} <br>
                            Lokasi: {{ $booking->location }}
                        </span>
                    </td>
                    <td align="right" style="padding:12px; border-bottom:1px solid #e0e0e0; font-size:14px;">
                        Rp. {{ number_format($service->pivot->price ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach

                <tr>
                    <td style="padding:12px; font-weight:bold; font-size:14px;">Total Harga</td>
                    <td align="right" style="padding:12px; font-weight:bold; font-size:14px;">
                        Rp. {{ number_format($booking->total_price, 0, ',', '.') }}
                    </td>
                </tr>
            </table>

            <!-- Footer -->
            <div style="text-align:center; margin-top:25px;">
                <img src="{{ asset('img/logo-black.png') }}" width="60" style="display:block; margin:0 auto;">
            </div>

        </td>
    </tr>

</table>

</body>
</html>
