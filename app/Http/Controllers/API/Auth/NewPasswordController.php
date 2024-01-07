<?php

namespace App\Http\Controllers\API\Auth;

use App\Actions\Auth\ResetPassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\Response;

class NewPasswordController extends Controller
{
    public function store(ResetPasswordRequest $request): Response
    {
        $status = app(ResetPassword::class)->execute(
            token: $request->token,
            email: $request->email,
            password: $request->password,
            passwordConfirmation: $request->password_confirmation
        );

        return response([
            'message' => $status
        ]);
    }
}
