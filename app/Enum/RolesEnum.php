<?php

namespace App\Enum;

enum RolesEnum: string
{
    case ADMIN = 'admin';
    case SUPERVISOR = 'supervisor';
    case USER = 'user';
}
