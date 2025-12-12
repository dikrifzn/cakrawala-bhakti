<?php

namespace App\Filament\Resources\EventTypes\Pages;

use App\Filament\Resources\EventTypes\EventTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEventType extends CreateRecord
{
    protected static string $resource = EventTypeResource::class;

    protected static ?string $title = 'Tambah Jenis Acara';
    protected ?string $heading = 'Tambah Jenis Acara';
}
