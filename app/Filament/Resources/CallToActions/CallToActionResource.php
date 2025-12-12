<?php

namespace App\Filament\Resources\CallToActions;

use App\Filament\Resources\CallToActions\Pages\CreateCallToAction;
use App\Filament\Resources\CallToActions\Pages\EditCallToAction;
use App\Filament\Resources\CallToActions\Pages\ListCallToActions;
use App\Filament\Resources\CallToActions\Schemas\CallToActionForm;
use App\Filament\Resources\CallToActions\Tables\CallToActionsTable;
use App\Models\CallToAction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CallToActionResource extends Resource
{
    protected static ?string $model = CallToAction::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationLabel = 'Bagian CTA';
    protected static string | UnitEnum | null $navigationGroup = 'Pengaturan Website';
    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return CallToActionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CallToActionsTable::configure($table);
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
            'index' => EditCallToAction::route('/'),
        ];
    }
}
