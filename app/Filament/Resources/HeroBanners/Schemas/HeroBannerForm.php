<?php

namespace App\Filament\Resources\HeroBanners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;

class HeroBannerForm
{
    public static function configure(Schema $schema): Schema
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
}
