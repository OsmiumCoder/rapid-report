<?php

namespace App\Http\Controllers\Investigation;

use App\Aggregates\InvestigationAggregateRoot;
use App\Data\InvestigationData;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Investigation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class InvestigationController extends Controller
{
    /**
     * Show the form for creating a new investigation.
     */
    public function create(Incident $incident)
    {
        $this->authorize('create', [Investigation::class, $incident]);

        return Inertia::render('Investigation/Create', [
            'incident' => $incident,
        ]);
    }

    /**
     * Store a newly created investigation in storage.
     */
    public function store(Incident $incident, InvestigationData $investigationData)
    {
        $this->authorize('create', [Investigation::class, $incident]);

        $uuid = Str::uuid()->toString();

        InvestigationAggregateRoot::retrieve(uuid: $uuid)
            ->createInvestigation($investigationData, $incident)
            ->persist();

        return to_route('incidents.investigations.show', ['incident' => $incident->id, 'investigation' => $uuid]);
    }

    /**
     * Display the specified investigation.
     */
    public function show(Incident $incident, Investigation $investigation)
    {
        $this->authorize('view', $investigation);

        $investigation->load('incident');

        return Inertia::render('Investigation/Show', ['investigation' => $investigation->load(['incident', 'supervisor'])]);
    }

    /**
     * Show the form for editing the specified investigation.
     */
    public function edit(Investigation $investigation)
    {
        //
    }

    /**
     * Update the specified investigation in storage.
     */
    public function update(Request $request, Investigation $investigation)
    {
        //
    }

    /**
     * Remove the specified investigation from storage.
     */
    public function destroy(Investigation $investigation)
    {
        //
    }
}
