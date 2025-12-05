<?php

namespace App\Filament\Resources\AboutSections\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AboutSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title'),
                TextInput::make('subtitle'),
                Textarea::make('description')
                    ->columnSpanFull(),
                FileUpload::make('image_1')
                    ->image(),
                FileUpload::make('image_2')
                    ->image(),
                FileUpload::make('image_3')
                    ->image(),
                FileUpload::make('image_4')
                    ->image(),
            ]);
    }
}
