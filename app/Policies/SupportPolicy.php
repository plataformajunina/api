<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\{Support, User};
use Illuminate\Auth\Access\Response;

class SupportPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(Permission::LIST_SUPPORTS);
    }

    public function view(User $user, Support $support): bool
    {
        return $user->hasPermissionTo(Permission::SHOW_SUPPORT)
            && $user->isNot($support->user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(Permission::CREATE_SUPPORT);
    }

    public function update(User $user, Support $support): bool
    {
        return $user->hasPermissionTo(Permission::UPDATE_SUPPORT)
            && $user->isNot($support->user);
    }

    public function delete(User $user, Support $support): bool
    {
        return $user->hasPermissionTo(Permission::DELETE_SUPPORT)
            && $user->isNot($support->user);
    }

    public function restore(User $user, Support $support): bool
    {
        return $user->hasPermissionTo(Permission::RESTORE_SUPPORT)
            && $user->isNot($support->user);
    }

    public function forceDelete(User $user, Support $support): bool
    {
        return $user->hasPermissionTo(Permission::RESTORE_SUPPORT)
            && $user->isNot($support->user);
    }
}
