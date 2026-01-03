<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdminRole
{
    /**
     * Handle an incoming request.
     * Only allows admin role to access admin panel.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'admin') {
            Auth::logout();
            
            $message = 'Akses ditolak. Panel admin hanya untuk admin.';
            if ($user && $user->role === 'manager') {
                $message = 'Anda adalah manager. Silakan gunakan panel manager di /manager';
            } elseif ($user && $user->role === 'customer') {
                $message = 'Customer tidak memiliki akses ke panel admin.';
            }
            
            return redirect('/admin/login')->with('error', $message);
        }

        return $next($request);
    }
}
