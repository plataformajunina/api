<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\{Login, Logout};
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Response;

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

    public function destroy(): Response
    {
        app(Logout::class)->execute();

        return response(['message' => 'Token Revogado.']);
    }
}
