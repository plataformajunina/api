<?php

namespace App\Actions\Auth;

class Logout
{
    public function execute(): bool
    {
        return auth()->user()->currentAccessToken()->delete();
    }
}
