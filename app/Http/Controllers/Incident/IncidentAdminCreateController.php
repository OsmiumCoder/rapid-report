<?php

namespace App\Http\Controllers\Incident;

use App\Data\IncidentData;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use Inertia\Inertia;
use Inertia\Response;

class IncidentAdminCreateController extends Controller
{
    public function __invoke(): Response
    {
        $this->authorize('viewAdminCreateForm', Incident::class);
        return Inertia::render('Incident/AdminCreate', [
            'incidentData' => IncidentData::empty(),
        ]);
    }
}
