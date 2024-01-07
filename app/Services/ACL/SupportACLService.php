<?php

namespace App\Services\ACL;

use App\Enums\{Permission, SupportRole};

class SupportACLService implements IACLService
{
    protected SupportRole $role = SupportRole::MANAGER;

    protected array $managerPermissions = [
        // group
        Permission::LIST_GROUPS,
        Permission::CREATE_GROUP,
        Permission::SHOW_GROUP,
        // person
        Permission::LIST_PEOPLE,
        Permission::CREATE_PERSON,
        Permission::SHOW_PERSON,
        // festival
        Permission::LIST_FESTIVALS,
        Permission::SHOW_FESTIVAL,
    ];

    public function __construct(?SupportRole $role)
    {
        $this->role = $role;
    }

    public function hasPermissionTo(Permission $permission): bool
    {
        return match ($this->role) {
            SupportRole::MAIN => true,
            default => in_array($permission, $this->managerPermissions)
        };
    }
}
