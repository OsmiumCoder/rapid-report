<?php

namespace App\Notifications\Incident;

use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class IncidentClosedNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $incidentSlug,
    ) {
        $this->message = "Incident #$incidentSlug has been closed";
        $this->url = route('incidents.show', ['incident' => $this->incidentSlug]);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Incident #$this->incidentSlug Closed")
            ->markdown('mail.incident-closed-notification', [
                'url' => $this->url,
                'message' => $this->message
            ]);
    }
}
