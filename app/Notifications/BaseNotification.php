<?php

namespace App\Notifications;

use App\Enum\NotificationMessageType;
use App\Models\NotificationMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

abstract class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public array $data;
    public string $message;
    public string $url;

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'url' => $this->url,
            'message' => $this->message,
        ];
    }

    /**
     * Parse the notification message and replace with the placeholders with the data from $data array.
     * Assign the parsed message to $this->message
     *
     * @return void
     */
    public function parseMessage(NotificationMessageType $notificationMessageType)
    {
        $notificationMessage = NotificationMessage::firstWhere('name', $notificationMessageType->value);

        $this->message = preg_replace_callback('/\{(\w+)}/', function ($matches) {
            $key = $matches[1];
            return $this->data[$key] ?? $matches[0];
        }, $notificationMessage->message);
    }
}
