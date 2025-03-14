<?php

namespace App\Notifications\Incident;

use App\Enum\NotificationMessageType;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class SupervisorAssignedNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public array $data
    ) {
        $this->url = route('incidents.show', ['incident' => $this->data['incidentSlug']]);
        $this->parseMessage(NotificationMessageType::INCIDENT_ASSIGNED);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Incident #{$this->data['incidentSlug']} Assigned")
            ->markdown('mail.incident-assigned', [
                'url' => $this->url,
                'message' => $this->message,
            ]);
    }
}
