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
        $pendingBookings = Booking::where('admin_status', 'review')->count();
        $detailSentBookings = Booking::where('admin_status', 'detail_sent')->count();
        $finishedBookings = Booking::where('admin_status', 'finished')->count();
        
        $totalRevenue = Booking::where('customer_status', 'final_signed')
            ->with('details')
            ->get()
            ->sum(fn ($b) => $b->details->sum('price'));

        $monthlyRevenue = Booking::where('customer_status', 'final_signed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->with('details')
            ->get()
            ->sum(fn ($b) => $b->details->sum('price'));

        return [
            Stat::make('Total Booking', $totalBookings)
                ->description('Total semua booking')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('primary'),
                
            Stat::make('Pending', $pendingBookings)
                ->description('Menunggu konfirmasi')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),
                
            Stat::make('Detail Sent', $detailSentBookings)
                ->description('Rincian dikirim ke client')
                ->descriptionIcon('heroicon-o-paper-airplane')
                ->color('info'),
                
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
