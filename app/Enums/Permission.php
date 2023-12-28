<?php

namespace App\Enums;

enum Permission: string
{
    // support
    case LIST_SUPPORTS = 'list_supports';
    case CREATE_SUPPORT = 'create_support';
    case SHOW_SUPPORT = 'show_support';
    case UPDATE_SUPPORT = 'update_support';
    case DELETE_SUPPORT = 'delete_support';
    case RESTORE_SUPPORT = 'restore_support';
    case FORCE_DELETE_SUPPORT = 'force_delete_support';

    // tenant
    case LIST_TENANTS = 'list_tenants';
    case CREATE_TENANT = 'create_tenant';
    case SHOW_TENANT = 'show_tenant';
    case UPDATE_TENANT = 'update_tenant';
    case DELETE_TENANT = 'delete_tenant';
    case RESTORE_TENANT = 'restore_tenant';
    case FORCE_DELETE_TENANT = 'force_delete_tenant';

    // group
    case LIST_GROUPS = 'list_groups';
    case CREATE_GROUP = 'create_group';
    case SHOW_GROUP = 'show_group';
    case UPDATE_GROUP = 'update_group';
    case DELETE_GROUP = 'delete_group';
    case RESTORE_GROUP = 'restore_group';
    case FORCE_DELETE_GROUP = 'force_delete_group';

    // person
    case LIST_PEOPLE = 'list_people';
    case CREATE_PERSON = 'create_person';
    case SHOW_PERSON = 'show_person';
    case UPDATE_PERSON = 'update_person';
    case DELETE_PERSON = 'delete_person';
    case RESTORE_PERSON = 'restore_person';
    case FORCE_DELETE_PERSON = 'force_delete_person';

    // team
    case LIST_TEAMS = 'list_teams';
    case CREATE_TEAM = 'create_team';
    case SHOW_TEAM = 'show_team';
    case UPDATE_TEAM = 'update_team';
    case DELETE_TEAM = 'delete_team';
    case RESTORE_TEAM = 'restore_team';
    case FORCE_DELETE_TEAM = 'force_delete_team';

    // team invitation
    case LIST_TEAM_INVITATIONS = 'list_team_invitations';
    case CREATE_TEAM_INVITATION = 'create_team_invitation';
    case SHOW_TEAM_INVITATION = 'show_team_invitation';
    case ACCEPT_TEAM_INVITATION = 'accept_team_invitation';
    case DECLINE_TEAM_INVITATION = 'decline_team_invitation';
    case DELETE_TEAM_INVITATION = 'delete_team_invitation';
    case RESTORE_TEAM_INVITATION = 'restore_team_invitation';
    case FORCE_DELETE_TEAM_INVITATION = 'force_delete_team_invitation';

    // system
    case LIST_SYSTEMS = 'list_systems';
    case CREATE_SYSTEM = 'create_system';
    case SHOW_SYSTEM = 'show_system';
    case UPDATE_SYSTEM = 'update_system';
    case DELETE_SYSTEM = 'delete_system';
    case RESTORE_SYSTEM = 'restore_system';
    case FORCE_DELETE_SYSTEM = 'force_delete_system';

    // template
    case LIST_TEMPLATES = 'list_templates';
    case CREATE_TEMPLATE = 'create_template';
    case SHOW_TEMPLATE = 'show_template';
    case UPDATE_TEMPLATE = 'update_template';
    case DELETE_TEMPLATE = 'delete_template';
    case RESTORE_TEMPLATE = 'restore_template';
    case FORCE_DELETE_TEMPLATE = 'force_delete_template';

    // festival
    case LIST_FESTIVALS = 'list_festivals';
    case CREATE_FESTIVAL = 'create_festival';
    case SHOW_FESTIVAL = 'show_festival';
    case UPDATE_FESTIVAL = 'update_festival';
    case DELETE_FESTIVAL = 'delete_festival';
    case RESTORE_FESTIVAL = 'restore_festival';
    case FORCE_DELETE_FESTIVAL = 'force_delete_festival';

    // evaluation
    case LIST_EVALUATIONS = 'list_evaluations';
    case CREATE_EVALUATION = 'create_evaluation';
    case SHOW_EVALUATION = 'show_evaluation';
    case UPDATE_EVALUATION = 'update_evaluation';
    case DELETE_EVALUATION = 'delete_evaluation';
    case RESTORE_EVALUATION = 'restore_evaluation';
    case FORCE_DELETE_EVALUATION = 'force_delete_evaluation';

    // sheet
    case LIST_SHEETS = 'list_sheets';
    case CREATE_SHEET = 'create_sheet';
    case SHOW_SHEET = 'show_sheet';
    case UPDATE_SHEET = 'update_sheet';
    case DELETE_SHEET = 'delete_sheet';
    case RESTORE_SHEET = 'restore_sheet';
    case FORCE_DELETE_SHEET = 'force_delete_sheet';
}
