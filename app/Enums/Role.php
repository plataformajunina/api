<?php

namespace App\Enums;

enum Role: string
{
    case SUPPORT = 'support';
    case TENANT = 'tenant';
    case GROUP = 'group';
    case PERSON = 'person';
}
