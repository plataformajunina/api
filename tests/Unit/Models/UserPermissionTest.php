<?php

use App\Enums\Permission;
use App\Models\{Support, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

//test('main support should have al permissions', function () {
//    $support = Support::factory()->asMain()->create();
//    $user = $support->user;
//
//    foreach (Permission::cases() as $permission) {
//        expect($user->hasPermissionTo($permission))->toBeTrue();
//    }
//});
//
//test('manager support should have permission for create group', function () {
//    $support = Support::factory()->create();
//    $user = $support->user;
//
//    expect($user->hasPermissionTo(Permission::CREATE_GROUP))->toBeTrue();
//});

test('manager support should not have permission for create tenant', function () {
    $support = Support::factory()->create();
    $user = $support->user;

    expect($user->hasPermissionTo(Permission::CREATE_TENANT))->toBeFalse();
});

test('tenant should have permission for create group', function () {
    $user = User::factory()->asTenant()->create();

    expect($user->hasPermissionTo(Permission::CREATE_GROUP))
        ->toBeTrue();
});

test('tenant should not have permission for create tenant', function () {
    $user = User::factory()->asTenant()->create();

    expect($user->hasPermissionTo(Permission::CREATE_TENANT))
        ->toBeFalse();
});

test('group should have permission for list festivals', function () {
    $user = User::factory()->asGroup()->create();

    expect($user->hasPermissionTo(Permission::LIST_GROUPS))
        ->toBeTrue();
});

test('group should not have permission for create group', function () {
    $user = User::factory()->asGroup()->create();

    expect($user->hasPermissionTo(Permission::CREATE_GROUP))
        ->toBeFalse();
});

test('person should have permission for list festivals', function () {
    $user = User::factory()->create();

    expect($user->hasPermissionTo(Permission::LIST_GROUPS))
        ->toBeTrue();
});

test('person should not have permission for create person', function () {
    $user = User::factory()->create();

    expect($user->hasPermissionTo(Permission::CREATE_PERSON))
        ->toBeFalse();
});
