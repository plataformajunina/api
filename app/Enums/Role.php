<?php

namespace App\Enums;

enum Role: string
{
    case MAIN_SUPPORT = 'main_support';
    case MANAGER_SUPPORT = 'manager_support';
    case TENANT = 'tenant';
    case GROUP = 'group';
    case PERSON = 'person';
}
