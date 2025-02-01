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

        $filters = json_decode(urldecode($request->query('filters')), true);
        $sortBy = $request->query('sort_by', 'created_at');
        $sortDirection = $request->query('sort_direction', 'desc');

        $assignedIncidents = Incident::sort($sortBy, $sortDirection)
            ->filter($filters)
            ->where('supervisor_id', $request->user()->id);


        return Inertia::render('Incident/Index', [
            'incidents' => $assignedIncidents->paginate($perPage = 10, $columns = ['*'], $pageName = 'incidents')->appends($request->query()),
            'indexType' => 'assigned',
        ]);
    }
}
