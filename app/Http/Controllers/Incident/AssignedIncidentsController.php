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

        $sortBy = $request->string('sort_by', 'status');
        $sortDirection = $request->string('sort_direction', 'asc');

        $assignedIncidents = Incident::sort($sortBy, $sortDirection)
            ->filter($filters)
            ->where('supervisor_id', $request->user()->id)
            ->paginate($perPage = 10, $columns = ['*'], $pageName = 'incidents')
            ->appends($request->query());


        return Inertia::render('Incident/Index', [
            'incidents' => $assignedIncidents,
            'indexType' => 'assigned',
            'currentFilters' => $filters,
            'currentSortBy' => $sortBy,
            'currentSortDirection' => $sortDirection,
        ]);
    }
}
