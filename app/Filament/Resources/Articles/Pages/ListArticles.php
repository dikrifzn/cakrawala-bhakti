<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Filament\Resources\Articles\ArticleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;

    protected static ?string $title = 'Artikel';
    protected ?string $heading = 'Artikel';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
