@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-20 px-5">
    <!-- Tombol Kembali -->
    <div class="mb-6">
        <a href="{{ route('profile.bookings') }}"
           class="inline-flex items-center gap-2 text-yellow-600 hover:text-yellow-700 font-semibold text-sm px-4 py-2 rounded-lg border border-yellow-600 hover:bg-yellow-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Pesanan
        </a>
    </div>

    <!-- Header dengan Status -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Detail Penawaran</h1>
        <p class="text-gray-600 mb-4">{{ $booking->event_name }} • {{ $booking->start_date }} - {{ $booking->end_date }}</p>
        <div class="flex flex-wrap gap-2 text-sm">
            <span class="px-3 py-1 rounded-full text-white font-semibold
                @if($booking->admin_status === 'detail_sent') bg-purple-500
                @elseif($booking->admin_status === 'final_approved') bg-green-500
                @elseif($booking->admin_status === 'on_progress') bg-blue-600
                @elseif($booking->admin_status === 'finished') bg-emerald-600
                @elseif($booking->admin_status === 'rejected') bg-red-600
                @else bg-gray-500 @endif">
                Admin: {{ str_replace('_', ' ', $booking->admin_status) }}
            </span>
            <span class="px-3 py-1 rounded-full text-white font-semibold
                @if($booking->customer_status === 'submitted') bg-amber-500
                @elseif($booking->customer_status === 'detail_approved') bg-blue-500
                @elseif($booking->customer_status === 'final_signed') bg-green-600
                @elseif($booking->customer_status === 'rejected') bg-red-600
                @else bg-gray-500 @endif">
                Client: {{ str_replace('_', ' ', $booking->customer_status) }}
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

            {{-- Informasi Acara --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Informasi Acara</h2>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nama Acara</p>
                        <p class="font-semibold">{{ $booking->event_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Lokasi</p>
                        <p class="font-semibold">{{ $booking->location }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Mulai</p>
                        <p class="font-semibold">
                            {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Selesai</p>
                        <p class="font-semibold">
                            {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Informasi Pemesan --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Informasi Pemesan</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                </div>
            </div>

            {{-- Proposal --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Proposal Acara</h2>

                <a href="{{ route('booking.downloadFile', ['booking' => $booking->id, 'type' => 'proposal_file']) }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 text-yellow-600 font-semibold hover:underline">
                    📄 Download Proposal
                </a>
            </div>

            {{-- Catatan --}}
            @if($booking->notes)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Catatan Tambahan</h2>
                    <p class="text-gray-700">{{ $booking->notes }}</p>
                </div>
            @endif


            {{-- Progress Timeline Component --}}
            <x-booking.timeline :booking="$booking" />

            {{-- Jadwal Pengerjaan --}}
            @if($booking->tasks->count() > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Jadwal Pengerjaan</h2>
                    <div class="space-y-3">
                        @foreach($booking->tasks->sortBy('order') as $task)
                            <div class="p-3 border rounded-lg bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold">{{ $task->task_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $task->start_date }} - {{ $task->end_date }}</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PIC: {{ $task->pic ?: '-' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            {{-- Details Table Component --}}
            @if($booking->details->count() > 0)
                <x-booking.details-table :booking="$booking" />
            @endif


            {{-- Approval (Stage 3) --}}
            @if($booking->admin_status === 'final_approved')
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">📄 Lembar Persetujuan</h2>
                    
                    {{-- Approval Section Component --}}
                    <x-booking.approval-section :booking="$booking" />
                </div>
            @endif

            {{-- Ringkasan Lengkap Booking (Saat Selesai) --}}
            @if($booking->customer_status === 'final_signed')
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">✅ Ringkasan Booking Selesai</h2>
                        <span class="px-4 py-2 rounded-full bg-green-100 text-green-800 font-semibold text-sm">SELESAI</span>
                    </div>

                    {{-- Grid Layout untuk Ringkasan --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- Bagian Kiri: Info Acara & Pemesan --}}
                        <div class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-600 uppercase font-bold mb-2">ID Booking</p>
                                <p class="text-lg font-bold text-gray-900">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-600 uppercase font-bold mb-2">📅 Informasi Acara</p>
                                <div class="space-y-2">
                                    <div>
                                        <span class="text-xs text-gray-500">Nama Acara:</span>
                                        <p class="font-semibold text-gray-900">{{ $booking->event_name }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500">Lokasi:</span>
                                        <p class="font-semibold text-gray-900">{{ $booking->location }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500">Periode:</span>
                                        <p class="font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-600 uppercase font-bold mb-2">👤 Pemesan</p>
                                <div class="space-y-2">
                                    <div>
                                        <span class="text-xs text-gray-500">Nama:</span>
                                        <p class="font-semibold text-gray-900">{{ $booking->customer_name }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500">Email:</span>
                                        <p class="font-semibold text-gray-900">{{ $booking->customer_email }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500">Telepon:</span>
                                        <p class="font-semibold text-gray-900">{{ $booking->customer_phone }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Bagian Kanan: Approval & PIC --}}
                        <div class="space-y-4">
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <p class="text-xs text-green-700 uppercase font-bold mb-2">✓ Persetujuan Final</p>
                                <div class="space-y-2">
                                    <div>
                                        <span class="text-xs text-gray-500">Ditandatangani:</span>
                                        <p class="font-semibold text-gray-900">{{ $booking->approved_by ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500">Waktu:</span>
                                        <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->approved_at)->format('d M Y H:i') }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500">IP Address:</span>
                                        <p class="font-semibold text-gray-900 font-mono text-sm">{{ $booking->approval_ip ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            @if($booking->pic_contact)
                                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                    <p class="text-xs text-blue-700 uppercase font-bold mb-2">👨‍💼 Person In Charge</p>
                                    <div class="space-y-2">
                                        <p class="font-semibold text-gray-900">{{ $booking->pic_contact }}</p>
                                        <p class="text-xs text-gray-600">Silakan hubungi PIC untuk melanjutkan proses pengerjaan</p>
                                    </div>
                                </div>
                            @endif

                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-600 uppercase font-bold mb-2">📊 Status Admin</p>
                                <p class="font-semibold text-gray-900">
                                    @if($booking->admin_status === 'final_approved')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                            ✓ Approval Dikirim
                                        </span>
                                    @else
                                        {{ ucfirst($booking->admin_status) }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Rincian Jasa Lengkap --}}
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <p class="text-xs text-gray-600 uppercase font-bold mb-4">💰 Rincian Jasa & Harga (Disetujui)</p>
                        @if($booking->details->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-200">
                                        <tr>
                                            <th class="text-left px-3 py-2 font-semibold">No</th>
                                            <th class="text-left px-3 py-2 font-semibold">Jasa / Layanan</th>
                                            <th class="text-right px-3 py-2 font-semibold">Harga</th>
                                            <th class="text-left px-3 py-2 font-semibold">Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($booking->details as $index => $detail)
                                            <tr class="border-b hover:bg-white transition">
                                                <td class="px-3 py-2">{{ $index + 1 }}</td>
                                                <td class="px-3 py-2 font-semibold">{{ $detail->service_name }}</td>
                                                <td class="px-3 py-2 text-right font-semibold">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                                <td class="px-3 py-2 text-gray-600 text-xs">{{ $detail->notes ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-yellow-50 border-t-2 border-yellow-200">
                                        <tr>
                                            <td colspan="2" class="px-3 py-3 font-bold text-right">TOTAL</td>
                                            <td class="px-3 py-3 text-right font-bold text-lg text-yellow-700">Rp {{ number_format($booking->details->sum('price') ?? 0, 0, ',', '.') }}</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-600 text-sm">Tidak ada rincian jasa.</p>
                        @endif
                    </div>

                    {{-- Timeline Pengerjaan --}}
                    @if($booking->tasks->count() > 0)
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <p class="text-xs text-gray-600 uppercase font-bold mb-4">📅 Timeline Pengerjaan</p>
                            <div class="space-y-3">
                                @foreach($booking->tasks as $index => $task)
                                    <div class="flex items-start gap-4 pb-3 border-b last:border-b-0">
                                        <div class="shrink-0 w-8 h-8 rounded-full bg-yellow-400 text-white flex items-center justify-center font-bold text-sm">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="grow">
                                            <p class="font-semibold text-gray-900">{{ $task->task_name }}</p>
                                            <div class="flex gap-4 mt-1 text-xs text-gray-600">
                                                <span>📅 Mulai: {{ \Carbon\Carbon::parse($task->start_date)->format('d M Y') }}</span>
                                                <span>📅 Selesai: {{ \Carbon\Carbon::parse($task->end_date)->format('d M Y') }}</span>
                                                @if($task->pic)
                                                    <span>👤 PIC: {{ $task->pic }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Document Links --}}
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-600 uppercase font-bold mb-4">📄 Dokumen & File</p>
                        <div class="flex flex-wrap gap-3">
                            @if($booking->proposal_file)
                                <a href="{{ route('booking.downloadFile', ['booking' => $booking->id, 'type' => 'proposal_file']) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-semibold transition">
                                    📄 Download Proposal
                                </a>
                            @endif
                            @if($booking->approval_file)
                                <a href="{{ route('booking.downloadFile', ['booking' => $booking->id, 'type' => 'approval_file']) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-semibold transition">
                                    ✅ Download Dokumen Persetujuan (Tertanda Tangan)
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Info --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm">
                <p class="text-blue-800">
                    <span class="font-semibold">📌 Catatan:</span> Semua tahapan akan muncul di halaman ini seiring dengan proses review admin. Pantau status Anda secara berkala.
                </p>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
function renderGanttChart() {
    const ganttChartElement = document.getElementById('ganttChart');
    if (!ganttChartElement) {
        console.log('Gantt chart element not found');
        return;
    }

    const tasks = [
        @foreach($booking->tasks as $t)
            {
                x: {!! json_encode($t->task_name) !!},
                y: [new Date({!! json_encode($t->start_date) !!}).getTime(), new Date({!! json_encode($t->end_date) !!}).getTime()]
            },
        @endforeach
    ];

    console.log('Gantt tasks:', tasks);
    console.log('ApexCharts:', typeof ApexCharts);
    console.log('Tasks count:', tasks.length);

    if (tasks.length > 0 && typeof ApexCharts !== 'undefined') {
        try {
            // Clear any existing content
            ganttChartElement.innerHTML = '';
            
            const options = {
                chart: {
                    type: 'rangeBar',
                    height: 400,
                    toolbar: {
                        show: true
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: [{
                    name: 'Timeline',
                    data: tasks
                }],
                xaxis: {
                    type: 'datetime',
                    axisBorder: {
                        show: true
                    },
                    axisTicks: {
                        show: true
                    }
                },
                yaxis: {
                    title: {
                        text: 'Tasks'
                    }
                },
                stroke: {
                    width: 1
                },
                colors: ['#f59e0b'],
                states: {
                    hover: {
                        filter: {
                            type: 'darken',
                            value: 0.15
                        }
                    }
                }
            };
            
            const chart = new ApexCharts(ganttChartElement, options);
            chart.render();
            console.log('Gantt chart rendered successfully');
        } catch (error) {
            console.error('Error rendering gantt chart:', error);
            ganttChartElement.innerHTML = '<div class="p-8 text-center text-red-600"><p class="text-lg">❌ Gagal memuat Gantt chart. Detail: ' + error.message + '</p></div>';
        }
    } else if (tasks.length === 0) {
        ganttChartElement.innerHTML = '<div class="p-8 text-center text-gray-600"><p class="text-lg">📋 Belum ada jadwal (tasks) yang dibuat admin.</p></div>';
    } else {
        console.log('ApexCharts not loaded yet');
    }
}

// Ensure ApexCharts is loaded, then render
function ensureApexAndRender() {
    if (typeof ApexCharts === 'undefined') {
        console.log('ApexCharts not found, loading from CDN...');
        const s = document.createElement('script');
        s.src = 'https://cdn.jsdelivr.net/npm/apexcharts@latest';
        s.async = true;
        s.onload = function() {
            console.log('ApexCharts loaded dynamically');
            setTimeout(renderGanttChart, 100);
        };
        s.onerror = function(e) {
            console.error('Failed to load ApexCharts script', e);
            const ganttChartElement = document.getElementById('ganttChart');
            if (ganttChartElement) {
                ganttChartElement.innerHTML = '<div class="p-8 text-center text-red-600"><p>⚠️ Gagal memuat library Gantt chart</p></div>';
            }
        };
        document.head.appendChild(s);
    } else {
        setTimeout(renderGanttChart, 100);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', ensureApexAndRender);
} else {
    ensureApexAndRender();
}

// Handle signature file upload and preview
document.querySelectorAll('input[name="signature"]').forEach(input => {
    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                const previewContainer = this.closest('form').querySelector('#previewContainer');
                const previewImg = this.closest('form').querySelector('#signaturePreview');
                if (previewContainer && previewImg) {
                    previewImg.src = event.target.result;
                    previewContainer.classList.remove('hidden');
                }
            };
            reader.readAsDataURL(file);
        }
    });
});

// Handle drag and drop for signature upload
document.querySelectorAll('form.signature-dropzone').forEach(form => {
    const innerDropzone = form.querySelector('.signature-dropzone:not(form)');
    const fileInput = form.querySelector('input[name="signature"]');
    
    if (!innerDropzone || !fileInput) return;

    // Prevent default drag and drop behavior
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        innerDropzone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Highlight on drag over
    ['dragenter', 'dragover'].forEach(eventName => {
        innerDropzone.addEventListener(eventName, () => {
            innerDropzone.classList.add('border-blue-500', 'bg-blue-50');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        innerDropzone.addEventListener(eventName, () => {
            innerDropzone.classList.remove('border-blue-500', 'bg-blue-50');
        }, false);
    });

    // Handle drop
    innerDropzone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files.length > 0) {
            fileInput.files = files;
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        }
    }, false);

    // Make the whole dropzone clickable to select file
    innerDropzone.addEventListener('click', (e) => {
        if (e.target.tagName !== 'INPUT') {
            fileInput.click();
        }
    });
});

// Open PDF preview in modal
function openPdfPreview(pdfUrl) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
    modal.innerHTML = `
        <div class="bg-white rounded-lg shadow-2xl w-full max-h-[90vh] overflow-hidden flex flex-col">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold">Preview PDF Dokumen</h3>
                <button onclick="this.closest('.fixed').remove()" class="text-gray-600 hover:text-gray-900 text-2xl font-bold">&times;</button>
            </div>
            <div class="flex-1 overflow-auto">
                <iframe src="${pdfUrl}" class="w-full h-full" frameborder="0"></iframe>
            </div>
            <div class="flex justify-end gap-2 p-4 border-t">
                <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Tutup</button>
                <a href="${pdfUrl}" download class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Download PDF</a>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}
</script>
@endpush
