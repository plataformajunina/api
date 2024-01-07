<?php

use App\Models\User;
use App\Notifications\PasswordUpdated;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\postJson;

beforeEach(fn() => $this->url = '/api/reset-password');

test('password can be reset with valid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    postJson('/api/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function (object $notification) use ($user) {
        postJson('/api/reset-password', [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => '#Abcdef1',
            'password_confirmation' => '#Abcdef1',
        ])
            ->assertOk();

        Notification::assertSentTo($user, PasswordUpdated::class);

        return true;
    });
});

test('password cannot be reset with invalid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    postJson('/api/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function (object $notification) use ($user) {
        postJson('/api/reset-password', [
            'token' => 'invalid-token',
            'email' => $user->email,
            'password' => '#Abcdef1',
            'password_confirmation' => '#Abcdef1',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email' => __('passwords.token')]);

        return true;
    });
});

test('password cannot be reset with a token from another user', function () {
    Notification::fake();

    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    postJson('/api/forgot-password', ['email' => $user1->email]);

    Notification::assertSentTo($user1, ResetPassword::class, function (object $notification) use ($user1, $user2) {
        postJson('/api/reset-password', [
            'token' => $notification->token,
            'email' => $user2->email,
            'password' => '#Abcdef1',
            'password_confirmation' => '#Abcdef1',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email' => __('passwords.token')]);

        return true;
    });
});

test('token should be required', function () {
    postJson($this->url, [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['token' => __('validation.required', ['attribute' => 'token'])]);
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

test('email should exist in the users table', function () {
    postJson($this->url, [
        'token' => 'token',
        'email' => 'user@email.com',
        'password' => '#Abcdef1',
        'password_confirmation' => '#Abcdef1',
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email' => __('passwords.user')]);
});

test('password should be required', function () {
    postJson($this->url, [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['password' => __('validation.required', ['attribute' => 'senha'])]);
});

test('password confirmation should be required', function () {
    postJson($this->url, [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['password_confirmation' => __('validation.required', ['attribute' => 'confirmação da senha'])]);
});
