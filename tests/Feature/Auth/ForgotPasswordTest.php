<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\postJson;

beforeEach(fn() => $this->url = '/api/forgot-password');

test('reset password link can be requested', function () {
    Notification::fake();

    $user = User::factory()->create();

    postJson($this->url, ['email' => $user->email])
        ->assertOk();

    Notification::assertSentTo($user, ResetPassword::class);
});

test('email should be valid', function () {
    postJson($this->url, ['email' => 'user@email.com'])
        ->assertJsonMissingValidationErrors('email', [
            __('validation.required'),
            __('validation.string'),
            __('validation.email')
        ]);
});

test('email should be required', function () {
    postJson($this->url, [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email' => __('validation.required', ['attribute' => 'e-mail'])]);
});

test('email should be a string', function () {
    postJson($this->url, ['email' => 12345])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email' => __('validation.string', ['attribute' => 'e-mail'])]);
});

test('email should be a valid email address', function (string $email) {
    postJson($this->url, ['email' => $email])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email' => __('validation.email', ['attribute' => 'e-mail'])]);
})->with(['invalid-email', 'invalid-email@.com']);

test('email must exist in the users table', function () {
    postJson($this->url, ['email' => 'user@email.com'])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email' => __('passwords.user')]);
});
