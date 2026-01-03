@props(['booking'])

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-4">📄 Lembar Persetujuan Final</h2>

    @if($booking->admin_status === 'final_approved')
        <p class="text-gray-600 mb-4">
            Dokumen persetujuan sudah siap. {{ $booking->customer_status === 'final_signed' ? 'Anda telah menandatangani dokumen ini.' : 'Silakan tanda tangani untuk melanjutkan.' }}
        </p>

        {{-- PDF Display --}}
        <div class="mb-6">
            <p class="text-sm font-semibold mb-3">📄 Dokumen Persetujuan:</p>
            @if($booking->customer_status === 'final_signed' && $booking->approval_file)
                {{-- Display signed PDF with signature --}}
                <iframe src="{{ route('booking.approval.preview-signed', $booking->id) }}" 
                        class="w-full border rounded" 
                        style="min-height: 600px;">
                </iframe>
            @else
                {{-- Display unsigned preview --}}
                <iframe src="{{ route('booking.approval.preview', $booking->id) }}" 
                        class="w-full border rounded" 
                        style="min-height: 600px;">
                </iframe>
            @endif
        </div>

        {{-- Signature Upload Section --}}
        @if($booking->admin_status === 'final_approved' && $booking->customer_status === 'detail_approved')
            <div class="mt-8 pt-8 border-t-2">
                <h3 class="text-xl font-bold mb-4">✍️ Upload Tanda Tangan</h3>
                <p class="text-gray-600 mb-6">Upload gambar tanda tangan Anda untuk menyelesaikan persetujuan dokumen.</p>

                <form method="POST" action="{{ route('booking.signature.upload', $booking->id) }}" enctype="multipart/form-data" class="signature-dropzone">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-sm font-semibold mb-3">Pilih File Tanda Tangan (PNG/JPG)</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition cursor-pointer signature-dropzone">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v4a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32 0h-9.5M7 20h9.5M7 28h20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p class="text-gray-700 font-semibold">Drag and drop tanda tangan di sini</p>
                            <p class="text-gray-500 text-sm">atau klik untuk memilih file</p>
                            <input type="file" name="signature" accept="image/png,image/jpeg" class="hidden" required>
                        </div>

                        @error('signature')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Preview --}}
                    <div id="previewContainer" class="mb-6 hidden">
                        <p class="text-sm font-semibold mb-2">Preview Tanda Tangan:</p>
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <img id="signaturePreview" src="" alt="Signature Preview" class="max-w-xs h-auto">
                        </div>
                    </div>

                    {{-- Requirements --}}
                    <div class="mb-6 p-4 bg-yellow-50 rounded border-l-4 border-yellow-500">
                        <p class="text-sm font-semibold text-yellow-900 mb-2">📋 Persyaratan Tanda Tangan:</p>
                        <ul class="text-sm text-yellow-800 space-y-1">
                            <li>✓ Format: PNG atau JPG</li>
                            <li>✓ Ukuran maksimal: 5 MB</li>
                            <li>✓ Resolusi minimal: 300 x 150 px</li>
                            <li>✓ Tanda tangan harus jelas dan dapat terbaca</li>
                        </ul>
                    </div>

                    {{-- Disclaimer --}}
                    <div class="mb-6 p-4 bg-blue-50 rounded border-l-4 border-blue-500">
                        <p class="text-xs text-blue-900">
                            <b>⚖️ Pernyataan:</b> Dengan menandatangani dokumen ini, Anda setuju dengan semua ketentuan yang tertera. Dokumen ini sah secara hukum sesuai dengan Undang-Undang Informasi dan Transaksi Elektronik (ITE).
                        </p>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">
                        ✍️ Selesaikan Penandatanganan
                    </button>
                </form>
            </div>
        @elseif($booking->customer_status === 'final_signed')
            <div class="p-4 bg-green-50 border border-green-200 rounded-lg mt-6">
                <p class="text-sm text-green-800">
                    <span class="font-semibold">✓ Booking Dikonfirmasi!</span> Semua dokumen sudah ditandatangani dan disetujui. Hubungi PIC kami untuk melanjutkan.
                </p>
            </div>
        @endif
    @else
        <p class="text-gray-500">Lembar persetujuan akan tersedia setelah Anda menyetujui rincian jasa.</p>
    @endif
</div>
