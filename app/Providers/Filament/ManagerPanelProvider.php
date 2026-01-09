<?php

namespace App\Providers\Filament;

use App\Http\Middleware\EnsureManagerRole;
use App\Http\Middleware\RestrictManagerLogin;
use App\Filament\Widgets\BookingStatsWidget;
use App\Filament\Widgets\BookingChartWidget;
use App\Filament\Widgets\RevenueChartWidget;
use App\Filament\Widgets\LatestBookingsWidget;
use App\Filament\Widgets\ContentStatsWidget;
use App\Filament\Resources\Bookings\BookingResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Support\Assets\Css;
use Illuminate\Support\Facades\Vite;

class ManagerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('manager')
            ->path('manager')
            ->assets([
                Css::make('tailwind', Vite::asset('resources/css/app.css')),
            ])
            ->login()
            ->brandName('Direktur Panel - Cakrawala Bhakti')
            ->favicon(asset('img/single-logo.png'))
            ->breadcrumbs(false)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->databaseNotifications()
            ->navigationGroups([
                \Filament\Navigation\NavigationGroup::make()->label('Booking'),
                \Filament\Navigation\NavigationGroup::make()->label('Laporan'),
            ])
            ->resources([
                BookingResource::class,
            ])
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                BookingStatsWidget::class,
                BookingChartWidget::class,
                RevenueChartWidget::class,
                LatestBookingsWidget::class,
                ContentStatsWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                RestrictManagerLogin::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                EnsureManagerRole::class,
            ]);
    }
}
