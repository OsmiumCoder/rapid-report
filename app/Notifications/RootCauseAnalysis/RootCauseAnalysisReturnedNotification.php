<?php

namespace App\Notifications\RootCauseAnalysis;

use App\Enum\NotificationMessageType;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class RootCauseAnalysisReturnedNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public array $data,
    ) {
        $this->url = route('incidents.root-cause-analyses.show', [
            'incident' => $this->data['incidentSlug'],
            'root_cause_analysis' => $this->data['rootCauseAnalysisId'],
        ]);

        $this->parseMessage(NotificationMessageType::RCA_RETURNED);
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
            ->subject("Root Cause Analysis For Incident #{$this->data['incidentSlug']} Returned")
            ->markdown('mail.root-cause-analysis-returned', [
                'url' => $this->url,
                'message' => $this->message,
            ]);
    }
}
