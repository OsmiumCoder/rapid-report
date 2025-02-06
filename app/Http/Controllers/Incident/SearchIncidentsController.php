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

        $query = $request->string('query');
        $searchBy = $request->string('search_by');

        $incidents = Incident::search($query)->options(['query_by' => $searchBy]);

//        if (! auth()->user()->can('viewAny', Incident::class) && auth()->user()->can('viewAssigned')) {
//            $incidents->where('supervisor_id', auth()->id());
//        } else {
//            abort(403);
//        }

        return Response::json($incidents->get());

    }
}
