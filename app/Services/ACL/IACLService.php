<?php

namespace App\Services\ACL;

use App\Enums\Permission;

interface IACLService
{
    public function hasPermissionTo(Permission $permission): bool;
}
