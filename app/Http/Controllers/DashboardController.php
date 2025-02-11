<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\States\IncidentStatus\Closed;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $incidents = Incident::latest()->where('reporters_email', $user->email)->take(5)->get();
        $incidentCount = Incident::where('reporters_email', $user->email)->count();
        $closedCount = Incident::where('status', Closed::$name)->where('reporters_email', $user->email)->count();
        $unresolvedCount = $incidentCount - $closedCount;

        return inertia('Dashboard/UserDashboard', [
            'incidents' => $incidents,
            'incidentCount' => $incidentCount,
            'unresolvedCount' => $unresolvedCount,
        ]);
    }
    public function adminOverview()
    {
        Gate::authorize('view-admin-overview');

        $incidents = Incident::latest()->take(5)->get();
        $incidentCount = Incident::count();
        $closedCount = Incident::where('status', Closed::$name)->count();
        $unresolvedCount = $incidentCount - $closedCount;

        return inertia('Dashboard/AdminOverview', [
            'incidents' => $incidents,
            'incidentCount' => $incidentCount,
            'closedCount' => $closedCount,
            'unresolvedCount' => $unresolvedCount,
        ]);
    }

    public function supervisorOverview()
    {
        Gate::authorize('view-supervisor-overview');

        $user = auth()->user();

        $unresolvedIncidents = Incident::latest()->where('supervisor_id', $user->id)->whereNot('status', Closed::$name)->take(5)->get();
        $incidentCount = Incident::where('supervisor_id', $user->id)->count();
        $closedCount = Incident::where('status', Closed::$name)->where('supervisor_id', $user->id)->count();
        $unresolvedCount = $incidentCount - $closedCount;

        return inertia('Dashboard/SupervisorOverview', [
            'unresolvedIncidents' => $unresolvedIncidents,
            'incidentCount' => $incidentCount,
            'closedCount' => $closedCount,
            'unresolvedCount' => $unresolvedCount,
        ]);
    }

    public function userManagement()
    {
        Gate::authorize('view-user-management');

        return inertia('Dashboard/UserManagement');
    }
}
