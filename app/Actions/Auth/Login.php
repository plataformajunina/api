<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Login
{
    public function execute(string $email, string $password, bool $remember = false): string
    {
        $user = User::query()->where('email', $email)->first();

        if ($user) {
            $credentials = ['email' => $email, 'password' => $password];
            if (Auth::attempt($credentials, $remember)) {
                return $user->createToken('auth-token-pj')->plainTextToken;
            }
        }

        throw ValidationException::withMessages([
            'email' => [__('auth.failed')],
        ]);
    }
}
