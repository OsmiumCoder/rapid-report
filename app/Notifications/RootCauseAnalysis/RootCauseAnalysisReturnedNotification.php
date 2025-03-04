<?php

namespace App\Notifications\RootCauseAnalysis;

use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class RootCauseAnalysisReturnedNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $incidentSlug,
        public string $rootCauseAnalysisId,
    ) {
        $this->message = "The root cause analysis {$this->rootCauseAnalysisId} for incident #{$this->incidentSlug} has been reopened.";
        $this->url = route('incidents.root-cause-analyses.show', [
            'incident' => $this->incidentSlug,
            'root_cause_analysis' => $this->rootCauseAnalysisId
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
            ->subject('Root Cause Analysis Returned')
            ->markdown('mail.root-cause-analysis-returned', [
                'url' => $this->url,
            ]);
    }
}
