<?php

namespace App\Http\Controllers\RootCauseAnalysis;

use App\Aggregates\RootCauseAnalysisAggregateRoot;
use App\Data\RootCauseAnalysisData;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\RootCauseAnalysis;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RootCauseAnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Incident $incident, RootCauseAnalysisData $rcaData)
    {
        $this->authorize('create', [RootCauseAnalysis::class, $incident]);

        $uuid = Str::uuid()->toString();

        RootCauseAnalysisAggregateRoot::retrieve(uuid: $uuid)
            ->createRootCauseAnalysis($rcaData, $incident)
            ->persist();

        return to_route('incidents.root-cause-analysis.show', ['incident' => $incident->id, 'root_cause_analysis' => $uuid]);
    }

    /**
     * Display the specified resource.
     */
    public function show(RootCauseAnalysis $rootCauseAnalysis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RootCauseAnalysis $rootCauseAnalysis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RootCauseAnalysis $rootCauseAnalysis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RootCauseAnalysis $rootCauseAnalysis)
    {
        //
    }
}
