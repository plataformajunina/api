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
