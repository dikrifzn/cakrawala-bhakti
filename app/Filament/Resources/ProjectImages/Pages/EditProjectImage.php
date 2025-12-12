<?php

namespace App\Filament\Resources\ProjectImages\Pages;

use App\Filament\Resources\ProjectImages\ProjectImageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProjectImage extends EditRecord
{
    protected static string $resource = ProjectImageResource::class;

    protected static ?string $title = 'Ubah Gambar Proyek';
    protected ?string $heading = 'Ubah Gambar Proyek';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
