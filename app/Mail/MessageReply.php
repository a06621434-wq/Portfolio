<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable dispatched when an admin replies to a visitor inquiry from the dashboard.
 */
class MessageReply extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Message $originalMessage,
        public string $replySubject,
        public string $replyBody,
        public string $senderName = 'Shahzad Ali (Shahzad Labs)'
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->replySubject,
            replyTo: ['info@shahzadlabs.com'],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.message-reply',
        );
    }
}
