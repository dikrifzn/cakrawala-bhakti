@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-5">
    <h1 class="text-2xl font-bold mb-4">📊 Upload Gantt Chart & Lembar Persetujuan untuk: {{ $booking->event_name }}</h1>

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('booking.admin.uploadGantt', $booking->id) }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-semibold mb-2">📊 Gantt Chart <span class="text-red-500">*</span></label>
                <input type="file" name="gantt_chart" accept=".pdf,.jpg,.jpeg,.png" required />
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">📋 Lembar Persetujuan <span class="text-red-500">*</span></label>
                <input type="file" name="approval_file" accept=".pdf,.jpg,.jpeg,.png" required />
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">👤 PIC Contact (Nama & No Telepon) <span class="text-red-500">*</span></label>
            <input type="text" name="pic_contact" placeholder="Contoh: Budi (081234567890)" class="border rounded-lg p-3 w-full" required />
        </div>

        <div class="flex gap-3">
            <a href="{{ route('booking.admin.review', $booking->id) }}" class="px-4 py-2 bg-gray-200 rounded">← Kembali</a>
            <button type="submit" class="px-6 py-2 bg-purple-500 text-white rounded">UPLOAD & KIRIM KE CLIENT</button>
        </div>
    </form>
</div>
@endsection
