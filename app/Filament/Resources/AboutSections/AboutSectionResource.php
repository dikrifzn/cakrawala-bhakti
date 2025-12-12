<?php

namespace App\Filament\Resources\AboutSections;

use App\Filament\Resources\AboutSections\Pages\EditAboutSection;
use App\Filament\Resources\AboutSections\Schemas\AboutSectionForm;
use App\Filament\Resources\AboutSections\Tables\AboutSectionsTable;
use App\Models\AboutSection;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class AboutSectionResource extends Resource
{
    protected static ?string $model = AboutSection::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationLabel = 'Bagian Tentang';
    protected static string | UnitEnum | null $navigationGroup = 'Pengaturan Website';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return AboutSectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AboutSectionsTable::configure($table);
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
            'index' => EditAboutSection::route('/'),
        ];
    }
}
