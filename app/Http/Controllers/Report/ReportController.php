<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): Response
    {
        Gate::authorize('view-report-page');

        return Inertia::render('Report/Index');
    }

    /**
     * @throws AuthorizationException
     */
    public function stats(): Response
    {
        Gate::authorize('view-report-page');

        return Inertia::render('Report/Stats', [
            'incidents' => Incident::all(),
        ]);
    }
}
