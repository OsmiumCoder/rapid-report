<?php

namespace App\Enum;

enum IncidentType: int
{
    case SAFETY = 1;
    case ENVIRONMENTAL = 2;
    case SECURITY = 3;
}
