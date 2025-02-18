<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RootCauseAnalysis extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected function casts()
    {
        return [
            'individuals_involved' => 'array',
            'whys' => 'array',
            'solutions_and_actions' => 'array',
            'peoples_positions' => 'array',
            'attention_to_work' => 'array',
            'communication' => 'array',
            'ppe_in_good_condition' => 'boolean',
            'ppe_in_use' => 'boolean',
            'ppe_correct_type' => 'boolean',
            'correct_tool_used' => 'boolean',
            'policies_followed' => 'boolean',
            'worked_safely' => 'boolean',
            'used_tool_properly' => 'boolean',
            'tool_in_good_condition' => 'boolean',
            'working_conditions' => 'array',
            'root_causes' => 'array',
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
