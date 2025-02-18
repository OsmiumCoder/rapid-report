<?php

namespace App\Notifications\Incident;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class IncidentSubmitted extends Notification
{
    use Queueable;

    public string $message;
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
        $url = route('incidents.show', [
            'incident' => $this->incidentId,
        ]);

        return (new MailMessage)
            ->subject('Incident Submitted')
            ->markdown('mail.incident-submitted', ['url' => $url]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'route' => 'incidents.show',
            'params' => [
                'incident' => $this->incidentId,
            ],
            'message' => $this->message,
        ];
    }
}
