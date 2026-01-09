<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Resources\Services\ServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;

    protected static ?string $title = 'Layanan';
    protected ?string $heading = 'Layanan';

    protected function getTableQuery(): Builder|Relation|null
    {
        return parent::getTableQuery()?->with(['creator']);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
