<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    /** @use HasFactory<\Database\Factories\IncidentFactory> */
    use HasFactory;

    public function witnesses()
    {
        return $this->belongsToMany(User::class, 'witnesses', 'incident_id', 'witness_id');
    }
}
