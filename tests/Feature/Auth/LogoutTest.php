<?php

use App\Models\User;

use function Pest\Laravel\actingAs;

test('user can logout', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson('/api/logout')
        ->assertOk();
});
