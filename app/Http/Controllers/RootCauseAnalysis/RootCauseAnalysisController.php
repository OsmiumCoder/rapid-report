<?php

namespace App\Http\Controllers\RootCauseAnalysis;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\RootCauseAnalysis;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RootCauseAnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Incident $incident)
    {
        $this->authorize('create', [RootCauseAnalysis::class, $incident]);
        return Inertia::render('RootCauseAnalysis/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RootCauseAnalysis $rootCauseAnalysis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RootCauseAnalysis $rootCauseAnalysis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RootCauseAnalysis $rootCauseAnalysis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RootCauseAnalysis $rootCauseAnalysis)
    {
        //
    }
}
