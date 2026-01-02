<x-filament::page>
    <div class="space-y-6">
        <div class="flex items-start justify-between gap-4 flex-wrap">
            <div class="space-y-1">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Review Booking</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300">ID #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }} · {{ $booking->event_name }}</p>
                <div class="flex flex-wrap gap-2 text-xs">
                    <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100">Admin: {{ $booking->admin_status }}</span>
                    <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-100">Client: {{ $booking->customer_status }}</span>
                    @if($booking->approval_file)
                        <a href="{{ route('booking.downloadFile', ['booking' => $booking->id, 'type' => 'approval_file']) }}" target="_blank" class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-100">Approval ready</a>
                    @endif
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ \App\Filament\Resources\Bookings\BookingResource::getUrl('edit', ['record' => $booking]) }}" class="px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100 border dark:border-gray-700">
                    Edit Data
                </a>
                <a href="{{ route('booking.downloadFile', ['booking' => $booking->id, 'type' => 'proposal_file']) }}" class="px-4 py-2 rounded-lg bg-primary-600 text-white text-sm hover:bg-primary-700">
                    Proposal
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm border dark:border-gray-800">
                <h3 class="text-sm text-gray-500 dark:text-gray-400">Pemesan</h3>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $booking->customer_name }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $booking->customer_email }} · {{ $booking->customer_phone }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm border dark:border-gray-800">
                <h3 class="text-sm text-gray-500 dark:text-gray-400">Waktu</h3>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $booking->start_date }} - {{ $booking->end_date }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $booking->location }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm border dark:border-gray-800">
                <h3 class="text-sm text-gray-500 dark:text-gray-400">Catatan</h3>
                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $booking->notes ?: 'Tidak ada catatan' }}</p>
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

        <div class="p-4 bg-gray-50 dark:bg-gray-800/60 rounded-xl border dark:border-gray-800">
            <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Workflow</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300">Gunakan tombol aksi di header halaman ini untuk kirim rincian, kirim approval, mulai pekerjaan, atau menolak booking.</p>
        </div>
    </div>
</x-filament::page>
