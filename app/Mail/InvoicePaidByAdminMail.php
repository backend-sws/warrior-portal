<?php

namespace App\Mail;

use App\Models\ServiceChargeInvoice;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoicePaidByAdminMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $invoice;
    public $candidate;

    public function __construct(ServiceChargeInvoice $invoice, User $candidate)
    {
        $this->invoice   = $invoice;
        $this->candidate = $candidate;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Marked as Paid – Warriors Educare',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.candidate.invoice_paid_by_admin',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
