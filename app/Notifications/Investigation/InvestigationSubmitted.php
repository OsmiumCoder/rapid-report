<?php

namespace App\Notifications\Investigation;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class InvestigationSubmitted extends Notification
{
    use Queueable;

    public string $message;
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $incidentId,
        public string $investigationId,
        public User $supervisor,
    ) {
        $this->message = "A new investigation was submitted by {$this->supervisor->name}";
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('incidents.investigations.show', $this->investigationId);

        return (new MailMessage)
            ->subject('Investigation Submitted')
            ->markdown('mail.investigation-submitted', ['url' => $url]);
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'route' => 'incidents.investigations.show',
            'params' => [
                'incident' => $this->incidentId,
                'investigation' => $this->investigationId,
            ],
            'message' => $this->message,
            'supervisor_name' => $this->supervisor->name,
        ];
    }
}
