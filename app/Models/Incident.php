<?php

namespace App\Models;

use App\Enum\IncidentStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Enum\IncidentType;
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
            'anonymous' => 'boolean',
            'on_behalf' => 'boolean',
            'on_behalf_anonymous' => 'boolean',
            'work_related' => 'boolean',
            'witnesses' => 'array',
            'status' => IncidentStatus::class,
            'incident_type' => IncidentType::class,
        ];
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
