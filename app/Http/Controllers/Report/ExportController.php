<?php

namespace App\Http\Controllers\Report;

use App\Data\IncidentExportData;
use App\Exports\IncidentsExport;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception as PhpSpreadSheetException;
use PhpOffice\PhpSpreadsheet\Writer\Exception as WriterException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    /**
     * @throws AuthorizationException
     * @throws PhpSpreadSheetException
     * @throws WriterException
     */
    public function exportXLSX(IncidentExportData $exportData): BinaryFileResponse
    {
        Gate::authorize('view-report-page');

        return Excel::download(
            new IncidentsExport($exportData),
            "{$exportData->start->toDateString()}-to-{$exportData->end->toDateString()}.xlsx",
            \Maatwebsite\Excel\Excel::XLSX
        );
    }

    /**
     * @throws AuthorizationException
     * @throws PhpSpreadSheetException
     * @throws WriterException
     */
    public function exportCSV(IncidentExportData $exportData): BinaryFileResponse
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
