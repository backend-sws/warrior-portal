<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentFailedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $transactionId;
    public $amount;

    public function __construct(User $user, string $transactionId, $amount)
    {
        $this->user          = $user;
        $this->transactionId = $transactionId;
        $this->amount        = $amount;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Failed – Warriors Educare',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.candidate.payment_failed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
