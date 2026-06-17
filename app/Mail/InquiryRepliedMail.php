<?php

namespace App\Mail;

use App\Models\CustomerMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquiryRepliedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customerMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(CustomerMessage $customerMessage)
    {
        $this->customerMessage = $customerMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'GetCare Concierge Support: Reply to your Inquiry',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.inquiry_replied',
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
