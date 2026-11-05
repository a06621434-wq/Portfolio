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

        // 1. Try primary configured mailer (unless explicitly in log mode)
        $primaryError = null;
        if (config('mail.default') !== 'log') {
            try {
                Mail::to($recipient)->send($mailable);
                Log::info("SendReplyEmailJob: Successfully delivered reply to [{$recipient}] via [" . config('mail.default') . '].');
                return;
            } catch (\Throwable $primaryException) {
                $primaryError = $primaryException->getMessage();
                Log::warning("SendReplyEmailJob: Primary mailer [" . config('mail.default') . "] failed for [{$recipient}]: " . $primaryError);
            }
        }

        // 2. High-reliability fallback: Hostinger Native PHP mail() with anti-spam RFC headers & SPF envelope alignment
        if (function_exists('mail')) {
            Log::info("SendReplyEmailJob: Attempting Hostinger native PHP mail() with anti-spam headers for [{$recipient}]...");
            if ($this->sendViaPhpMail($recipient, $mailable)) {
                Log::info("SendReplyEmailJob: Successfully delivered reply to [{$recipient}] via Hostinger native mail().");
                return;
            }
        }

        // 3. Fallback: log for audit if neither network mailer succeeded
        if (config('mail.default') === 'log') {
            Mail::mailer('log')->to($recipient)->send($mailable);
            Log::info("SendReplyEmailJob: Stored reply to [{$recipient}] in laravel.log (log driver).");
            return;
        }

        if ($primaryError) {
            throw new \RuntimeException("Mail delivery failed: {$primaryError}");
        }
    }

    /**
     * Send email directly using PHP native mail() function with strict RFC 5322 compliance,
     * SPF envelope alignment (-f parameter), Message-ID, Date, and multipart/alternative format
     * to prevent emails from being marked as Spam.
     */
    protected function sendViaPhpMail(string $recipient, MessageReply $mailable): bool
    {
        if (!function_exists('mail')) {
            return false;
        }

        try {
            $renderedHtml = $mailable->render();
            $subject      = $this->replySubject;
            $fromName     = $this->senderName ?: (config('mail.from.name') ?: 'Shahzad Ali');
            $fromAddr     = config('mail.from.address') ?: 'alikhore12@gmail.com';
            $domain       = parse_url((string) config('app.url', 'https://shahzadlabs.com'), PHP_URL_HOST) ?: 'shahzadlabs.com';

            // Clean Plain-Text alternative
            $plainText = strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>', '</div>'], "\n", $renderedHtml));
            $plainText = preg_replace("/\n{3,}/", "\n\n", trim($plainText));

            // Unique Boundary, Message-ID, Date (Critical for SpamAssassin / Gmail anti-spam AI)
            $boundary  = '==Multipart_Boundary_x' . md5(microtime());
            $messageId = '<' . time() . '.' . bin2hex(random_bytes(8)) . '@' . $domain . '>';
            $date      = date('r');

            $headers = [
                'Date: ' . $date,
                'Message-ID: ' . $messageId,
                'From: ' . $fromName . ' <' . $fromAddr . '>',
                'Reply-To: Shahzad Ali <alikhore12@gmail.com>',
                'Return-Path: <' . $fromAddr . '>',
                'MIME-Version: 1.0',
                'Content-Type: multipart/alternative; boundary="' . $boundary . '"',
                'X-Priority: 3',
                'X-Auto-Response-Suppress: All',
            ];

            // Build Multipart Body (Plain Text + HTML)
            $body  = "--" . $boundary . "\r\n";
            $body .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
            $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
            $body .= $plainText . "\r\n\r\n";

            $body .= "--" . $boundary . "\r\n";
            $body .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
            $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
            $body .= $renderedHtml . "\r\n\r\n";

            $body .= "--" . $boundary . "--\r\n";

            // Crucial: -f parameter sets Envelope-From to match From header on Hostinger MTA,
            // passing SPF alignment and avoiding spam classification!
            $additionalParams = '-f' . $fromAddr;

            return (bool) @mail($recipient, $subject, $body, implode("\r\n", $headers), $additionalParams);
        } catch (\Throwable $e) {
            Log::warning("SendReplyEmailJob: PHP mail() fallback failed: " . $e->getMessage());
            return false;
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
