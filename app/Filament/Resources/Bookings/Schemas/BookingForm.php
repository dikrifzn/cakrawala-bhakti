<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Models\Service;
use Carbon\Carbon;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Placeholder::make('section_pelanggan')->content('Data Pelanggan')->columnSpanFull(),
                TextInput::make('customer_name')
                    ->label('Nama Pelanggan')
                    ->required()
                    ->placeholder('Nama lengkap')
                    ->columnSpan(1),
                TextInput::make('customer_phone')
                    ->label('Telepon')
                    ->tel()
                    ->placeholder('+62...')
                    ->helperText('Gunakan nomor yang aktif untuk koordinasi')
                    ->columnSpan(1),
                TextInput::make('customer_email')
                    ->label('Email')
                    ->email()
                    ->placeholder('nama@domain.com')
                    ->columnSpanFull(),

                Placeholder::make('section_acara')->content('Detail Acara')->columnSpanFull(),
                Select::make('event_type_id')
                    ->label('Jenis Acara')
                    ->relationship('eventType', 'name') 
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpan(1),
                TextInput::make('location')
                    ->label('Lokasi')
                    ->placeholder('Hotel / Gedung / Kota')
                    ->columnSpan(1),
                DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                        self::syncTotalDays($set, $get);
                    })
                    ->columnSpan(1),
                DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                        self::syncTotalDays($set, $get);
                    })
                    ->columnSpan(1),
                TimePicker::make('start_time')
                    ->label('Jam Mulai')
                    ->seconds(false)
                    ->columnSpan(1),
                TimePicker::make('end_time')
                    ->label('Jam Selesai')
                    ->seconds(false)
                    ->columnSpan(1),
                TextInput::make('total_days')
                    ->label('Total Hari')
                    ->numeric()
                    ->required()
                    ->readOnly()
                    ->default(1)
                    ->helperText('Otomatis dihitung dari tanggal mulai & selesai')
                    ->columnSpan(1),

                Placeholder::make('section_layanan')->content('Layanan')->columnSpanFull(),
                CheckboxList::make('selectedServices')
                    ->label('Layanan')
                    ->options(fn () => Service::orderBy('service_name')->pluck('service_name', 'id'))
                    ->columns(2)
                    ->searchable()
                    ->helperText('Pilih layanan yang dibutuhkan')
                    ->columnSpanFull(),
                Checkbox::make('include_permit')
                    ->label('Include Perizinan')
                    ->inline(false)
                    ->columnSpan(1),
                TextInput::make('permit_price')
                    ->label('Biaya Perizinan')
                    ->numeric()
                    ->default(0)
                    ->prefix('Rp')
                    ->visible(fn (Get $get) => (bool) $get('include_permit'))
                    ->columnSpan(1),
                Textarea::make('notes')
                    ->label('Catatan')
                    ->placeholder('Kebutuhan khusus, rundown, detail teknis, dll.')
                    ->columnSpanFull(),

                Placeholder::make('section_harga')->content('Harga & Status')->columnSpanFull(),
                TextInput::make('total_price')
                    ->label('Total Harga')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('Rp')
                    ->helperText('Isi total estimasi sesuai layanan dan perizinan')
                    ->columnSpan(1),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'finished' => 'Finished',
                    ])
                    ->default('pending')
                    ->required()
                    ->columnSpan(1),
            ]);
    }

    protected static function syncTotalDays(Set $set, Get $get): void
    {
        $start = $get('start_date');
        $end = $get('end_date');

        if (! $start || ! $end) {
            return;
        }

        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);

        $days = $endDate->diffInDays($startDate) + 1;

        $set('total_days', max(1, $days));
    }
}
