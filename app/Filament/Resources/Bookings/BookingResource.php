<?php

namespace App\Filament\Resources\Bookings;

use App\Filament\Resources\Bookings\Pages\CreateBooking;
use App\Filament\Resources\Bookings\Pages\EditBooking;
use App\Filament\Resources\Bookings\Pages\ListBookings;
use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use App\Notifications\BookingStatusUpdatedNotification;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\Action as TableAction;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Collection;
use UnitEnum;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $recordTitleAttribute = 'event_name';
    protected static ?string $navigationLabel = 'Pemesanan';
    protected static string | UnitEnum | null $navigationGroup = 'Booking';
    protected ?string $heading = 'Custom Page Heading';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Yang belum di proses';
    }
    

    public static function form(Schema $schema): Schema
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
                        static::syncTotalDays($set, $get);
                    })
                    ->columnSpan(1),
                DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                        static::syncTotalDays($set, $get);
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
                Repeater::make('booking_services')
                    ->label('Layanan yang Dipilih')
                    ->relationship('bookingServices')
                    ->schema([
                        Select::make('service_id')
                            ->label('Layanan')
                            ->options(function ($record, $get) {
                                $booking = $get('../../'); // Get parent record (booking)
                                $bookingRecord = $record?->booking ?? Booking::find($booking['id'] ?? null);
                                
                                return Service::where(function ($query) use ($bookingRecord) {
                                    $query->whereHas('creator', function ($q) {
                                        $q->where('role', 'admin');
                                    })
                                    ->orWhere('created_by', $bookingRecord?->user_id)
                                    ->orWhereNull('created_by');
                                })
                                ->orderBy('service_name')
                                ->pluck('service_name', 'id');
                            })
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                $service = Service::find($state);
                                if ($service) {
                                    $set('price', $service->price ?? 0);
                                }
                            })
                            ->searchable()
                            ->columnSpan(2),
                        TextInput::make('price')
                            ->label('Harga')
                            ->numeric()
                            ->required()
                            ->prefix('Rp')
                            ->helperText('Harga dapat disesuaikan')
                            ->columnSpan(1),
                        TextInput::make('quantity')
                            ->label('Jumlah')
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->minValue(1)
                            ->columnSpan(1),
                    ])
                    ->columns(4)
                    ->defaultItems(0)
                    ->addActionLabel('Tambah Layanan')
                    ->reorderable(false)
                    ->collapsible()
                    ->columnSpanFull(),
                Checkbox::make('include_permit')
                    ->label('Include Perizinan')
                    ->inline(false)
                    ->reactive()
                    ->columnSpan(1),
                TextInput::make('permit_price')
                    ->label('Biaya Perizinan')
                    ->numeric()
                    ->default(0)
                    ->prefix('Rp')
                    ->helperText('Isi harga perizinan sesuai kebutuhan')
                    ->required(fn (Get $get) => (bool) $get('include_permit'))
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

    public static function table(Table $table): Table
    {
        return $table
            ->paginationPageOptions([25, 50, 100])
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('customer_name')
                    ->label('Pemesan')
                    ->searchable(),
                TextColumn::make('customer_email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('customer_phone')
                    ->label('Telepon')
                    ->searchable(),
                TextColumn::make('eventType.name')
                    ->label('Jenis Acara')
                    ->badge()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Selesai')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('total_days')
                    ->label('Hari')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('location')
                    ->label('Lokasi')
                    ->limit(40)
                    ->searchable(),
                TextColumn::make('serviceNames')
                    ->label('Services')
                    ->wrap()
                    ->limit(40),
                IconColumn::make('include_permit')
                    ->label('Perizinan')
                    ->boolean()
                    ->tooltip(fn ($state) => $state ? 'Include perizinan' : 'Tanpa perizinan'),
                TextColumn::make('permit_price')
                    ->label('Harga Perizinan')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'finished' => 'Finished',
                        default => $state,
                    })
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger'  => 'rejected',
                        'info'    => 'finished',
                    ]),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'finished' => 'Finished',
                    ]),
                SelectFilter::make('event_type_id')
                    ->label('Jenis Acara')
                    ->relationship('eventType', 'name'),
                Filter::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Dari'),
                        DatePicker::make('created_until')
                            ->label('Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                Filter::make('event_date')
                    ->label('Tanggal Event')
                    ->form([
                        DatePicker::make('event_from')
                            ->label('Dari'),
                        DatePicker::make('event_until')
                            ->label('Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['event_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('start_date', '>=', $date),
                            )
                            ->when(
                                $data['event_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('end_date', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                TableAction::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->url(fn (Booking $record) => static::getUrl('edit', ['record' => $record]))
                    ->color('gray'),
                TableAction::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-badge')
                    ->url(fn (Booking $record) => static::getUrl('edit', ['record' => $record]))
                    ->visible(fn (Booking $record) => $record->status !== 'finished')
                    ->color('primary'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('setApproved')
                        ->label('Set Approved')
                        ->color('success')
                        ->icon('heroicon-o-check-circle')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $records->each(function (Booking $booking) {
                                $booking->update(['status' => 'approved']);
                                static::notifyStatusChange($booking);
                            });
                        }),
                    BulkAction::make('setRejected')
                        ->label('Set Rejected')
                        ->color('danger')
                        ->icon('heroicon-o-x-circle')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $records->each(function (Booking $booking) {
                                $booking->update(['status' => 'rejected']);
                                static::notifyStatusChange($booking);
                            });
                        }),
                    BulkAction::make('setFinished')
                        ->label('Set Finished')
                        ->color('info')
                        ->icon('heroicon-o-flag')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $records->each(function (Booking $booking) {
                                $booking->update(['status' => 'finished']);
                                static::notifyStatusChange($booking);
                            });
                        }),
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
            'customer_name',
            'customer_email',
            'customer_phone',
            'event_name',
            'location',
        ];
    }

    protected static function notifyStatusChange(Booking $booking): void
    {
        $booking->load(['services' => fn ($query) => $query->withPivot('price', 'quantity')]);

        if ($booking->customer_email) {
            Notification::route('mail', $booking->customer_email)
                ->notify(new BookingStatusUpdatedNotification($booking));
        }

        $admins = User::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new BookingStatusUpdatedNotification($booking));
        }
    }

    public static function getGlobalSearchResultTitle($record): string
    {
        return $record->event_name ?: ($record->customer_name ?? 'Pemesanan');
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        $details = [];
        if (!empty($record->customer_name)) {
            $details[] = 'Pemesan: ' . $record->customer_name;
        }
        if (!empty($record->eventType?->name)) {
            $details[] = 'Jenis: ' . $record->eventType->name;
        }
        if (!empty($record->location)) {
            $details[] = 'Lokasi: ' . $record->location;
        }
        if (!empty($record->start_date) && !empty($record->end_date)) {
            $details[] = 'Tanggal: ' . Carbon::parse($record->start_date)->format('d M Y') . ' - ' . Carbon::parse($record->end_date)->format('d M Y');
        }
        return $details;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookings::route('/'),
            'create' => CreateBooking::route('/create'),
            'edit' => EditBooking::route('/{record}/edit'),
        ];
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
