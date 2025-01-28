<?php

namespace App\Http\Controllers\Incident;

use App\Aggregates\IncidentAggregateRoot;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssignSupervisor extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Incident $incident, string $supervisor_id)
    {
        // TODO: Add route handling
        IncidentAggregateRoot::retrieve($incident->id)->assignSupervisor($supervisor_id);
    }
}
