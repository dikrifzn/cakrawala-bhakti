<?php

namespace App\Filament\Resources\Bookings;

use App\Filament\Resources\Bookings\Pages\CreateBooking;
use App\Filament\Resources\Bookings\Pages\EditBooking;
use App\Filament\Resources\Bookings\Pages\ListBookings;
use App\Models\Booking;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use UnitEnum;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Pemesanan Event';

    protected static UnitEnum|string|null $navigationGroup = 'Pemesanan';

    protected static ?int $navigationSort = 1;

    /* =========================
     | FORM
     ========================= */
    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema->components([
            /* =====================
             | BOOKING INFO
             ===================== */
            Placeholder::make('info')
                ->content(fn ($record) => $record?->event_name ? "📅 {$record->event_name} ({$record->start_date} - {$record->end_date})" : 'Booking Info')
                ->columnSpanFull(),

            /* =====================
             | CLIENT DATA
             ===================== */
            TextInput::make('customer_name')
                ->label('Nama Pemesan')
                ->required(),

            TextInput::make('customer_email')
                ->label('Email')
                ->email()
                ->required(),

            TextInput::make('customer_phone')
                ->label('Nomor Telepon')
                ->required(),

            /* =====================
             | EVENT DATA
             ===================== */
            TextInput::make('event_name')
                ->label('Nama Event')
                ->required(),

            DatePicker::make('start_date')
                ->label('Tanggal Mulai')
                ->required(),

            DatePicker::make('end_date')
                ->label('Tanggal Selesai')
                ->required(),

            TextInput::make('location')
                ->label('Lokasi')
                ->required(),

            FileUpload::make('proposal_file')
                ->label('File Proposal')
                ->directory('proposals')
                ->acceptedFileTypes(['application/pdf'])
                ->hint(fn ($record) => $record?->proposal_file ? '✓ Ada' : ''),

            Placeholder::make('proposal_download')
                ->label('Preview Proposal')
                ->content(fn ($record) => $record?->proposal_file ? new HtmlString(
                    "<div class='mt-4'><iframe src='".route('booking.downloadFile', ['booking' => $record->id, 'type' => 'proposal_file', 'inline' => 1])."' style='width:100%;height:560px;border:1px solid #e5e7eb' frameborder='0'></iframe></div>"
                ) : new HtmlString('<span class="text-gray-600">Belum ada proposal</span>'))
                ->columnSpanFull(),

            Textarea::make('notes')
                ->label('Catatan')
                ->rows(2),

            /* =====================
             | RINCIAN JASA
             ===================== */
            Repeater::make('details')
                ->relationship()
                ->schema([
                    TextInput::make('service_name')
                        ->label('Jasa')
                        ->required(),
                    TextInput::make('price')
                        ->label('Harga')
                        ->numeric()
                        ->required(),
                    TextInput::make('notes')
                        ->label('Catatan'),
                ])
                ->columnSpanFull()
                ->visible(fn ($record) => in_array($record?->admin_status, ['detail_sent', 'final_approved', 'on_progress', 'finished']))
                ->disabled(),

            // total price is computed from related details; not stored on booking

            /* =====================
             | STATUS
             ===================== */
            Select::make('admin_status')
                ->label('Status Admin')
                ->options([
                    'review' => '1️⃣ Review',
                    'detail_sent' => '2️⃣ Detail Sent',
                    'final_approved' => '3️⃣ Approval Sent',
                    'on_progress' => '4️⃣ On Progress',
                    'finished' => '5️⃣ Finished',
                    'rejected' => '❌ Rejected',
                ])
                ->required()
                ->disabled(),

            Select::make('customer_status')
                ->label('Status Client')
                ->options([
                    'submitted' => 'Submitted',
                    'detail_approved' => '✓ Detail Approved',
                    'final_signed' => '✓ Final Signed',
                    'rejected' => '✗ Rejected',
                ])
                ->required()
                ->disabled(),
        ]);
    }

    /* =========================
     | TABLE
     ========================= */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_name')
                    ->label('👤 Pemesan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('event_name')
                    ->label('📅 Event')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('admin_status')
                    ->label('Status Admin')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'review' => '1️⃣ Review',
                        'detail_sent' => '2️⃣ Detail Sent',
                        'final_approved' => '3️⃣ Approval Sent',
                        'on_progress' => '4️⃣ On Progress',
                        'finished' => '5️⃣ Finished',
                        'rejected' => '❌ Rejected',
                        default => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'review' => 'info',
                        'detail_sent' => 'warning',
                        'final_approved' => 'primary',
                        'on_progress' => 'success',
                        'finished' => 'success',
                        'rejected' => 'danger',
                        default => 'secondary',
                    }),

                TextColumn::make('customer_status')
                    ->label('Status Client')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'submitted' => 'info',
                        'detail_approved' => 'warning',
                        'final_signed' => 'success',
                        'rejected' => 'danger',
                        default => 'secondary',
                    }),

                TextColumn::make('price_total')
                    ->label('Harga')
                    ->getStateUsing(fn ($record) => 'Rp '.number_format($record->details->sum('price') ?? 0, 0, ',', '.')),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('review')
                    ->label('Review')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => static::getUrl('review', ['record' => $record])),
                Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->url(fn ($record) => static::getUrl('edit', ['record' => $record])),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /* =========================
     | PAGES
     ========================= */
    public static function getPages(): array
    {
        return [
            'index' => ListBookings::route('/'),
            'create' => CreateBooking::route('/create'),
            'edit' => EditBooking::route('/{record}/edit'),
            'review' => \App\Filament\Resources\Bookings\Pages\ReviewBooking::route('/{record}/review'),
        ];
    }
}
