<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdminRole
{
    /**
     * Handle an incoming request.
     * Allows both admin and manager roles to access Filament panel.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            Auth::logout();
            return redirect('/admin/login')->with('error', 'Akses ditolak. Hanya admin atau manager yang dapat mengakses panel ini.');
        }

        return $next($request);
    }
}
