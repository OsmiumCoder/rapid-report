<?php

namespace App\Enum;

enum RolesEnum: string
{
    case SUPER_ADMIN = 'super-admin';
    case ADMIN = 'admin';
    case SUPERVISOR = 'supervisor';
    case USER = 'user';
}
