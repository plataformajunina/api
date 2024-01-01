<?php

use App\Models\User;

use function Pest\Laravel\{assertDatabaseCount, postJson};

beforeEach(fn() => $this->url = '/api/login');

test('user can login', function () {
    $user = User::factory()->create();

    $request = [
        'email' => $user->email,
        'password' => 'password',
        'remember' => false
    ];

    postJson($this->url, $request)
        ->assertOk()
        ->assertJsonStructure(['access_token', 'token_type']);

    assertDatabaseCount('personal_access_tokens', 1);
});

test('login fails with incorrect credentials', function () {
    $user = User::factory()->create();

    $request = [
        'email' => $user->email,
        'password' => 'wrong-password',
        'remember' => true
    ];

    postJson($this->url, $request)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email' => __('auth.failed')]);

    assertDatabaseCount('personal_access_tokens', 0);
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

test('password should be valid', function () {
    postJson($this->url, ['password' => 'password'])
        ->assertJsonMissingValidationErrors('password');
});

test('password should be required', function () {
    postJson($this->url, [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['password' => __('validation.required', ['attribute' => 'senha'])]);
});

test('password should be a string', function () {
    postJson($this->url, ['password' => 12345])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['password' => __('validation.string', ['attribute' => 'senha'])]);
});

test('remember should be valid', function () {
    postJson($this->url, ['remember' => true])
        ->assertJsonMissingValidationErrors('remember');
});

test('remember should be required', function () {
    postJson($this->url, [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['remember' => __('validation.required', ['attribute' => 'lembrar-me'])]);
});

test('remember should be a boolean', function () {
    postJson($this->url, ['remember' => 'not_a_boolean'])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['remember' => __('validation.boolean', ['attribute' => 'lembrar-me'])]);
});
