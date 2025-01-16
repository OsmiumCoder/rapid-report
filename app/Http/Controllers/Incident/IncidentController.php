<?php

namespace App\Http\Controllers\Incident;

use App\Aggregates\IncidentAggregateRoot;
use App\Data\IncidentData;
use App\Enum\IncidentStatus;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\StorableEvents\Incident\IncidentCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Ramsey\Uuid\Uuid;

class IncidentController extends Controller
{
    /**
     * Display a listing of the Incident.
     */
    public function index()
    {
        $this->authorize('viewAny', Incident::class);


        return Inertia::render('Incident/Index', [
            'incidents' => Incident::paginate()
        ]);
    }

    /**
     * Show the form for creating a new Incident.
     */
    public function create()
    {
        return Inertia::render('Incident/Create', [
            'form' => IncidentData::empty()
        ]);
    }

    /**
     * Store a newly created Incident in storage.
     */
    public function store(IncidentData $incidentData)
    {
        $uuid = Str::uuid()->toString();

        IncidentAggregateRoot::retrieve(uuid: $uuid)
            ->createIncident($incidentData)
            ->persist();

        return to_route('incidents.show', ['incident' => $uuid]);
    }

    /**
     * Display the specified Incident.
     */
    public function show(Incident $incident)
    {
        $this->authorize('view', $incident);

        return Inertia::render('Incident/Show', [
            'incident' => $incident
        ]);
    }

    /**
     * Show the form for editing the specified Incident.
     */
    public function edit(Incident $incident)
    {
        //
    }

    /**
     * Update the specified Incident in storage.
     */
    public function update(Request $request, Incident $incident)
    {
        //
    }

    /**
     * Remove the specified Incident from storage.
     */
    public function destroy(Incident $incident)
    {
        //
    }
}
