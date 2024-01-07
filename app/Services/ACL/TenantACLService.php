<?php

namespace App\Services\ACL;

use App\Enums\Permission;

class TenantACLService implements IACLService
{
    protected array $permissions = [
        // group
        Permission::LIST_GROUPS,
        Permission::CREATE_GROUP,
        Permission::SHOW_GROUP,
        // person
        Permission::LIST_PEOPLE,
        Permission::CREATE_PERSON,
        Permission::SHOW_PERSON,
        // team
        Permission::LIST_TEAMS,
        Permission::CREATE_TEAM,
        Permission::SHOW_TEAM,
        Permission::UPDATE_TEAM,
        Permission::DELETE_TEAM,
        Permission::RESTORE_TEAM,
        Permission::FORCE_DELETE_TEAM,
        // team invitation
        Permission::LIST_TEAM_INVITATIONS,
        Permission::CREATE_TEAM_INVITATION,
        Permission::SHOW_TEAM_INVITATION,
        Permission::DELETE_TEAM_INVITATION,
        Permission::RESTORE_TEAM_INVITATION,
        Permission::FORCE_DELETE_TEAM_INVITATION,
        // system
        Permission::LIST_SYSTEMS,
        Permission::CREATE_SYSTEM,
        Permission::SHOW_SYSTEM,
        Permission::UPDATE_SYSTEM,
        Permission::DELETE_SYSTEM,
        Permission::RESTORE_SYSTEM,
        Permission::FORCE_DELETE_SYSTEM,
        // template
        Permission::LIST_TEMPLATES,
        Permission::CREATE_TEMPLATE,
        Permission::SHOW_TEMPLATE,
        Permission::UPDATE_TEMPLATE,
        Permission::DELETE_TEMPLATE,
        Permission::RESTORE_TEMPLATE,
        Permission::FORCE_DELETE_TEMPLATE,
        // festival
        Permission::LIST_FESTIVALS,
        Permission::CREATE_FESTIVAL,
        Permission::SHOW_FESTIVAL,
        Permission::UPDATE_FESTIVAL,
        Permission::DELETE_FESTIVAL,
        Permission::RESTORE_FESTIVAL,
        Permission::FORCE_DELETE_FESTIVAL,
        // evaluation
        Permission::LIST_EVALUATIONS,
        Permission::CREATE_EVALUATION,
        Permission::SHOW_EVALUATION,
        Permission::UPDATE_EVALUATION,
        Permission::DELETE_EVALUATION,
        Permission::RESTORE_EVALUATION,
        Permission::FORCE_DELETE_EVALUATION,
        // sheet
        Permission::LIST_SHEETS,
        Permission::CREATE_SHEET,
        Permission::SHOW_SHEET,
        Permission::UPDATE_SHEET,
        Permission::DELETE_SHEET,
        Permission::RESTORE_SHEET,
        Permission::FORCE_DELETE_SHEET,
    ];

    public function hasPermissionTo(Permission $permission): bool
    {
        return in_array($permission, $this->permissions);
    }
}
