<?php

namespace App\Notifications\Incident;

use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class AdditionalInformationNotification extends BaseNotification
{
    public function __construct(public string $incidentId, public string $additionalInformation)
    {
        $this->url = route('incidents.show', ['incident' => $this->incidentId]);
        $this->message = 'Additional information was added to an incident';
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Incident Additional Information Added')
            ->markdown('mail.incident-additional-information', [
                'url' => $this->url,
                'additionalInformation' => $this->additionalInformation,
            ]);
    }
}
