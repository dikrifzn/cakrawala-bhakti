<?php

namespace App\Filament\Resources\BookingServices\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BookingServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('booking_id')
                    ->required()
                    ->numeric(),
                TextInput::make('service_id')
                    ->required()
                    ->numeric(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}
