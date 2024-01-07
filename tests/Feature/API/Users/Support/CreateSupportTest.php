<?php

use App\Enums\{Role, SupportRole};
use App\Models\{Support, User};
use App\Notifications\Welcome;

use function Pest\Laravel\{actingAs, assertDatabaseCount, postJson};

beforeEach(fn() => $this->url = '/api/supports');

test('main support can create support', function () {
    Notification::fake();

    $support = Support::factory()->asMain()->create();

    $request = [
        'role' => SupportRole::MAIN->value,
        'name' => 'Main Support',
        'email' => 'main.support@plataformajunina.com.br'
    ];

    actingAs($support->user)
        ->postJson($this->url, $request)
        ->assertCreated()
        ->assertJson($request);

    $userCreated = User::query()->with('support')->skip(1)->first();

    Notification::assertSentTo($userCreated, Welcome::class, function (object $notification) use ($userCreated) {
        expect(Hash::check($notification->password, $userCreated->password))->toBeTrue();

        return true;
    });

    assertDatabaseCount('users', 2);
    expect($userCreated)
        ->role->toBe(Role::SUPPORT)
        ->name->toBe($request['name'])
        ->email->toBe($request['email'])
        ->profile_photo->toBeNull();

    assertDatabaseCount('supports', 2);
    expect($userCreated->support)
        ->role->toBe(SupportRole::tryFrom($request['role']));
});

test('unauthenticated user cannot create support', function () {
    postJson($this->url, [])
        ->assertUnauthorized();
});

test('manager support cannot create support', function () {
    $support = Support::factory()->create();

    actingAs($support->user)
        ->postJson($this->url, [])
        ->assertForbidden();
});

test('tenant cannot create support', function () {
    $user = User::factory()->asTenant()->create();

    actingAs($user)
        ->postJson($this->url, [])
        ->assertForbidden();
});

test('group member cannot create support', function () {
    $user = User::factory()->asGroup()->create();

    actingAs($user)
        ->postJson($this->url, [])
        ->assertForbidden();
});

test('person cannot create support', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson($this->url, [])
        ->assertForbidden();
});

test('role should be valid', function ($role) {
    actingAsMainSupport()
        ->postJson($this->url, ['role' => $role])
        ->assertJsonMissingValidationErrors('role', [
            __('validation.required'),
            __('validation.string'),
            __('validation.enum')
        ]);
})->with([
    SupportRole::MAIN->value,
    SupportRole::MANAGER->value
]);

test('role should be required', function () {
    actingAsMainSupport()
        ->postJson($this->url, [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['role' => __('validation.required', ['attribute' => 'função'])]);
});

test('role should be a string', function () {
    actingAsMainSupport()
        ->postJson($this->url, ['role' => 12345])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['role' => __('validation.string', ['attribute' => 'função'])]);
});

test('role should be valid value', function () {
    actingAsMainSupport()
        ->postJson($this->url, ['role' => 'invalid'])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['role' => __('validation.enum', ['attribute' => 'função'])]);
});

test('name should be valid', function () {
    actingAsMainSupport()
        ->postJson($this->url, ['name' => 'Support'])
        ->assertJsonMissingValidationErrors('name', [
            __('validation.required'),
            __('validation.string'),
            __('validation.min.string'),
            __('validation.max.string')
        ]);
});

test('name should be required', function () {
    actingAsMainSupport()
        ->postJson($this->url, [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['name' => __('validation.required', ['attribute' => 'nome'])]);
});

test('name should have at least 3 characters', function () {
    actingAsMainSupport()
        ->postJson($this->url, ['name' => 'ab'])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['name' => __('validation.min.string', ['attribute' => 'nome', 'min' => 3])]);
});

test('name should have at most 255 characters', function () {
    actingAsMainSupport()
        ->postJson($this->url, ['name' => str_repeat('a', 256)])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['name' => __('validation.max.string', ['attribute' => 'nome', 'max' => 255])]);
});

test('email should be valid', function () {
    actingAsMainSupport()
        ->postJson($this->url, ['email' => 'main.support@plataformajunina.com.br'])
        ->assertJsonMissingValidationErrors('email', [
            __('validation.required'),
            __('validation.string'),
            __('validation.email'),
            __('validation.max.string'),
            __('validation.domain'),
            __('validation.unique'),
        ]);
});

test('email should be required', function () {
    actingAsMainSupport()
        ->postJson($this->url, [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email' => __('validation.required', ['attribute' => 'e-mail'])]);
});

test('email should be a string', function () {
    actingAsMainSupport()
        ->postJson($this->url, ['email' => 12345])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email' => __('validation.string', ['attribute' => 'e-mail'])]);
});

test('email should be a valid email address', function (string $email) {
    actingAsMainSupport()
        ->postJson($this->url, ['email' => $email])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email' => __('validation.email', ['attribute' => 'e-mail'])]);
})->with(['invalid-email', 'invalid-email@.com']);

test('email should have at most 255 characters', function () {
    actingAsMainSupport()
        ->postJson($this->url, ['email' => str_repeat('a', 256)])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email' => __('validation.max.string', ['attribute' => 'e-mail', 'max' => 255])]);
});

test('email should have domain plataformajunina.com.br', function () {
    actingAsMainSupport()
        ->postJson($this->url, ['email' => 'main.support@plataformajunina.com'])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email' => __('validation.domain', ['attribute' => 'e-mail', 'domain' => 'plataformajunina.com.br'])]);
});

test('email should be unique', function () {
    User::factory()->create([
        'email' => 'existing@plataformajunina.com.br',
    ]);

    actingAsMainSupport()
        ->postJson($this->url, ['email' => 'existing@plataformajunina.com.br'])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email' => __('validation.unique', ['attribute' => 'e-mail'])]);
});
