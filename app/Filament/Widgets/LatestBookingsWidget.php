<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestBookingsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Booking::query()
                    ->with(['user'])
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Pemesan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('event_name')
                    ->label('Jenis Acara')
                    ->badge(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tanggal')
                    ->date('d M Y'),
                Tables\Columns\TextColumn::make('price_total')
                    ->label('Total')
                    ->getStateUsing(fn ($record) => 'Rp ' . number_format($record->details->sum('price') ?? 0, 0, ',', '.')),
                Tables\Columns\TextColumn::make('admin_status')
                    ->label('Status Admin')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'review' => 'Review',
                        'detail_sent' => 'Detail Sent',
                        'final_approved' => 'Approval Sent',
                        'on_progress' => 'On Progress',
                        'finished' => 'Finished',
                        'rejected' => 'Rejected',
                        default => $state,
                    })
                    ->colors([
                        'warning' => 'review',
                        'info'    => 'detail_sent',
                        'primary' => 'final_approved',
                        'success' => ['on_progress', 'finished'],
                        'danger'  => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since(),
            ]);
    }
}
