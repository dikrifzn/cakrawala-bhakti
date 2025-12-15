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
use Symfony\Component\HttpFoundation\StreamedResponse;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    protected static ?string $title = 'Pemesanan';
    protected ?string $heading = 'Pemesanan';

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
                    $query = $this->getFilteredTableQuery();
                    $bookings = $query->with('eventType', 'services')
                        ->orderBy('created_at', 'desc')
                        ->get();

                    $pdf = Pdf::loadView('reports.bookings-pdf', compact('bookings'));

                    $filename = 'laporan_booking_' . now()->format('Y-m-d_H-i-s') . '.pdf';

                    return new StreamedResponse(function () use ($pdf) {
                        echo $pdf->output();
                    }, 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                    ]);
                }),
            Action::make('export')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    $query = $this->getFilteredTableQuery();
                    $bookings = $query->with('eventType', 'services')
                        ->orderBy('created_at', 'desc')
                        ->get();

                    $csvContent = "ID,Nama Pelanggan,Email,Telepon,Tipe Event,Tanggal Mulai,Tanggal Selesai,Jam Mulai,Jam Selesai,Jumlah Hari,Lokasi,Catatan,Total Harga,Status,Tanggal Dibuat\n";

                    foreach ($bookings as $booking) {
                            $csvContent .= implode(',', [
                                $booking->id,
                                '"' . str_replace('"', '""', $booking->customer_name) . '"',
                                '"' . ($booking->customer_email ?? '') . '"',
                                '"' . ($booking->customer_phone ?? '') . '"',
                                '"' . str_replace('"', '""', $booking->eventType?->name ?? '-') . '"',
                                $booking->start_date,
                                $booking->end_date,
                                $booking->start_time,
                                $booking->end_time,
                                $booking->total_days,
                                '"' . str_replace('"', '""', $booking->location ?? '') . '"',
                                '"' . str_replace('"', '""', $booking->notes ?? '') . '"',
                                'Rp ' . number_format($booking->total_price, 0, ',', '.'),
                                $booking->status,
                                $booking->created_at->format('Y-m-d H:i:s'),
                            ]) . "\n";
                    }

                    $filename = 'laporan_booking_' . now()->format('Y-m-d_H-i-s') . '.csv';

                    $csvContent = mb_convert_encoding($csvContent, 'UTF-8', 'UTF-8');

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

    protected function getEmptyStateHeading(): ?string
    {
        return 'Belum ada pemesanan';
    }

    protected function getEmptyStateDescription(): ?string
    {
        return 'Tambahkan pemesanan baru untuk mulai mengelola booking.';
    }

    protected function getEmptyStateActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Pemesanan')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }
}
