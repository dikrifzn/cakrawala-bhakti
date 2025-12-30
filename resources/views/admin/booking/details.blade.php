@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-5">
    <h1 class="text-2xl font-bold mb-4">💰 Input Rincian Jasa untuk: {{ $booking->event_name }}</h1>

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('booking.admin.sendDetails', $booking->id) }}">
        @csrf

        <div id="details">
            <div class="detail-row mb-4 p-4 bg-gray-50 rounded border-l-4 border-yellow-500">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Nama Jasa/Layanan</label>
                        <input type="text" name="details[0][service_name]" placeholder="Contoh: Dekorasi" class="border rounded-lg p-3 w-full text-sm" required />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Harga (Rp)</label>
                        <input type="number" name="details[0][price]" placeholder="0" class="border rounded-lg p-3 w-full text-sm" required />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Catatan</label>
                        <input type="text" name="details[0][notes]" placeholder="Opsional" class="border rounded-lg p-3 w-full text-sm" />
                    </div>
                </div>
            </div>
        </div>

        <button type="button" id="addDetail" class="mb-4 px-4 py-2 bg-gray-300 rounded">+ Tambah Rincian</button>

        <div class="flex gap-3">
            <a href="{{ route('booking.admin.review', $booking->id) }}" class="px-4 py-2 bg-gray-200 rounded">← Kembali</a>
            <button type="submit" class="px-6 py-2 bg-yellow-500 text-white rounded">KIRIM RINCIAN KE CLIENT</button>
        </div>
    </form>

    <script>
    let idx = 1;
    document.getElementById('addDetail')?.addEventListener('click', function() {
        const container = document.getElementById('details');
        const div = document.createElement('div');
        div.className = 'detail-row mb-4 p-4 bg-gray-50 rounded border-l-4 border-yellow-500';
        div.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <label class="block text-sm font-semibold mb-2">Nama Jasa/Layanan</label>
                    <input type="text" name="details[${idx}][service_name]" placeholder="Contoh: Dekorasi" class="border rounded-lg p-3 w-full text-sm" required />
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Harga (Rp)</label>
                    <input type="number" name="details[${idx}][price]" placeholder="0" class="border rounded-lg p-3 w-full text-sm" required />
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Catatan</label>
                    <input type="text" name="details[${idx}][notes]" placeholder="Opsional" class="border rounded-lg p-3 w-full text-sm" />
                </div>
            </div>
        `;
        container.appendChild(div);
        idx++;
    });
    </script>
</div>
@endsection
