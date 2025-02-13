<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Investigation extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'resulted_in' => 'array',
            'substandard_acts' => 'array',
            'substandard_conditions' => 'array',
            'energy_transfer_causes' => 'array',
            'personal_factors' => 'array',
            'job_factors' => 'array',
        ];
    }

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class);
    }
}
