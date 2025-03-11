<?php

namespace App\Http\Controllers\Report;

use App\Enum\IncidentType;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): Response
    {
        Gate::authorize('view-report-page');

        return Inertia::render('Report/Index');
    }

    /**
     * @throws AuthorizationException
     */
    public function stats(): Response
    {
        Gate::authorize('view-report-page');

        $closeTimes = Incident::selectRaw("DATEDIFF(closed_at, created_at) as diff")
            ->whereNotNull('closed_at')->pluck('diff')->toArray();

        $closedCounts = array_count_values(array_map(function ($value) {
            if ($value < 1) {
                return 'Less then 1 day';
            }
            if ($value < 7) {
                return 'Between 1 day and a Week';
            }
            if ($value < 31) {
                return 'Between 1 week and a Month';
            }
            return 'Over a month';
        }, $closeTimes));

        return Inertia::render('Report/Stats', [
            'locationCount' => Incident::selectRaw('location, count(location) as total')
                ->groupBy('location')
                ->pluck('total', 'location'),
            'closedTimeCount' => $closedCounts,
            'typeCount' => Incident::selectRaw('incident_type, count(incident_type) as total')
                ->groupBy('incident_type')
                ->pluck('total', 'incident_type'),
            'roleCount' => Incident::selectRaw('role, count(role) as total')
                ->groupBy('role')
                ->pluck('total', 'role'),
            'statusCount' => Incident::selectRaw('status, count(status) as total')
                ->groupBy('status')
                ->pluck('total', 'status'),
            'anonymousCount' => Incident::selectRaw('anonymous, count(anonymous) as total')
                ->groupBy('anonymous')
                ->pluck('total', 'anonymous'),
            'descriptorCount' => Incident::selectRaw('descriptor, count(descriptor) as total')
                ->groupBy('descriptor')
                ->pluck('total', 'descriptor'),
            'safetyCount' => Incident::selectRaw('descriptor, count(descriptor) as total')
                ->where('incident_type', IncidentType::SAFETY)
                ->groupBy('descriptor')
                ->pluck('total', 'descriptor'),
            'environmentalCount' => Incident::selectRaw('descriptor, count(descriptor) as total')
                ->where('incident_type', IncidentType::ENVIRONMENTAL)
                ->groupBy('descriptor')
                ->pluck('total', 'descriptor'),
            'securityCount' => Incident::selectRaw('descriptor, count(descriptor) as total')
                ->where('incident_type', IncidentType::SECURITY)
                ->groupBy('descriptor')
                ->pluck('total', 'descriptor'),
            'onBehalfCount' => Incident::selectRaw('on_behalf, count(on_behalf) as total')
                ->groupBy('on_behalf')
                ->pluck('total', 'on_behalf'),
            'onBehalfAnonymousCount' => Incident::selectRaw('on_behalf_anonymous, count(on_behalf_anonymous) as total')
                ->groupBy('on_behalf_anonymous')
                ->pluck('total', 'on_behalf_anonymous'),

        ]);
    }
}
