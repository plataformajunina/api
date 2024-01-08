<?php

use App\Models\Support;
use Illuminate\Support\Str;

use function Pest\Laravel\{actingAs, getJson};

beforeEach(function () {
    $this->urlBase = '/api/supports/';
    $this->support = Support::factory()->asMain()->create();
});

test('main suport can show support', function () {
    actingAsMainSupport()
        ->getJson("{$this->urlBase}{$this->support->id}")
        ->assertOk()
        ->assertJson([
            'id' => $this->support->id,
            'role' => $this->support->role->value,
            'name' => $this->support->user->name,
            'email' => $this->support->user->email
        ]);
});

test('support exists', function () {
    $id = Str::uuid();

    actingAsMainSupport()
        ->getJson("{$this->urlBase}{$id}")
        ->assertNotFound();
});

test('unauthenticated user cannot show support', function () {
    getJson("{$this->urlBase}{$this->support->id}")
        ->assertUnauthorized();
});

test('main support cannot self-show', function () {
    actingAs($this->support->user)
        ->getJson("{$this->urlBase}{$this->support->id}")
        ->assertForbidden();
});

test('manager support cannot show support', function () {
    actingAsManegerSupport()
        ->getJson("{$this->urlBase}{$this->support->id}")
        ->assertForbidden();
});

test('tenant cannot show support', function () {
    actingAsTenant()
        ->getJson("{$this->urlBase}{$this->support->id}")
        ->assertForbidden();
});

test('group cannot show support', function () {
    actingAsGroup()
        ->getJson("{$this->urlBase}{$this->support->id}")
        ->assertForbidden();
});

test('person cannot show support', function () {
    actingAsPerson()
        ->getJson("{$this->urlBase}{$this->support->id}")
        ->assertForbidden();
});
