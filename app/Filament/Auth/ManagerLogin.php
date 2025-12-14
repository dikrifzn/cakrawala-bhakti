<?php

namespace App\Filament\Auth;

use Illuminate\Validation\ValidationException;

class ManagerLogin
{
    public static function validate(string $email): void
    {
        $user = \App\Models\User::where('email', $email)->first();
        
        if ($user && !in_array($user->role, ['manager'], true)) {
            throw ValidationException::withMessages([
                'email' => 'Akses ditolak. Panel manager hanya untuk manager dan admin. Silakan gunakan panel yang sesuai dengan role Anda.',
            ]);
        }
    }
}
