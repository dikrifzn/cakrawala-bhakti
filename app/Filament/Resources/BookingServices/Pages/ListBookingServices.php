<?php

namespace App\Filament\Resources\BookingServices\Pages;

use App\Filament\Resources\BookingServices\BookingServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBookingServices extends ListRecords
{
    protected static string $resource = BookingServiceResource::class;

    protected static ?string $title = 'Layanan Pemesanan';
    protected ?string $heading = 'Layanan Pemesanan';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
