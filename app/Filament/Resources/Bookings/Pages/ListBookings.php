<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use App\Models\Booking;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    protected function getTableQuery(): Builder|Relation|null
    {
        return parent::getTableQuery()?->with(['bookingServices.service', 'eventType']);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportPdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document')
                ->color('danger')
                ->action(function () {
                    $bookings = Booking::with('eventType', 'services')
                        ->orderBy('created_at', 'desc')
                        ->get();

                    $pdf = Pdf::loadView('reports.bookings-pdf', compact('bookings'));
                    
                    return $pdf->download('laporan_booking_' . now()->format('Y-m-d_H-i-s') . '.pdf');
                }),
            Action::make('export')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    $bookings = Booking::with('eventType', 'services')
                        ->orderBy('created_at', 'desc')
                        ->get();

                    // Create CSV content
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
                            'Rp ' . number_format($booking->total_price, 0, ',', '.'),
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
            CreateAction::make(),
        ];
    }
}
