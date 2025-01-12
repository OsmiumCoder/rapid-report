<?php

namespace App\Http\Controllers;

use App\Data\IncidentData;
use App\Enum\IncidentStatus;
use App\Models\Incident;
use App\StorableEvents\Incident\IncidentCreated;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IncidentController extends Controller
{
    /**
     * Display a listing of the Incident.
     */
    public function index()
    {
        //
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
        $event = new IncidentCreated(
            role: $incidentData->role,
            last_name: $incidentData->last_name,
            first_name: $incidentData->first_name,
            upei_id: $incidentData->upei_id,
            email: $incidentData->email,
            phone: $incidentData->phone,
            work_related: $incidentData->work_related,
            happened_at: $incidentData->happened_at,
            location: $incidentData->location,
            room_number: $incidentData->room_number,
            reported_to: $incidentData->reported_to,
            witnesses: $incidentData->witnesses,
            incident_type: $incidentData->incident_type,
            descriptor: $incidentData->descriptor,
            description: $incidentData->description,
            injury_description: $incidentData->injury_description,
            first_aid_description: $incidentData->first_aid_description,
            reporters_email: $incidentData->reporters_email,
            supervisor_name: $incidentData->supervisor_name,
            status: IncidentStatus::OPEN
        );

        event($event);

        // TODO: update redirect, show a banner
        return to_route('dashboard');
    }

    /**
     * Display the specified Incident.
     */
    public function show(Incident $incident)
    {
        //
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
