<?php

namespace App\Enum;

enum IncidentType: int
{
    case Safety = 1;
    case Environmental = 2;
    case Security = 3;
}
