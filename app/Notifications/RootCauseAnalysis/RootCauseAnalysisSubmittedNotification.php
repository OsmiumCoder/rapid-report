<?php

namespace App\Notifications\RootCauseAnalysis;

use App\Models\User;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class RootCauseAnalysisSubmittedNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $incidentId,
        public string $rootCauseAnalysisId,
        public User $supervisor,
    ) {
        $this->message = "A new root cause analysis was submitted by {$this->supervisor->name}";
        $this->url = route('incidents.root-cause-analyses.show', [
            'incident' => $this->incidentId,
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
            ->subject('Root Cause Analysis Submitted')
            ->markdown('mail.root-cause-analysis-submitted', ['url' => $this->url]);
    }
}
