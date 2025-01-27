<?php

namespace App\Models;

use App\Enum\IncidentStatus;
use App\States\IncidentStatus\IncidentStatusState;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Enum\IncidentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStates\HasStates;

class Incident extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;
    use HasStates;

    protected function casts(): array
    {
        return [
            'anonymous' => 'boolean',
            'on_behalf' => 'boolean',
            'on_behalf_anonymous' => 'boolean',
            'work_related' => 'boolean',
            'witnesses' => 'array',
            'status' => IncidentStatusState::class,
            'incident_type' => IncidentType::class,
        ];
    }
}
