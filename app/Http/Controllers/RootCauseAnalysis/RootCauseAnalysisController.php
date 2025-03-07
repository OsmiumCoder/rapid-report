<?php

namespace App\Http\Controllers\RootCauseAnalysis;

use App\Aggregates\RootCauseAnalysisAggregateRoot;
use App\Data\RootCauseAnalysisData;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\RootCauseAnalysis;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class RootCauseAnalysisController extends Controller
{
    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create(Incident $incident): Response
    {
        $this->authorize('create', [RootCauseAnalysis::class, $incident]);

        return Inertia::render('RootCauseAnalysis/Create', [
            'incident' => $incident
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(Incident $incident, RootCauseAnalysisData $rcaData): RedirectResponse
    {
        $this->authorize('create', [RootCauseAnalysis::class, $incident]);

        $uuid = Str::uuid()->toString();

        RootCauseAnalysisAggregateRoot::retrieve(uuid: $uuid)
            ->createRootCauseAnalysis($rcaData, $incident)
            ->persist();

        return to_route('incidents.root-cause-analyses.show', [
            'incident' => $incident->id,
            'root_cause_analysis' => $uuid
        ]);
    }

    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show(Incident $incident, RootCauseAnalysis $rootCauseAnalysis): Response
    {
        $this->authorize('view', $rootCauseAnalysis);

        return Inertia::render('RootCauseAnalysis/Show', [
            'rca' => $rootCauseAnalysis->load(['incident.comments.user','supervisor'])
        ]);
    }
}
