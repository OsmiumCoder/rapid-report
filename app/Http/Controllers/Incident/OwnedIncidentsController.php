<?php

namespace App\Http\Controllers\Incident;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OwnedIncidentsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $this->authorize('viewAnyOwned', Incident::class);

        $filters = json_decode(urldecode($request->query('filters')), true);
        $sortBy = $request->query('sort_by', 'created_at');
        $sortDirection = $request->query('sort_direction', 'desc');

        if ($sortBy == 'name') {
            $ownedIncidents = Incident::orderBy('first_name', $sortDirection)
                ->orderBy('last_name', $sortDirection)
                ->where('reporters_email', $request->user()->email);
        } else {
            $ownedIncidents = Incident::orderBy($sortBy, $sortDirection)
                ->where('reporters_email', $request->user()->email);
        }

        if ($filters != null) {
            foreach ($filters as $filter) {
                $ownedIncidents->where($filter['column'], '=', $filter['value']);
            }
        }

        return Inertia::render('Incident/Index', [
            'incidents' => $ownedIncidents->paginate($perPage = 10, $columns = ['*'], $pageName = 'incidents')->appends($request->query()),
            'indexType' => 'owned',
        ]);
    }
}
