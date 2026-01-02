<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 10px;
            margin: 10px;
        }
        h1 { 
            font-size: 16px; 
            margin-bottom: 5px;
        }
        p {
            margin: 3px 0;
            font-size: 9px;
        }
        .main-table { 
            width: 100%; 
            border-collapse: collapse;
            font-size: 9px;
            margin-bottom: 15px;
        }
        .main-table th, 
        .main-table td { 
            border: 1px solid #333; 
            padding: 4px;
            text-align: left;
        }
        .main-table th { 
            background: #e0e0e0;
            font-weight: bold;
        }
        .main-table tr:nth-child(even) {
            background: #f9f9f9;
        }
        .services-section {
            margin: 8px 0;
            padding: 6px;
            border: 1px solid #ccc;
            background: #fafafa;
        }
        .services-section h4 {
            margin: 0 0 3px 0;
            font-size: 9px;
            font-weight: bold;
        }
        .services-list {
            font-size: 8px;
            line-height: 1.3;
            margin-left: 10px;
        }
        .services-list li {
            margin: 1px 0;
        }
    </style>
</head>
<body>
    <h1>Laporan Booking</h1>
    <p>Dicetak: {{ now()->format('d M Y H:i') }}</p>
    
    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 15%;">Nama</th>
                <th style="width: 15%;">Event</th>
                <th style="width: 10%;">Mulai</th>
                <th style="width: 10%;">Selesai</th>
                <th style="width: 15%;">Lokasi</th>
                <th style="width: 15%;">Total Harga</th>
                <th style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $b)
                @php
                    $startDate = $b->start_date ? \Illuminate\Support\Carbon::parse($b->start_date)->format('d M Y') : '-';
                    $endDate = $b->end_date ? \Illuminate\Support\Carbon::parse($b->end_date)->format('d M Y') : '-';
                @endphp
                <tr>
                    <td>{{ $b->id }}</td>
                    <td>{{ $b->customer_name }}</td>
                    <td>{{ $b->event_name ?? '-' }}</td>
                    <td>{{ $startDate }}</td>
                    <td>{{ $endDate }}</td>
                    <td>{{ $b->location ?? '-' }}</td>
                    <td>Rp {{ number_format($b->details->sum('price') ?? 0, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($b->admin_status ?? 'review') }}</td>
                </tr>
                
                <!-- Details Row -->
                @if($b->details->count() > 0)
                <tr>
                    <td colspan="8">
                        <div class="services-section">
                            <h4>Rincian Jasa:</h4>
                            <ul class="services-list">
                                @foreach($b->details as $detail)
                                    <li>
                                        {{ $detail->service_name }}
                                        - Rp {{ number_format($detail->price, 0, ',', '.') }}
                                        @if($detail->notes)
                                            ({{ $detail->notes }})
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </td>
                </tr>
                @endif
                
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
