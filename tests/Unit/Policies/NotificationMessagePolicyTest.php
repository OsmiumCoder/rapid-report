<?php

namespace Tests\Unit\Policies;

use App\Enum\NotificationMessageType;
use App\Models\NotificationMessage;
use App\Models\User;
use App\Policies\NotificationMessagePolicy;
use Tests\TestCase;

class NotificationMessagePolicyTest extends TestCase
{
    public function test_admin_can_update_notification_message()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $notificationMessage = NotificationMessage::firstWhere('name', NotificationMessageType::INCIDENT_RECEIVED);

        $this->assertTrue($this->getPolicy()->update($admin, $notificationMessage));
    }

    public function test_supervisor_cant_update_notification_message()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $notificationMessage = NotificationMessage::firstWhere('name', NotificationMessageType::INCIDENT_RECEIVED);

        $this->assertFalse($this->getPolicy()->update($supervisor, $notificationMessage));
    }

    public function test_user_cant_update_notification_message()
    {
        $user = User::factory()->create()->syncRoles('user');
        $notificationMessage = NotificationMessage::firstWhere('name', NotificationMessageType::INCIDENT_RECEIVED);

        $this->assertFalse($this->getPolicy()->update($user, $notificationMessage));
    }

    protected function getPolicy()
    {
        return app(NotificationMessagePolicy::class);
    }
}
