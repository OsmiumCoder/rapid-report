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

        if ($sortBy == 'name') {
            $assignedIncidents = Incident::orderBy('first_name', $sortDirection)
                ->orderBy('last_name', $sortDirection)
                ->where('supervisor_id', $request->user()->id);
        } else {
            $assignedIncidents = Incident::orderBy($sortBy, $sortDirection)
                ->where('supervisor_id', $request->user()->id);
        }

        if ($filters != null) {
            foreach ($filters as $filter) {
                $assignedIncidents->where($filter['column'], '=', $filter['value']);
            }
        }

        return Inertia::render('Incident/Index', [
            'incidents' => $assignedIncidents->paginate($perPage = 10, $columns = ['*'], $pageName = 'incidents')->appends($request->query()),
            'indexType' => 'assigned',
        ]);
    }
}
