<?php

namespace App\Filament\Resources\ProjectImages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProjectImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('project_id')
                    ->required()
                    ->numeric(),
                FileUpload::make('image')
                    ->disk('public')
                    ->image()
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
