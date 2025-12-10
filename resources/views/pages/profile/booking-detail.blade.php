@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 pt-24">
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <a href="{{ route('profile.bookings') }}" class="text-yellow-600 hover:text-yellow-700 font-semibold text-sm flex items-center gap-1 mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Pesanan
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Detail Pesanan</h1>
                <p class="mt-2 text-gray-600">ID Booking: #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div>
                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold 
                    @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($booking->status === 'approved') bg-blue-100 text-blue-800
                    @elseif($booking->status === 'finished') bg-green-100 text-green-800
                    @elseif($booking->status === 'rejected') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst($booking->status) }}
                </span>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column - Detail --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Event Information --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Informasi Acara</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 uppercase tracking-wide">Jenis Acara</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $booking->eventType->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 uppercase tracking-wide">Nama Acara</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $booking->event_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 uppercase tracking-wide">Tanggal Mulai</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 uppercase tracking-wide">Tanggal Selesai</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $booking->end_date ? \Carbon\Carbon::parse($booking->end_date)->format('d M Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 uppercase tracking-wide">Jam Mulai</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $booking->start_time ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 uppercase tracking-wide">Jam Selesai</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $booking->end_time ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 uppercase tracking-wide">Total Hari</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $booking->total_days ?? '-' }} hari</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 uppercase tracking-wide">Lokasi</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $booking->location ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Customer Information --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Informasi Kontak</h2>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600 uppercase tracking-wide">Nama Pemesan</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $booking->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 uppercase tracking-wide">Email</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $booking->customer_email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 uppercase tracking-wide">Nomor Telepon</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $booking->customer_phone ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Services --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Layanan yang Dipilih</h2>
                    @if($booking->services->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Layanan</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Harga</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach($booking->services as $service)
                                        @php
                                            $pivot = $service->pivot;
                                            $price = $pivot->price ?? $service->price ?? 0;
                                            $quantity = $pivot->quantity ?? 1;
                                            $subtotal = $price * $quantity;
                                        @endphp
                                        <tr>
                                            <td class="px-4 py-3 text-gray-900">{{ $service->service_name }}</td>
                                            <td class="px-4 py-3 text-gray-900">Rp {{ number_format($price, 0, ',', '.') }}</td>
                                            <td class="px-4 py-3 text-gray-900">{{ $quantity }}</td>
                                            <td class="px-4 py-3 text-right font-semibold text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-600">Tidak ada layanan yang dipilih</p>
                    @endif
                </div>

                {{-- Permit Information --}}
                @if($booking->include_permit)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Informasi Perizinan</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">Perizinan</span>
                                <span class="font-semibold text-gray-900">Include</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Harga Perizinan</span>
                                @if($booking->permit_price > 0)
                                    <span class="font-semibold text-gray-900">Rp {{ number_format($booking->permit_price, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-yellow-600">Menunggu admin</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Notes --}}
                @if($booking->notes)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Catatan Tambahan</h2>
                        <p class="text-gray-700 leading-relaxed">{{ $booking->notes }}</p>
                    </div>
                @endif
            </div>

            {{-- Right Column - Summary --}}
            <div class="lg:col-span-1">
                {{-- Price Summary --}}
                <div class="bg-white rounded-lg shadow p-6 sticky top-24">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Harga</h2>
                    
                    @php
                        $subtotal = $booking->services->sum(function($service) {
                            $price = $service->pivot->price ?? $service->price ?? 0;
                            $quantity = $service->pivot->quantity ?? 1;
                            return $price * $quantity;
                        });
                    @endphp

                    <div class="space-y-3 pb-4 border-b">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Subtotal Layanan</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if($booking->include_permit)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Perizinan</span>
                                @if($booking->permit_price > 0)
                                    <span class="font-semibold text-gray-900">Rp {{ number_format($booking->permit_price, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-yellow-600 text-sm">Menunggu admin</span>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="py-4 border-b">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Pajak (0%)</span>
                            <span class="font-semibold text-gray-900">Rp 0</span>
                        </div>
                    </div>

                    <div class="pt-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-bold text-gray-900">Total Harga</span>
                            <span class="text-2xl font-bold text-yellow-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 mt-6">
                        <p class="text-sm text-gray-600 uppercase tracking-wide mb-2">Dibuat pada</p>
                        <p class="font-semibold text-gray-900">{{ $booking->created_at->format('d M Y H:i') }}</p>
                    </div>

                    @if($booking->status === 'pending')
                        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-sm text-yellow-800"><strong>Status:</strong> Pesanan Anda sedang menunggu persetujuan dari tim kami.</p>
                        </div>
                    @elseif($booking->status === 'approved')
                        <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-blue-800"><strong>Status:</strong> Pesanan Anda telah disetujui. Tim akan segera menghubungi Anda.</p>
                        </div>
                    @elseif($booking->status === 'finished')
                        <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <p class="text-sm text-green-800"><strong>Status:</strong> Acara Anda telah selesai. Terima kasih!</p>
                        </div>
                    @elseif($booking->status === 'rejected')
                        <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-sm text-red-800"><strong>Status:</strong> Pesanan Anda telah ditolak. Hubungi tim kami untuk informasi lebih lanjut.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
