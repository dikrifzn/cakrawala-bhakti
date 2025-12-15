<?php

namespace App\Filament\Resources\BookingServices\Pages;

use App\Filament\Resources\BookingServices\BookingServiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookingService extends CreateRecord
{
    protected static string $resource = BookingServiceResource::class;

    protected static ?string $title = 'Tambah Layanan Pemesanan';
    protected ?string $heading = 'Tambah Layanan Pemesanan';
}
