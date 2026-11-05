<?php

namespace App\Jobs;

use App\Mail\MessageReply;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Queued Job to reliably dispatch email replies to inquiries with fallback retry logic.
 */
class SendReplyEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Max retries for the job.
     */
    public int $tries = 3;

    /**
     * Exponential backoff delays in seconds between retries.
     */
    public array $backoff = [10, 30, 60];

    /**
     * Timeout in seconds.
     */
    public int $timeout = 60;

    public function __construct(
        public Message $originalMessage,
        public string $replySubject,
        public string $replyBody,
        public string $senderName = 'Shahzad Ali (Shahzad Labs)'
    ) {}

    /**
     * Execute the queued job.
     */
    public function handle(): void
    {
        $recipient = $this->originalMessage->email;
        $mailable = new MessageReply(
            $this->originalMessage,
            $this->replySubject,
            $this->replyBody,
            $this->senderName
        );

        Log::info("SendReplyEmailJob: Processing queued reply to [{$recipient}] (Inquiry #{$this->originalMessage->id})...");

        try {
            // 1. Try primary configured mailer
            Mail::to($recipient)->send($mailable);
            Log::info("SendReplyEmailJob: Successfully delivered reply to [{$recipient}] via [" . config('mail.default') . '].');
            return;
        } catch (\Throwable $primaryException) {
            Log::warning("SendReplyEmailJob: Primary mailer [" . config('mail.default') . "] failed for [{$recipient}]: " . $primaryException->getMessage());

            // 2. Try failover to sendmail if primary was smtp
            if (config('mail.default') === 'smtp') {
                try {
                    Log::info("SendReplyEmailJob: Attempting sendmail fallback for [{$recipient}]...");
                    Mail::mailer('sendmail')->to($recipient)->send($mailable);
                    Log::info("SendReplyEmailJob: Successfully delivered via sendmail fallback to [{$recipient}].");
                    return;
                } catch (\Throwable $sendmailException) {
                    Log::warning("SendReplyEmailJob: Sendmail fallback also failed: " . $sendmailException->getMessage());
                }
            }

            // Re-throw so Laravel queue manages backoff and logs to failed_jobs
            throw $primaryException;
        }
    }

    /**
     * Handle job failure after max attempts.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("SendReplyEmailJob: Permanently failed to send reply to [{$this->originalMessage->email}] (Inquiry #{$this->originalMessage->id}): " . $exception->getMessage());
    }
}

