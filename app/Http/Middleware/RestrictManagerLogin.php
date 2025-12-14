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
        if (Auth::check()) {
            return $next($request);
        }

        if ($request->method() === 'POST' && $request->is('manager/login')) {
            $email = $request->input('email');

            if ($email) {
                ManagerLogin::validate($email);
            }
        }

        return $next($request);
    }
}
