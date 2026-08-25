<?php

namespace App\Mail;

use App\Models\TuitionApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TuitionApplicationStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

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
        $status = ucfirst($this->application->status);
        $lead = $this->application->tuitionLead;
        $classInfo = $lead ? "Class {$lead->class} ({$lead->subjects})" : "Home Tuition";

        $subjectMap = [
            'Assigned'    => "🎉 Congratulations! You are Assigned as Tutor for {$classInfo}",
            'Shortlisted' => "⭐ You are Shortlisted for {$classInfo} – Demo Class Update",
            'Rejected'    => "Update on Your Home Tuition Application: {$classInfo}",
            'Applied'     => "Home Tuition Application Received: {$classInfo}",
        ];

        $subject = $subjectMap[$status] ?? "Update on Your Home Tuition Application: {$classInfo}";

        return new Envelope(
            subject: $subject . ' — Warriors Educare',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.candidate.tuition_application_status',
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
}
