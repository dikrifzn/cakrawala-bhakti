<?php

namespace App\Http\Middleware;

use App\Filament\Auth\ManagerLogin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestrictManagerLogin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Jika sudah login, lanjutkan
        if (Auth::check()) {
            return $next($request);
        }

        // Jika mencoba submit login POST
        if ($request->method() === 'POST' && $request->is('manager/login')) {
            $email = $request->input('email');

            // Validasi role sebelum authentication
            if ($email) {
                ManagerLogin::validate($email);
            }
        }

        return $next($request);
    }
}
