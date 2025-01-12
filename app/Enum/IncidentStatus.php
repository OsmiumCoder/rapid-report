<?php

namespace App\Enum;

enum IncidentStatus: int
{
    case OPEN = 1;
    case PENDING_FOLLOW_UP = 2;
    case CLOSED = 3;
}
