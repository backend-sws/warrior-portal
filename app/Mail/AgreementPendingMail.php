<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AgreementPendingMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = [15, 60, 180];

    public $candidate;

    public function __construct(User $candidate)
    {
        $this->candidate = $candidate;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Action Required: Please Sign Your Agreement – Warriors Educare',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.candidate.agreement_pending',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
