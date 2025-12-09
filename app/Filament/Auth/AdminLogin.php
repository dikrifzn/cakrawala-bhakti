<?php

namespace App\Filament\Auth;

use Illuminate\Validation\ValidationException;

class AdminLogin
{
    /**
     * Validate admin role on login attempt
     */
    public static function validate(string $email): void
    {
        $user = \App\Models\User::where('email', $email)->first();
        
        if ($user && $user->role !== 'admin') {
            throw ValidationException::withMessages([
                'email' => 'Akses ditolak. Panel admin hanya untuk admin. Silakan gunakan ' . ucfirst($user->role) . ' panel.',
            ]);
        }
    }
}
