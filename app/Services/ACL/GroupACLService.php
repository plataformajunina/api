<?php

namespace App\Services\ACL;

use App\Enums\Permission;

class GroupACLService implements IACLService
{
    protected array $permissions = [
        // group
        Permission::LIST_GROUPS,
        Permission::SHOW_GROUP,
        // system
        Permission::LIST_SYSTEMS,
        Permission::SHOW_SYSTEM,
        // festival
        Permission::LIST_FESTIVALS,
        Permission::SHOW_FESTIVAL
    ];

    public function hasPermissionTo(Permission $permission): bool
    {
        return in_array($permission, $this->permissions);
    }
}
