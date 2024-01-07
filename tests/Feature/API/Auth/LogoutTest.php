<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertDatabaseCount};

test('user can logout', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson('/api/logout')
        ->assertOk();

    assertDatabaseCount('personal_access_tokens', 0);
});
