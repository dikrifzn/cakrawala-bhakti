@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 pt-24">
    <div class="max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <a href="{{ route('profile.bookings') }}"
                   class="text-yellow-600 hover:text-yellow-700 font-semibold text-sm flex items-center gap-1 mb-4">
                    ← Kembali ke Pesanan
                </a>

                <h1 class="text-3xl font-bold text-gray-900">Detail Pesanan</h1>
                <p class="mt-2 text-gray-600">
                    ID Booking: #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                </p>
            </div>

            <span class="px-4 py-2 rounded-full text-sm font-semibold
                @if($booking->customer_status === 'review') bg-yellow-100 text-yellow-800
                @elseif($booking->customer_status === 'details_approved') bg-blue-100 text-blue-800
                @elseif($booking->customer_status === 'final_approved') bg-green-100 text-green-800
                @elseif($booking->customer_status === 'rejected') bg-red-100 text-red-800
                @else bg-gray-100 text-gray-800 @endif">
                @if($booking->customer_status === 'details_approved') Rincian Disetujui
                @elseif($booking->customer_status === 'final_approved') Final Disetujui
                @else {{ ucfirst($booking->customer_status) }}
                @endif
            </span>
        </div>

        {{-- Main --}}
        <div class="space-y-6">

            {{-- Informasi Acara --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Informasi Acara</h2>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nama Acara</p>
                        <p class="font-semibold">{{ $booking->event_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Lokasi</p>
                        <p class="font-semibold">{{ $booking->location }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Mulai</p>
                        <p class="font-semibold">
                            {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Selesai</p>
                        <p class="font-semibold">
                            {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Informasi Pemesan --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Informasi Pemesan</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nama</p>
                        <p class="font-semibold">{{ $booking->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-semibold">{{ $booking->customer_email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Telepon</p>
                        <p class="font-semibold">{{ $booking->customer_phone }}</p>
                    </div>
                </div>
            </div>

            {{-- Proposal --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Proposal Acara</h2>

                <a href="{{ route('booking.downloadFile', ['booking' => $booking->id, 'type' => 'proposal_file']) }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 text-yellow-600 font-semibold hover:underline">
                    📄 Download Proposal
                </a>
            </div>

            {{-- Catatan --}}
            @if($booking->notes)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Catatan Tambahan</h2>
                    <p class="text-gray-700">{{ $booking->notes }}</p>
                </div>
            @endif


            {{-- Progress Timeline --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-6">📈 Progress Status</h2>
                
                <div class="space-y-4">
                    {{-- Step 1: Review Proposal --}}
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $booking->admin_status !== 'review' ? 'bg-green-500' : 'bg-yellow-400' }} flex items-center justify-center text-white font-bold text-sm">
                            {{ $booking->admin_status !== 'review' ? '✓' : '1' }}
                        </div>
                        <div class="flex-grow">
                            <p class="font-semibold text-gray-900">Admin Review Proposal</p>
                            <p class="text-sm text-gray-600">Admin sedang mereview proposal acara Anda</p>
                            @if($booking->admin_status !== 'review')
                                <p class="text-xs text-green-600 mt-1">✓ Selesai</p>
                            @endif
                        </div>
                    </div>

                    {{-- Step 2: Rincian Jasa --}}
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full {{ in_array($booking->admin_status, ['details_sent', 'gantt_uploaded']) ? 'bg-green-500' : ($booking->admin_status === 'approved' ? 'bg-yellow-400' : 'bg-gray-300') }} flex items-center justify-center text-white font-bold text-sm">
                            {{ in_array($booking->admin_status, ['details_sent', 'gantt_uploaded']) ? '✓' : '2' }}
                        </div>
                        <div class="flex-grow">
                            <p class="font-semibold text-gray-900">Rincian Jasa & Harga</p>
                            <p class="text-sm text-gray-600">Admin mengirimkan detail jasa dan harga</p>
                            @if(in_array($booking->admin_status, ['details_sent', 'gantt_uploaded']))
                                <p class="text-xs text-green-600 mt-1">✓ Selesai</p>
                            @endif
                        </div>
                    </div>

                    {{-- Step 3: Gantt Chart & Final Agreement --}}
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $booking->admin_status === 'gantt_uploaded' ? 'bg-green-500' : ($booking->admin_status === 'details_sent' ? 'bg-yellow-400' : 'bg-gray-300') }} flex items-center justify-center text-white font-bold text-sm">
                            {{ $booking->admin_status === 'gantt_uploaded' ? '✓' : '3' }}
                        </div>
                        <div class="flex-grow">
                            <p class="font-semibold text-gray-900">Gantt Chart & Persetujuan Final</p>
                            <p class="text-sm text-gray-600">Admin mengirimkan jadwal kerja dan dokumen persetujuan</p>
                            @if($booking->admin_status === 'gantt_uploaded')
                                <p class="text-xs text-green-600 mt-1">✓ Selesai</p>
                            @endif
                        </div>
                    </div>

                    {{-- Step 4: Final Approval --}}
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $booking->customer_status === 'final_approved' ? 'bg-green-500' : ($booking->admin_status === 'gantt_uploaded' ? 'bg-yellow-400' : 'bg-gray-300') }} flex items-center justify-center text-white font-bold text-sm">
                            {{ $booking->customer_status === 'final_approved' ? '✓' : '4' }}
                        </div>
                        <div class="flex-grow">
                            <p class="font-semibold text-gray-900">Konfirmasi Final Anda</p>
                            <p class="text-sm text-gray-600">Anda melakukan persetujuan final booking</p>
                            @if($booking->customer_status === 'final_approved')
                                <p class="text-xs text-green-600 mt-1">✓ Selesai</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rincian Jasa (Stage 2) --}}
            @if(in_array($booking->admin_status, ['details_sent', 'gantt_uploaded']))
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">💰 Rincian Jasa & Harga</h2>
                    
                    @if($booking->details->count() > 0)
                        <div class="overflow-x-auto mb-4">
                            <table class="w-full text-sm">
                                <thead class="border-b">
                                    <tr>
                                        <th class="text-left py-2 font-semibold">Jasa</th>
                                        <th class="text-center py-2 font-semibold">Harga</th>
                                        <th class="text-right py-2 font-semibold">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($booking->details as $detail)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="text-left py-3">{{ $detail->service_name }}</td>
                                            <td class="text-center py-3 font-semibold">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                            <td class="text-right py-3 text-gray-600">{{ $detail->notes ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="border-t-2 bg-gray-50">
                                    <tr>
                                        <td class="py-3 font-bold">Total</td>
                                        <td class="py-3 font-bold"></td>
                                        <td class="text-right py-3 text-lg font-bold text-yellow-600">Rp {{ number_format($booking->details->sum('price') ?? 0, 0, ',', '.') }}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        {{-- Action Buttons for Details Stage --}}
                        @if($booking->admin_status === 'details_sent' && $booking->customer_status === 'review')
                            <div class="flex gap-3 mt-6">
                                <form action="{{ route('booking.client.approveDetails', $booking->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition">
                                        ✓ Setujui Rincian
                                    </button>
                                </form>
                                <form action="{{ route('booking.client.rejectDetails', $booking->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition">
                                        ✗ Tolak Rincian
                                    </button>
                                </form>
                            </div>
                        @elseif($booking->admin_status === 'details_sent' && $booking->customer_status !== 'review')
                                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-sm text-blue-800">
                                    <span class="font-semibold">Status:</span> Anda telah {{ $booking->customer_status === 'details_approved' ? '✓ menyetujui' : '✗ menolak' }} rincian jasa ini.
                                </p>
                            </div>
                        @endif
                    @else
                        <p class="text-gray-600">Rincian jasa belum tersedia. Admin masih menyiapkan detail.</p>
                    @endif
                </div>
            @endif

            {{-- Gantt Chart & Final Agreement (Stage 3) --}}
            @if($booking->admin_status === 'gantt_uploaded')
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">📊 Jadwal Pengerjaan & Persetujuan Final</h2>
                    
                    <div class="space-y-4 mb-6">
                        {{-- Gantt Chart --}}
                        @if($booking->gantt_chart)
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Gantt Chart</p>
                                <a href="{{ asset('storage/' . $booking->gantt_chart) }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-2 text-yellow-600 font-semibold hover:underline">
                                    📊 Download Gantt Chart
                                </a>
                            </div>
                        @endif

                        {{-- Approval File --}}
                        @if($booking->approval_file)
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Lembar Persetujuan & Perjanjian</p>
                                <a href="{{ asset('storage/' . $booking->approval_file) }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-2 text-yellow-600 font-semibold hover:underline">
                                    📄 Download Lembar Persetujuan
                                </a>
                            </div>
                        @endif

                        {{-- PIC Contact --}}
                        @if($booking->pic_contact)
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <p class="text-sm font-semibold text-gray-700 mb-2">👤 PIC (Contact Person)</p>
                                <p class="text-gray-800">{{ $booking->pic_contact }}</p>
                            </div>
                        @endif
                    </div>

                    {{-- Action Buttons for Final Approval --}}
                    @if($booking->customer_status !== 'final_approved' && $booking->customer_status !== 'rejected')
                        <div class="flex gap-3">
                            <form action="{{ route('booking.client.finalApprove', $booking->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition">
                                    ✓ Setujui & Konfirmasi
                                </button>
                            </form>
                            <button type="button" onclick="alert('Tolak fitur akan datang')" class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition">
                                ✗ Tolak
                            </button>
                        </div>
                    @elseif($booking->customer_status === 'final_approved')
                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                            <p class="text-sm text-green-800">
                                <span class="font-semibold">✓ Booking Dikonfirmasi!</span> Semua dokumen sudah disetujui. Hubungi PIC kami untuk melanjutkan.
                            </p>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Info --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm">
                <p class="text-blue-800">
                    <span class="font-semibold">📌 Catatan:</span> Semua tahapan akan muncul di halaman ini seiring dengan proses review admin. Pantau status Anda secara berkala.
                </p>
            </div>

        </div>
    </div>
</div>
@endsection
