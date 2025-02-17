<?php

namespace Policies;

use App\Models\Incident;
use App\Models\Investigation;
use App\Models\User;
use App\Policies\InvestigationPolicy;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\InReview;
use Tests\TestCase;

class InvestigationPolicyTest extends TestCase
{
    public function test_supervisor_can_not_create_if_not_assigned_state()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class
        ]);

        $this->assertFalse($this->getPolicy()->create($supervisor, $incident));
    }

    public function test_supervisor_can_create_if_assigned_state()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $this->assertTrue($this->getPolicy()->create($supervisor, $incident));
    }

    public function test_admin_can_view_any_investigation()
    {
        $admin = User::factory()->create()->syncRoles('admin');

        $investigation = Investigation::factory()->create();

        $this->assertTrue($this->getPolicy()->view($admin, $investigation));
    }

    public function test_supervisor_can_view_investigation_they_made()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $investigation = Investigation::factory()->create(['supervisor_id' => $supervisor->id]);

        $this->assertTrue($this->getPolicy()->view($supervisor, $investigation));
    }

    public function test_supervisor_can_not_view_investigation_they_did_not_make()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $investigation = Investigation::factory()->create();

        $this->assertFalse($this->getPolicy()->view($supervisor, $investigation));
    }

    public function test_user_can_not_view_investigations()
    {
        $user = User::factory()->create()->syncRoles('user');

        $investigation = Investigation::factory()->create();

        $this->assertFalse($this->getPolicy()->view($user, $investigation));
    }


    public function test_admin_can_not_create_investigation()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $incident = Incident::factory()->create();

        $this->assertFalse($this->getPolicy()->create($admin, $incident));
    }

    public function test_supervisor_can_create_investigation_if_currently_assigned()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $this->assertTrue($this->getPolicy()->create($supervisor, $incident));
    }

    public function test_supervisor_can_not_create_investigation_if_not_currently_assigned()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create();

        $this->assertFalse($this->getPolicy()->create($supervisor, $incident));
    }

    public function test_user_can_not_create_investigation()
    {
        $user = User::factory()->create()->syncRoles('user');
        $incident = Incident::factory()->create();

        $this->assertFalse($this->getPolicy()->create($user, $incident));
    }

    protected function getPolicy()
    {
        return app(InvestigationPolicy::class);
    }
}
