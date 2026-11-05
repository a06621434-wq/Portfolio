<?php

namespace App\Http\Controllers;

use App\Jobs\SendReplyEmailJob;
use App\Mail\MessageReply;
use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * Admin dashboard: overview metrics, inquiry management, and queue worker operations.
 */
class DashboardController extends Controller
{
    /**
     * Dashboard overview with key metrics.
     */
    public function index()
    {
        $stats = [
            'total_projects'     => Project::count(),
            'featured_projects'  => Project::featured()->count(),
            'total_skills'       => Skill::count(),
            'total_messages'     => Message::count(),
            'unread_messages'    => Message::unread()->count(),
        ];

        $recentMessages = Message::with('replies')->latest()->take(6)->get();
        $recentProjects = Project::latest()->take(5)->get();
        $recentSkills   = Skill::latest()->take(5)->get();

        $queueStats = [
            'pending' => DB::table('jobs')->count(),
            'failed'  => DB::table('failed_jobs')->count(),
            'driver'  => config('queue.default', 'database'),
            'mailer'  => config('mail.default', 'smtp'),
        ];

        return view('admin.dashboard', compact('stats', 'recentMessages', 'recentProjects', 'recentSkills', 'queueStats'));
    }

    /**
     * View all contact messages / inquiries inbox.
     */
    public function messages()
    {
        $messages = Message::with('replies')->latest()->paginate(20);

        return view('admin.messages', compact('messages'));
    }

    /**
     * Show a single message and mark as read.
     */
    public function showMessage(Message $message)
    {
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        $message->load('replies.user');

        $queueStats = [
            'pending' => DB::table('jobs')->count(),
            'failed'  => DB::table('failed_jobs')->count(),
            'driver'  => config('queue.default', 'database'),
            'mailer'  => config('mail.default', 'smtp'),
        ];

        return view('admin.message-show', compact('message', 'queueStats'));
    }

    /**
     * Send direct reply to a contact inquiry message via queue with instant processing.
     */
    public function replyMessage(Request $request, Message $message)
    {
        $validated = $request->validate([
            'subject'    => ['required', 'string', 'max:255'],
            'reply_body' => ['required', 'string', 'max:5000'],
        ]);

        // 1. Record reply in database
        $reply = $message->replies()->create([
            'user_id'    => auth()->id(),
            'subject'    => $validated['subject'],
            'reply_body' => $validated['reply_body'],
        ]);

        // 2. Mark parent message as replied & read
        $message->update([
            'is_read'    => true,
            'replied_at' => now(),
        ]);

        // 3. Dispatch Email notification to sender via Queue Job
        $senderName = auth()->user()?->name ?: 'Shahzad Ali (Shahzad Labs)';
        $mailError = null;

        try {
            // Push job onto queue
            SendReplyEmailJob::dispatch($message, $validated['subject'], $validated['reply_body'], $senderName);

            // Execute an immediate worker cycle so email sends right away without requiring a background supervisor daemon
            if (config('queue.default') === 'database') {
                Artisan::call('queue:work', [
                    '--stop-when-empty' => true,
                    '--max-jobs'        => 5,
                    '--tries'           => 3,
                    '--timeout'         => 25,
                ]);
            }
        } catch (\Throwable $e) {
            $mailError = $e->getMessage();
            Log::warning('Direct message reply queue execution failed: ' . $mailError);
        }

        // 4. Verify whether the job was sent or failed in failed_jobs table
        $recentFailed = DB::table('failed_jobs')
            ->where('failed_at', '>=', now()->subSeconds(25))
            ->latest('id')
            ->first();

        if ($recentFailed && empty($mailError)) {
            $exText = (string) $recentFailed->exception;
            if (str_contains($exText, '535') || str_contains($exText, 'BadCredentials') || str_contains($exText, 'Username and Password not accepted')) {
                $mailError = 'Google SMTP authentication notice: A 16-character App Password is recommended for Gmail.';
            } else {
                $mailError = 'Queue delivery notice: ' . Str::limit(strip_tags($recentFailed->exception), 140);
            }
        }

        $isSuccessful = empty($mailError);
        $successMsg = 'Direct reply queued and dispatched to ' . $message->email . ' successfully!';

        if ($mailError) {
            $successMsg = 'Reply saved to history! Notice: ' . $mailError . ' (You can also click "Gmail Direct" above to send in 1 click).';
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success'    => true,
                'delivered'  => $isSuccessful,
                'message'    => $successMsg,
                'mail_error' => $mailError,
                'reply'      => [
                    'id'         => $reply->id,
                    'subject'    => $reply->subject,
                    'reply_body' => $reply->reply_body,
                    'user_name'  => auth()->user()?->name ?: 'Admin',
                    'date'       => $reply->created_at->format('M d, Y \a\t h:i A'),
                ],
            ]);
        }

        return redirect()->back()->with('success', $successMsg);
    }

    /**
     * Trigger queue worker on demand from Admin dashboard.
     */
    public function processQueue(Request $request)
    {
        try {
            Artisan::call('queue:work', [
                '--stop-when-empty' => true,
                '--max-jobs'        => 25,
                '--tries'           => 3,
                '--timeout'         => 35,
            ]);

            $pending = DB::table('jobs')->count();
            $failed  = DB::table('failed_jobs')->count();

            return response()->json([
                'success' => true,
                'message' => "Queue worker cycle finished! Pending jobs: {$pending}, Failed jobs: {$failed}.",
                'pending' => $pending,
                'failed'  => $failed,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Queue worker error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Send a diagnostic test email to verify mail delivery directly.
     */
    public function testMail(Request $request)
    {
        $targetEmail = $request->input('email', 'alikhore12@gmail.com');

        // 1. Try Laravel configured network mailer if not 'log'
        if (config('mail.default') !== 'log') {
            try {
                Mail::raw("Shahzad Labs SMTP Diagnostic Test\nTimestamp: " . now()->toDateTimeString() . "\nMailer: " . config('mail.default'), function ($m) use ($targetEmail) {
                    $m->to($targetEmail)
                      ->subject('Shahzad Labs SMTP Test - ' . now()->format('H:i:s'));
                });

                return response()->json([
                    'success' => true,
                    'message' => "Test email successfully sent to {$targetEmail} via [" . config('mail.default') . ']!',
                ]);
            } catch (\Throwable $e) {
                Log::warning('testMail: Default mailer failed: ' . $e->getMessage());
            }
        }

        // 2. High-reliability fallback: Hostinger Native PHP mail() wrapper with anti-spam headers
        if (function_exists('mail')) {
            $fromName  = config('mail.from.name', 'Shahzad Ali');
            $fromAddr  = config('mail.from.address', 'info@shahzadlabs.com');
            $domain    = parse_url((string) config('app.url', 'https://shahzadlabs.com'), PHP_URL_HOST) ?: 'shahzadlabs.com';
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
            ];

            $subject = 'Shahzad Labs Inbox Test - ' . now()->format('H:i:s');
            $plain = "Hello,\n\nThis is a verified delivery test from Shahzad Labs to ensure emails land directly in your primary inbox.\n\nBest regards,\nShahzad Ali\nhttps://shahzadlabs.com";
            $html = "<html><body style='font-family: sans-serif; line-height: 1.6; color: #333;'><h2 style='color: #4f46e5;'>Shahzad Labs</h2><p>Hello,</p><p>This is a verified delivery test from <strong>Shahzad Labs</strong> to ensure inquiry replies reach your primary inbox without being marked as spam.</p><hr style='border: none; border-top: 1px solid #eee; margin: 20px 0;'><p style='font-size: 12px; color: #888;'>Shahzad Ali | <a href='https://shahzadlabs.com'>shahzadlabs.com</a></p></body></html>";

            $body  = "--" . $boundary . "\r\n";
            $body .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n\r\n";
            $body .= $plain . "\r\n\r\n";
            $body .= "--" . $boundary . "\r\n";
            $body .= "Content-Type: text/html; charset=\"UTF-8\"\r\n\r\n";
            $body .= $html . "\r\n\r\n";
            $body .= "--" . $boundary . "--\r\n";

            $sent = @mail($targetEmail, $subject, $body, implode("\r\n", $headers), '-f' . $fromAddr);

            if ($sent) {
                return response()->json([
                    'success' => true,
                    'message' => "Test email successfully delivered to {$targetEmail} via Hostinger Native Mail (hsendmail)!",
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Could not dispatch test email. Please verify server mail settings.',
        ], 500);
    }

    /**
     * Public Cron Endpoint for Hostinger Scheduled Cron Job & Diagnostic Verification.
     * Usage:
     *   curl https://shahzadlabs.com/cron/process-queue?token=shahzadlabs-queue-sync
     *   curl https://shahzadlabs.com/cron/process-queue?token=shahzadlabs-queue-sync&action=diagnose
     *   curl https://shahzadlabs.com/cron/process-queue?token=shahzadlabs-queue-sync&action=test_send&to=alikhore12@gmail.com
     */
    public function cronProcessQueue(Request $request)
    {
        $expectedToken = env('CRON_TOKEN', 'shahzadlabs-queue-sync');
        if ($request->query('token') !== $expectedToken) {
            return response()->json(['error' => 'Unauthorized cron token'], 403);
        }

        $action = $request->query('action', 'work');

        if ($action === 'diagnose') {
            $recentFailed = DB::table('failed_jobs')->latest('id')->take(3)->get();
            return response()->json([
                'status'           => 'diagnostics',
                'time'             => now()->toDateTimeString(),
                'mail_default'     => config('mail.default'),
                'smtp_host'        => config('mail.mailers.smtp.host'),
                'smtp_port'        => config('mail.mailers.smtp.port'),
                'smtp_username'    => config('mail.mailers.smtp.username'),
                'smtp_encryption'  => config('mail.mailers.smtp.encryption'),
                'mail_from'        => config('mail.from'),
                'queue_driver'     => config('queue.default'),
                'pending_jobs'     => DB::table('jobs')->count(),
                'failed_jobs_count'=> DB::table('failed_jobs')->count(),
                'recent_failed'    => $recentFailed,
                'php_mail_enabled' => function_exists('mail'),
                'sendmail_path'    => ini_get('sendmail_path'),
            ]);
        }

        if ($action === 'test_php_mail') {
            $to = $request->query('to', 'alikhore12@gmail.com');
            $fromName  = config('mail.from.name', 'Shahzad Ali');
            $fromAddr  = config('mail.from.address', 'info@shahzadlabs.com');
            $domain    = parse_url((string) config('app.url', 'https://shahzadlabs.com'), PHP_URL_HOST) ?: 'shahzadlabs.com';
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
            ];

            $subject = 'Shahzad Labs Inbox Delivery Test - ' . now()->format('H:i:s');
            $plain = "Hello,\n\nThis is a verified delivery test from Shahzad Ali at Shahzad Labs.\nSent at: " . now()->toDateTimeString() . "\n\nBest regards,\nShahzad Ali\nhttps://shahzadlabs.com";
            $html = "<html><body style='font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, sans-serif; line-height: 1.6; color: #1e293b; max-width: 600px; margin: 0 auto; padding: 24px; background: #f8fafc;'><div style='background: #ffffff; border-radius: 12px; padding: 32px; border: 1px solid #e2e8f0;'><h2 style='color: #4f46e5; margin-top: 0;'>Shahzad Labs</h2><p>Hello,</p><p>This is a verified inquiry reply test sent directly from <strong>Shahzad Labs</strong> to verify inbox delivery.</p><div style='background: #f1f5f9; padding: 16px; border-radius: 8px; margin: 20px 0;'><p style='margin: 0; font-size: 13px; color: #475569;'><strong>Status:</strong> Authenticated message with aligned envelope headers.</p></div><p>Best regards,<br><strong>Shahzad Ali</strong><br><a href='https://shahzadlabs.com' style='color: #4f46e5; text-decoration: none;'>shahzadlabs.com</a></p></div></body></html>";

            $body  = "--" . $boundary . "\r\n";
            $body .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n\r\n";
            $body .= $plain . "\r\n\r\n";
            $body .= "--" . $boundary . "\r\n";
            $body .= "Content-Type: text/html; charset=\"UTF-8\"\r\n\r\n";
            $body .= $html . "\r\n\r\n";
            $body .= "--" . $boundary . "--\r\n";

            $sent = @mail($to, $subject, $body, implode("\r\n", $headers), '-f' . $fromAddr);

            return response()->json([
                'status'     => $sent ? 'success' : 'failed',
                'sent'       => $sent,
                'to'         => $to,
                'from'       => $fromAddr,
                'message_id' => $messageId,
                'envelope'   => '-f' . $fromAddr,
                'last_error' => error_get_last(),
            ]);
        }

        try {
            Artisan::call('queue:work', [
                '--stop-when-empty' => true,
                '--max-jobs'        => 30,
                '--tries'           => 3,
                '--timeout'         => 45,
            ]);

            $pending = DB::table('jobs')->count();
            $failed  = DB::table('failed_jobs')->count();

            return response()->json([
                'status'  => 'success',
                'time'    => now()->toDateTimeString(),
                'pending' => $pending,
                'failed'  => $failed,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a message.
     */
    public function destroyMessage(Message $message)
    {
        $message->delete();

        return redirect()->route('admin.messages')
            ->with('success', 'Message deleted successfully.');
    }
}
