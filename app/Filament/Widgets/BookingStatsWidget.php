<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $approvedBookings = Booking::where('status', 'approved')->count();
        $finishedBookings = Booking::where('status', 'finished')->count();
        
        $totalRevenue = Booking::whereIn('status', ['approved', 'finished'])->sum('total_price');
        $monthlyRevenue = Booking::whereIn('status', ['approved', 'finished'])
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        return [
            Stat::make('Total Booking', $totalBookings)
                ->description('Total semua booking')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('primary'),
                
            Stat::make('Pending', $pendingBookings)
                ->description('Menunggu konfirmasi')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),
                
            Stat::make('Approved', $approvedBookings)
                ->description('Booking disetujui')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
                
            Stat::make('Finished', $finishedBookings)
                ->description('Acara selesai')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('info'),
                
            Stat::make('Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Total pendapatan')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),
                
            Stat::make('Revenue Bulan Ini', 'Rp ' . number_format($monthlyRevenue, 0, ',', '.'))
                ->description(now()->format('F Y'))
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('primary'),
        ];
    }
}
