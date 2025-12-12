<?php

namespace App\Filament\Resources\HeroBanners;

use App\Filament\Resources\HeroBanners\Pages\EditHeroBanner;
use App\Models\HeroBanner;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class HeroBannerResource extends Resource
{
    protected static ?string $model = HeroBanner::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationLabel = 'Bagian Hero';
    protected static string | UnitEnum | null $navigationGroup = 'Pengaturan Website';
    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        // Singleton: tidak boleh membuat record baru via UI
        return false;
    }

    public static function canDelete($record): bool
    {
        // Singleton: tidak boleh menghapus record
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                RichEditor::make('title')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('highlight_text'),
                Textarea::make('subtitle')
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('button_text'),
                TextInput::make('button_link'),
                FileUpload::make('background_image')
                    ->image()
                    ->disk('public')
                    ->directory('hero-banners')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                TextColumn::make('highlight_text')
                    ->label('Teks Highlight')
                    ->searchable(),
                TextColumn::make('button_text')
                    ->label('Teks Tombol')
                    ->searchable(),
                TextColumn::make('button_link')
                    ->label('Link Tombol')
                    ->searchable(),
                ImageColumn::make('background_image')
                    ->label('Gambar'),
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

    public static function getPages(): array
    {
        return [
            'index' => EditHeroBanner::route('/'),
        ];
    }
}
