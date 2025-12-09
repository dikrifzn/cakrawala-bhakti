<?php

namespace App\Filament\Widgets\Manager;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingStatusChart extends StatsOverviewWidget
{
    protected ?string $heading = 'Ringkasan Status Booking';

    protected function getStats(): array
    {
        $statuses = [
            'pending' => ['label' => 'Pending', 'color' => 'warning'],
            'approved' => ['label' => 'Approved', 'color' => 'success'],
            'rejected' => ['label' => 'Rejected', 'color' => 'danger'],
            'finished' => ['label' => 'Finished', 'color' => 'info'],
        ];

        return collect($statuses)->map(function ($meta, $status) {
            $count = Booking::where('status', $status)->count();

            return Stat::make($meta['label'], number_format($count))
                ->color($meta['color']);
        })->values()->all();
    }
}
