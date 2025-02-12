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

        $sortBy = $request->string('sort_by', 'created_at');
        $sortDirection = $request->string('sort_direction', 'desc');

        $ownedIncidents = Incident::sort($sortBy, $sortDirection)
            ->where('reporters_email', $request->user()->email)
            ->filter($filters)
            ->paginate($perPage = 10, $columns = ['*'], $pageName = 'incidents')
            ->appends($request->query());

        return Inertia::render('Incident/Index', [
            'incidents' => $ownedIncidents,
            'indexType' => 'owned',
            'currentFilters' => $filters,
            'currentSortBy' => $sortBy,
            'currentSortDirection' => $sortDirection,
        ]);
    }
}
