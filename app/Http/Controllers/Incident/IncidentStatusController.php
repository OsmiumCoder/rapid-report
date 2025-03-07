<?php

namespace App\Http\Controllers\Incident;

use App\Aggregates\IncidentAggregateRoot;
use App\Exceptions\UserNotSupervisorException;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class IncidentStatusController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function requestReview(Incident $incident): RedirectResponse
    {
        $this->authorize('requestReview', $incident);

        IncidentAggregateRoot::retrieve($incident->id)
            ->requestReview()
            ->persist();

        return back();
    }

    /**
     * @throws AuthorizationException
     */
    public function returnInvestigation(Incident $incident): RedirectResponse
    {
        $this->authorize('performAdminActions', Incident::class);

        IncidentAggregateRoot::retrieve($incident->id)
            ->returnInvestigation()
            ->persist();

        return back();
    }

    /**
     * @throws AuthorizationException
     */
    public function returnRCA(Incident $incident): RedirectResponse
    {
        $this->authorize('performAdminActions', Incident::class);

        IncidentAggregateRoot::retrieve($incident->id)
            ->returnRCA()
            ->persist();

        return back();
    }

    /**
     * @throws AuthorizationException
     * @throws UserNotSupervisorException
     */
    public function assignSupervisor(Request $request, Incident $incident): RedirectResponse
    {
        $this->authorize('performAdminActions', Incident::class);

        $form = $request->validate([
            'supervisor_id' => 'required|exists:users,id',
        ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->assignSupervisor($form['supervisor_id'])
            ->persist();

        return back();
    }

    /**
     * @throws AuthorizationException
     */
    public function unassignSupervisor(Incident $incident): RedirectResponse
    {
        $this->authorize('performAdminActions', Incident::class);

        IncidentAggregateRoot::retrieve($incident->id)
            ->unassignSupervisor()
            ->persist();

        return back();
    }

    /**
     * @throws AuthorizationException
     */
    public function closeIncident(Incident $incident): RedirectResponse
    {
        $this->authorize('performAdminActions', Incident::class);

        IncidentAggregateRoot::retrieve($incident->id)
            ->closeIncident()
            ->persist();

        return back();

    }

    /**
     * @throws AuthorizationException
     */
    public function reopenIncident(Incident $incident): RedirectResponse
    {
        $this->authorize('performAdminActions', Incident::class);

        IncidentAggregateRoot::retrieve($incident->id)
            ->reopenIncident()
            ->persist();

        return back();

    }
}
