<?php

namespace App\Http\Controllers\Incident;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SearchIncidentsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $form = $request->validate([
            'search' => ['required', 'string'],
            'search_by' => ['required', 'string'],
        ]);

        $incidentQuery = Incident::search($form['search'])->options(['query_by' => $form['search_by']]);

        $this->authorize('searchIncidents', [Incident::class, $incidentQuery]);

        return Response::json($incidentQuery->get());

    }
}
