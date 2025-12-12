<?php

namespace App\Filament\Resources\ProjectImages;

use App\Filament\Resources\ProjectImages\Pages\CreateProjectImage;
use App\Filament\Resources\ProjectImages\Pages\EditProjectImage;
use App\Filament\Resources\ProjectImages\Pages\ListProjectImages;
use App\Models\ProjectImage;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ProjectImageResource extends Resource
{
    protected static ?string $model = ProjectImage::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static ?string $recordTitleAttribute = 'id';
    protected static ?string $navigationLabel = 'Gambar Proyek';
    protected static string | UnitEnum | null $navigationGroup = 'Publikasi';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->relationship('project', 'project_title')
                    ->required()
                    ->searchable(),
                FileUpload::make('image')
                    ->disk('public')
                    ->image()
                    ->directory('project')
                    ->multiple()
                    ->reorderable()
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.project_title')
                    ->label('Proyek')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('image_count')
                    ->label('Gambar')
                    ->getStateUsing(fn($record) => is_array($record->image) ? count($record->image) : 1)
                    ->badge()
                    ->color('info'),
                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
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

    public static function getPages(): array
    {
        return [
            'index' => ListProjectImages::route('/'),
            'create' => CreateProjectImage::route('/create'),
            'edit' => EditProjectImage::route('/{record}/edit'),
        ];
    }
}
