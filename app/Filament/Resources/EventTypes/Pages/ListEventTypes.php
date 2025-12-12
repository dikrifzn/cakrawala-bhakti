<?php

namespace App\Filament\Resources\EventTypes\Pages;

use App\Filament\Resources\EventTypes\EventTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventTypes extends ListRecords
{
    protected static string $resource = EventTypeResource::class;

    protected static ?string $title = 'Jenis Acara';
    protected ?string $heading = 'Jenis Acara';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
