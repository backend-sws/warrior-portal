<?php

namespace App\Mail;

use App\Models\JobPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobRejectedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $job;
    public $reason;

    public function __construct(JobPost $job, ?string $reason = null)
    {
        $this->job    = $job;
        $this->reason = $reason;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Job Post Has Been Reviewed – Warriors Educare',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.employer.job_rejected',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
