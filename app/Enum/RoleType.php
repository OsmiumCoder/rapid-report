<?php

namespace App\Enum;

enum RoleType: int
{
    case EMPLOYEE = 1;
    case STUDENT = 2;
    case VISITOR = 3;
    case CONTRACTOR = 4;

    public static function toString($enumValue): string
    {
        return match ($enumValue) {
            1 => 'Employee',
            2 => 'Student',
            3 => 'Visitor',
            4 => 'Contractor',
            default => 'Unknown',
        };
    }
}
