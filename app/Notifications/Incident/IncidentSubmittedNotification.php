<?php

namespace App\Notifications\Incident;

use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;

class IncidentSubmittedNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $incidentId,
        public ?string $firstName,
        public ?string $lastName,
    ) {
        if ($this->firstName == null && $this->lastName == null) {
            $name = 'an Anonymous User';
        } elseif ($this->firstName == null) {
            $name = $this->lastName;
        } elseif ($this->lastName == null) {
            $name = $this->firstName;
        } else {
            $name = $this->firstName.' '.$this->lastName;
        }
        $this->message = "An incident was submitted by $name";
        $this->url = route('incidents.show', [
            'incident' => $this->incidentId,
        ]);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'vonage'];
    }

    /**
     * Get the Vonage / SMS representation of the notification.
     */
    public function toVonage(object $notifiable): VonageMessage
    {
        return (new VonageMessage)
            ->content($this->message);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Incident Submitted')
            ->markdown('mail.incident-submitted', ['url' => $this->url]);
    }
}
