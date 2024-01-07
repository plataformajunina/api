<?php

use App\Enums\{Permission, SupportRole};
use App\Services\ACL\{GroupACLService, PersonACLService, SupportACLService, TenantACLService};

test('main support should have al permissions', function () {
    $service  = new SupportACLService(SupportRole::MAIN);

    foreach (Permission::cases() as $permission) {
        expect($service->hasPermissionTo($permission))->toBeTrue();
    }
});

test('manager support should have permission for create group', function () {
    $service  = new SupportACLService(SupportRole::MANAGER);

    expect($service->hasPermissionTo(Permission::CREATE_GROUP))->toBeTrue();
});

test('manager support should not have permission for create tenant', function () {
    $service  = new SupportACLService(SupportRole::MANAGER);

    expect($service->hasPermissionTo(Permission::CREATE_TENANT))->toBeFalse();
});

test('tenant should have permission for create group', function () {
    expect(app(TenantACLService::class)->hasPermissionTo(Permission::CREATE_GROUP))
        ->toBeTrue();
});

test('tenant should not have permission for create tenant', function () {
    expect(app(TenantACLService::class)->hasPermissionTo(Permission::CREATE_TENANT))
        ->toBeFalse();
});

test('group should have permission for list festivals', function () {
    expect(app(GroupACLService::class)->hasPermissionTo(Permission::LIST_GROUPS))
        ->toBeTrue();
});

test('group should not have permission for create group', function () {
    expect(app(GroupACLService::class)->hasPermissionTo(Permission::CREATE_GROUP))
        ->toBeFalse();
});

test('person should have permission for list festivals', function () {
    expect(app(PersonACLService::class)->hasPermissionTo(Permission::LIST_GROUPS))
        ->toBeTrue();
});

test('person should not have permission for create person', function () {
    expect(app(PersonACLService::class)->hasPermissionTo(Permission::CREATE_PERSON))
        ->toBeFalse();
});
