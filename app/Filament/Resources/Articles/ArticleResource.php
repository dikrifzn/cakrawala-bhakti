<?php

namespace App\Filament\Resources\Articles;

use App\Filament\Resources\Articles\Pages\CreateArticle;
use App\Filament\Resources\Articles\Pages\EditArticle;
use App\Filament\Resources\Articles\Pages\ListArticles;
use App\Models\Article;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationLabel = 'Artikel';
    protected static string | UnitEnum | null $navigationGroup = 'Publikasi';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name') 
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        TextInput::make('name')->label('Nama Kategori')->required(),
                        TextInput::make('slug')->label('Slug')->required(),
                    ]),
                FileUpload::make('thumbnail')
                    ->image()
                    ->disk('public')
                    ->directory('articles'),
                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginationPageOptions([25, 50, 100])
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                ImageColumn::make('thumbnail')
                    ->label('Gambar')
                    ->getStateUsing(fn ($record) => 
                        $record->thumbnail 
                            ? asset('storage/' . $record->thumbnail) 
                            : asset('img/default-thumbnail.png')
                    )
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
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
            'title',
            'slug',
            'content',
        ];
    }

    public static function getGlobalSearchResultTitle($record): string
    {
        return $record->title ?? 'Artikel';
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        $details = [];
        if (!empty($record->category?->name)) {
            $details[] = 'Kategori: ' . $record->category->name;
        }
        if (!empty($record->slug)) {
            $details[] = 'Slug: ' . $record->slug;
        }
        return $details;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArticles::route('/'),
            'create' => CreateArticle::route('/create'),
            'edit' => EditArticle::route('/{record}/edit'),
        ];
    }
}
