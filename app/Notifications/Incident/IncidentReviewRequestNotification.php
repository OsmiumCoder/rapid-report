<?php

namespace App\Notifications\Incident;

use App\Enum\NotificationMessageType;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class IncidentReviewRequestNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public array $data
    ) {
        $this->url = route('incidents.show', ['incident' => $this->data['incidentSlug']]);
        $this->parseMessage(NotificationMessageType::INCIDENT_REVIEW_REQUESTED);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Incident #{$this->data['incidentSlug']} Follow Up Review Request")
            ->markdown('mail.incident-review-request', [
                'url' => $this->url,
                'message' => $this->message
            ]);
    }
}
