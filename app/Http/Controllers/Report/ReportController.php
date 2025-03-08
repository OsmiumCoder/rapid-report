<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index()
    {
        Gate::authorize('view-report-page');

        return Inertia::render('Report/Index');
    }

    public function stats()
    {
        Gate::authorize('view-report-page');
        $pairs = Incident::selectRaw('created_at')
            ->addSelect('closed_at')
            ->whereNotNull('closed_at')
            ->get(['created_at', 'closed_at'])
            ->toArray();
        $diffs = array_map(fn($item):false|int =>
            date_diff(date_create($item['created_at']),date_create($item['closed_at']))->days, $pairs);
        $count = array_count_values(array_reduce($diffs, function($carry, $value) {
            if ($value < 1) {
                $carry[] = 'Less then 1 day ';
            } elseif ($value >= 1 && $value < 7) {
                $carry[] = 'Between 1 day and a Week';
            } elseif ($value >= 7 && $value < 31) {
                $carry[] = 'Between 1 week and a Month';
            } elseif ($value >= 31 ) {
                $carry[] = 'Over a month';
            }
            return $carry;
        }, []));

        return Inertia::render('Report/Stats', [
            'location' => Incident::selectRaw('location ,count(location) as total')
                ->groupBy('location')
                ->pluck('total', 'location'),
            'incident_live_time_dist' => $count,
            'type_dist' => Incident::selectRaw('incident_type ,count(incident_type) as total')
                ->groupBy('incident_type')
                ->pluck('total', 'incident_type'),
            'role_dist' => Incident::selectRaw('role, count(role) as total')
                ->groupBy('role')
                ->pluck('total', 'role'),
            'status_dist' => Incident::selectRaw('status, count(status) as total')
                ->groupBy('status')
                ->pluck('total', 'status'),
            'anon_dist' => Incident::selectRaw('anonymous, count(anonymous) as total')
                ->groupBy('anonymous')
                ->pluck('total', 'anonymous'),
            'descriptor_dist' => Incident::selectRaw('descriptor, count(descriptor) as total')
                ->groupBy('descriptor')
                ->pluck('total', 'descriptor'),
            'safety_dist' => Incident::selectRaw('descriptor,count(descriptor) as total')
                ->where('incident_type', 1)
                ->groupBy('descriptor')
                ->pluck('total', 'descriptor'),
            'environmental_dist' => Incident::selectRaw('descriptor,count(descriptor) as total')
                ->where('incident_type', 2)
                ->groupBy('descriptor')
                ->pluck('total', 'descriptor'),
            'security_dist' => Incident::selectRaw('descriptor,count(descriptor) as total')
                ->where('incident_type', 3)
                ->groupBy('descriptor')
                ->pluck('total', 'descriptor'),
            'on_behalf_dist' => Incident::selectRaw('on_behalf, count(on_behalf) as total')
                ->groupBy('on_behalf')
                ->pluck('total', 'on_behalf'),
            'on_behalf_anon_dist' => Incident::selectRaw('on_behalf_anonymous, count(on_behalf_anonymous) as total')
                ->groupBy('on_behalf_anonymous')
                ->pluck('total', 'on_behalf_anonymous'),

        ]);
    }
}
