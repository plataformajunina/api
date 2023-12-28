<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\Login;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request): Response
    {
        $token = app(Login::class)->execute(
            email: $request->email,
            password: $request->password,
            remember: $request->remember,
        );

        return response([
            "access_token" => $token,
            "token_type" => "bearer"
        ]);
    }

    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
