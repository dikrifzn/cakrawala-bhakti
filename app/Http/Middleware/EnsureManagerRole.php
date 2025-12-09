<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureManagerRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = Auth::user();

        if (! $user || ! in_array($user->role, ['manager'], true)) {
            Auth::logout();
            return redirect('/manager/login')->with('error', 'Akses ditolak. Hanya manager yang dapat mengakses panel ini.');
        }

        return $next($request);
    }
}
