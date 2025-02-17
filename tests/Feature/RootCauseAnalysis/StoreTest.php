<?php

namespace RootCauseAnalysis;

use App\Data\RootCauseAnalysisData;
use App\Enum\CommentType;
use App\Models\Incident;
use App\Models\RootCauseAnalysis;
use App\Models\User;
use App\Notifications\RootCauseAnalysis\RootCauseAnalysisSubmitted;
use App\States\IncidentStatus\Assigned;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_sends_received_notification_to_admin()
    {
        Notification::fake();

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $incident = Incident::factory()->create(['status' => Assigned::class, 'supervisor_id' => $supervisor->id]);

        $rcaData = RootCauseAnalysisData::from([
            'individuals_involved' => [
                ['name' => 'john', 'email' => 'john@doe.com', 'phone' => '1234567890'],
            ],
            'primary_effect' => 'primary effect',
            'whys' => ['why 1', 'why 2', 'why 3', 'why 4', 'why 5'],
            'solutions_and_actions' => [
                [
                    "cause" => 'cause 1',
                    'control' => 'control 1',
                    'remedial_action' => 'action 1',
                    'by_who' => 'who 1',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 1',
                ],
                [
                    "cause" => 'cause 2',
                    'control' => 'control 2',
                    'remedial_action' => 'action 2',
                    'by_who' => 'who 2',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 2',
                ]
            ],
            'peoples_positions' => ['position 1', 'position 2', 'position 3', 'position 4'],
            'attention_to_work' => ['attention to work 1', 'attention to work 2'],
            'communication' => ['communication 1', 'communication 2'],
            'ppe_in_good_condition' => true,
            'ppe_in_use' => true,
            'ppe_correct_type' => true,
            'correct_tool_used' => true,
            'policies_followed' => true,
            'worked_safely' => true,
            'used_tool_properly' => true,
            'tool_in_good_condition' => true,
            'working_conditions' => ['working condition 1', 'working condition 2'],
            'root_causes' => ['root cause 1', 'root cause 2'],
        ]);

        Notification::assertNothingSent();

        $response = $this->actingAs($supervisor)->post(route('incidents.root-cause-analyses.store', $incident), $rcaData->toArray());

        Notification::assertCount(3);

        Notification::assertSentTo($admins, RootCauseAnalysisSubmitted::class);

        $rca = RootCauseAnalysis::first();

        Notification::assertSentTo(
            $admins,
            function (RootCauseAnalysisSubmitted $notification, array $channels) use ($rca, $supervisor) {
                return $notification->rootCauseAnalysisId === $rca->id && $notification->supervisor->id === $supervisor->id;
            }
        );
    }

    public function test_adds_created_rca_comment_on_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class, 'supervisor_id' => $supervisor->id]);

        $rcaData = RootCauseAnalysisData::from([
            'individuals_involved' => [
                ['name' => 'john', 'email' => 'john@doe.com', 'phone' => '1234567890'],
            ],
            'primary_effect' => 'primary effect',
            'whys' => ['why 1', 'why 2', 'why 3', 'why 4', 'why 5'],
            'solutions_and_actions' => [
                [
                    "cause" => 'cause 1',
                    'control' => 'control 1',
                    'remedial_action' => 'action 1',
                    'by_who' => 'who 1',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 1',
                ],
                [
                    "cause" => 'cause 2',
                    'control' => 'control 2',
                    'remedial_action' => 'action 2',
                    'by_who' => 'who 2',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 2',
                ]
            ],
            'peoples_positions' => ['position 1', 'position 2', 'position 3', 'position 4'],
            'attention_to_work' => ['attention to work 1', 'attention to work 2'],
            'communication' => ['communication 1', 'communication 2'],
            'ppe_in_good_condition' => true,
            'ppe_in_use' => true,
            'ppe_correct_type' => true,
            'correct_tool_used' => true,
            'policies_followed' => true,
            'worked_safely' => true,
            'used_tool_properly' => true,
            'tool_in_good_condition' => true,
            'working_conditions' => ['working condition 1', 'working condition 2'],
            'root_causes' => ['root cause 1', 'root cause 2'],
        ]);

        $response = $this->actingAs($supervisor)->post(route('incidents.root-cause-analyses.store', $incident), $rcaData->toArray());

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('created', $comment->content);
        $this->assertStringContainsStringIgnoringCase('root cause analysis', $comment->content);

    }

    public function test_redirects_to_show_page()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class, 'supervisor_id' => $supervisor->id]);

        $rcaData = RootCauseAnalysisData::from([
            'individuals_involved' => [
                ['name' => 'john', 'email' => 'john@doe.com', 'phone' => '1234567890'],
            ],
            'primary_effect' => 'primary effect',
            'whys' => ['why 1', 'why 2', 'why 3', 'why 4', 'why 5'],
            'solutions_and_actions' => [
                [
                    "cause" => 'cause 1',
                    'control' => 'control 1',
                    'remedial_action' => 'action 1',
                    'by_who' => 'who 1',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 1',
                ],
                [
                    "cause" => 'cause 2',
                    'control' => 'control 2',
                    'remedial_action' => 'action 2',
                    'by_who' => 'who 2',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 2',
                ]
            ],
            'peoples_positions' => ['position 1', 'position 2', 'position 3', 'position 4'],
            'attention_to_work' => ['attention to work 1', 'attention to work 2'],
            'communication' => ['communication 1', 'communication 2'],
            'ppe_in_good_condition' => true,
            'ppe_in_use' => true,
            'ppe_correct_type' => true,
            'correct_tool_used' => true,
            'policies_followed' => true,
            'worked_safely' => true,
            'used_tool_properly' => true,
            'tool_in_good_condition' => true,
            'working_conditions' => ['working condition 1', 'working condition 2'],
            'root_causes' => ['root cause 1', 'root cause 2'],
        ]);

        $response = $this->actingAs($supervisor)->post(route('incidents.root-cause-analyses.store', $incident), $rcaData->toArray());

        $rca = RootCauseAnalysis::first();

        $response->assertRedirectToRoute('incidents.root-cause-analyses.show', ['incident' => $incident->id, 'root_cause_analysis' => $rca->id]);
    }

    public function test_throws_validation_error_for_solutions_and_actions()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class, 'supervisor_id' => $supervisor->id]);

        $rcaData = [
            'individuals_involved' => '',
            'primary_effect' => '',
            'whys' => '',
            'solutions_and_actions' => [[]],
            'peoples_positions' => '',
            'attention_to_work' => '',
            'communication' => '',
            'ppe_in_good_condition' => '',
            'ppe_in_use' => '',
            'ppe_correct_type' => '',
            'correct_tool_used' => '',
            'policies_followed' => '',
            'worked_safely' => '',
            'used_tool_properly' => '',
            'tool_in_good_condition' => '',
            'working_conditions' => '',
            'root_causes' => '',
        ];

        $response = $this->actingAs($supervisor)->post(route('incidents.root-cause-analyses.store', $incident), $rcaData);

        $this->assertInstanceOf(ValidationException::class, $response->exception);

        $response->assertInvalid([
            'individuals_involved',
            'primary_effect',
            'whys',
            'peoples_positions',
            'attention_to_work',
            'communication',
            'ppe_in_good_condition',
            'ppe_in_use',
            'ppe_correct_type',
            'correct_tool_used',
            'policies_followed',
            'worked_safely',
            'used_tool_properly',
            'tool_in_good_condition',
            'working_conditions',
            'root_causes',
            'solutions_and_actions.0.cause',
            'solutions_and_actions.0.control',
            'solutions_and_actions.0.remedial_action',
            'solutions_and_actions.0.by_who',
            'solutions_and_actions.0.by_when',
            'solutions_and_actions.0.manager',
        ]);
    }

    public function test_throws_validation_error_for_individuals_involved()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class, 'supervisor_id' => $supervisor->id]);

        $rcaData = [
            'individuals_involved' => [[]],
            'primary_effect' => '',
            'whys' => '',
            'solutions_and_actions' => '',
            'peoples_positions' => '',
            'attention_to_work' => '',
            'communication' => '',
            'ppe_in_good_condition' => '',
            'ppe_in_use' => '',
            'ppe_correct_type' => '',
            'correct_tool_used' => '',
            'policies_followed' => '',
            'worked_safely' => '',
            'used_tool_properly' => '',
            'tool_in_good_condition' => '',
            'working_conditions' => '',
            'root_causes' => '',
        ];

        $response = $this->actingAs($supervisor)->post(route('incidents.root-cause-analyses.store', $incident), $rcaData);

        $this->assertInstanceOf(ValidationException::class, $response->exception);

        $response->assertInvalid([
            'primary_effect',
            'whys',
            'solutions_and_actions',
            'peoples_positions',
            'attention_to_work',
            'communication',
            'ppe_in_good_condition',
            'ppe_in_use',
            'ppe_correct_type',
            'correct_tool_used',
            'policies_followed',
            'worked_safely',
            'used_tool_properly',
            'tool_in_good_condition',
            'working_conditions',
            'root_causes',
            'individuals_involved.0.name',
        ]);
    }

    public function test_throws_validation_error_for_bad_data()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class, 'supervisor_id' => $supervisor->id]);

        $rcaData = [
            'individuals_involved' => '',
            'primary_effect' => '',
            'whys' => '',
            'solutions_and_actions' => '',
            'peoples_positions' => '',
            'attention_to_work' => '',
            'communication' => '',
            'ppe_in_good_condition' => '',
            'ppe_in_use' => '',
            'ppe_correct_type' => '',
            'correct_tool_used' => '',
            'policies_followed' => '',
            'worked_safely' => '',
            'used_tool_properly' => '',
            'tool_in_good_condition' => '',
            'working_conditions' => '',
            'root_causes' => '',
        ];

        $response = $this->actingAs($supervisor)->post(route('incidents.root-cause-analyses.store', $incident), $rcaData);

        $this->assertInstanceOf(ValidationException::class, $response->exception);

        $response->assertInvalid([
            'individuals_involved',
            'primary_effect',
            'whys',
            'solutions_and_actions',
            'peoples_positions',
            'attention_to_work',
            'communication',
            'ppe_in_good_condition',
            'ppe_in_use',
            'ppe_correct_type',
            'correct_tool_used',
            'policies_followed',
            'worked_safely',
            'used_tool_properly',
            'tool_in_good_condition',
            'working_conditions',
            'root_causes',
        ]);
    }

    public function test_user_forbidden_to_create_rca()
    {
        $user = User::factory()->create()->syncRoles('user');

        $incident = Incident::factory()->create(['status' => Assigned::class,]);

        $rcaData = RootCauseAnalysisData::from([
            'individuals_involved' => [
                ['name' => 'john', 'email' => 'john@doe.com', 'phone' => '1234567890'],
            ],
            'primary_effect' => 'primary effect',
            'whys' => ['why 1', 'why 2', 'why 3', 'why 4', 'why 5'],
            'solutions_and_actions' => [
                [
                    "cause" => 'cause 1',
                    'control' => 'control 1',
                    'remedial_action' => 'action 1',
                    'by_who' => 'who 1',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 1',
                ],
                [
                    "cause" => 'cause 2',
                    'control' => 'control 2',
                    'remedial_action' => 'action 2',
                    'by_who' => 'who 2',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 2',
                ]
            ],
            'peoples_positions' => ['position 1', 'position 2', 'position 3', 'position 4'],
            'attention_to_work' => ['attention to work 1', 'attention to work 2'],
            'communication' => ['communication 1', 'communication 2'],
            'ppe_in_good_condition' => true,
            'ppe_in_use' => true,
            'ppe_correct_type' => true,
            'correct_tool_used' => true,
            'policies_followed' => true,
            'worked_safely' => true,
            'used_tool_properly' => true,
            'tool_in_good_condition' => true,
            'working_conditions' => ['working condition 1', 'working condition 2'],
            'root_causes' => ['root cause 1', 'root cause 2'],
        ]);

        $response = $this->actingAs($user)->post(route('incidents.root-cause-analyses.store', $incident), $rcaData->toArray());

        $response->assertForbidden();
    }

    public function test_admin_forbidden_to_create_rca()
    {
        $admin = User::factory()->create()->syncRoles('admin');

        $incident = Incident::factory()->create(['status' => Assigned::class,]);

        $rcaData = RootCauseAnalysisData::from([
            'individuals_involved' => [
                ['name' => 'john', 'email' => 'john@doe.com', 'phone' => '1234567890'],
            ],
            'primary_effect' => 'primary effect',
            'whys' => ['why 1', 'why 2', 'why 3', 'why 4', 'why 5'],
            'solutions_and_actions' => [
                [
                    "cause" => 'cause 1',
                    'control' => 'control 1',
                    'remedial_action' => 'action 1',
                    'by_who' => 'who 1',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 1',
                ],
                [
                    "cause" => 'cause 2',
                    'control' => 'control 2',
                    'remedial_action' => 'action 2',
                    'by_who' => 'who 2',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 2',
                ]
            ],
            'peoples_positions' => ['position 1', 'position 2', 'position 3', 'position 4'],
            'attention_to_work' => ['attention to work 1', 'attention to work 2'],
            'communication' => ['communication 1', 'communication 2'],
            'ppe_in_good_condition' => true,
            'ppe_in_use' => true,
            'ppe_correct_type' => true,
            'correct_tool_used' => true,
            'policies_followed' => true,
            'worked_safely' => true,
            'used_tool_properly' => true,
            'tool_in_good_condition' => true,
            'working_conditions' => ['working condition 1', 'working condition 2'],
            'root_causes' => ['root cause 1', 'root cause 2'],
        ]);

        $response = $this->actingAs($admin)->post(route('incidents.root-cause-analyses.store', $incident), $rcaData->toArray());

        $response->assertForbidden();
    }

    public function test_not_assigned_supervisor_forbidden_to_create_rca()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $rcaData = RootCauseAnalysisData::from([
            'individuals_involved' => [
                ['name' => 'john', 'email' => 'john@doe.com', 'phone' => '1234567890'],
            ],
            'primary_effect' => 'primary effect',
            'whys' => ['why 1', 'why 2', 'why 3', 'why 4', 'why 5'],
            'solutions_and_actions' => [
                [
                    "cause" => 'cause 1',
                    'control' => 'control 1',
                    'remedial_action' => 'action 1',
                    'by_who' => 'who 1',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 1',
                ],
                [
                    "cause" => 'cause 2',
                    'control' => 'control 2',
                    'remedial_action' => 'action 2',
                    'by_who' => 'who 2',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 2',
                ]
            ],
            'peoples_positions' => ['position 1', 'position 2', 'position 3', 'position 4'],
            'attention_to_work' => ['attention to work 1', 'attention to work 2'],
            'communication' => ['communication 1', 'communication 2'],
            'ppe_in_good_condition' => true,
            'ppe_in_use' => true,
            'ppe_correct_type' => true,
            'correct_tool_used' => true,
            'policies_followed' => true,
            'worked_safely' => true,
            'used_tool_properly' => true,
            'tool_in_good_condition' => true,
            'working_conditions' => ['working condition 1', 'working condition 2'],
            'root_causes' => ['root cause 1', 'root cause 2'],
        ]);

        $response = $this->actingAs($supervisor)->post(route('incidents.root-cause-analyses.store', $incident), $rcaData->toArray());

        $response->assertForbidden();
    }

    public function test_assigned_supervisor_forbidden_to_create_rca_if_incident_not_assigned_state()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['supervisor_id' => $supervisor->id]);

        $rcaData = RootCauseAnalysisData::from([
            'individuals_involved' => [
                ['name' => 'john', 'email' => 'john@doe.com', 'phone' => '1234567890'],
            ],
            'primary_effect' => 'primary effect',
            'whys' => ['why 1', 'why 2', 'why 3', 'why 4', 'why 5'],
            'solutions_and_actions' => [
                [
                    "cause" => 'cause 1',
                    'control' => 'control 1',
                    'remedial_action' => 'action 1',
                    'by_who' => 'who 1',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 1',
                ],
                [
                    "cause" => 'cause 2',
                    'control' => 'control 2',
                    'remedial_action' => 'action 2',
                    'by_who' => 'who 2',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 2',
                ]
            ],
            'peoples_positions' => ['position 1', 'position 2', 'position 3', 'position 4'],
            'attention_to_work' => ['attention to work 1', 'attention to work 2'],
            'communication' => ['communication 1', 'communication 2'],
            'ppe_in_good_condition' => true,
            'ppe_in_use' => true,
            'ppe_correct_type' => true,
            'correct_tool_used' => true,
            'policies_followed' => true,
            'worked_safely' => true,
            'used_tool_properly' => true,
            'tool_in_good_condition' => true,
            'working_conditions' => ['working condition 1', 'working condition 2'],
            'root_causes' => ['root cause 1', 'root cause 2'],
        ]);

        $response = $this->actingAs($supervisor)->post(route('incidents.root-cause-analyses.store', $incident), $rcaData->toArray());

        $response->assertForbidden();
    }

    public function test_stores_rca()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class, 'supervisor_id' => $supervisor->id]);

        $rcaData = RootCauseAnalysisData::from([
            'individuals_involved' => [
                ['name' => 'john', 'email' => 'john@doe.com', 'phone' => '1234567890'],
            ],
            'primary_effect' => 'primary effect',
            'whys' => ['why 1', 'why 2', 'why 3', 'why 4', 'why 5'],
            'solutions_and_actions' => [
                [
                    "cause" => 'cause 1',
                    'control' => 'control 1',
                    'remedial_action' => 'action 1',
                    'by_who' => 'who 1',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 1',
                ],
                [
                    "cause" => 'cause 2',
                    'control' => 'control 2',
                    'remedial_action' => 'action 2',
                    'by_who' => 'who 2',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 2',
                ]
            ],
            'peoples_positions' => ['position 1', 'position 2', 'position 3', 'position 4'],
            'attention_to_work' => ['attention to work 1', 'attention to work 2'],
            'communication' => ['communication 1', 'communication 2'],
            'ppe_in_good_condition' => true,
            'ppe_in_use' => true,
            'ppe_correct_type' => true,
            'correct_tool_used' => true,
            'policies_followed' => true,
            'worked_safely' => true,
            'used_tool_properly' => true,
            'tool_in_good_condition' => true,
            'working_conditions' => ['working condition 1', 'working condition 2'],
            'root_causes' => ['root cause 1', 'root cause 2'],
        ]);

        $this->assertDatabaseCount('root_cause_analyses', 0);

        $response = $this->actingAs($supervisor)->post(route('incidents.root-cause-analyses.store', $incident), $rcaData->toArray());

        $this->assertDatabaseCount('root_cause_analyses', 1);

        $rca = RootCauseAnalysis::first();

        $this->assertEquals($incident->id, $rca->incident_id);
        $this->assertEquals($supervisor->id, $rca->supervisor_id);
        $this->assertEquals($rcaData->individuals_involved, $rca->individuals_involved);
        $this->assertEquals($rcaData->primary_effect, $rca->primary_effect);
        $this->assertEquals($rcaData->whys, $rca->whys);
        $this->assertEquals($rcaData->solutions_and_actions, $rca->solutions_and_actions);
        $this->assertEquals($rcaData->peoples_positions, $rca->peoples_positions);
        $this->assertEquals($rcaData->attention_to_work, $rca->attention_to_work);
        $this->assertEquals($rcaData->communication, $rca->communication);
        $this->assertEquals($rcaData->ppe_in_good_condition, $rca->ppe_in_good_condition);
        $this->assertEquals($rcaData->ppe_in_use, $rca->ppe_in_use);
        $this->assertEquals($rcaData->ppe_correct_type, $rca->ppe_correct_type);
        $this->assertEquals($rcaData->correct_tool_used, $rca->correct_tool_used);
        $this->assertEquals($rcaData->policies_followed, $rca->policies_followed);
        $this->assertEquals($rcaData->worked_safely, $rca->worked_safely);
        $this->assertEquals($rcaData->used_tool_properly, $rca->used_tool_properly);
        $this->assertEquals($rcaData->tool_in_good_condition, $rca->tool_in_good_condition);
        $this->assertEquals($rcaData->working_conditions, $rca->working_conditions);
        $this->assertEquals($rcaData->root_causes, $rca->root_causes);
    }
}
