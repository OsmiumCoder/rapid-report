<?php

namespace App\Notifications\Investigation;

use App\Models\User;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class InvestigationReturnedNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $incidentId,
        public string $investigationId,
        public User $admin
    ) {
        $this->message = "$admin->name has returned your investigation for further review";
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Investigation Returned')
            ->markdown('mail.investigation-returned', ['url' => $this->url, 'message' => $this->message]);
    }
}
