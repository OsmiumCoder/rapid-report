<?php

namespace App\Http\Controllers\Report;

use App\Data\ExportData;
use App\Exports\IncidentsExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportXLSX(ExportData $exportData)
    {
        Gate::authorize('view-report-page');

        return Excel::download(
            new IncidentsExport($exportData),
            "{$exportData->start->toDateString()}-to-{$exportData->end->toDateString()}.xlsx",
            \Maatwebsite\Excel\Excel::XLSX
        );
    }

    public function exportCSV(ExportData $exportData)
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
