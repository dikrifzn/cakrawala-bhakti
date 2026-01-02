@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 pt-24">
    <div class="max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Pesanan Saya</h1>
            <p class="mt-2 text-gray-600">Daftar booking acara yang pernah Anda ajukan</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            {{-- Sidebar --}}
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="w-16 h-16 mx-auto rounded-full bg-yellow-400 flex items-center justify-center text-white text-2xl font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <h3 class="mt-4 font-semibold">{{ Auth::user()->name }}</h3>
                    <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>

                    <div class="border-t mt-6 pt-4 space-y-2 text-sm">
                        <a href="{{ route('profile.edit') }}" class="block hover:text-yellow-600">Edit Profil</a>
                        <a href="{{ route('profile.bookings') }}" class="block text-yellow-600 font-semibold">Pesanan Saya</a>
                    </div>
                </div>
            </div>

            {{-- Booking List --}}
            <div class="md:col-span-3">

                @forelse ($bookings as $booking)
                    <div class="bg-white rounded-xl shadow p-6 mb-4">

                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">
                                    {{ $booking->event_name }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    ID Booking: #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                                </p>
                            </div>

                            {{-- Status Badge --}}
                            <div class="flex flex-col gap-2 items-end">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($booking->admin_status === 'review') bg-yellow-100 text-yellow-800
                                    @elseif($booking->admin_status === 'detail_sent') bg-purple-100 text-purple-800
                                    @elseif($booking->admin_status === 'final_approved') bg-blue-100 text-blue-800
                                    @elseif($booking->admin_status === 'on_progress') bg-green-100 text-green-800
                                    @elseif($booking->admin_status === 'finished') bg-green-200 text-green-900
                                    @elseif($booking->admin_status === 'rejected') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    
                                    @switch($booking->admin_status)
                                        @case('review')
                                            👀 Review
                                            @break
                                        @case('detail_sent')
                                            💰 Rincian Jasa
                                            @break
                                        @case('final_approved')
                                            📄 Approval Dikirim
                                            @break
                                        @case('on_progress')
                                            🚧 On Progress
                                            @break
                                        @case('finished')
                                            🏁 Selesai
                                            @break
                                        @case('rejected')
                                            ✗ Ditolak
                                            @break
                                        @default
                                            {{ ucfirst($booking->admin_status) }}
                                    @endswitch
                                </span>

                                {{-- Customer Status if relevant --}}
                                @if(in_array($booking->customer_status, ['detail_approved','final_signed']))
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        ✓ Anda Setujui
                                    </span>
                                @elseif($booking->customer_status === 'rejected')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        ✗ Anda Tolak
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 py-4 border-t border-b">
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Tanggal Mulai</p>
                                <p class="font-semibold">
                                    {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Tanggal Selesai</p>
                                <p class="font-semibold">
                                    {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Lokasi</p>
                                <p class="font-semibold">{{ $booking->location }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Estimasi Biaya</p>
                                <p class="font-semibold text-yellow-600">
                                    Rp {{ number_format($booking->details->sum('price') ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-4 text-sm">
                            <p class="text-gray-500">
                                Diajukan: {{ $booking->created_at->format('d M Y H:i') }}
                                
                                {{-- Action Hint --}}
                                @if($booking->admin_status === 'detail_sent' && $booking->customer_status === 'submitted')
                                    <span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-semibold">
                                        ⚠️ Tunggu tindakan Anda
                                    </span>
                                @elseif($booking->admin_status === 'final_approved' && $booking->customer_status !== 'final_signed')
                                    <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">
                                        ✓ Siap dikonfirmasi
                                    </span>
                                @endif
                            </p>

                            <a href="{{ route('profile.booking-detail', $booking->id) }}"
                               class="text-yellow-600 font-semibold hover:underline">
                                Lihat Detail →
                            </a>
                        </div>

                    </div>
                @empty
                    <div class="bg-white p-10 rounded-xl shadow text-center">
                        <h3 class="font-semibold text-lg mb-2">Belum ada booking</h3>
                        <p class="text-gray-600 mb-6">Anda belum mengajukan booking acara.</p>
                        <a href="{{ route('booking.index') }}"
                           class="px-6 py-2 bg-yellow-400 rounded-lg font-semibold hover:bg-yellow-500">
                            Pesan Sekarang
                        </a>
                    </div>
                @endforelse

                {{ $bookings->links() }}

            </div>
        </div>
    </div>
</div>
@endsection
