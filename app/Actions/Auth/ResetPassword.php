<?php

namespace App\Actions\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ResetPassword
{
    public function execute(string $token, string $email, string $password, string $passwordConfirmation): string
    {
        $credentials = [
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
            'token' => $token
        ];

        $status = Password::reset(
            $credentials,
            function ($user) use ($credentials, $email) {
                $user->forceFill([
                    'password' => Hash::make($credentials['password']),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return __($status);
        }

        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }
}
