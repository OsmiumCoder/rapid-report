<?php

namespace App\Enum;

enum IncidentType: int
{
    case SAFETY = 1;
    case ENVIRONMENTAL = 2;
    case SECURITY = 3;

    public static function toString($enumValue): string
    {
        return match ($enumValue) {
            self::SAFETY => 'Safety',
            self::ENVIRONMENTAL => 'Environmental',
            self::SECURITY => 'Security',
            default => 'Unknown',
        };
    }
}
