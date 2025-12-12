<?php

namespace App\Filament\Resources\ProjectImages\Pages;

use App\Filament\Resources\ProjectImages\ProjectImageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProjectImage extends CreateRecord
{
    protected static string $resource = ProjectImageResource::class;

    protected static ?string $title = 'Tambah Gambar Proyek';
    protected ?string $heading = 'Tambah Gambar Proyek';
}
