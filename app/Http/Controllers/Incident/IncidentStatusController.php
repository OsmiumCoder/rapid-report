<?php

namespace App\Http\Controllers\Incident;

use App\Aggregates\IncidentAggregateRoot;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentStatusController extends Controller
{
    public function assignSupervisor(Request $request, Incident $incident)
    {
        $this->authorize('performAdminActions', Incident::class);

        $form = $request->validate([
            'supervisor_id' => 'required|exists:users,id',
        ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->assignSupervisor($form['supervisor_id'])
            ->persist();

        return back();
    }

    public function unassignSupervisor(Request $request, Incident $incident)
    {
        $this->authorize('performAdminActions', Incident::class);

        IncidentAggregateRoot::retrieve($incident->id)
            ->unassignSupervisor()
            ->persist();

        return back();
    }

    public function closeIncident(Request $request, Incident $incident)
    {
        $this->authorize('performAdminActions', Incident::class);

        IncidentAggregateRoot::retrieve($incident->id)
            ->closeIncident()
            ->persist();

        return back();

    }

    public function reopenIncident(Request $request, Incident $incident)
    {
        $this->authorize('performAdminActions', Incident::class);

        IncidentAggregateRoot::retrieve($incident->id)
            ->reopenIncident()
            ->persist();

        return back();

    }
}
