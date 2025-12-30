<x-filament::page>
    <div class="space-y-6 px-6 py-6">
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
            <div class="lg:col-span-2">
                <x-filament::card class="mb-6">
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
                </x-filament::card>

                <x-filament::card class="mb-6">
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
                </x-filament::card>
                @if($booking->admin_status === 'review')
                    <x-filament::card class="mb-6 border-l-4 border-blue-500">
                        <h3 class="text-lg font-bold mb-3">📄 Proposal Event</h3>
                        <p class="text-gray-600 mb-4">
                            Review proposal yang dikirim oleh client sebelum mengsetujui atau menolak
                        </p>

                        <div class="w-full h-[600px] border rounded-lg overflow-hidden bg-gray-100">
                            <iframe
                                src="{{ route('booking.downloadFile', [
                                    'booking' => $booking->id,
                                    'type' => 'proposal_file'
                                ]) }}?inline=1"
                                class="w-full h-full"
                            ></iframe>
                        </div>
                    </x-filament::card>
                @endif
                @if($booking->admin_status === 'review')
                    <x-filament::card class="mb-6">
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
                    </x-filament::card>
                @endif

                @if($booking->admin_status === 'approved')
                    <x-filament::card class="mb-6">
                        <h3 class="text-lg font-bold mb-4">💰 Input Rincian Jasa & Harga</h3>
                        <p class="text-gray-600 mb-4">Masukkan detail layanan yang akan diberikan sesuai budget client</p>

                        <form method="POST" action="{{ route('booking.admin.sendDetails', $booking->id) }}">
                            @csrf
                            <div id="filament-details" class="mb-4">
                                <div class="detail-row mb-4 p-4 rounded border-l-4 border-yellow-500 relative">
                                    
                                    <!-- tombol hapus -->
                                    <button
                                        type="button"
                                        class="absolute top-3 right-3 text-red-600 hover:text-red-800 text-sm"
                                        onclick="removeDetail(this)"
                                    >
                                        Hapus
                                    </button>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-sm font-semibold mb-2">Nama Jasa</label>
                                            <input type="text" name="details[0][service_name]" class="border rounded-lg p-3 w-full text-sm" required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold mb-2">Harga (Rp)</label>
                                            <input type="number" name="details[0][price]" class="border rounded-lg p-3 w-full text-sm" required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold mb-2">Catatan</label>
                                            <input type="text" name="details[0][notes]" class="border rounded-lg p-3 w-full text-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="filamentAddDetail" class="mb-4 px-4 py-2 bg-gray-300 rounded">+ Tambah Rincian</button>

                            <div class="flex gap-3">
                                <button type="submit" class="px-6 py-2 bg-yellow-500 text-white rounded">➤ KIRIM RINCIAN KE CLIENT</button>
                            </div>
                        </form>
                    </x-filament::card>
                @endif

                @if(in_array($booking->admin_status, ['details_sent', 'gantt_uploaded']))
                    <x-filament::card class="mb-6">
                        <h3 class="text-lg font-bold mb-4">📋 Rincian Jasa (Sudah Dikirim)</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="border-b">
                                        <th class="px-4 py-3 text-left font-semibold">Jasa</th>
                                        <th class="px-4 py-3 text-right font-semibold">Harga</th>
                                        <th class="px-4 py-3 text-left font-semibold">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($booking->details as $detail)
                                        <tr class="border-b">
                                            <td class="px-4 py-3">{{ $detail->service_name }}</td>
                                            <td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                            <td class="px-4 py-3 text-gray-600 text-sm">{{ $detail->notes ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="font-bold text-lg border-t-2">
                                        <td class="px-4 py-3">TOTAL</td>
                                        <td class="px-4 py-3 text-right">Rp {{ number_format($booking->details->sum('price') ?? 0, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </x-filament::card>

                    @if($booking->admin_status === 'details_sent' && $booking->customer_status === 'details_approved')
                        <x-filament::card class="mb-6">
                            <h3 class="text-lg font-bold mb-4">📊 Upload Gantt Chart & Persetujuan</h3>
                            <p class="text-gray-600 mb-4">Upload jadwal pengerjaan dan file persetujuan untuk dikirim ke client</p>

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
                                    <button type="submit" class="px-6 py-2 bg-purple-500 text-white rounded">➤ UPLOAD & KIRIM KE CLIENT</button>
                                </div>
                            </form>
                        </x-filament::card>
                    @elseif($booking->admin_status === 'details_sent')
                        <x-filament::card class="mb-6">
                            <p class="text-gray-600">Menunggu persetujuan client untuk rincian. Upload gantt akan tersedia setelah client menyetujui rincian.</p>
                        </x-filament::card>
                    @endif
                @endif
            </div>

            <div class="lg:col-span-1">
                <x-filament::card class="mb-6 sticky top-24">
                    <h3 class="text-lg font-bold mb-4">📍 Progress Timeline</h3>
                    <div class="space-y-4">
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
                </x-filament::card>

                <x-filament::card class="mb-6">
                    <h3 class="text-lg font-bold mb-4">⚡ Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ \App\Filament\Resources\Bookings\BookingResource::getUrl('index') }}" class="block w-full text-center px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">← Kembali ke Daftar</a>
                    </div>
                </x-filament::card>
            </div>
        </div>
    </div>
</x-filament::page>
@push('scripts')
<script>
let detailIndex = 1;

document.getElementById('filamentAddDetail').addEventListener('click', function () {
    const container = document.getElementById('filament-details');

    const html = `
        <div class="detail-row mb-4 p-4 rounded border-l-4 border-yellow-500 relative">
            <button type="button"
                class="absolute top-3 right-3 text-red-600 hover:text-red-800 text-sm"
                onclick="removeDetail(this)">
                Hapus
            </button>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <label class="block text-sm font-semibold mb-2">Nama Jasa</label>
                    <input type="text" name="details[${detailIndex}][service_name]" class="border rounded-lg p-3 w-full text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Harga (Rp)</label>
                    <input type="number" name="details[${detailIndex}][price]" class="border rounded-lg p-3 w-full text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Catatan</label>
                    <input type="text" name="details[${detailIndex}][notes]" class="border rounded-lg p-3 w-full text-sm">
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    detailIndex++;
});

function removeDetail(button) {
    button.closest('.detail-row').remove();
}
</script>

@endpush