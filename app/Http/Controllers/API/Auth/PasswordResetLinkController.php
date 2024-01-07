<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\PasswordResetLink;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetLinkRequest;
use Illuminate\Http\Response;

class PasswordResetLinkController extends Controller
{
    public function store(PasswordResetLinkRequest $request): Response
    {
        $status = app(PasswordResetLink::class)->execute(
            email: $request->email
        );

        return response([
            'message' => $status
        ]);
    }
}
