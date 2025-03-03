<?php

namespace App\Notifications\Incident;

use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;

class IncidentReopenedNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $incidentSlug,
    ) {
        $this->message = "Incident #{$incidentSlug} has been reopened.";
        $this->url = route('incidents.show', ['incident' => $incidentSlug]);
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
            ->subject("Incident $this->incidentSlug Reopened")
            ->line($this->message)
            ->markdown('mail.incident-reopened-notification', [
                'url' => $this->url,
                'message' => $this->message,
                ]);
    }
}
