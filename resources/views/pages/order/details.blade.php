@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-12 px-5">
    <!-- Header dengan Status -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Detail Penawaran</h1>
        <p class="text-gray-600 mb-4">{{ $booking->event_name }} • {{ $booking->start_date }} - {{ $booking->end_date }}</p>
        
        <!-- Status Badge -->
        <div class="inline-block">
            <span class="px-4 py-2 rounded-full text-white text-sm font-semibold
                @if($booking->admin_status === 'details_sent') bg-purple-500
                @elseif($booking->admin_status === 'gantt_uploaded') bg-green-500
                @endif
            ">
                @if($booking->admin_status === 'details_sent') Rincian Dikirim
                @elseif($booking->admin_status === 'gantt_uploaded') Gantt & Persetujuan Dikirim
                @endif
            </span>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
            <p class="font-semibold">✓ {{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
            <p class="font-semibold">✗ {{ session('error') }}</p>
        </div>
    @endif

    <!-- Step 1: Review Rincian Jasa -->
    @if($booking->admin_status === 'details_sent')
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center mb-4">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-purple-500 text-white font-bold mr-3">1</span>
                <h2 class="text-xl font-bold">Rincian Jasa & Harga</h2>
            </div>

            <!-- Download Proposal -->
            <div class="mb-4 p-4 bg-gray-50 rounded">
                <p class="text-sm text-gray-600 mb-2">Proposal Anda:</p>
                <a href="{{ route('booking.downloadFile', ['booking' => $booking->id, 'type' => 'proposal_file']) }}" target="_blank" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                    📄 Download Proposal
                </a>
            </div>

            <!-- Details Table -->
            <div class="mb-6 overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="px-4 py-3 text-left font-semibold">Jasa / Layanan</th>
                            <th class="px-4 py-3 text-right font-semibold">Harga</th>
                            <th class="px-4 py-3 text-left font-semibold">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($booking->details as $detail)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $detail->service_name }}</td>
                                <td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-gray-600 text-sm">{{ $detail->notes ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-yellow-50 font-bold text-lg">
                            <td class="px-4 py-3">TOTAL</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($booking->details->sum('price') ?? 0, 0, ',', '.') }}</td>
                            <td class="px-4 py-3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Actions -->
            <div class="flex gap-3">
                <form method="POST" action="{{ route('booking.client.approveDetails', $booking->id) }}" class="flex-1">
                    @csrf
                    <button class="w-full px-4 py-3 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600">
                        ✓ Setujui Penawaran
                    </button>
                </form>

                <form method="POST" action="{{ route('booking.client.rejectDetails', $booking->id) }}" class="flex-1">
                    @csrf
                    <button class="w-full px-4 py-3 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600">
                        ✗ Tolak
                    </button>
                </form>
            </div>
        </div>
    @endif

    <!-- Step 2: Review Gantt & Persetujuan -->
    @if($booking->admin_status === 'gantt_uploaded')
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center mb-4">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-green-500 text-white font-bold mr-3">2</span>
                <h2 class="text-xl font-bold">Jadwal Pengerjaan & Persetujuan</h2>
            </div>

            <!-- Download Links -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="p-4 bg-gray-50 rounded">
                    <p class="text-sm text-gray-600 mb-2">📊 Gantt Chart (Timeline Pengerjaan)</p>
                    <a href="{{ route('booking.downloadFile', ['booking' => $booking->id, 'type' => 'gantt_chart']) }}" target="_blank" class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                        Download
                    </a>
                </div>

                <div class="p-4 bg-gray-50 rounded">
                    <p class="text-sm text-gray-600 mb-2">📋 Lembar Persetujuan</p>
                    <a href="{{ route('booking.downloadFile', ['booking' => $booking->id, 'type' => 'approval_file']) }}" target="_blank" class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                        Download
                    </a>
                </div>
            </div>

            <!-- PIC Contact -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                <p class="text-sm text-gray-600 mb-2">👤 Person In Charge (PIC)</p>
                <p class="text-lg font-semibold text-blue-700">{{ $booking->pic_contact }}</p>
                <p class="text-xs text-gray-600 mt-2">Silakan hubungi PIC ini untuk informasi pengerjaan lebih lanjut</p>
            </div>

            <!-- Rincian Jasa -->
            <div class="mb-6">
                <h3 class="font-semibold mb-3">Ringkasan Jasa</h3>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="px-4 py-3 text-left font-semibold">Jasa / Layanan</th>
                                <th class="px-4 py-3 text-right font-semibold">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($booking->details as $detail)
                                <tr class="border-b">
                                    <td class="px-4 py-3">{{ $detail->service_name }}</td>
                                    <td class="px-4 py-3 text-right">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-yellow-50 font-bold text-lg">
                                <td class="px-4 py-3">TOTAL</td>
                                <td class="px-4 py-3 text-right">Rp {{ number_format($booking->details->sum('price') ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Final Approval -->
            <form method="POST" action="{{ route('booking.client.finalApprove', $booking->id) }}">
                @csrf
                <button class="w-full px-4 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">
                    ✓ Setujui & Konfirmasi Booking
                </button>
            </form>
        </div>
    @endif

    <!-- Timeline Status -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold mb-4">Tahapan Proses</h3>
        <div class="space-y-3">
            <div class="flex items-center">
                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-green-500 text-white text-xs font-bold mr-3">✓</span>
                <span class="text-sm">Proposal Disetujui Admin</span>
            </div>
            <div class="flex items-center">
                <span class="flex items-center justify-center w-6 h-6 rounded-full @if($booking->admin_status !== 'details_sent') bg-green-500 text-white @else bg-purple-500 text-white @endif text-xs font-bold mr-3">✓</span>
                <span class="text-sm">Rincian Jasa Diterima</span>
            </div>
            <div class="flex items-center">
                <span class="flex items-center justify-center w-6 h-6 rounded-full @if($booking->admin_status === 'gantt_uploaded') bg-green-500 text-white @else bg-gray-300 @endif text-xs font-bold mr-3">✓</span>
                <span class="text-sm">Gantt Chart & Persetujuan</span>
            </div>
        </div>
    </div>
</div>
@endsection
