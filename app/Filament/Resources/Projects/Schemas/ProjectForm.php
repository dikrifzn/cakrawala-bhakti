<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
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
                FileUpload::make('cover_image')
                    ->disk('public')
                    ->image()
                    ->required(),
            ]);
    }
}
