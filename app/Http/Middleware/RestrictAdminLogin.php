<?php

namespace App\Http\Middleware;

use App\Filament\Auth\AdminLogin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestrictAdminLogin
{
    /**
     * Handle an incoming request.
     * Validates that only admin role can login to admin panel.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::check()) {
            // Jika sudah login, pastikan role-nya admin
            $user = Auth::user();
            if ($user->role !== 'admin') {
                Auth::logout();
                $message = $user->role === 'manager' 
                    ? 'Anda adalah manager. Silakan gunakan panel manager di /manager'
                    : 'Akses ditolak. Panel admin hanya untuk admin.';
                return redirect('/admin/login')->with('error', $message);
            }
            return $next($request);
        }

        if ($request->method() === 'POST' && $request->is('admin/login')) {
            $email = $request->input('email');

            // Validasi role sebelum authentication
            if ($email) {
                AdminLogin::validate($email);
            }
        }

        return $next($request);
    }
}
