<?php

namespace App\Http\Controllers\Report;

use App\Data\IncidentData;
use App\Data\ReportExportData;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index()
    {
        Gate::authorize('view-report-page');
        return Inertia::render('Report/Index', [
        'form' => ReportExportData::empty(),
        ]);
    }
    public function stats()
    {
        Gate::authorize('view-report-page');

        return Inertia::render('Report/Stats', [
            'incidents' => Incident::all(),
        ]);
    }

    public function downloadFileCSV(ReportExportData $exportData)
    {

        $file_path = Storage::disk('public')->put('example.json', $exportData->toJson());

        return response()->download('contents','file.txt');
    }
}
