<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index()
    {
         Gate::authorize('view-report-page');

        return Inertia::render('Report/Index', [
            'incidents' => Incident::all(),
        ]);
    }
}
