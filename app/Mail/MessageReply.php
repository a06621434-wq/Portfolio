<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Queued Mailable dispatched when an admin replies to a visitor inquiry from the dashboard.
 */
class MessageReply extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The number of times the queued job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public array $backoff = [10, 30, 60];

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 60;

    public function __construct(
        public Message $originalMessage,
        public string $replySubject,
        public string $replyBody,
        public string $senderName = 'Shahzad Ali (Shahzad Labs)'
    ) {}

    public function envelope(): Envelope
    {
        $fromAddress = 'alikhore12@gmail.com';
        $fromName    = $this->senderName ?: (config('mail.from.name') ?: 'Shahzad Ali');

        return new Envelope(
            from: new Address($fromAddress, $fromName),
            replyTo: [new Address('alikhore12@gmail.com', 'Shahzad Ali')],
            subject: $this->replySubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.message-reply',
        );
    }
}
