<?php

namespace App\Http\Controllers\Investigation;

use App\Aggregates\InvestigationAggregateRoot;
use App\Data\InvestigationData;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Investigation;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class InvestigationController extends Controller
{
    /**
     * Show the form for creating a new investigation.
     * @throws AuthorizationException
     */
    public function create(Incident $incident): Response
    {
        $this->authorize('create', [Investigation::class, $incident]);

        return Inertia::render('Investigation/Create', [
            'incident' => $incident,
        ]);
    }

    /**
     * Store a newly created investigation in storage.
     * @throws AuthorizationException
     */
    public function store(Incident $incident, InvestigationData $investigationData): RedirectResponse
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
     * @throws AuthorizationException
     */
    public function show(Incident $incident, Investigation $investigation): Response
    {
        $this->authorize('view', $investigation);

        return Inertia::render('Investigation/Show', [
            'investigation' => $investigation->load(['incident.comments.user', 'supervisor'])
        ]);
    }
}
