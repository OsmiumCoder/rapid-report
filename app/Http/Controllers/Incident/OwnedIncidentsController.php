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
        $assignedIncidents = Incident::where('supervisor_id', $request->user()->id)->paginate(10);

        return Inertia::render('Incident/Index', [
            'incidents' => $assignedIncidents
        ]);
    }
}
