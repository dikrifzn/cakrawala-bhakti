@props(['booking'])

@php
    $detailsSent = in_array($booking->admin_status, ['detail_sent','final_approved','on_progress','finished']);
    $clientApproved = in_array($booking->customer_status, ['detail_approved','final_signed']);
    $approvalSent = in_array($booking->admin_status, ['final_approved','on_progress','finished']);
    $signed = $booking->customer_status === 'final_signed';
    $inProgress = $booking->admin_status === 'on_progress';
    $done = $booking->admin_status === 'finished';
@endphp

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-6">📈 Progress Status</h2>
    
    <div class="space-y-4">
        {{-- Step 1: Review & Kirim Rincian --}}
        <div class="flex items-start gap-4">
            <div class="shrink-0 w-8 h-8 rounded-full {{ $detailsSent ? 'bg-green-500' : 'bg-yellow-400' }} flex items-center justify-center text-white font-bold text-sm">
                {{ $detailsSent ? '✓' : '1' }}
            </div>
            <div class="grow">
                <p class="font-semibold text-gray-900">Admin review & kirim rincian</p>
                <p class="text-sm text-gray-600">Proposal direview lalu rincian jasa dikirim ke Anda</p>
                @if($detailsSent)
                    <p class="text-xs text-green-600 mt-1">✓ Rincian sudah dikirim</p>
                    <p class="text-xs text-blue-600 mt-1">
                        {{ $booking->customer_status === 'submitted' ? '⏳ Menunggu persetujuan Anda' : '✓ Anda sudah merespons rincian' }}
                    </p>
                @else
                    <p class="text-xs text-yellow-700 mt-1">⏳ Admin sedang mereview</p>
                @endif
            </div>
        </div>

        {{-- Step 2: Persetujuan Rincian oleh Anda --}}
        <div class="flex items-start gap-4">
            <div class="shrink-0 w-8 h-8 rounded-full {{ $clientApproved ? 'bg-blue-500' : ($detailsSent ? 'bg-yellow-400' : 'bg-gray-300') }} flex items-center justify-center text-white font-bold text-sm">
                {{ $clientApproved ? '✓' : '2' }}
            </div>
            <div class="grow">
                <p class="font-semibold text-gray-900">Persetujuan rincian</p>
                <p class="text-sm text-gray-600">Setujui atau tolak rincian jasa yang dikirim admin</p>
                @if($clientApproved)
                    <p class="text-xs text-green-600 mt-1">✓ Anda menyetujui rincian</p>
                @elseif($detailsSent)
                    <p class="text-xs text-blue-600 mt-1">⏳ Menunggu respon Anda</p>
                @endif
            </div>
        </div>

        {{-- Step 3: Lembar Persetujuan --}}
        <div class="flex items-start gap-4">
            <div class="shrink-0 w-8 h-8 rounded-full {{ $approvalSent ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center text-white font-bold text-sm">
                {{ $approvalSent ? '✓' : '3' }}
            </div>
            <div class="grow">
                <p class="font-semibold text-gray-900">Lembar persetujuan</p>
                <p class="text-sm text-gray-600">Admin menyiapkan dokumen persetujuan final</p>
                @if($approvalSent)
                    <p class="text-xs text-green-600 mt-1">✓ Dikirim admin</p>
                    @if(!$signed)
                        <p class="text-xs text-blue-600 mt-1">⏳ Menunggu tanda tangan Anda</p>
                    @endif
                @elseif($clientApproved)
                    <p class="text-xs text-blue-600 mt-1">⏳ Menunggu admin kirim dokumen</p>
                @endif
            </div>
        </div>

        {{-- Step 4: Tanda Tangan & Finalisasi --}}
        <div class="flex items-start gap-4">
            <div class="shrink-0 w-8 h-8 rounded-full {{ $signed ? 'bg-green-500' : ($approvalSent ? 'bg-yellow-400' : 'bg-gray-300') }} flex items-center justify-center text-white font-bold text-sm">
                {{ $signed ? '✓' : '4' }}
            </div>
            <div class="grow">
                <p class="font-semibold text-gray-900">Tanda tangan & finalisasi</p>
                <p class="text-sm text-gray-600">Upload tanda tangan Anda untuk mengesahkan dokumen</p>
                @if($signed)
                    <p class="text-xs text-green-600 mt-1">✓ Selesai</p>
                @elseif($approvalSent)
                    <p class="text-xs text-blue-600 mt-1">⏳ Menunggu tanda tangan Anda</p>
                @endif
            </div>
        </div>

        {{-- Step 5: Pengerjaan & Selesai --}}
        <div class="flex items-start gap-4">
            <div class="shrink-0 w-8 h-8 rounded-full {{ $done ? 'bg-emerald-600' : ($inProgress ? 'bg-blue-600' : 'bg-gray-300') }} flex items-center justify-center text-white font-bold text-sm">
                {{ $done ? '✓' : '5' }}
            </div>
            <div class="grow">
                <p class="font-semibold text-gray-900">Pengerjaan & penyelesaian</p>
                <p class="text-sm text-gray-600">Admin menjalankan pekerjaan setelah dokumen final</p>
                @if($inProgress)
                    <p class="text-xs text-blue-600 mt-1">🚧 Sedang dikerjakan</p>
                @elseif($done)
                    <p class="text-xs text-green-600 mt-1">✓ Selesai</p>
                @endif
            </div>
        </div>
    </div>
</div>
