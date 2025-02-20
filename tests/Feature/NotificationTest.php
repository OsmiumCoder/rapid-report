<?php

namespace Tests\Feature;

use App\Data\IncidentData;
use App\Enum\IncidentType;
use App\Models\User;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    public function test_mark_all_notifications_as_read()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

        $incidentData = IncidentData::from([
            'anonymous' => false,
            'on_behalf' => false,
            'on_behalf_anonymous' => false,
            'role' => 0,
            'last_name' => null,
            'first_name' => null,
            'upei_id' => null,
            'email' => null,
            'phone' => null,
            'work_related' => true,
            'workers_comp_submitted' => true,
            'happened_at' => now(),
            'location' => 'Building A',
            'room_number' => null,
            'witnesses' => null,
            'incident_type' => IncidentType::SAFETY,
            'descriptor' => 'Burn',
            'description' => 'A fire broke out in the room.',
            'injury_description' => null,
            'first_aid_description' => null,
            'reporters_email' => null,
            'supervisor_name' => null,
        ]);

        $this->assertCount(0, $admin->notifications);

        $storeResponse = $this->post(route('incidents.store'), $incidentData->toArray());
        $storeResponse->assertOk();

        $admin->refresh();

        $this->assertCount(1, $admin->notifications);

        $notification = $admin->notifications->first();

        $this->assertNull($notification->read_at);

        $notificationResponse = $this->put(route('notifications.mark-all-read'));

        $notificationResponse->assertRedirect();

        $notification->refresh();

        $this->assertNotNull($notification->read_at);
    }

    public function test_delete_notification()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

        $incidentData = IncidentData::from([
            'anonymous' => false,
            'on_behalf' => false,
            'on_behalf_anonymous' => false,
            'role' => 0,
            'last_name' => null,
            'first_name' => null,
            'upei_id' => null,
            'email' => null,
            'phone' => null,
            'work_related' => true,
            'workers_comp_submitted' => true,
            'happened_at' => now(),
            'location' => 'Building A',
            'room_number' => null,
            'witnesses' => null,
            'incident_type' => IncidentType::SAFETY,
            'descriptor' => 'Burn',
            'description' => 'A fire broke out in the room.',
            'injury_description' => null,
            'first_aid_description' => null,
            'reporters_email' => null,
            'supervisor_name' => null,
        ]);

        $this->assertCount(0, $admin->notifications);

        $storeResponse = $this->post(route('incidents.store'), $incidentData->toArray());
        $storeResponse->assertOk();

        $admin->refresh();

        $this->assertCount(1, $admin->notifications);

        $notification = $admin->notifications->first();

        $notificationResponse = $this->delete(route('notifications.destroy', ['notification' => $notification->id]));

        $notificationResponse->assertRedirect();

        $admin->refresh();
        $this->assertCount(0, $admin->notifications);
    }

    public function test_delete_all_notifications()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

        $incidentData = IncidentData::from([
            'anonymous' => false,
            'on_behalf' => false,
            'on_behalf_anonymous' => false,
            'role' => 0,
            'last_name' => null,
            'first_name' => null,
            'upei_id' => null,
            'email' => null,
            'phone' => null,
            'work_related' => true,
            'workers_comp_submitted' => true,
            'happened_at' => now(),
            'location' => 'Building A',
            'room_number' => null,
            'witnesses' => null,
            'incident_type' => IncidentType::SAFETY,
            'descriptor' => 'Burn',
            'description' => 'A fire broke out in the room.',
            'injury_description' => null,
            'first_aid_description' => null,
            'reporters_email' => null,
            'supervisor_name' => null,
        ]);

        $this->assertCount(0, $admin->notifications);

        $storeResponse = $this->post(route('incidents.store'), $incidentData->toArray());
        $storeResponse->assertOk();

        $storeResponse = $this->post(route('incidents.store'), $incidentData->toArray());
        $storeResponse->assertOk();

        $admin->refresh();

        $this->assertCount(2, $admin->notifications);

        $notificationResponse = $this->delete(route('notifications.destroy-all'));

        $notificationResponse->assertRedirect();


        $admin->refresh();



        $this->assertCount(0, $admin->notifications);
    }
}
