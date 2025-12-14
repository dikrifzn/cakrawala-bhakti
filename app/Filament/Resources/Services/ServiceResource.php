<?php

namespace App\Filament\Resources\Services;

use App\Filament\Resources\Services\Pages\CreateService;
use App\Filament\Resources\Services\Pages\EditService;
use App\Filament\Resources\Services\Pages\ListServices;
use App\Models\Service;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $recordTitleAttribute = 'service_name';
    protected static ?string $navigationLabel = 'Layanan';
    protected static string | UnitEnum | null $navigationGroup = 'Pemesanan';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('service_name')
                    ->required(),
                TextInput::make('short_description'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                FileUpload::make('banner_image')
                    ->image()
                    ->disk('public')
                    ->directory('services'),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('created_by')
                    ->label('Dibuat oleh')
                    ->options(User::pluck('name', 'id'))
                    ->disabled()
                    ->visible(fn () => false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginationPageOptions([25, 50, 100])
            ->columns([
                TextColumn::make('service_name')
                    ->label('Nama Layanan')
                    ->searchable(),
                TextColumn::make('short_description')
                    ->label('Deskripsi Singkat')
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Harga')
                    ->money()
                    ->sortable(),
                ImageColumn::make('banner_image')
                    ->label('Gambar Banner'),
                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('creator.name')
                    ->label('Dibuat oleh')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diubah pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'service_name',
            'short_description',
            'icon',
        ];
    }

    public static function getGlobalSearchResultTitle($record): string
    {
        return $record->service_name ?? 'Layanan';
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        $details = [];
        if (!empty($record->short_description)) {
            $details[] = 'Deskripsi: ' . $record->short_description;
        }
        if (!empty($record->icon)) {
            $details[] = 'Ikon: ' . $record->icon;
        }
        if (!empty($record->price)) {
            $details[] = 'Harga: Rp' . number_format($record->price, 0, ',', '.');
        }
        return $details;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServices::route('/'),
            'create' => CreateService::route('/create'),
            'edit' => EditService::route('/{record}/edit'),
        ];
    }
}
