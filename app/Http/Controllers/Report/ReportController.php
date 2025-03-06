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
        $witnesses = Incident::selectRaw('witnesses')
            ->pluck('witnesses')
            ->toArray();
        $witness_count = [];
        foreach ($witnesses as $witness) {
            $witness_count[] = count($witness);

        }
        return Inertia::render('Report/Stats', [
            'type_dist' => Incident::selectRaw('incident_type ,count(incident_type) as total')
                ->groupBy('incident_type')
                ->pluck('total', 'incident_type'),
            'witnesses_dist' => array_count_values($witness_count),
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
