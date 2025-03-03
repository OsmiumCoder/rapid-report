<?php

namespace App\Notifications\Incident;

use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class AdditionalInformationNotification extends BaseNotification
{
    public function __construct(public string $incidentSlug, public string $additionalInformation)
    {
        $this->url = route('incidents.show', ['incident' => $this->incidentSlug]);
        $this->message = "Additional information was added to incident# $this->incidentSlug";
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Additional Information Added To Incident #$this->incidentSlug")
            ->markdown('mail.incident-additional-information', [
                'url' => $this->url,
                'incidentSlug' => $this->incidentSlug,
                'additionalInformation' => $this->additionalInformation,
            ]);
    }
}
