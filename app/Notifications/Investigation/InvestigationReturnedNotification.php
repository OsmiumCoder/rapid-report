<?php

namespace App\Notifications\Investigation;

use App\Enum\NotificationMessageType;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class InvestigationReturnedNotification extends BaseNotification
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

        $this->parseMessage(NotificationMessageType::INVESTIGATION_RETURNED);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Investigation For Incident #{$this->data['incidentSlug']} Returned")
            ->markdown('mail.investigation-returned', [
                'url' => $this->url,
                'message' => $this->message
            ]);
    }
}
