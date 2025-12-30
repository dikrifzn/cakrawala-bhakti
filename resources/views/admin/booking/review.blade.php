@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-5">
    <!-- Header -->
    <div class="flex justify-between items-start mb-8">
        <div>
            <h1 class="text-3xl font-bold mb-2">📋 Kelola Booking Event</h1>
            <p class="text-gray-600">{{ $booking->event_name }}</p>
        </div>
        <span class="px-4 py-2 rounded-full text-white text-sm font-semibold
            @if($booking->admin_status === 'review') bg-blue-500
            @elseif($booking->admin_status === 'approved') bg-yellow-500
            @elseif($booking->admin_status === 'details_sent') bg-purple-500
            @elseif($booking->admin_status === 'gantt_uploaded') bg-green-500
            @elseif($booking->admin_status === 'rejected') bg-red-500
            @endif
        ">
            @if($booking->admin_status === 'review') Review
            @elseif($booking->admin_status === 'approved') Approved
            @elseif($booking->admin_status === 'details_sent') Details Sent
            @elseif($booking->admin_status === 'gantt_uploaded') Gantt Uploaded
            @elseif($booking->admin_status === 'rejected') Rejected
            @endif
        </span>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
            <p class="font-semibold">✓ {{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
            <p class="font-semibold">✗ {{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content (Left) -->
        <div class="lg:col-span-2">
            <!-- Client Info Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">👤 Data Pemesan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                    <div>
                        <p class="text-sm text-gray-600">Lokasi Event</p>
                        <p class="font-semibold">{{ $booking->location }}</p>
                    </div>
                </div>
            </div>

            <!-- Event Details Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">📅 Detail Event</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nama Event</p>
                        <p class="font-semibold">{{ $booking->event_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal</p>
                        <p class="font-semibold">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600 mb-1">Catatan</p>
                        <p class="font-semibold">{{ $booking->notes ?? 'Tidak ada catatan' }}</p>
                    </div>
                </div>
            </div>

            <!-- Proposal Download -->
            @if($booking->admin_status === 'review')
                <div class="bg-blue-50 rounded-lg shadow-md p-6 mb-6 border-l-4 border-blue-500">
                    <h3 class="text-lg font-bold mb-3">📄 Proposal Event</h3>
                    <p class="text-gray-600 mb-4">Review proposal yang dikirim oleh client sebelum mengsetujui atau menolak</p>
                    <a href="{{ asset('storage/' . $booking->proposal_file) }}" target="_blank" class="inline-block px-6 py-3 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600">
                        🔍 Buka Proposal
                    </a>
                </div>
            @endif

            <!-- Step 1: Review & Approve/Reject Proposal -->
            @if($booking->admin_status === 'review')
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-bold mb-4">✓ Keputusan Proposal</h3>
                    <p class="text-gray-600 mb-6">Apakah proposal ini bisa dikerjakan dengan budget client?</p>
                    
                    <div class="space-y-3">
                        <form method="POST" action="{{ route('booking.admin.approve', $booking->id) }}">
                            @csrf
                            <button class="w-full px-6 py-3 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition">
                                ✓ SETUJUI PROPOSAL → Lanjut Input Rincian Jasa
                            </button>
                        </form>

                        <form method="POST" action="{{ route('booking.admin.reject', $booking->id) }}">
                            @csrf
                            <button class="w-full px-6 py-3 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition">
                                ✗ TOLAK PROPOSAL
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Step 2: Input Rincian Jasa -->
            @if($booking->admin_status === 'approved')
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-bold mb-4">💰 Input Rincian Jasa & Harga</h3>
                    <p class="text-gray-600 mb-4">Masukkan detail layanan yang akan diberikan sesuai budget client</p>

                    <form method="POST" action="{{ route('booking.admin.sendDetails', $booking->id) }}">
                        @csrf
                        
                        <div id="details" class="mb-4">
                            <div class="detail-row mb-4 p-4 bg-gray-50 rounded border-l-4 border-yellow-500">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-semibold mb-2">Nama Jasa/Layanan</label>
                                        <input type="text" name="details[0][service_name]" placeholder="Contoh: Dekorasi" class="border rounded-lg p-3 w-full text-sm focus:ring-2 focus:ring-yellow-400" required />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold mb-2">Harga (Rp)</label>
                                        <input type="number" name="details[0][price]" placeholder="0" class="border rounded-lg p-3 w-full text-sm focus:ring-2 focus:ring-yellow-400" required />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold mb-2">Catatan</label>
                                        <input type="text" name="details[0][notes]" placeholder="Opsional" class="border rounded-lg p-3 w-full text-sm focus:ring-2 focus:ring-yellow-400" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="addDetail" class="mb-6 px-4 py-2 bg-gray-300 text-gray-800 rounded-lg font-semibold hover:bg-gray-400">
                            + Tambah Rincian Lain
                        </button>

                        <button type="submit" class="w-full px-6 py-3 bg-yellow-500 text-white rounded-lg font-semibold hover:bg-yellow-600 transition">
                            ➤ KIRIM RINCIAN KE CLIENT
                        </button>
                    </form>
                </div>
            @endif

            <!-- Step 3: Upload Gantt Chart -->
            @if($booking->admin_status === 'details_sent' || $booking->admin_status === 'gantt_uploaded')
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-bold mb-4">📊 Upload Gantt Chart & Persetujuan</h3>
                    <p class="text-gray-600 mb-4">Setelah client menyetujui rincian, upload jadwal pengerjaan dan file persetujuan</p>

                    <form method="POST" action="{{ route('booking.admin.uploadGantt', $booking->id) }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold mb-2">📊 Gantt Chart <span class="text-red-500">*</span></label>
                                <label class="block border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:bg-gray-50 transition">
                                    <span class="text-gray-600 block">Klik untuk upload</span>
                                    <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 5MB)</span>
                                    <input type="file" name="gantt_chart" accept=".pdf,.jpg,.jpeg,.png" class="hidden" required />
                                </label>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold mb-2">📋 Lembar Persetujuan <span class="text-red-500">*</span></label>
                                <label class="block border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:bg-gray-50 transition">
                                    <span class="text-gray-600 block">Klik untuk upload</span>
                                    <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 5MB)</span>
                                    <input type="file" name="approval_file" accept=".pdf,.jpg,.jpeg,.png" class="hidden" required />
                                </label>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold mb-2">👤 PIC Contact (Nama & No Telepon) <span class="text-red-500">*</span></label>
                            <input type="text" name="pic_contact" placeholder="Contoh: Budi (081234567890)" class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-purple-400" required />
                        </div>

                        <button type="submit" class="w-full px-6 py-3 bg-purple-500 text-white rounded-lg font-semibold hover:bg-purple-600 transition">
                            ➤ UPLOAD & KIRIM KE CLIENT
                        </button>
                    </form>
                </div>
            @endif

            <!-- Rincian Jasa yang Sudah Dikirim -->
            @if(in_array($booking->admin_status, ['details_sent', 'gantt_uploaded']))
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-bold mb-4">📋 Rincian Jasa (Sudah Dikirim)</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="px-4 py-3 text-left font-semibold">Jasa</th>
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
                                <tr class="bg-yellow-50 font-bold text-lg border-t-2">
                                    <td class="px-4 py-3">TOTAL</td>
                                    <td class="px-4 py-3 text-right">Rp {{ number_format($booking->details->sum('price') ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar (Right) -->
        <div class="lg:col-span-1">
            <!-- Progress Timeline -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 sticky top-24">
                <h3 class="text-lg font-bold mb-4">📍 Progress Timeline</h3>
                
                <div class="space-y-4">
                    <!-- Step 1 -->
                    <div class="flex">
                        <div class="flex flex-col items-center mr-4">
                            <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center text-xs font-bold">✓</div>
                            @if($booking->admin_status !== 'review')
                                <div class="w-0.5 h-12 bg-green-500"></div>
                            @else
                                <div class="w-0.5 h-12 bg-gray-300"></div>
                            @endif
                        </div>
                        <div class="pt-1">
                            <p class="font-semibold">Review Proposal</p>
                            <p class="text-xs text-gray-600">Client submit</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex">
                        <div class="flex flex-col items-center mr-4">
                                <div class="w-8 h-8 rounded-full @if(in_array($booking->admin_status, ['approved', 'details_sent', 'gantt_uploaded'])) bg-green-500 text-white @else bg-gray-300 @endif flex items-center justify-center text-xs font-bold">
                                @if(in_array($booking->admin_status, ['approved', 'details_sent', 'gantt_uploaded']))
                                    ✓
                                @else
                                    2
                                @endif
                            </div>
                            @if(in_array($booking->admin_status, ['details_sent', 'gantt_uploaded']))
                                <div class="w-0.5 h-12 bg-green-500"></div>
                            @else
                                <div class="w-0.5 h-12 bg-gray-300"></div>
                            @endif
                        </div>
                        <div class="pt-1">
                            <p class="font-semibold">Input Rincian Jasa</p>
                            <p class="text-xs text-gray-600">Admin input layanan</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex">
                        <div class="flex flex-col items-center mr-4">
                            <div class="w-8 h-8 rounded-full @if($booking->admin_status === 'gantt_uploaded') bg-green-500 text-white @else bg-gray-300 @endif flex items-center justify-center text-xs font-bold">
                                @if($booking->admin_status === 'gantt_uploaded')
                                    ✓
                                @else
                                    3
                                @endif
                            </div>
                        </div>
                        <div class="pt-1">
                            <p class="font-semibold">Upload Gantt Chart</p>
                            <p class="text-xs text-gray-600">Timeline pengerjaan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold mb-4">⚡ Quick Actions</h3>
                
                <div class="space-y-2">
                    <a href="{{ route('booking.index') }}" class="block w-full text-center px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        ← Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

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
                <input type="text" name="details[${idx}][service_name]" placeholder="Contoh: Dekorasi" class="border rounded-lg p-3 w-full text-sm focus:ring-2 focus:ring-yellow-400" required />
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Harga (Rp)</label>
                <input type="number" name="details[${idx}][price]" placeholder="0" class="border rounded-lg p-3 w-full text-sm focus:ring-2 focus:ring-yellow-400" required />
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Catatan</label>
                <input type="text" name="details[${idx}][notes]" placeholder="Opsional" class="border rounded-lg p-3 w-full text-sm focus:ring-2 focus:ring-yellow-400" />
            </div>
        </div>
    `;
    container.appendChild(div);
    idx++;
});
</script>
@endsection
