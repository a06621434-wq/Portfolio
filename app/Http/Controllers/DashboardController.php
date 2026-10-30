<?php

namespace App\Http\Controllers;

use App\Mail\MessageReply;
use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Admin dashboard: overview metrics and inquiry management.
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
            'total_skills'        => Skill::count(),
            'total_messages'     => Message::count(),
            'unread_messages'    => Message::unread()->count(),
        ];

        $recentMessages = Message::with('replies')->latest()->take(6)->get();
        $recentProjects = Project::latest()->take(5)->get();
        $recentSkills   = Skill::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentMessages', 'recentProjects', 'recentSkills'));
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

        return view('admin.message-show', compact('message'));
    }

    /**
     * Send direct reply to a contact inquiry message.
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

        // 3. Dispatch Email notification to sender
        $mailError = null;
        try {
            $senderName = auth()->user()?->name ?: 'Shahzad Ali (Shahzad Labs)';
            Mail::to($message->email)->send(
                new MessageReply($message, $validated['subject'], $validated['reply_body'], $senderName)
            );
        } catch (\Throwable $e) {
            $mailError = $e->getMessage();
            Log::warning('Direct message reply mail failed: ' . $mailError);
        }

        $successMsg = 'Direct reply sent to ' . $message->email . ' successfully!';
        if ($mailError) {
            $successMsg .= ' (Reply saved to history; mail status: ' . $mailError . ')';
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $successMsg,
                'reply'   => [
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
     * Delete a message.
     */
    public function destroyMessage(Message $message)
    {
        $message->delete();

        return redirect()->route('admin.messages')
            ->with('success', 'Message deleted successfully.');
    }
}
