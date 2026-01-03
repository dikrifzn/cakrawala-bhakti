<?php

namespace App\Filament\Auth;

use Illuminate\Validation\ValidationException;

class ManagerLogin
{
    public static function validate(string $email): void
    {
        $user = \App\Models\User::where('email', $email)->first();
        
        if ($user && $user->role !== 'manager') {
            $message = $user->role === 'admin'
                ? 'Anda adalah admin. Silakan gunakan panel admin di /admin'
                : 'Akses ditolak. Panel manager hanya untuk manager.';
                
            throw ValidationException::withMessages([
                'email' => $message,
            ]);
        }
    }
}
