<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Models\Service;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\CheckboxList;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('customer_name')
                    ->required(),
                TextInput::make('customer_email')
                    ->email(),
                TextInput::make('customer_phone')
                    ->tel(),
                Select::make('event_type_id')
                    ->label('Event Type')
                    ->relationship('eventType', 'name') 
                    ->searchable()
                    ->preload()
                    ->required(),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date')
                    ->required(),
                TimePicker::make('start_time'),
                TimePicker::make('end_time'),
                TextInput::make('total_days')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('location'),
                CheckboxList::make('selectedServices')
                    ->label('Services')
                    ->options(Service::pluck('service_name', 'id'))
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('Rp'),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'finished' => 'Finished',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }
}
