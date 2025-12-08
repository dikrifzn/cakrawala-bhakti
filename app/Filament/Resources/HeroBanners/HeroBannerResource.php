<?php

namespace App\Filament\Resources\HeroBanners;

use App\Filament\Resources\HeroBanners\Pages\EditHeroBanner;
use App\Filament\Resources\HeroBanners\Schemas\HeroBannerForm;
use App\Filament\Resources\HeroBanners\Tables\HeroBannersTable;
use App\Models\HeroBanner;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class HeroBannerResource extends Resource
{
    protected static ?string $model = HeroBanner::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static ?string $recordTitleAttribute = 'Hero Section';
    protected static string | UnitEnum | null $navigationGroup = 'Pengaturan Website';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return HeroBannerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HeroBannersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => EditHeroBanner::route('/'),
        ];
    }
}
