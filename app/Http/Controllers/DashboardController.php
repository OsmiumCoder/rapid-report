<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Closed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $incidents = Incident::latest()->where('reporters_email', $user->email)->take(5)->get();
        $incidentCount = Incident::where('reporters_email', $user->email)->count();
        $closedCount = Incident::whereState('status', Closed::class)->where('reporters_email', $user->email)->count();
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
        $closedCount = Incident::whereState('status', Closed::class)->count();
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

        $unresolvedIncidents = Incident::latest()
            ->where('supervisor_id', $user->id)
            ->whereState('status', Assigned::class)
            ->take(5)
            ->get();

        $incidentCount = Incident::where('supervisor_id', $user->id)->count();

        $closedCount = Incident::whereState('status', Closed::class)
            ->where('supervisor_id', $user->id)
            ->count();

        $unresolvedCount = $incidentCount - $closedCount;

        return inertia('Dashboard/SupervisorOverview', [
            'unresolvedIncidents' => $unresolvedIncidents,
            'incidentCount' => $incidentCount,
            'closedCount' => $closedCount,
            'unresolvedCount' => $unresolvedCount,
        ]);
    }

    public function userManagement(Request $request)
    {
        Gate::authorize('view-user-management');

        $search = $request->string('search', '');

        $paginatedUsers = User::whereNot('id', auth()->user()->id)
            ->where(function ($query) use ($search) {
                $query->whereLike('name', "%$search%")
                    ->orWhereLike('email', "%$search%");
            })
            ->orderBy('name')
            ->paginate()
            ->appends($request->query());

        return inertia('Dashboard/UserManagement', [
            'users' => $paginatedUsers,
            'roles' => Role::all()
        ]);
    }
}
