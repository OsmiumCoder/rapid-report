<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IncidentReceived extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Incident Received',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $url = url('/incidents');
        return new Content(
            markdown: 'mail.incident-received',
            with: (['url' => $url, 'http://rapid-report.test/incidents/']),
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function toMail($notifiable): Content
    {
        $url = url('/incidents');
        return new Content(
            markdown: 'mail.incident-received',
            with: (['url' => $url, 'http://rapid-report.test/incidents/']),
        );
    }
}
