<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomAdminMessageMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = [15, 60, 180];

    public $candidate;
    public $msgTitle;
    public $msgBody;

    public function __construct(User $candidate, string $title, string $body)
    {
        $this->candidate = $candidate;
        $this->msgTitle  = $title;
        $this->msgBody   = $body;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->msgTitle . ' – Warriors Educare',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.candidate.custom_admin_message',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
