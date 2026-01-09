<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use App\Filament\Widgets\BookingStatsWidget;
use App\Filament\Widgets\BookingChartWidget;
use App\Filament\Widgets\RevenueChartWidget;
use App\Filament\Widgets\LatestBookingsWidget;
use App\Filament\Widgets\ContentStatsWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\EnsureAdminRole;
use App\Http\Middleware\RestrictAdminLogin;
use Filament\Navigation\NavigationGroup;
use Filament\Support\Assets\Css;
use Illuminate\Support\Facades\Vite;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->brandName('Admin - Cakrawala Bhakti')
            ->favicon(asset('img/single-logo.png'))
            ->id('admin')
            ->path('admin')
            ->assets([
                Css::make('tailwind', Vite::asset('resources/css/app.css')),
            ])
            ->login()
            ->breadcrumbs(false)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->globalSearch(false)
            ->sidebarCollapsibleOnDesktop()
            ->databaseNotifications()
            ->navigationGroups([
                NavigationGroup::make()->label('Booking'),
                NavigationGroup::make()->label('Publikasi'),
                NavigationGroup::make()->label('Pengaturan Website'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
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
                RestrictAdminLogin::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                EnsureAdminRole::class,
            ]);
    }
}
