<?php

namespace App\Http\Controllers\Report;

use App\Data\ReportExportData;
use App\Exports\IncidentsExport;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        Gate::authorize('view-report-page');

        return Inertia::render('Report/Index');
    }

    public function stats()
    {
        Gate::authorize('view-report-page');

        return Inertia::render('Report/Stats', [
            'incidents' => Incident::all(),
        ]);
    }

    public function exportXLSX(ReportExportData $exportData)
    {
        Gate::authorize('view-report-page');

        return Excel::download(
            new IncidentsExport($exportData),
            "{$exportData->start->toDateString()}-to-{$exportData->end->toDateString()}.xlsx",
            \Maatwebsite\Excel\Excel::XLSX
        );
    }

    public function exportCSV(ReportExportData $exportData)
    {
        Gate::authorize('view-report-page');

        return Excel::download(
            new IncidentsExport($exportData),
            "{$exportData->start->toDateString()}-to-{$exportData->end->toDateString()}.csv",
            \Maatwebsite\Excel\Excel::CSV,
            ['Content-Type' => 'text/csv']
        );
    }

}
