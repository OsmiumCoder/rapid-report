<?php

namespace Tests\Unit\Notification;

use App\Enum\NotificationMessageType;
use App\Models\NotificationMessage;
use App\Notifications\BaseNotification;
use Tests\TestCase;

class TestNotification extends BaseNotification
{
}

class BaseNotificationTest extends TestCase
{
    public function test_notification_parse_message_injects_values_into_message()
    {
        $notification = new TestNotification;
        $notification->data = ['name' => 'Some Name'];

        $notificationMessage = NotificationMessage::firstWhere('name', NotificationMessageType::INCIDENT_ASSIGNED);
        $notification->parseMessage($notificationMessage->name);

        $this->assertStringContainsString('Some Name', $notification->message);
        $this->assertStringNotContainsString('{name}', $notification->message);
    }
}
