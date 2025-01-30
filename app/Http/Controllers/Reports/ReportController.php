<?php
namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Incident;
 use Inertia\Inertia;

 class ReportController extends Controller{
    public function index()
    {
        $this->authorize('viewAny', Incident::class);

        return Inertia::render('Reports/Index', [
            'incidents' => Incident::all(),
            'indexType' => 'all',
        ]);
    }
}

