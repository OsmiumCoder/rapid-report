<?php

namespace App\Http\Controllers\Investigation;

use App\Data\InvestigationData;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Investigation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvestigationController extends Controller
{
    /**
     * Show the form for creating a new investigation.
     */
    public function create(Incident $incident)
    {
        $this->authorize('create', Investigation::class);

        return Inertia::render('Investigation/Create', [
            'form' => InvestigationData::empty()
        ]);
    }

    /**
     * Store a newly created investigation in storage.
     */
    public function store(InvestigationData $investigationData)
    {

    }

    /**
     * Display the specified investigation.
     */
    public function show(Investigation $investigation)
    {
        //
    }

    /**
     * Show the form for editing the specified investigation.
     */
    public function edit(Investigation $investigation)
    {
        //
    }

    /**
     * Update the specified investigation in storage.
     */
    public function update(Request $request, Investigation $investigation)
    {
        //
    }

    /**
     * Remove the specified investigation from storage.
     */
    public function destroy(Investigation $investigation)
    {
        //
    }
}
