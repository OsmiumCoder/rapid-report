<?php

namespace App\Models;

use App\Enum\IncidentStatus;
use App\Enum\IncidentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incident extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'witnesses' => 'array',
            'status' => IncidentStatus::class,
            'incident_type' => IncidentType::class,
        ];
    }
}
