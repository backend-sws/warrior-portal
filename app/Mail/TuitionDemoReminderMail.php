<?php

namespace App\Mail;

use App\Models\TuitionApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TuitionDemoReminderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = [15, 60, 180];

    public $application;

    /**
     * Create a new message instance.
     */
    public function __construct(TuitionApplication $application)
    {
        $this->application = $application;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $location = $this->application->tuitionLead?->location ?? 'Trial Location';
        return new Envelope(
            subject: "Reminder: Home Tuition Demo Class Scheduled – Warriors Educare ({$location})",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.candidate.tuition_demo_reminder',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
