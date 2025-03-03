<?php

namespace App\Notifications\Incident;

use App\Models\Incident;
use App\Models\User;
use App\Notifications\BaseNotification;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Returned;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IncidentFollowUpOverdueNotification extends BaseNotification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $incidentSlug,
        public User   $supervisor,
    ) {
        $this->message = "Your required follow-up on incident #$incidentSlug is overdue.";
        $this->url = route('incidents.show', ['incident' => $incidentSlug]);
    }

    /**
     * Determine the notification's delivery delay.
     *
     * @return array<string, \Illuminate\Support\Carbon>
     */
    public function withDelay(object $notifiable): array
    {
        return [
            'mail' => now()->addHours(72),
            'database' => now()->addHours(72),
        ];
    }

    /**
     * Determine if the notification should be sent.
     */
    public function shouldSend(object $notifiable, string $channel): bool
    {
        $incident = Incident::where('slug', $this->incidentSlug)->first();
        return ($incident->status::class == Assigned::class || $incident->status::class == Returned::class)
            && $incident->supervisor_id == $this->supervisor->id;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Incident #$this->incidentSlug Follow Up Overdue")
            ->markdown('mail.incident-follow-up-overdue-notification', ['url' => $this->url, 'message' => $this->message]);
    }
}
