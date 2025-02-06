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

        $incidents = Incident::search($form['search'])->options(['query_by' => $form['search_by']]);

//        if (! auth()->user()->can('viewAny', Incident::class) && auth()->user()->can('viewAssigned')) {
//            $incidents->where('supervisor_id', auth()->id());
//        } else {
//            abort(403);
//        }

        return Response::json($incidents->get());

    }
}
