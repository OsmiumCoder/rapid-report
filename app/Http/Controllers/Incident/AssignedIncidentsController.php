<?php

namespace App\Http\Controllers\Incident;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AssignedIncidentsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $this->authorize('viewAnyAssigned', Incident::class);

        $assignedIncidents = Incident::where('supervisor_id', $request->user()->id)->paginate($perPage = 10, $columns = ['*'], $pageName = 'incidents');

        return Inertia::render('Incident/Index', [
            'incidents' => $assignedIncidents,
            'indexType' => 'assigned',
        ]);
    }
}
