<?php

namespace Tests\Feature\Incident;

use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\AdditionalInformationNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AdditionalInformationTest extends TestCase
{
    public function test_first_additional_information_on_incident_creates_new_array()
    {
        $user = User::factory()->create([
            'email' => 'user@b.com'
        ]);
        $this->actingAs($user);

        $incident = Incident::factory()->create([
            'reporters_email' => $user->email,
        ]);

        $this->assertNull($incident->additional_information);

        $response = $this->patch(route('incidents.additional-information', $incident), [
            'additional_information' => 'information'
        ]);

        $response->assertRedirect();

        $incident->refresh();

        $this->assertCount(1, $incident->additional_information);

        $this->assertEquals('information', $incident->additional_information[0]['information']);
        $this->assertEquals(
            now()->timestamp,
            Carbon::parse($incident->additional_information[0]['created_at'])->timestamp
        );

    }

    public function test_additional_information_appends_to_current_additional_information_on_incident()
    {
        $user = User::factory()->create([
            'email' => 'user@b.com'
        ]);
        $this->actingAs($user);

        $incident = Incident::factory()->create([
            'reporters_email' => $user->email,
            'additional_information' => [
                ['information' => 'information 1', 'created_at' => now()->timestamp]
            ]
        ]);

        $this->assertCount(1, $incident->additional_information);

        $response = $this->patch(route('incidents.additional-information', $incident), [
            'additional_information' => 'information 2'
        ]);

        $response->assertRedirect();

        $incident->refresh();

        $this->assertCount(2, $incident->additional_information);

        $this->assertEquals('information 1', $incident->additional_information[0]['information']);
        $this->assertEquals(
            now()->timestamp,
            Carbon::parse($incident->additional_information[0]['created_at'])->timestamp
        );

        $this->assertEquals('information 2', $incident->additional_information[1]['information']);
        $this->assertEquals(
            now()->timestamp,
            Carbon::parse($incident->additional_information[1]['created_at'])->timestamp
        );
    }

    public function test_incident_reporter_can_add_additional_information_to_incident()
    {
        $user = User::factory()->create([
            'email' => 'user@b.com'
        ]);
        $this->actingAs($user);

        $incident = Incident::factory()->create([
            'reporters_email' => $user->email
        ]);

        $this->assertNull($incident->additional_information);

        $response = $this->patch(route('incidents.additional-information', $incident), [
            'additional_information' => 'information'
        ]);

        $response->assertRedirect();

        $incident->refresh();

        $this->assertCount(1, $incident->additional_information);

        $this->assertEquals('information', $incident->additional_information[0]['information']);
        $this->assertEquals(
            now()->timestamp,
            Carbon::parse($incident->additional_information[0]['created_at'])->timestamp
        );
    }

    public function test_user_who_did_not_report_incident_cant_add_additional_information()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $incident = Incident::factory()->create();

        $response = $this->patch(route('incidents.additional-information', $incident), [
            ['additional_information' => 'information']
        ]);

        $response->assertForbidden();
    }

    public function test_additional_information_on_incident_sends_notification()
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'user@b.com'
        ]);

        $admins = User::factory(3)->create()->each(function ($user) {
            $user->syncRoles('admin');
        });

        $this->actingAs($user);

        $incident = Incident::factory()->create([
            'reporters_email' => $user->email
        ]);

        $this->assertNull($incident->additional_information);

        $response = $this->patch(route('incidents.additional-information', $incident), [
            'additional_information' => 'information'
        ]);

        $response->assertRedirect();

        Notification::assertSentTo($admins, AdditionalInformationNotification::class);
    }
}
