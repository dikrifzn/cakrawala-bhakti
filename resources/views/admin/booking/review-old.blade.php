@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-12 px-5">
    <!-- Header dengan Status -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Review Proposal Event</h1>
        <p class="text-gray-600 mb-4">{{ $booking->event_name }} • {{ $booking->start_date }} - {{ $booking->end_date }}</p>
        
        <!-- Status Badge -->
        <div class="inline-block">
            <span class="px-4 py-2 rounded-full text-white text-sm font-semibold
                @if($booking->admin_status === 'review') bg-blue-500
                @elseif($booking->admin_status === 'approved') bg-yellow-500
                @elseif($booking->admin_status === 'details_sent') bg-purple-500
                @elseif($booking->admin_status === 'gantt_uploaded') bg-green-500
                @elseif($booking->admin_status === 'rejected') bg-red-500
                @endif
            ">
                @if($booking->admin_status === 'review') Review Proposal
                @elseif($booking->admin_status === 'approved') Proposal Disetujui
                @elseif($booking->admin_status === 'details_sent') Rincian Dikirim
                @elseif($booking->admin_status === 'gantt_uploaded') Gantt Dikirim
                @elseif($booking->admin_status === 'rejected') Ditolak
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

    <!-- Step 1: Review Proposal -->
    @if($booking->admin_status === 'review')
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center mb-4">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-500 text-white font-bold mr-3">1</span>
                <h2 class="text-xl font-bold">Review Proposal</h2>
            </div>

            <div class="bg-gray-50 p-4 rounded mb-4">
                <p class="text-sm text-gray-600 mb-3"><strong>Pemesan:</strong> {{ $booking->customer_name }}</p>
                <p class="text-sm text-gray-600 mb-3"><strong>Email:</strong> {{ $booking->customer_email }}</p>
                <p class="text-sm text-gray-600 mb-3"><strong>Lokasi:</strong> {{ $booking->location }}</p>
                <a href="{{ asset('storage/' . $booking->proposal_file) }}" target="_blank" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                    📄 Download Proposal
                </a>
            </div>

            <div class="flex gap-3">
                <form method="POST" action="{{ route('booking.admin.approve', $booking->id) }}" class="flex-1">
                    @csrf
                    <button class="w-full px-4 py-3 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600">
                        ✓ Setujui Proposal
                    </button>
                </form>

                <form method="POST" action="{{ route('booking.admin.reject', $booking->id) }}" class="flex-1">
                    @csrf
                    <button class="w-full px-4 py-3 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600">
                        ✗ Tolak Proposal
                    </button>
                </form>
            </div>
        </div>
    @endif

    <!-- Step 2: Input Rincian Jasa -->
    @if($booking->admin_status === 'approved')
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center mb-4">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-500 text-white font-bold mr-3">2</span>
                <h2 class="text-xl font-bold">Input Rincian Jasa & Harga</h2>
            </div>

            <form method="POST" action="{{ route('booking.admin.sendDetails', $booking->id) }}">
                @csrf
                
                <div class="bg-gray-50 p-4 rounded mb-4">
                    <p class="text-sm text-gray-600">Masukkan detail layanan yang akan diberikan kepada client sesuai dengan budget dan kebutuhan mereka</p>
                </div>

                <div id="details" class="mb-4">
                    <div class="detail-row mb-4 p-4 bg-gray-50 rounded">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-sm font-semibold mb-1">Nama Jasa</label>
                                <input type="text" name="details[0][service_name]" placeholder="Contoh: Dekorasi" class="border rounded-lg p-3 w-full text-sm" required />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Harga</label>
                                <input type="number" name="details[0][price]" placeholder="0" class="border rounded-lg p-3 w-full text-sm" required />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Catatan (Opsional)</label>
                                <input type="text" name="details[0][notes]" placeholder="Catatan singkat" class="border rounded-lg p-3 w-full text-sm" />
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" id="addDetail" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg font-semibold hover:bg-gray-400 mb-6">
                    + Tambah Rincian Lain
                </button>

                <div class="flex gap-3">
                    <button type="submit" class="flex-1 px-4 py-3 bg-yellow-500 text-white rounded-lg font-semibold hover:bg-yellow-600">
                        ➤ Kirim Rincian ke Client
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Step 3: Upload Gantt Chart -->
    @if($booking->admin_status === 'details_sent' || $booking->admin_status === 'gantt_uploaded')
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center mb-4">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-purple-500 text-white font-bold mr-3">3</span>
                <h2 class="text-xl font-bold">Upload Jadwal Pengerjaan & Persetujuan</h2>
            </div>

            <form method="POST" action="{{ route('booking.admin.uploadGantt', $booking->id) }}" enctype="multipart/form-data">
                @csrf
                
                <div class="bg-gray-50 p-4 rounded mb-4">
                    <p class="text-sm text-gray-600">Upload Gantt Chart (timeline pengerjaan), Lembar Persetujuan, dan PIC yang bisa dihubungi client</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Gantt Chart <span class="text-red-500">*</span></label>
                        <label class="block border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-50">
                            <span class="text-gray-600">📊 Pilih File</span>
                            <input type="file" name="gantt_chart" accept=".pdf,.jpg,.jpeg,.png" class="hidden" required />
                        </label>
                        <p class="text-xs text-gray-500 mt-1">PDF, JPG, atau PNG (Max 5MB)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Lembar Persetujuan <span class="text-red-500">*</span></label>
                        <label class="block border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-50">
                            <span class="text-gray-600">📄 Pilih File</span>
                            <input type="file" name="approval_file" accept=".pdf,.jpg,.jpeg,.png" class="hidden" required />
                        </label>
                        <p class="text-xs text-gray-500 mt-1">PDF, JPG, atau PNG (Max 5MB)</p>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2">PIC (Person In Charge) <span class="text-red-500">*</span></label>
                    <input type="text" name="pic_contact" placeholder="Nama & Nomor Telepon PIC" class="border rounded-lg p-3 w-full" required />
                    <p class="text-xs text-gray-500 mt-1">Contoh: Budi (081234567890)</p>
                </div>

                <button type="submit" class="w-full px-4 py-3 bg-purple-500 text-white rounded-lg font-semibold hover:bg-purple-600">
                    ➤ Upload & Kirim ke Client
                </button>
            </form>
        </div>
    @endif

    <!-- Timeline Status -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold mb-4">Timeline Proses</h3>
        <div class="space-y-3">
            <div class="flex items-center">
                <span class="flex items-center justify-center w-6 h-6 rounded-full @if($booking->admin_status !== 'review') bg-green-500 text-white @else bg-blue-500 text-white @endif text-xs font-bold mr-3">✓</span>
                <span class="text-sm">Review Proposal</span>
            </div>
            <div class="flex items-center">
                <span class="flex items-center justify-center w-6 h-6 rounded-full @if(in_array($booking->admin_status, ['approved', 'details_sent', 'gantt_uploaded'])) bg-green-500 text-white @elseif($booking->admin_status === 'review') bg-gray-300 @else bg-gray-300 @endif text-xs font-bold mr-3">✓</span>
                <span class="text-sm">Input Rincian Jasa</span>
            </div>
            <div class="flex items-center">
                <span class="flex items-center justify-center w-6 h-6 rounded-full @if($booking->admin_status === 'gantt_uploaded') bg-green-500 text-white @elseif(in_array($booking->admin_status, ['details_sent'])) bg-purple-500 text-white @else bg-gray-300 @endif text-xs font-bold mr-3">✓</span>
                <span class="text-sm">Upload Gantt & Persetujuan</span>
            </div>
        </div>
    </div>
</div>

<script>
let idx = 1;
document.getElementById('addDetail')?.addEventListener('click', function() {
    const container = document.getElementById('details');
    const div = document.createElement('div');
    div.className = 'detail-row mb-4 p-4 bg-gray-50 rounded';
    div.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <label class="block text-sm font-semibold mb-1">Nama Jasa</label>
                <input type="text" name="details[${idx}][service_name]" placeholder="Contoh: Dekorasi" class="border rounded-lg p-3 w-full text-sm" required />
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Harga</label>
                <input type="number" name="details[${idx}][price]" placeholder="0" class="border rounded-lg p-3 w-full text-sm" required />
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Catatan (Opsional)</label>
                <input type="text" name="details[${idx}][notes]" placeholder="Catatan singkat" class="border rounded-lg p-3 w-full text-sm" />
            </div>
        </div>
    `;
    container.appendChild(div);
    idx++;
});
</script>
@endsection
