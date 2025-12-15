<?php

namespace App\Filament\Resources\ArticleCategories\Pages;

use App\Filament\Resources\ArticleCategories\ArticleCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListArticleCategories extends ListRecords
{
    protected static string $resource = ArticleCategoryResource::class;

    protected static ?string $title = 'Kategori Artikel';
    protected ?string $heading = 'Kategori Artikel';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
