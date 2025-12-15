<?php

namespace App\Filament\Resources\WhyChooseUs;

use App\Filament\Resources\WhyChooseUs\Pages\EditWhyChooseUs;
use App\Models\WhyChooseUs;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class WhyChooseUsResource extends Resource
{
    protected static ?string $model = WhyChooseUs::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-star';

    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationLabel = 'Bagian Alasan Memilih Kami';
    protected static string | UnitEnum | null $navigationGroup = 'Pengaturan Website';
    protected static ?int $navigationSort = 3;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->label('Judul'),
                FileUpload::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->directory('why-choose-us')
                    ->image()
                    ->imageEditor()
                    ->maxSize(2048),
                RichEditor::make('description')
                    ->columnSpanFull()
                    ->label('Deskripsi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->html()
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dibuat pada')
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
            'index' => EditWhyChooseUs::route('/'),
        ];
    }
}
