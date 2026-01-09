<x-filament::page>
    @php
        $adminStatusMap = [
            'review' => ['label' => 'Review', 'pill' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100'],
            'detail_sent' => ['label' => 'Detail Sent', 'pill' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-100'],
            'final_approved' => ['label' => 'Approval Sent', 'pill' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-100'],
            'on_progress' => ['label' => 'On Progress', 'pill' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-100'],
            'finished' => ['label' => 'Finished', 'pill' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-100'],
            'rejected' => ['label' => 'Rejected', 'pill' => 'bg-rose-100 text-rose-800 dark:bg-rose-900 dark:text-rose-100'],
        ];

        $clientStatusMap = [
            'submitted' => ['label' => 'Submitted', 'pill' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100'],
            'detail_approved' => ['label' => 'Detail Approved', 'pill' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-100'],
            'final_signed' => ['label' => 'Final Signed', 'pill' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-100'],
            'rejected' => ['label' => 'Rejected', 'pill' => 'bg-rose-100 text-rose-800 dark:bg-rose-900 dark:text-rose-100'],
        ];

        $steps = [
            'review' => 'Review',
            'detail_sent' => 'Rincian dikirim',
            'final_approved' => 'Approval siap',
            'on_progress' => 'On progress',
            'finished' => 'Selesai',
        ];

        $stepKeys = array_keys($steps);
        $currentIndex = array_search($booking->admin_status, $stepKeys, true);
        $currentIndex = $currentIndex === false ? 0 : $currentIndex;
        $progress = round((($currentIndex + 1) / max(count($steps), 1)) * 100);

        $checklist = [
            ['label' => 'Proposal', 'ok' => filled($booking->proposal_file), 'hint' => 'Upload proposal PDF', 'link' => route('booking.downloadFile', ['booking' => $booking->id, 'type' => 'proposal_file'])],
            ['label' => 'Rincian Jasa', 'ok' => $booking->details->isNotEmpty(), 'hint' => 'Isi rincian via aksi "Kirim Rincian"'],
            ['label' => 'Jadwal', 'ok' => $booking->tasks->isNotEmpty(), 'hint' => 'Tambah jadwal di aksi "Kirim Rincian"'],
            ['label' => 'Approval', 'ok' => filled($booking->approval_file), 'hint' => 'Kirim lembar persetujuan'],
            ['label' => 'Tanda Tangan', 'ok' => filled($booking->signature_file), 'hint' => 'Upload TTD final'],
        ];

        $nextAction = match ($booking->admin_status) {
            'review' => 'Susun rincian & jadwal, lalu kirim ke client.',
            'detail_sent' => $booking->customer_status === 'detail_approved'
                ? 'Generate & kirim lembar persetujuan.'
                : 'Tunggu approval detail dari client.',
            'final_approved' => filled($booking->signature_file)
                ? 'Mulai pengerjaan.'
                : 'Tunggu / unggah tanda tangan final.',
            'on_progress' => 'Pantau task dan tandai selesai jika sudah rampung.',
            'finished' => 'Tidak ada aksi. Booking selesai.',
            'rejected' => 'Booking ditolak.',
            default => 'Lanjutkan sesuai alur.',
        };
    @endphp

    <div class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div class="space-y-2">
                <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                    <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100">ID #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
                    <span>{{ $booking->created_at?->format('d M Y') }}</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $booking->event_name }}</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $booking->customer_name }} · {{ $booking->location }}</p>

                <div class="flex flex-wrap gap-2 text-xs">
                            <span class="px-2 py-1 rounded-full {{ $adminStatusMap[$booking->admin_status]['pill'] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100' }}">Admin: {{ $adminStatusMap[$booking->admin_status]['label'] ?? ucfirst($booking->admin_status) }}</span>
                            <span class="px-2 py-1 rounded-full {{ $clientStatusMap[$booking->customer_status]['pill'] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100' }}">Client: {{ $clientStatusMap[$booking->customer_status]['label'] ?? ucfirst($booking->customer_status) }}</span>
                            @if($booking->approval_file)
                                <a href="{{ route('booking.downloadFile', ['booking' => $booking->id, 'type' => 'approval_file']) }}" target="_blank" class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-100">Approval ready</a>
                            @endif
                        </div>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ \App\Filament\Resources\Bookings\BookingResource::getUrl('edit', ['record' => $booking]) }}" class="px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100 border dark:border-gray-700">
                    Edit Data
                </a>
                <a href="{{ route('booking.downloadFile', ['booking' => $booking->id, 'type' => 'proposal_file']) }}" class="px-4 py-2 rounded-lg bg-primary-600 text-white text-sm hover:bg-primary-700">
                    Proposal
                </a>
                @if($booking->approval_file)
                    <a href="{{ route('booking.downloadFile', ['booking' => $booking->id, 'type' => 'approval_file']) }}" class="px-4 py-2 rounded-lg bg-emerald-600 text-white text-sm hover:bg-emerald-700">
                        Approval
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            <div class="p-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm border dark:border-gray-800 space-y-1">
                <h3 class="text-sm text-gray-500 dark:text-gray-400">Pemesan</h3>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $booking->customer_name }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $booking->customer_email }} · {{ $booking->customer_phone }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm border dark:border-gray-800 space-y-1">
                <h3 class="text-sm text-gray-500 dark:text-gray-400">Waktu</h3>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $booking->start_date }} - {{ $booking->end_date }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $booking->location }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm border dark:border-gray-800 space-y-2">
                <h3 class="text-sm text-gray-500 dark:text-gray-400">Catatan</h3>
                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $booking->notes ?: 'Tidak ada catatan' }}</p>
                <div class="mt-2">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Aksi berikutnya</p>
                    <p class="text-sm font-medium text-primary-700 dark:text-primary-200">{{ $nextAction }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            <div class="p-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm border dark:border-gray-800 lg:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-semibold text-gray-900 dark:text-gray-100">Progress Verifikasi</h2>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $progress }}%</span>
                </div>
                <div class="relative mb-4">
                    <div class="h-2 rounded-full bg-gray-100 dark:bg-gray-800"></div>
                    <div class="absolute left-0 top-0 h-2 rounded-full bg-primary-500" style="width: {{ $progress }}%"></div>
                </div>
                <div class="grid grid-cols-2 gap-2 md:grid-cols-5">
                    @foreach($steps as $key => $label)
                        @php
                            $active = $booking->admin_status === $key || array_search($booking->admin_status, $stepKeys, true) >= array_search($key, $stepKeys, true);
                        @endphp
                        <div class="p-3 rounded-lg border text-sm {{ $active ? 'border-primary-200 bg-primary-50 text-primary-700 dark:border-primary-900/50 dark:bg-primary-900/30 dark:text-primary-100' : 'border-gray-200 bg-gray-50 text-gray-600 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-300' }}">
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full {{ $active ? 'bg-primary-500' : 'bg-gray-300 dark:bg-gray-700' }}"></span>
                                <span>{{ $label }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="p-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm border dark:border-gray-800 space-y-3">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900 dark:text-gray-100">Checklist</h2>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Bantu verifikasi cepat</span>
                </div>
                <div class="space-y-2">
                    @foreach($checklist as $item)
                        <div class="flex items-start gap-3 p-3 rounded-lg border {{ $item['ok'] ? 'border-emerald-200 bg-emerald-50 dark:border-emerald-900/40 dark:bg-emerald-900/20' : 'border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-800/70' }}">
                            <div class="mt-1 h-2.5 w-2.5 rounded-full {{ $item['ok'] ? 'bg-emerald-500' : 'bg-gray-400 dark:bg-gray-600' }}"></div>
                            <div class="text-sm text-gray-800 dark:text-gray-100">
                                <div class="font-medium flex items-center gap-2">
                                    <span>{{ $item['label'] }}</span>
                                    @if($item['ok'] && ($item['link'] ?? false))
                                        <a class="text-primary-600 hover:underline" href="{{ $item['link'] }}" target="_blank">Lihat</a>
                                    @endif
                                </div>
                                @unless($item['ok'])
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $item['hint'] }}</p>
                                @endunless
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="p-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm border dark:border-gray-800">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold text-gray-900 dark:text-gray-100">Rincian Jasa</h2>
                <span class="text-sm text-gray-500 dark:text-gray-400">Total: Rp {{ number_format($booking->details->sum('price') ?? 0, 0, ',', '.') }}</span>
            </div>
            @if($booking->details->isEmpty())
                <p class="text-sm text-gray-600 dark:text-gray-300">Belum ada rincian. Gunakan aksi "Kirim Rincian" di atas.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-gray-500 dark:text-gray-400 border-b dark:border-gray-800">
                            <tr>
                                <th class="text-left py-2">Jasa</th>
                                <th class="text-left py-2">Harga</th>
                                <th class="text-left py-2">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-gray-800">
                            @foreach($booking->details as $detail)
                                <tr class="text-gray-900 dark:text-gray-100">
                                    <td class="py-2">{{ $detail->service_name }}</td>
                                    <td class="py-2">Rp {{ number_format($detail->price ?? 0, 0, ',', '.') }}</td>
                                    <td class="py-2 text-gray-600 dark:text-gray-300">{{ $detail->notes ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="p-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm border dark:border-gray-800">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold text-gray-900 dark:text-gray-100">Jadwal Pengerjaan</h2>
                <span class="text-sm text-gray-500 dark:text-gray-400">Urut berdasarkan order</span>
            </div>
            @if($booking->tasks->isEmpty())
                <p class="text-sm text-gray-600 dark:text-gray-300">Belum ada jadwal. Tambahkan saat mengirim rincian.</p>
            @else
                <div class="space-y-3">
                    @foreach($booking->tasks->sortBy('order') as $task)
                        <div class="p-3 border rounded-lg dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $task->task_name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $task->start_date }} - {{ $task->end_date }}</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PIC: {{ $task->pic ?: '-' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            <div class="p-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm border dark:border-gray-800">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-semibold text-gray-900 dark:text-gray-100">Proposal</h2>
                    <a href="{{ route('booking.downloadFile', ['booking' => $booking->id, 'type' => 'proposal_file']) }}" class="text-sm text-primary-600 hover:underline">Unduh</a>
                </div>
                <div class="aspect-4/3 w-full border rounded overflow-hidden dark:border-gray-800">
                    <iframe src="{{ route('booking.downloadFile', ['booking' => $booking->id, 'type' => 'proposal_file']) }}?inline=1" class="w-full h-full" frameborder="0"></iframe>
                </div>
            </div>

            <div class="p-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm border dark:border-gray-800">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-semibold text-gray-900 dark:text-gray-100">Lembar Persetujuan</h2>
                    @if($booking->approval_file)
                        <a href="{{ route('booking.downloadFile', ['booking' => $booking->id, 'type' => 'approval_file']) }}" class="text-sm text-primary-600 hover:underline">Unduh</a>
                    @endif
                </div>
                @if($booking->approval_file)
                    <div class="aspect-4/3 w-full border rounded overflow-hidden dark:border-gray-800">
                        <iframe src="{{ route('booking.downloadFile', ['booking' => $booking->id, 'type' => 'approval_file']) }}?inline=1" class="w-full h-full" frameborder="0"></iframe>
                    </div>
                @else
                    <p class="text-sm text-gray-600 dark:text-gray-300">Belum ada lembar persetujuan. Gunakan aksi "Kirim Lembar Persetujuan" di atas.</p>
                @endif
            </div>
        </div>

        <div class="p-4 bg-gray-50 dark:bg-gray-800/60 rounded-xl border dark:border-gray-800">
            <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Panduan cepat</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300">Gunakan tombol aksi di header (Kirim Rincian, Kirim Approval, Upload TTD, Mulai Pengerjaan) sesuai status untuk menyelesaikan verifikasi.</p>
        </div>
    </div>
</x-filament::page>
