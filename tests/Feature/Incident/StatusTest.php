<?php

namespace Tests\Feature\Incident;

use App\Enum\CommentType;
use App\Models\Incident;
use App\Models\Investigation;
use App\Models\RootCauseAnalysis;
use App\Models\User;
use App\Notifications\Incident\IncidentReviewRequest;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\InReview;
use App\States\IncidentStatus\Reopened;
use App\States\IncidentStatus\Returned;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class StatusTest extends TestCase
{
    public function test_supervisor_forbidden_to_request_review_if_not_assigned_to_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'status' => Assigned::class
        ]);

        $investigation = Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $rca = RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $response = $this->patch(route('incidents.request-review', ['incident' => $incident]));

        $response->assertForbidden();
    }

    public function test_supervisor_forbidden_to_request_review_if_not_assigned_state()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
        ]);

        $investigation = Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $rca = RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $response = $this->patch(route('incidents.request-review', ['incident' => $incident]));

        $response->assertForbidden();
    }

    public function test_supervisor_forbidden_to_request_review_if_latest_investigation_and_root_cause_analyses_not_his()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $investigation = Investigation::factory()->create([
            'incident_id' => $incident->id,
        ]);

        $rca = RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
        ]);

        $response = $this->patch(route('incidents.request-review', ['incident' => $incident]));

        $response->assertForbidden();
    }

    public function test_supervisor_forbidden_to_request_review_if_latest_root_cause_analyses_not_his()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $investigation = Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $rca = RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
        ]);

        $response = $this->patch(route('incidents.request-review', ['incident' => $incident]));

        $response->assertForbidden();
    }

    public function test_supervisor_forbidden_to_request_review_if_latest_investigation_not_his()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $investigation = Investigation::factory()->create([
            'incident_id' => $incident->id,
        ]);

        $rca = RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $response = $this->patch(route('incidents.request-review', ['incident' => $incident]));

        $response->assertForbidden();
    }

    public function test_supervisor_forbidden_to_request_review_if_no_investigations_and_no_root_cause_analyses()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $response = $this->patch(route('incidents.request-review', ['incident' => $incident]));

        $response->assertForbidden();
    }

    public function test_supervisor_forbidden_to_request_review_if_no_root_cause_analyses()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $investigation = Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $response = $this->patch(route('incidents.request-review', ['incident' => $incident]));

        $response->assertForbidden();
    }

    public function test_supervisor_forbidden_to_request_review_if_no_investigations()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $rca = RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $response = $this->patch(route('incidents.request-review', ['incident' => $incident]));

        $response->assertForbidden();
    }

    public function test_user_forbidden_to_request_review()
    {
        $user = User::factory()->create()->syncRoles('user');

        $this->actingAs($user);

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $investigation = Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $rca = RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $response = $this->patch(route('incidents.request-review', ['incident' => $incident]));

        $response->assertForbidden();
    }

    public function test_admin_forbidden_to_request_review()
    {
        $admin = User::factory()->create()->syncRoles('admin');

        $this->actingAs($admin);

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $investigation = Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $rca = RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $response = $this->patch(route('incidents.request-review', ['incident' => $incident]));

        $response->assertForbidden();
    }

    public function test_request_review_stores_request_notification_in_database()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $investigation = Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $rca = RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        Notification::assertNothingSent();

        $response = $this->patch(route('incidents.request-review', ['incident' => $incident]));

        $incident->refresh();

        Notification::assertCount(3);

        Notification::assertSentTo(
            $admins,
            function (IncidentReviewRequest $notification, array $channels) use ($incident, $admins, $supervisor) {
                $databaseStore = $notification->toArray($admins->first());

                $this->assertEquals(route('incidents.show', $incident->id), $databaseStore['url']);

                return array_key_exists('message', $databaseStore);
            }
        );
    }

    public function test_request_review_sends_request_notification_to_admin()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $investigation = Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $rca = RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        Notification::assertNothingSent();

        $response = $this->patch(route('incidents.request-review', ['incident' => $incident]));

        Notification::assertCount(3);

        Notification::assertSentTo($admins, IncidentReviewRequest::class);

        Notification::assertSentTo(
            $admins,
            function (IncidentReviewRequest $notification, array $channels) use ($incident, $supervisor) {
                return $notification->incidentId === $incident->id && $notification->supervisor->id === $supervisor->id;
            }
        );
    }

    public function test_request_review_adds_review_requested_comment()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $investigation = Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $rca = RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $response = $this->patch(route('incidents.request-review', ['incident' => $incident]));

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('review', $comment->content);
        $this->assertStringContainsStringIgnoringCase('requested', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
    }

    public function test_request_review_transitions_incident_from_assigned_to_in_review()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $investigation = Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $rca = RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $response = $this->patch(route('incidents.request-review', ['incident' => $incident]));

        $incident->refresh();

        $this->assertEquals(InReview::class, $incident->status::class);
    }

    public function test_adds_returned_comment()
    {
        $admin = User::factory()->create()->syncRoles('admin');

        $this->actingAs($admin);

        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $response = $this->patch(route('incidents.return-investigation', ['incident' => $incident]));

        $response->assertRedirect();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('returned', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
        $this->assertEquals($admin->id, $comment->user_id);
    }

    public function test_admin_can_return_incidents()
    {
        $admin = User::factory()->create()->syncRoles('admin');

        $this->actingAs($admin);

        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $response = $this->patch(route('incidents.return-investigation', ['incident' => $incident]));

        $response->assertStatus(302);

        $incident->refresh();

        $this->assertEquals(Returned::class, $incident->status::class);
    }

    public function test_user_can_not_return_incidents()
    {
        $user = User::factory()->create()->syncRoles('user');

        $this->actingAs($user);

        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $response = $this->patch(route('incidents.return-investigation', ['incident' => $incident]));

        $response->assertStatus(403);

        $incident->refresh();

        $this->assertEquals(InReview::class, $incident->status::class);
    }

    public function test_supervisor_can_not_return_incidents()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $response = $this->patch(route('incidents.return-investigation', ['incident' => $incident]));

        $response->assertStatus(403);

        $this->assertEquals(InReview::class, $incident->status::class);
    }

    public function test_adds_reopened_comment()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($admin);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        $response = $this->patch(route('incidents.reopen', ['incident' => $incident]));

        $response->assertRedirect();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('reopened', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
        $this->assertEquals($admin->id, $comment->user_id);
    }

    public function test_adds_closed_comment()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($admin);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        $response = $this->patch(route('incidents.close', ['incident' => $incident]));

        $response->assertRedirect();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('closed', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
        $this->assertEquals($admin->id, $comment->user_id);
    }

    public function test_admin_can_reopen_incidents()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($admin);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        $response = $this->patch(route('incidents.reopen', ['incident' => $incident]));

        $response->assertStatus(302);

        $incident->refresh();

        $this->assertEquals(Reopened::class, $incident->status::class);
        $this->assertNull($incident->supervisor_id);
    }

    public function test_user_can_not_reopen_incidents()
    {
        $user = User::factory()->create()->syncRoles('user');

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($user);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        $response = $this->patch(route('incidents.reopen', ['incident' => $incident]));

        $response->assertStatus(403);

        $incident->refresh();

        $this->assertEquals(Closed::class, $incident->status::class);
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }

    public function test_supervisor_can_not_reopen_incidents()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        $response = $this->patch(route('incidents.reopen', ['incident' => $incident]));

        $response->assertStatus(403);

        $this->assertEquals(Closed::class, $incident->status::class);
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }

    public function test_admin_can_close_incidents()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($admin);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        $response = $this->patch(route('incidents.close', ['incident' => $incident]));

        $response->assertStatus(302);

        $incident->refresh();

        $this->assertEquals(Closed::class, $incident->status::class);
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }

    public function test_user_can_not_close_incidents()
    {
        $user = User::factory()->create()->syncRoles('user');

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($user);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        $response = $this->patch(route('incidents.close', ['incident' => $incident]));

        $response->assertStatus(403);

        $incident->refresh();

        $this->assertEquals(InReview::class, $incident->status::class);
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }

    public function test_supervisor_can_not_close_incidents()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        $response = $this->patch(route('incidents.close', ['incident' => $incident]));

        $response->assertStatus(403);

        $this->assertEquals(InReview::class, $incident->status::class);
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }
}
