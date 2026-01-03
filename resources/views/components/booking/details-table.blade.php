@props(['booking'])

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-4">📝 Rincian Jasa / Service Details</h2>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="text-left py-3 px-2">Jasa</th>
                    <th class="text-center py-3 px-2">Harga</th>
                    <th class="text-right py-3 px-2">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($booking->details as $detail)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="text-left py-3">{{ $detail->service_name }}</td>
                        <td class="text-center py-3 font-semibold">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td class="text-right py-3 text-gray-600">{{ $detail->notes ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-6 text-gray-500">Belum ada rincian jasa</td>
                    </tr>
                @endforelse
            </tbody>
            @if($booking->details->count() > 0)
                <tfoot class="border-t-2 bg-gray-50">
                    <tr>
                        <td class="py-3 font-bold">Total</td>
                        <td class="py-3 font-bold"></td>
                        <td class="text-right py-3 text-lg font-bold text-yellow-600">
                            Rp {{ number_format($booking->details->sum('price') ?? 0, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>

    {{-- Action Buttons for Details Stage --}}
    @if($booking->admin_status === 'detail_sent' && $booking->customer_status === 'submitted')
        <div class="flex gap-3 mt-6">
            <form action="{{ route('booking.client.approveDetails', $booking->id) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full px-4 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition">
                    ✓ Setujui Rincian
                </button>
            </form>
            <form action="{{ route('booking.client.rejectDetails', $booking->id) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition">
                    ✗ Tolak Rincian
                </button>
            </form>
        </div>
    @elseif($booking->admin_status === 'detail_sent' && $booking->customer_status !== 'submitted')
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <p class="text-sm text-blue-800">
                <span class="font-semibold">Status:</span> Anda telah {{ $booking->customer_status === 'detail_approved' ? '✓ menyetujui' : '✗ menolak' }} rincian jasa ini.
            </p>
        </div>
    @endif
</div>
