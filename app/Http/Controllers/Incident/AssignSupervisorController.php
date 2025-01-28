<?php

namespace App\Http\Controllers\Incident;

use App\Aggregates\IncidentAggregateRoot;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssignSupervisorController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $incident_id, string $supervisor_id)
    {
        IncidentAggregateRoot::retrieve($incident_id)->assignSupervisor($supervisor_id)->persist();

        return response()->json([
            'success' => true,
        ]);
    }
}
