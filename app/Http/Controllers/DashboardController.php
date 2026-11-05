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
                $mailError = 'Google SMTP authentication failed (BadCredentials). Google requires a 16-character App Password in .env.';
            } else {
                $mailError = 'Queue delivery issue: ' . Str::limit(strip_tags($recentFailed->exception), 140);
            }
        }

        $isSuccessful = empty($mailError);
        $successMsg = 'Direct reply queued and sent to ' . $message->email . ' successfully!';

        if (config('mail.default') === 'log') {
            $successMsg = 'Reply saved in history! NOTE: Server mailer is set to "log" mode, so email was recorded in storage/logs/laravel.log.';
        } elseif ($mailError) {
            $successMsg = 'Reply saved to history! Notice: ' . $mailError . ' (You can also click "Gmail" button above to send immediately via Gmail).';
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
     * Send a diagnostic test email to verify SMTP credentials directly.
     */
    public function testMail(Request $request)
    {
        $targetEmail = $request->input('email', config('mail.from.address') ?: 'alikhore12@gmail.com');

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
            $msg = $e->getMessage();
            if (str_contains($msg, '535') || str_contains($msg, 'BadCredentials')) {
                $msg = 'Google SMTP rejected password (535 BadCredentials). Please generate and enter a 16-digit Google App Password in .env.';
            }

            return response()->json([
                'success' => false,
                'message' => 'SMTP Diagnostic Error: ' . $msg,
            ], 422);
        }
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
            $subject = 'Shahzad Labs PHP mail() Test - ' . now()->format('H:i:s');
            $body = "This is a test email sent using PHP native mail() function on Hostinger at " . now()->toDateTimeString();
            $from = config('mail.from.address', 'info@shahzadlabs.com');
            $headers = [
                'From: ' . config('mail.from.name', 'Shahzad Labs') . ' <' . $from . '>',
                'Reply-To: alikhore12@gmail.com',
                'X-Mailer: PHP/' . phpversion(),
                'MIME-Version: 1.0',
                'Content-Type: text/plain; charset=UTF-8',
            ];

            $sent = @mail($to, $subject, $body, implode("\r\n", $headers));

            return response()->json([
                'status'     => $sent ? 'success' : 'failed',
                'sent'       => $sent,
                'to'         => $to,
                'from'       => $from,
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
