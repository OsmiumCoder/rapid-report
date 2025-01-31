<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Policies\ReportPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Inertia\Inertia;

class ReportController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): \Inertia\Response
    {
        if (!auth()->user()->can('view reports')) {
            abort(403);
        }

        return Inertia::render('Reports/Show', [
            'incidents' => Incident::all(),
        ]);
    }
}
