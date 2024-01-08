<?php

use App\Models\{Support, User};
use Tests\TestCase;

function actingAsMainSupport(): TestCase
{
    $support = Support::factory()->asMain()->create();

    return test()->actingAs($support->user);
}

function actingAsManegerSupport(): TestCase
{
    $support = Support::factory()->create();

    return test()->actingAs($support->user);
}

function actingAsTenant(): TestCase
{
    $user = User::factory()->asTenant()->create();

    return test()->actingAs($user);
}

function actingAsGroup(): TestCase
{
    $user = User::factory()->asGroup()->create();

    return test()->actingAs($user);
}

function actingAsPerson(): TestCase
{
    $user = User::factory()->create();

    return test()->actingAs($user);
}
