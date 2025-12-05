<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdminRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            Auth::logout();
            return redirect('/admin/login')->with('error', 'Akses ditolak. Hanya admin yang dapat mengakses panel ini.');
        }

        return $next($request);
    }
}
