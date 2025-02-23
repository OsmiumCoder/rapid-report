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

    public function via(): array
    {
        return ['mail', 'database'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject('Incident Additional Information Added')
            ->markdown('mail.incident-additional-information', [
                'url' => $this->url,
                'additionalInformation' => $this->additionalInformation,
            ]);
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'message' => $this->message,
        ];
    }
}
