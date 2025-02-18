<?php

namespace App\Models;

use App\Enum\IncidentType;
use App\States\IncidentStatus\IncidentStatusState;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\ModelStates\HasStates;

class Incident extends Model
{
    use HasFactory;
    use HasStates;
    use HasUuids;
    use SoftDeletes;
    use Searchable;

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

    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Convert all boolean fields to integers
        foreach ($array as $key => $value) {
            if (is_bool($value)) {
                $array[$key] = (int)$value;
            }
        }

        return array_merge($array, [
            'id' => (string)$this->id,
            'upei_id' => (string)$this->upei_id,
            'supervisor' => $this->supervisor ? $this->supervisor->name : null,
            'supervisor_id' => (int)$this->supervisor_id,
            'created_at' => $this->created_at->timestamp,
        ]);
    }

    public function supervisor()
    {
        return $this->hasOne(User::class, 'id', 'supervisor_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function investigations()
    {
        return $this->hasMany(Investigation::class);
    }

    public function rootCauseAnalyses()
    {
        return $this->hasMany(RootCauseAnalysis::class);
    }

    public function scopeFilter($query, ?array $filters)
    {
        if ($filters == null) {
            return;
        }

        foreach ($filters as $filter) {
            $query->where(function ($innerQuery) use ($filter) {
                for ($i = 0; $i < count($filter['values']); $i++) {
                    if ($i == 0 || $filter['column'] == 'created_at') {
                        $innerQuery->where($filter['column'], $filter['values'][$i]['comparator'], $filter['values'][$i]['value']);
                    } else {
                        $innerQuery->orWhere($filter['column'], $filter['values'][$i]['comparator'], $filter['values'][$i]['value']);
                    }
                }
            });
        }
    }

    public function scopeSort($query, $sortBy = 'created_at', $sortDirection = 'asc'): void
    {
        if ($sortBy == 'name') {
            $query->orderBy('first_name', $sortDirection)->orderBy('last_name', $sortDirection);
        } elseif ($sortBy == 'status') {
            $query->orderByRaw(
                "CASE
                WHEN status = 'reopened' THEN 1
                WHEN status = 'returned' THEN 2
                WHEN status = 'opened' THEN 3
                WHEN status = 'assigned' THEN 4
                WHEN status = 'in review' THEN 5
                WHEN status = 'closed' THEN 6
                ELSE 7
            END $sortDirection"
            );
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        // Always sort by created_at within what we are sorting by
        // Unless that's what's been explicitly set
        if ($sortBy != 'created_at') {
            $query->orderBy('created_at', 'desc');
        }
    }
}
