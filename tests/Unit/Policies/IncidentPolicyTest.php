<?php

namespace Tests\Unit\Policies;

use App\Models\Incident;
use App\Models\Investigation;
use App\Models\RootCauseAnalysis;
use App\Models\User;
use App\Policies\IncidentPolicy;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\InReview;
use App\States\IncidentStatus\Opened;
use App\States\IncidentStatus\Reopened;
use App\States\IncidentStatus\Returned;
use Tests\TestCase;

class IncidentPolicyTest extends TestCase
{
    public function test_user_can_not_provide_follow_up_on_assigned_incident()
    {
        $user = User::factory()->create()->syncRoles('user');
        $incident = Incident::factory()->create([
            'supervisor_id' => $user->id,
            'status' => Assigned::class
        ]);

        $result = $this->getPolicy()->provideFollowUp($user, $incident);

        $this->assertFalse($result);
    }

    public function test_user_can_not_provide_follow_up_on_returned_incident()
    {
        $user = User::factory()->create()->syncRoles('user');
        $incident = Incident::factory()->create([
            'supervisor_id' => $user->id,
            'status' => Returned::class
        ]);

        $result = $this->getPolicy()->provideFollowUp($user, $incident);

        $this->assertFalse($result);
    }

    public function test_admin_can_not_provide_follow_up_on_assigned_incident()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $incident = Incident::factory()->create([
            'supervisor_id' => $admin->id,
            'status' => Assigned::class
        ]);

        $result = $this->getPolicy()->provideFollowUp($admin, $incident);

        $this->assertFalse($result);
    }

    public function test_admin_can_not_provide_follow_up_on_returned_incident()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $incident = Incident::factory()->create([
            'supervisor_id' => $admin->id,
            'status' => Returned::class
        ]);

        $result = $this->getPolicy()->provideFollowUp($admin, $incident);

        $this->assertFalse($result);
    }

    public function test_supervisor_can_not_provide_follow_up_on_closed_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class
        ]);

        $result = $this->getPolicy()->provideFollowUp($supervisor, $incident);

        $this->assertFalse($result);
    }

    public function test_supervisor_can_not_provide_follow_up_on_reopened_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Reopened::class
        ]);

        $result = $this->getPolicy()->provideFollowUp($supervisor, $incident);

        $this->assertFalse($result);
    }

    public function test_supervisor_can_not_provide_follow_up_on_in_review_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class
        ]);

        $result = $this->getPolicy()->provideFollowUp($supervisor, $incident);

        $this->assertFalse($result);
    }

    public function test_supervisor_can_not_provide_follow_up_on_open_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Opened::class
        ]);

        $result = $this->getPolicy()->provideFollowUp($supervisor, $incident);

        $this->assertFalse($result);
    }

    public function test_supervisor_can_provide_follow_up_on_returned_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Returned::class
        ]);

        $result = $this->getPolicy()->provideFollowUp($supervisor, $incident);

        $this->assertTrue($result);
    }

    public function test_supervisor_can_provide_follow_up_on_assigned_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $result = $this->getPolicy()->provideFollowUp($supervisor, $incident);

        $this->assertTrue($result);
    }

    public function test_supervisor_can_request_review()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $result = $this->getPolicy()->requestReview($supervisor, $incident);

        $this->assertTrue($result);
    }

    public function test_supervisor_cant_request_review_if_not_assigned_to_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'status' => Assigned::class
        ]);

        Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $result = $this->getPolicy()->requestReview($supervisor, $incident);

        $this->assertFalse($result);
    }

    public function test_supervisor_cant_request_review_if_not_assigned_state()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
        ]);

        Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $result = $this->getPolicy()->requestReview($supervisor, $incident);

        $this->assertFalse($result);
    }

    public function test_supervisor_cant_request_review_if_latest_investigation_and_root_cause_analyses_not_his()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        Investigation::factory()->create([
            'incident_id' => $incident->id,
        ]);

        RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
        ]);

        $result = $this->getPolicy()->requestReview($supervisor, $incident);

        $this->assertFalse($result);
    }

    public function test_supervisor_cant_request_review_if_latest_root_cause_analyses_not_his()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
        ]);

        $result = $this->getPolicy()->requestReview($supervisor, $incident);

        $this->assertFalse($result);
    }

    public function test_supervisor_cant_request_review_if_latest_investigation_not_his()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        Investigation::factory()->create([
            'incident_id' => $incident->id,
        ]);

        RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $result = $this->getPolicy()->requestReview($supervisor, $incident);

        $this->assertFalse($result);
    }

    public function test_supervisor_cant_request_review_if_no_investigations_and_no_root_cause_analyses()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $result = $this->getPolicy()->requestReview($supervisor, $incident);

        $this->assertFalse($result);
    }

    public function test_supervisor_cant_request_review_if_no_root_cause_analyses()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $result = $this->getPolicy()->requestReview($supervisor, $incident);

        $this->assertFalse($result);
    }

    public function test_supervisor_cant_request_review_if_no_investigations()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $result = $this->getPolicy()->requestReview($supervisor, $incident);

        $this->assertFalse($result);
    }

    public function test_admin_cant_request_review()
    {
        $admin = User::factory()->create()->syncRoles('admin');

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $result = $this->getPolicy()->requestReview($admin, $incident);

        $this->assertFalse($result);
    }

    public function test_user_cant_request_review()
    {
        $user = User::factory()->create()->syncRoles('user');

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $result = $this->getPolicy()->requestReview($user, $incident);

        $this->assertFalse($result);
    }

    public function test_admin_can_search_for_all_incidents()
    {
        $admin = User::factory()->create()->syncRoles('admin');

        $queryBuilder = Incident::search('searchValue');

        $result = $this->getPolicy()->searchIncidents($admin, $queryBuilder);
        $this->assertTrue($result);
    }

    public function test_supervisor_can_search_for_assigned_incidents()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $queryBuilder = Incident::search('searchValue');

        $result = $this->getPolicy()->searchIncidents($supervisor, $queryBuilder);
        $this->assertTrue($result);
    }

    public function test_user_can_not_search_for_incidents()
    {
        $user = User::factory()->create()->syncRoles('user');
        $queryBuilder = Incident::search('searchValue');

        $result = $this->getPolicy()->searchIncidents($user, $queryBuilder);
        $this->assertFalse($result);
    }

    public function test_supervisor_can_add_comment_on_incident_they_own_but_arent_assigned()
    {
        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@b.com',
        ])->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'reporters_email' => $user->email,
        ]);

        $result = $this->getPolicy()->addComment($user, $incident);
        $this->assertTrue($result);
    }

    public function test_user_cant_add_comment_on_incident_they_dont_own()
    {
        $incident = Incident::factory()->create([
            'reporters_email' => 'reporters@example.com',
        ]);

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@b.com',
        ])->syncRoles('user');

        $result = $this->getPolicy()->addComment($user, $incident);
        $this->assertFalse($result);
    }

    public function test_user_can_comment_on_own_incident()
    {
        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@b.com',
        ])->syncRoles('user');

        $incident = Incident::factory()->create([
            'reporters_email' => $user->email,
        ]);

        $result = $this->getPolicy()->addComment($user, $incident);
        $this->assertTrue($result);
    }

    public function test_supervisor_cant_comment_on_incident_not_assigned_to_them()
    {
        $incident = Incident::factory()->create();

        $user = User::factory()->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@b.com',
        ])->syncRoles('supervisor');

        $result = $this->getPolicy()->addComment($user, $incident);
        $this->assertFalse($result);
    }

    public function test_supervisor_can_comment_on_assigned_incident()
    {
        $user = User::factory()->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@b.com',
        ])->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $user->id,
        ]);

        $result = $this->getPolicy()->addComment($user, $incident);
        $this->assertTrue($result);
    }

    public function test_admin_can_comment_on_any_incident()
    {
        $incident = Incident::factory()->create();

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->syncRoles('admin');

        $result = $this->getPolicy()->addComment($user, $incident);
        $this->assertTrue($result);
    }

    public function test_admin_can_perform_admin_actions_on_incidents()
    {
        $admin = User::factory()->create()->syncRoles('admin');

        $this->assertTrue($this->getPolicy()->performAdminActions($admin));
    }

    public function test_supervisor_can_not_perform_admin_actions_on_incidents()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->assertFalse($this->getPolicy()->performAdminActions($supervisor));
    }

    public function test_user_can_not_perform_admin_actions_on_incidents()
    {
        $user = User::factory()->create()->syncRoles('user');

        $this->assertFalse($this->getPolicy()->performAdminActions($user));
    }

    public function test_user_can_view_all_their_incidents()
    {
        $user = User::factory()->create()->syncRoles('user');

        $this->assertTrue($this->getPolicy()->viewAnyOwned($user));
    }

    public function test_user_cant_view_any_assigned_incident()
    {
        $user = User::factory()->create()->syncRoles('user');

        $this->assertFalse($this->getPolicy()->viewAnyAssigned($user));
    }

    public function test_supervisor_can_view_any_assigned_incident()
    {
        $user = User::factory()->create()->syncRoles('supervisor');

        $this->assertTrue($this->getPolicy()->viewAnyAssigned($user));
    }

    public function test_supervisor_can_view_incident_they_own_but_arent_assigned()
    {
        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@b.com',
        ])->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'reporters_email' => $user->email,
        ]);

        $result = $this->getPolicy()->view($user, $incident);
        $this->assertTrue($result);
    }

    public function test_user_cant_view_incident_they_dont_own()
    {
        $incident = Incident::factory()->create([
            'reporters_email' => 'reporters@example.com',
        ]);

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@b.com',
        ])->syncRoles('user');

        $result = $this->getPolicy()->view($user, $incident);
        $this->assertFalse($result);
    }

    public function test_user_can_view_own_incident()
    {
        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@b.com',
        ])->syncRoles('user');

        $incident = Incident::factory()->create([
            'reporters_email' => $user->email,
        ]);

        $result = $this->getPolicy()->view($user, $incident);
        $this->assertTrue($result);
    }

    public function test_supervisor_cant_view_incident_not_assigned_to_them()
    {
        $incident = Incident::factory()->create();

        $user = User::factory()->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@b.com',
        ])->syncRoles('supervisor');

        $result = $this->getPolicy()->view($user, $incident);
        $this->assertFalse($result);
    }

    public function test_supervisor_can_view_assigned_incident()
    {
        $user = User::factory()->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@b.com',
        ])->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $user->id,
        ]);

        $result = $this->getPolicy()->view($user, $incident);
        $this->assertTrue($result);
    }

    public function test_admin_can_view_any_single_incident()
    {
        $incident = Incident::factory()->create();

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->syncRoles('admin');

        $result = $this->getPolicy()->view($user, $incident);
        $this->assertTrue($result);
    }

    public function test_user_cant_view_all_incidents()
    {
        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@b.com',
        ])->syncRoles('user');

        $result = $this->getPolicy()->viewAny($user);
        $this->assertFalse($result);
    }

    public function test_supervisor_cant_view_all_incidents()
    {
        $user = User::factory()->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@b.com',
        ])->syncRoles('supervisor');

        $result = $this->getPolicy()->viewAny($user);
        $this->assertFalse($result);
    }

    public function test_admin_can_view_all_incidents()
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->syncRoles('admin');

        $result = $this->getPolicy()->viewAny($user);
        $this->assertTrue($result);
    }

    protected function getPolicy()
    {
        return app(IncidentPolicy::class);
    }
}
