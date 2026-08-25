<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentCollectionDailyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $summary;

    /**
     * Create a new message instance.
     */
    public function __construct(array $summary)
    {
        $this->summary = $summary;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $dueCount = $this->summary['due_today_count'] ?? 0;
        $overdueCount = $this->summary['overdue_count'] ?? 0;
        $followUpCount = $this->summary['follow_up_today_count'] ?? 0;
        $total = $dueCount + $overdueCount + $followUpCount;

        return new Envelope(
            subject: "📋 Daily Payment Summary: {$total} Actions Required — Warriors Educare",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.payment_collection_daily',
        );
    }
}
