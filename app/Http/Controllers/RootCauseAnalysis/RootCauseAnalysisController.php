<?php

namespace App\Http\Controllers\RootCauseAnalysis;

use App\Aggregates\RootCauseAnalysisAggregateRoot;
use App\Data\RootCauseAnalysisData;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\RootCauseAnalysis;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class RootCauseAnalysisController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Incident $incident)
    {
        $this->authorize('create', [RootCauseAnalysis::class, $incident]);
        return Inertia::render('RootCauseAnalysis/Create', ['incident' => $incident]);
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

        return to_route('incidents.root-cause-analyses.show', ['incident' => $incident->id, 'root_cause_analysis' => $uuid]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Incident $incident, RootCauseAnalysis $rootCauseAnalysis)
    {

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
