<?php

namespace App\Filament\Resources\CallToActions\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CallToActionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('highlight_text'),
                Textarea::make('subtitle')
                    ->columnSpanFull(),
                FileUpload::make('background_image')
                    ->image(),
            ]);
    }
}
