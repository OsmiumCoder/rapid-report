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
    public string $url;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $incidentId,
        public string $investigationId,
        public User $supervisor,
    ) {
        $this->message = "A new investigation was submitted by {$this->supervisor->name}";
        $this->url = route('incidents.investigations.show', [
            'incident' => $this->incidentId,
            'investigation' => $this->investigationId
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Investigation Submitted')
            ->markdown('mail.investigation-submitted', ['url' => $this->url]);
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
            'url' => $this->url,
            'message' => $this->message,
            'supervisor_name' => $this->supervisor->name,
        ];
    }
}
