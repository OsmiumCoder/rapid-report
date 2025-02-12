<?php

namespace App\Http\Controllers\Report;

use App\Data\ReportExportData;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
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

    public function downloadFileCSV(ReportExportData $exportData){
        Gate::authorize('view-report-page');
        $path = Storage::disk('public')->path("name");
        return response()->download($path);
    }
}
