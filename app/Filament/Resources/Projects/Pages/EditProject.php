<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected static ?string $title = 'Ubah Proyek';
    protected ?string $heading = 'Ubah Proyek';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

}
