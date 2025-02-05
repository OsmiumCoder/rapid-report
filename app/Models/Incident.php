<?php

namespace App\Models;

use App\Enum\IncidentType;
use App\States\IncidentStatus\IncidentStatusState;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStates\HasStates;

class Incident extends Model
{
    use HasFactory;
    use HasStates;
    use HasUuids;
    use SoftDeletes;

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

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function scopeFilter($query, ?array $filters)
    {
        if ($filters == null) {
            return;
        }

        $query->where(function ($innerQuery) use ($filters) {
            for ($i = 0; $i < count($filters); $i++) {
                if ($i == 0 || $filters[$i]['column'] == 'descriptor') {
                    $innerQuery->where($filters[$i]['column'], $filters[$i]['comparator'], $filters[$i]['value']);
                } else {
                    $innerQuery->where($filters[$i]['column'], $filters[$i]['comparator'], $filters[$i]['value']);
                }
            }
        });
    }

    public function scopeSort($query, $sortBy, $sortDirection): void
    {
        if ($sortBy == 'name') {
            $query->orderBy('first_name', $sortDirection)->orderBy('last_name', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }
    }
}
