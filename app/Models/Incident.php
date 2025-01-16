<?php

namespace App\Models;

use App\Enum\IncidentStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incident extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;

    protected function casts(): array
    {
        return [
            'witnesses' => 'array',
            'status' => IncidentStatus::class,
        ];
    }
}
