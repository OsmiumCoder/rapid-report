<?php

namespace Investigation;

use App\Data\InvestigationData;
use App\Enum\CommentType;
use App\Models\Incident;
use App\Models\Investigation;
use App\Models\User;
use App\Notifications\Investigation\InvestigationSubmitted;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\InReview;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_incident_transitions_from_assigned_to_in_review()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class, 'supervisor_id' => $supervisor->id]);

        $investigationData = InvestigationData::from([
            'immediate_causes' => "immediate causes",
            'basic_causes' => 'basic causes',
            'remedial_actions' => "remedial actions",
            'prevention' => 'prevention',
            'hazard_class' => 'hazard class',
            'risk_rank' => 10,
            'resulted_in' => ['injury', 'burn'],
            'substandard_acts' => ['injury', 'burn'],
            'substandard_conditions' => ['injury', 'burn'],
            'energy_transfer_causes' => ['injury', 'burn'],
            'personal_factors' => ['injury', 'burn'],
            'job_factors' => ['injury', 'burn'],
        ]);

        $response = $this->actingAs($supervisor)->post(route('incidents.investigations.store', $incident), $investigationData->toArray());

        $incident->refresh();

        $this->assertEquals(InReview::class, $incident->status::class);
    }

    public function test_sends_received_notification_to_admin()
    {
        Notification::fake();

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $incident = Incident::factory()->create(['status' => Assigned::class, 'supervisor_id' => $supervisor->id]);

        $investigationData = InvestigationData::from([
            'immediate_causes' => "immediate causes",
            'basic_causes' => 'basic causes',
            'remedial_actions' => "remedial actions",
            'prevention' => 'prevention',
            'hazard_class' => 'hazard class',
            'risk_rank' => 10,
            'resulted_in' => ['injury', 'burn'],
            'substandard_acts' => ['injury', 'burn'],
            'substandard_conditions' => ['injury', 'burn'],
            'energy_transfer_causes' => ['injury', 'burn'],
            'personal_factors' => ['injury', 'burn'],
            'job_factors' => ['injury', 'burn'],
        ]);

        Notification::assertNothingSent();

        $response = $this->actingAs($supervisor)->post(route('incidents.investigations.store', $incident), $investigationData->toArray());

        Notification::assertCount(3);

        Notification::assertSentTo($admins, InvestigationSubmitted::class);

        $investigation = Investigation::first();

        Notification::assertSentTo(
            $admins,
            function (InvestigationSubmitted $notification, array $channels) use ($investigation, $supervisor) {
                return $notification->investigationId === $investigation->id && $notification->supervisor->id === $supervisor->id;
            }
        );
    }

    public function test_adds_created_investigation_comment_on_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class, 'supervisor_id' => $supervisor->id]);

        $investigationData = InvestigationData::from([
            'immediate_causes' => "immediate causes",
            'basic_causes' => 'basic causes',
            'remedial_actions' => "remedial actions",
            'prevention' => 'prevention',
            'hazard_class' => 'hazard class',
            'risk_rank' => 10,
            'resulted_in' => ['injury', 'burn'],
            'substandard_acts' => ['injury', 'burn'],
            'substandard_conditions' => ['injury', 'burn'],
            'energy_transfer_causes' => ['injury', 'burn'],
            'personal_factors' => ['injury', 'burn'],
            'job_factors' => ['injury', 'burn'],
        ]);

        $response = $this->actingAs($supervisor)->post(route('incidents.investigations.store', $incident), $investigationData->toArray());

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('created', $comment->content);
        $this->assertStringContainsStringIgnoringCase('investigation', $comment->content);

    }

    public function test_redirects_to_show_page()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class, 'supervisor_id' => $supervisor->id]);

        $investigationData = InvestigationData::from([
            'immediate_causes' => "immediate causes",
            'basic_causes' => 'basic causes',
            'remedial_actions' => "remedial actions",
            'prevention' => 'prevention',
            'hazard_class' => 'hazard class',
            'risk_rank' => 10,
            'resulted_in' => ['injury', 'burn'],
            'substandard_acts' => ['injury', 'burn'],
            'substandard_conditions' => ['injury', 'burn'],
            'energy_transfer_causes' => ['injury', 'burn'],
            'personal_factors' => ['injury', 'burn'],
            'job_factors' => ['injury', 'burn'],
        ]);

        $response = $this->actingAs($supervisor)->post(route('incidents.investigations.store', $incident), $investigationData->toArray());

        $investigation = Investigation::first();

        $response->assertRedirectToRoute('incidents.investigations.show', ['incident' => $incident->id, 'investigation' => $investigation->id]);
    }

    public function test_throws_validation_error_for_bad_data()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class, 'supervisor_id' => $supervisor->id]);

        $investigationData = [
            'immediate_causes' => "",
            'basic_causes' => '',
            'remedial_actions' => "",
            'prevention' => '',
            'hazard_class' => '',
            'risk_rank' => 10,
            'resulted_in' => [],
            'substandard_acts' => [],
            'substandard_conditions' => [],
            'energy_transfer_causes' => [],
            'personal_factors' => [],
            'job_factors' => [],
        ];

        $response = $this->actingAs($supervisor)->post(route('incidents.investigations.store', $incident), $investigationData);

        $this->assertInstanceOf(ValidationException::class, $response->exception);

        $response->assertInvalid([
            'immediate_causes',
            'basic_causes',
            'remedial_actions',
            'prevention',
            'hazard_class',
            'resulted_in',
            'substandard_acts',
            'substandard_conditions',
            'energy_transfer_causes',
            'personal_factors',
            'job_factors',
        ]);
    }

    public function test_user_forbidden_to_create_investigation()
    {
        $user = User::factory()->create()->syncRoles('user');

        $incident = Incident::factory()->create();

        $investigationData = InvestigationData::from([
            'immediate_causes' => "immediate causes",
            'basic_causes' => 'basic causes',
            'remedial_actions' => "remedial actions",
            'prevention' => 'prevention',
            'hazard_class' => 'hazard class',
            'risk_rank' => 10,
            'resulted_in' => ['injury', 'burn'],
            'substandard_acts' => ['injury', 'burn'],
            'substandard_conditions' => ['injury', 'burn'],
            'energy_transfer_causes' => ['injury', 'burn'],
            'personal_factors' => ['injury', 'burn'],
            'job_factors' => ['injury', 'burn'],
        ]);

        $response = $this->actingAs($user)->post(route('incidents.investigations.store', $incident), $investigationData->toArray());

        $response->assertForbidden();
    }

    public function test_admin_forbidden_to_create_investigation()
    {
        $admin = User::factory()->create()->syncRoles('admin');

        $incident = Incident::factory()->create();

        $investigationData = InvestigationData::from([
            'immediate_causes' => "immediate causes",
            'basic_causes' => 'basic causes',
            'remedial_actions' => "remedial actions",
            'prevention' => 'prevention',
            'hazard_class' => 'hazard class',
            'risk_rank' => 10,
            'resulted_in' => ['injury', 'burn'],
            'substandard_acts' => ['injury', 'burn'],
            'substandard_conditions' => ['injury', 'burn'],
            'energy_transfer_causes' => ['injury', 'burn'],
            'personal_factors' => ['injury', 'burn'],
            'job_factors' => ['injury', 'burn'],
        ]);

        $response = $this->actingAs($admin)->post(route('incidents.investigations.store', $incident), $investigationData->toArray());

        $response->assertForbidden();
    }

    public function test_not_assigned_supervisor_forbidden_to_create_investigation()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create();

        $investigationData = InvestigationData::from([
            'immediate_causes' => "immediate causes",
            'basic_causes' => 'basic causes',
            'remedial_actions' => "remedial actions",
            'prevention' => 'prevention',
            'hazard_class' => 'hazard class',
            'risk_rank' => 10,
            'resulted_in' => ['injury', 'burn'],
            'substandard_acts' => ['injury', 'burn'],
            'substandard_conditions' => ['injury', 'burn'],
            'energy_transfer_causes' => ['injury', 'burn'],
            'personal_factors' => ['injury', 'burn'],
            'job_factors' => ['injury', 'burn'],
        ]);

        $response = $this->actingAs($supervisor)->post(route('incidents.investigations.store', $incident), $investigationData->toArray());

        $response->assertForbidden();
    }

    public function test_stores_investigation()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class, 'supervisor_id' => $supervisor->id]);

        $investigationData = InvestigationData::from([
            'immediate_causes' => "immediate causes",
            'basic_causes' => 'basic causes',
            'remedial_actions' => "remedial actions",
            'prevention' => 'prevention',
            'hazard_class' => 'hazard class',
            'risk_rank' => 10,
            'resulted_in' => ['injury', 'burn'],
            'substandard_acts' => ['injury', 'burn'],
            'substandard_conditions' => ['injury', 'burn'],
            'energy_transfer_causes' => ['injury', 'burn'],
            'personal_factors' => ['injury', 'burn'],
            'job_factors' => ['injury', 'burn'],
        ]);

        $this->assertDatabaseCount('investigations', 0);

        $response = $this->actingAs($supervisor)->post(route('incidents.investigations.store', $incident), $investigationData->toArray());

        $this->assertDatabaseCount('investigations', 1);

        $investigation = Investigation::first();

        $this->assertEquals($incident->id, $investigation->incident_id);
        $this->assertEquals($supervisor->id, $investigation->supervisor_id);
        $this->assertEquals($investigationData->immediate_causes, $investigation->immediate_causes);
        $this->assertEquals($investigationData->basic_causes, $investigation->basic_causes);
        $this->assertEquals($investigationData->remedial_actions, $investigation->remedial_actions);
        $this->assertEquals($investigationData->prevention, $investigation->prevention);
        $this->assertEquals($investigationData->hazard_class, $investigation->hazard_class);
        $this->assertEquals($investigationData->risk_rank, $investigation->risk_rank);
        $this->assertEquals($investigationData->resulted_in, $investigation->resulted_in);
        $this->assertEquals($investigationData->substandard_acts, $investigation->substandard_acts);
        $this->assertEquals($investigationData->substandard_conditions, $investigation->substandard_conditions);
        $this->assertEquals($investigationData->energy_transfer_causes, $investigation->energy_transfer_causes);
        $this->assertEquals($investigationData->personal_factors, $investigation->personal_factors);
        $this->assertEquals($investigationData->job_factors, $investigation->job_factors);
    }
}
