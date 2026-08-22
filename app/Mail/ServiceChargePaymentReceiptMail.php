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

class ServiceChargePaymentReceiptMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $invoice;
    public $user;
    public $amountPaid;

    public function __construct(ServiceChargeInvoice $invoice, User $user, $amountPaid)
    {
        $this->invoice    = $invoice;
        $this->user       = $user;
        $this->amountPaid = $amountPaid;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Receipt – Service Charge Paid – Warriors Educare',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.candidate.service_charge_receipt',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
