<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected static ?string $title = 'Proyek';

    protected ?string $heading = 'Proyek';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
