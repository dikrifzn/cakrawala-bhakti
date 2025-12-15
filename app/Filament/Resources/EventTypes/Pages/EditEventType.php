<?php

namespace App\Filament\Resources\EventTypes\Pages;

use App\Filament\Resources\EventTypes\EventTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEventType extends EditRecord
{
    protected static string $resource = EventTypeResource::class;

    protected static ?string $title = 'Ubah Jenis Acara';
    protected ?string $heading = 'Ubah Jenis Acara';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
