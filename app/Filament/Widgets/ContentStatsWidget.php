<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContentStatsWidget extends BaseWidget
{
    protected static ?int $sort = 5;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Artikel', Article::count())
                ->description('Total artikel yang dipublikasi')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary'),
                
            Stat::make('Total Proyek', Project::count())
                ->description('Portfolio proyek')
                ->descriptionIcon('heroicon-o-briefcase')
                ->color('success'),
                
            Stat::make('Total Layanan', Service::count())
                ->description('Layanan yang tersedia')
                ->descriptionIcon('heroicon-o-sparkles')
                ->color('warning'),
                
            Stat::make('Total User', User::count())
                ->description('Pengguna terdaftar')
                ->descriptionIcon('heroicon-o-users')
                ->color('info'),
        ];
    }
}
