<?php

namespace App\Filament\Resources\CallToActions;

use App\Filament\Resources\CallToActions\Pages\CreateCallToAction;
use App\Filament\Resources\CallToActions\Pages\EditCallToAction;
use App\Filament\Resources\CallToActions\Pages\ListCallToActions;
use App\Models\CallToAction;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\RichEditor;
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
        return $schema
            ->components([
                RichEditor::make('title')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('highlight_text'),
                Textarea::make('subtitle')
                    ->columnSpanFull(),
                FileUpload::make('background_image')
                    ->image()
                    ->disk('public')
                    ->directory('cta'),
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
                ImageColumn::make('background_image')
                    ->label('Gambar Latar'),
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
            ->toolbarActions([]);
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
