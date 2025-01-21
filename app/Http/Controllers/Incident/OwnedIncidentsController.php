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

        $ownedIncidents = Incident::where('reporters_email', $request->user()->email)->paginate($perPage = 10, $columns = ['*'], $pageName = 'incidents');

        return Inertia::render('Incident/Index', [
            'incidents' => $ownedIncidents,
            'indexType' => 'owned',
        ]);
    }
}
