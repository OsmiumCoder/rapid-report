<?php

namespace App\Notifications\Incident;

use App\Enum\NotificationMessageType;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class AdditionalInformationNotification extends BaseNotification
{
    public function __construct(public array $data)
    {
        $this->url = route('incidents.show', ['incident' => $this->data['incidentSlug']]);
        $this->parseMessage(NotificationMessageType::ADDITIONAL_INFORMATION_ADDED);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Additional Information Added To Incident #{$this->data['incidentSlug']}")
            ->markdown('mail.incident-additional-information', [
                'url' => $this->url,
                'message' => $this->message,
            ]);
    }
}
