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
        $this->authorize('viewOwned', Incident::class);

        $assignedIncidents = Incident::where('reporters_email', $request->user()->email)->paginate();

        return Inertia::render('Incident/Owned', [
            'incidents' => $assignedIncidents
        ]);
    }
}
