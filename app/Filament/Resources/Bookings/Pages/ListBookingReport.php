<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingReportResource;
use App\Models\Booking;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;

class ListBookingReport extends ListRecords
{
    protected static string $resource = BookingReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    $bookings = Booking::with('eventType', 'services')
                        ->orderBy('created_at', 'desc')
                        ->get();

                    $csvContent = "ID,Nama Pelanggan,Email,Telepon,Tipe Event,Tanggal Mulai,Tanggal Selesai,Jam Mulai,Jam Selesai,Jumlah Hari,Lokasi,Catatan,Total Harga,Status,Tanggal Dibuat\n";

                    foreach ($bookings as $booking) {
                        $csvContent .= implode(',', [
                            $booking->id,
                            '"' . str_replace('"', '""', $booking->customer_name) . '"',
                            '"' . $booking->customer_email . '"',
                            '"' . $booking->customer_phone . '"',
                            '"' . ($booking->eventType?->name ?? '-') . '"',
                            $booking->start_date,
                            $booking->end_date,
                            $booking->start_time,
                            $booking->end_time,
                            $booking->total_days,
                            '"' . str_replace('"', '""', $booking->location) . '"',
                            '"' . str_replace('"', '""', $booking->notes ?? '') . '"',
                            'Rp ' . number_format($booking->details->sum('price') ?? 0, 0, ',', '.'),
                            $booking->status,
                            $booking->created_at->format('Y-m-d H:i:s'),
                        ]) . "\n";
                    }

                    $filename = 'laporan_booking_' . now()->format('Y-m-d_H-i-s') . '.csv';

                    return response()->streamDownload(
                        function () use ($csvContent) {
                            echo $csvContent;
                        },
                        $filename,
                        [
                            'Content-Type' => 'text/csv; charset=utf-8',
                            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                        ]
                    );
                }),
        ];
    }
}
