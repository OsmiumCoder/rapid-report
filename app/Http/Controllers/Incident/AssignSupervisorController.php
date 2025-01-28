<?php

namespace App\Http\Controllers\Incident;

use App\Aggregates\IncidentAggregateRoot;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;

class AssignSupervisorController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Incident $incident)
    {
        $this->authorize('assignSupervisor', Incident::class);

        $form = $request->validate([
            'supervisor_id' => 'required|exists:users,id',
        ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->assignSupervisor($form['supervisor_id'])
            ->persist();

        return response()->json([
            'success' => true,
        ]);
    }
}
