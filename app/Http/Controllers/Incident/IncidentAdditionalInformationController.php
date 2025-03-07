<?php

namespace App\Http\Controllers\Incident;

use App\Aggregates\IncidentAggregateRoot;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class IncidentAdditionalInformationController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Incident $incident): RedirectResponse
    {
        $this->authorize('addAdditionalInformation', [Incident::class, $incident]);

        $validated = $request->validate([
            'additional_information' => ['required', 'string', 'min:1'],
        ]);
        IncidentAggregateRoot::retrieve($incident->id)
            ->addAdditionalInformation($validated['additional_information'])
            ->persist();

        return back();
    }
}
