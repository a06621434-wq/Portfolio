<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable dispatched when a visitor submits the contact form.
 * Sends the inquiry details to info@shahzadlabs.com.
 */
class ContactInquiry extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Message $inquiry
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New Inquiry: {$this->inquiry->subject}",
            replyTo: [$this->inquiry->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact-inquiry',
        );
    }
}
