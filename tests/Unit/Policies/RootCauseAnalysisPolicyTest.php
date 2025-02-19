<?php

namespace Tests\Unit\Policies;

use App\Models\RootCauseAnalysis;
use App\Models\User;
use App\Models\Incident;
use App\Policies\RootCauseAnalysisPolicy;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\InReview;
use Tests\TestCase;

class RootCauseAnalysisPolicyTest extends TestCase
{
    public function test_admin_can_view_any_rca()
    {
        $admin = User::factory()->create()->syncRoles('admin');

        $rca = RootCauseAnalysis::factory()->create();

        $this->assertTrue($this->getPolicy()->view($admin, $rca));
    }

    public function test_supervisor_can_view_rca_they_made()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $rca = RootCauseAnalysis::factory()->create(['supervisor_id' => $supervisor->id]);

        $this->assertTrue($this->getPolicy()->view($supervisor, $rca));
    }

    public function test_supervisor_can_not_view_rca_they_did_not_make()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $rca = RootCauseAnalysis::factory()->create();

        $this->assertFalse($this->getPolicy()->view($supervisor, $rca));
    }

    public function test_user_can_not_view_rca()
    {
        $user = User::factory()->create()->syncRoles('user');

        $rca = RootCauseAnalysis::factory()->create();

        $this->assertFalse($this->getPolicy()->view($user, $rca));
    }

    public function test_supervisor_can_not_create_rca_if_assigned_to_someone_else()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $supervisorA = User::factory()->create()->assignRole('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisorA->id,
            'status' => Assigned::class
        ]);

        $this->assertFalse($this->getPolicy()->create($supervisor, $incident));
    }

    public function test_supervisor_can_not_create_rca_if_not_assigned_state()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class
        ]);

        $this->assertFalse($this->getPolicy()->create($supervisor, $incident));
    }

    public function test_supervisor_can_create_rca_if_assigned_state()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $this->assertTrue($this->getPolicy()->create($supervisor, $incident));
    }

    public function test_user_can_not_create_rca()
    {
        $user = User::factory()->create()->assignRole('user');

        $incident = Incident::factory()->create([
            'supervisor_id' => $user->id,
            'status' => Assigned::class
        ]);

        $this->assertFalse($this->getPolicy()->create($user, $incident));
    }

    public function test_admin_can_not_create_rca()
    {
        $admin = User::factory()->create()->assignRole('admin');

        $incident = Incident::factory()->create([
            'supervisor_id' => $admin->id,
            'status' => Assigned::class
        ]);

        $this->assertFalse($this->getPolicy()->create($admin, $incident));
    }

    protected function getPolicy()
    {
        return app(RootCauseAnalysisPolicy::class);
    }
}
