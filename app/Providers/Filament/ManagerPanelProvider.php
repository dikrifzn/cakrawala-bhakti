<?php

namespace App\Providers\Filament;

use App\Http\Middleware\EnsureManagerRole;
use App\Http\Middleware\RestrictManagerLogin;
use App\Filament\Widgets\Manager\BookingStatusChart;
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

class ManagerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('manager')
            ->path('manager')
            ->login()
            ->brandName('Manager Panel')
            ->colors([
                'primary' => Color::Amber,
            ])
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
            ->discoverWidgets(in: app_path('Filament/Widgets/Manager'), for: 'App\\Filament\\Widgets\\Manager')
            ->widgets([
                BookingStatusChart::class,
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
