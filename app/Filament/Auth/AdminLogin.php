<?php

namespace App\Filament\Auth;

use Illuminate\Validation\ValidationException;

class AdminLogin
{
    public static function validate(string $email): void
    {
        $user = \App\Models\User::where('email', $email)->first();
        
        if ($user && $user->role !== 'admin') {
            $message = $user->role === 'manager'
                ? 'Anda adalah manager. Silakan gunakan panel manager di /manager'
                : 'Akses ditolak. Panel admin hanya untuk admin.';
                
            throw ValidationException::withMessages([
                'email' => $message,
            ]);
        }
    }
}
