<?php

namespace App\Http\Controllers\Incident;

use App\Aggregates\IncidentAggregateRoot;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;


class IncidentStatusController extends Controller
{
    public function closeIncident(Request $request, Incident $incident)
    {
        $this->authorize('performAdminActions', Incident::class);

        IncidentAggregateRoot::retrieve($incident->id)
            ->closeIncident()
            ->persist();

        return redirect()->back();

    }

    public function reopenIncident(Request $request, Incident $incident)
    {
        $this->authorize('performAdminActions', Incident::class);

        IncidentAggregateRoot::retrieve($incident->id)
            ->reopenIncident()
            ->persist();

        return redirect()->back();

    }
}
