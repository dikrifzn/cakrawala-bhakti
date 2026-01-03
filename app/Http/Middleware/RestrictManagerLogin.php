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
     * Validates that only manager role can login to manager panel.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::check()) {
            // Jika sudah login, pastikan role-nya manager
            $user = Auth::user();
            if ($user->role !== 'manager') {
                Auth::logout();
                $message = $user->role === 'admin' 
                    ? 'Anda adalah admin. Silakan gunakan panel admin di /admin'
                    : 'Akses ditolak. Panel manager hanya untuk manager.';
                return redirect('/manager/login')->with('error', $message);
            }
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
