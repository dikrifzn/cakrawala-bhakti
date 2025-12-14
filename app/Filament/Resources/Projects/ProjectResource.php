<?php

namespace App\Filament\Resources\Projects;

use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Models\Project;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'project_title';
    protected static ?string $navigationLabel = 'Proyek';
    protected static string | UnitEnum | null $navigationGroup = 'Publikasi';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('project_title')
                    ->required(),
                TextInput::make('client_name'),
                TextInput::make('location'),
                DatePicker::make('date'),
                Textarea::make('description')
                    ->columnSpanFull(),
                FileUpload::make('images')
                    ->label('Gambar Proyek')
                    ->image()
                    ->multiple()
                    ->reorderable()
                    ->disk('public')
                    ->directory('projects')
                    ->columnSpanFull()
                    ->helperText('Unggah beberapa gambar sekaligus. Urutan bisa diubah.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project_title')
                    ->label('Judul Proyek')
                    ->searchable(),
                TextColumn::make('client_name')
                    ->label('Nama Klien')
                    ->searchable(),
                TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable(),
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                ImageColumn::make('images')
                    ->label('Gambar')
                    ->getStateUsing(fn ($record) => $record->images[0] ?? null)
                    ->circular(),
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
            'project_title',
            'client_name',
            'location',
            'description',
        ];
    }

    public static function getGlobalSearchResultTitle($record): string
    {
        return $record->project_title ?? 'Proyek';
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        $details = [];
        if (!empty($record->client_name)) {
            $details[] = 'Klien: ' . $record->client_name;
        }
        if (!empty($record->location)) {
            $details[] = 'Lokasi: ' . $record->location;
        }
        if (!empty($record->date)) {
            $details[] = 'Tanggal: ' . ($record->date instanceof \Carbon\Carbon ? $record->date->format('d M Y') : (string) $record->date);
        }
        return $details;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }
}
