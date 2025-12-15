<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Add HTTP caching headers for better performance
        \Illuminate\Support\Facades\Response::macro('cached', function ($content, $minutes = 60) {
            return response($content)
                ->header('Cache-Control', "public, max-age=" . ($minutes * 60))
                ->header('Pragma', 'public')
                ->header('Expires', gmdate('D, d M Y H:i:s', strtotime("+{$minutes} minutes")) . ' GMT');
        });
    }
}
