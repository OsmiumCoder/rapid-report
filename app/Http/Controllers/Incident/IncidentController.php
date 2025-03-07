<?php

namespace App\Http\Controllers\Incident;

use App\Aggregates\IncidentAggregateRoot;
use App\Data\IncidentData;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class IncidentController extends Controller
{
    /**
     * Display a listing of the Incident.
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
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
    public function create(): Response
    {
        return Inertia::render('Incident/Create', [
            'form' => IncidentData::empty(),
        ]);
    }

    /**
     * Store a newly created Incident in storage.
     */
    public function store(IncidentData $incidentData): Response
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
     * @throws AuthorizationException
     */
    public function show(Incident $incident): Response
    {
        $this->authorize('view', $incident);

        $user = auth()->user();

        if ($user->can('perform admin actions')) {
            $supervisors = User::role('supervisor')->get();
            $roles = Role::all();
        } else {
            $supervisors = [];
            $roles = [];
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
            'incident' => $incident->load(['comments.user', 'supervisor', 'files.user']),
            'supervisors' => $supervisors,
            'roles' => $roles,
            'canRequestReview' => $user->can('requestReview', $incident),
            'canProvideFollowup' => $user->can('provideFollowup', $incident),
        ]);
    }
}
