<?php

namespace Tests\Feature\Notification;

use App\Enum\NotificationMessageType;
use App\Models\NotificationMessage;
use App\Models\User;
use Tests\TestCase;

class NotificationMessageTest extends TestCase
{
    public function test_updating_notification_message()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

        $notificationMessage = NotificationMessage::firstWhere('name', NotificationMessageType::INCIDENT_RECEIVED);

        $response = $this->put(
            route('notifications.update-message', ['notification_message' => $notificationMessage->id]),
            ['message' => 'some message']
        );

        $response->assertRedirect();

        $notificationMessage->refresh();

        $this->assertEquals('some message', $notificationMessage->message);
    }

    public function test_supervisor_forbidden_to_update_notification_message()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $notificationMessage = NotificationMessage::firstWhere('name', NotificationMessageType::INCIDENT_RECEIVED);

        $response = $this->put(
            route('notifications.update-message', ['notification_message' => $notificationMessage->id]),
            ['message' => 'some message']
        );

        $response->assertForbidden();
    }

    public function test_user_forbidden_to_update_notification_message()
    {
        $user = User::factory()->create()->syncRoles('user');
        $this->actingAs($user);

        $notificationMessage = NotificationMessage::firstWhere('name', NotificationMessageType::INCIDENT_RECEIVED);

        $response = $this->put(
            route('notifications.update-message', ['notification_message' => $notificationMessage->id]),
            ['message' => 'some message']
        );

        $response->assertForbidden();
    }
}
