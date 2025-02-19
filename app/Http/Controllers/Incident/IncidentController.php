<?php

namespace App\Http\Controllers\Incident;

use App\Aggregates\IncidentAggregateRoot;
use App\Data\IncidentData;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class IncidentController extends Controller
{
    /**
     * Display a listing of the Incident.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Incident::class);

        $filters = json_decode(urldecode($request->query('filters')), true);

        $sortBy = $request->string('sort_by', 'created_at');
        $sortDirection = $request->string('sort_direction', 'desc');

        $incidents = Incident::sort($sortBy, $sortDirection)
            ->filter($filters)
            ->paginate($perPage = 10, $columns = ['*'], $pageName = 'incidents')
            ->appends($request->query());

        return Inertia::render('Incident/Index', [
            'incidents' => $incidents,
            'indexType' => 'all',
            'currentFilters' => $filters,
            'currentSortBy' => $sortBy,
            'currentSortDirection' => $sortDirection,
        ]);
    }

    /**
     * Show the form for creating a new Incident.
     */
    public function create()
    {
        return Inertia::render('Incident/Create', [
            'form' => IncidentData::empty(),
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

        return Inertia::render('Incident/Created', [
            'incident_id' => $uuid,
            'can_view' => auth()->user()?->email == $incidentData->reporters_email,
        ]);
    }

    /**
     * Display the specified Incident.
     */
    public function show(Incident $incident)
    {
        $this->authorize('view', $incident);

        $user = auth()->user();

        if ($user->can('perform admin actions')) {
            $supervisors = User::role('supervisor')->get();
        } else {
            $supervisors = [];
        }

        if ($user->can('view any incident follow-up')) {
            $incident->load(['investigations.supervisor', 'rootCauseAnalyses.supervisor']);
        } else {
            $incident->load([
                'investigations' => function ($query) use ($user, $incident) {
                    $query->where('supervisor_id', $user->id)->with('supervisor');
                },
                'rootCauseAnalyses' => function ($query) use ($user, $incident) {
                    $query->where('supervisor_id', $user->id)->with('supervisor');
                },
            ]);
        }

        return Inertia::render('Incident/Show', [
            'incident' => $incident->load(['comments.user', 'supervisor']),
            'supervisors' => $supervisors,
            'canRequestReview' => $user->can('requestReview', $incident)
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
