<?php

namespace App\Filament\Resources\BookingServices;

use App\Filament\Resources\BookingServices\Pages\CreateBookingService;
use App\Filament\Resources\BookingServices\Pages\EditBookingService;
use App\Filament\Resources\BookingServices\Pages\ListBookingServices;
use App\Filament\Resources\BookingServices\Schemas\BookingServiceForm;
use App\Filament\Resources\BookingServices\Tables\BookingServicesTable;
use App\Models\BookingService;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class BookingServiceResource extends Resource
{
    protected static ?string $model = BookingService::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $recordTitleAttribute = 'id';
    protected static ?string $navigationLabel = 'Layanan Pemesanan';
    protected static string | UnitEnum | null $navigationGroup = 'Pemesanan';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return BookingServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookingServicesTable::configure($table);
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
            'index' => ListBookingServices::route('/'),
            'create' => CreateBookingService::route('/create'),
            'edit' => EditBookingService::route('/{record}/edit'),
        ];
    }
}
