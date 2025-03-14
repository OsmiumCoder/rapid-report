<?php

namespace App\Notifications\Investigation;

use App\Enum\NotificationMessageType;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class InvestigationSubmittedNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public array $data
    ) {
        $this->url = route('incidents.investigations.show', [
            'incident' => $this->data['incidentSlug'],
            'investigation' => $this->data['investigationId']
        ]);

        $this->parseMessage(NotificationMessageType::INVESTIGATION_CREATED);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Investigation Submitted For Incident #{$this->data['incidentSlug']}")
            ->markdown('mail.investigation-submitted', [
                'url' => $this->url,
                'message' => $this->message
            ]);
    }
}
