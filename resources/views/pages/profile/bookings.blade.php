@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 pt-24">
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Pesanan Saya</h1>
            <p class="mt-2 text-gray-600">Kelola semua pesanan booking acara Anda</p>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            {{-- Sidebar --}}
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex flex-col items-center mb-6">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-500 flex items-center justify-center text-white text-2xl font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ Auth::user()->email }}</p>
                    </div>

                    <div class="border-t pt-4">
                        <nav class="space-y-2">
                            <a href="{{ route('profile.edit') }}" class="w-full px-4 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Edit Profil
                            </a>
                            <a href="{{ route('profile.bookings') }}" class="w-full px-4 py-2 rounded-md text-sm font-medium bg-yellow-50 text-yellow-700 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Pesanan Saya
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            {{-- Bookings List --}}
            <div class="md:col-span-3">
                @if($bookings->count() > 0)
                    <div class="space-y-4">
                        @foreach($bookings as $booking)
                            <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6">
                                <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-4">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900">
                                            {{ $booking->eventType->name ?? 'Event' }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">ID Booking: #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                    <div class="mt-4 md:mt-0">
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

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 py-4 border-t border-b">
                                    <div>
                                        <p class="text-xs text-gray-600 uppercase tracking-wide">Tanggal Acara</p>
                                        <p class="text-sm font-semibold text-gray-900 mt-1">
                                            {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600 uppercase tracking-wide">Lokasi</p>
                                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $booking->location ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600 uppercase tracking-wide">Total Hari</p>
                                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $booking->total_days ?? '-' }} hari</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600 uppercase tracking-wide">Total Harga</p>
                                        <p class="text-sm font-semibold text-yellow-600 mt-1">
                                            Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>

                                @if($booking->services->count() > 0)
                                    <div class="mt-4">
                                        <p class="text-sm font-semibold text-gray-700 mb-2">Layanan yang Dipilih:</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($booking->services as $service)
                                                <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">
                                                    {{ $service->service_name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if($booking->include_permit)
                                    <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                        <p class="text-xs font-semibold text-blue-700">Perizinan</p>
                                        <p class="text-sm text-blue-700 mt-1">
                                            @if($booking->permit_price > 0)
                                                Rp {{ number_format($booking->permit_price, 0, ',', '.') }}
                                            @else
                                                Menunggu admin
                                            @endif
                                        </p>
                                    </div>
                                @endif

                                <div class="mt-4 pt-4 border-t flex flex-col md:flex-row md:items-center md:justify-between">
                                    <p class="text-xs text-gray-500">
                                        Dipesan pada: {{ $booking->created_at->format('d M Y H:i') }}
                                    </p>
                                    <a href="{{ route('profile.booking-detail', $booking->id) }}" class="mt-4 md:mt-0 text-yellow-600 hover:text-yellow-700 font-semibold text-sm flex items-center gap-1">
                                        Detail Pesanan
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($bookings->hasPages())
                        <div class="mt-8">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                @else
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Pesanan</h3>
                        <p class="text-gray-600 mb-6">Anda belum membuat pesanan apapun. Mulai pesan acara Anda sekarang!</p>
                        <a href="{{ route('booking.index') }}" class="inline-block px-6 py-2 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 transition">
                            Pesan Acara Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
