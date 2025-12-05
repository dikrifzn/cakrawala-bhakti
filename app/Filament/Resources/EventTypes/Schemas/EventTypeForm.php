<?php

namespace App\Filament\Resources\EventTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EventTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
