@extends('admin.layout')
@section('title', 'Messages Inbox')

@section('content')
    <div class="space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2">
            <div>
                <h1 class="font-display text-2xl font-bold text-white tracking-tight">Messages Inbox</h1>
                <p class="mt-1 text-sm text-surface-200/50">Contact form inquiries from visitors with direct reply capabilities.</p>
            </div>

            {{-- Summary Badge --}}
            <div class="flex items-center gap-3">
                <span class="text-xs px-3.5 py-1.5 rounded-full bg-white/[0.05] border border-white/[0.08] text-surface-200/70 whitespace-nowrap">
                    Total Inquiries: <strong class="text-white font-semibold">{{ $messages->total() }}</strong>
                </span>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════
             MESSAGES TABLE (FULL WIDTH & HORIZONTALLY SCROLLABLE)
        ═══════════════════════════════════════════════════════════ --}}
        <div class="glass-card overflow-hidden w-full max-w-full border border-white/[0.08]">
            <div class="overflow-x-auto scrollbar-thin w-full max-w-full block">
                <table class="w-full text-left border-collapse min-w-[880px] table-fixed">
                    <colgroup>
                        <col class="w-[12%]">
                        <col class="w-[22%]">
                        <col class="w-[36%]">
                        <col class="w-[12%]">
                        <col class="w-[18%]">
                    </colgroup>
                    <thead>
                        <tr class="border-b border-white/[0.08] bg-white/[0.02]">
                            <th scope="col" class="py-4 px-5 text-xs font-semibold uppercase tracking-wider text-surface-200/50">Status</th>
                            <th scope="col" class="py-4 px-4 text-xs font-semibold uppercase tracking-wider text-surface-200/50">From</th>
                            <th scope="col" class="py-4 px-4 text-xs font-semibold uppercase tracking-wider text-surface-200/50">Subject &amp; Inquiry</th>
                            <th scope="col" class="py-4 px-4 text-xs font-semibold uppercase tracking-wider text-surface-200/50">Received</th>
                            <th scope="col" class="py-4 px-5 text-right text-xs font-semibold uppercase tracking-wider text-surface-200/50">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/[0.04]">
                        @forelse($messages as $msg)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            {{-- Status Badge --}}
                            <td class="py-4 px-5 align-middle whitespace-nowrap">
                                @if($msg->is_replied)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 shadow-sm whitespace-nowrap">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        Replied
                                    </span>
                                @elseif(!$msg->is_read)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 shadow-sm whitespace-nowrap">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-400 animate-ping"></span>
                                        New
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-white/[0.04] text-surface-200/60 border border-white/[0.08] whitespace-nowrap">
                                        Read
                                    </span>
                                @endif
                            </td>

                            {{-- Sender Info --}}
                            <td class="py-4 px-4 align-middle">
                                <div class="min-w-0 max-w-full">
                                    <p class="text-sm font-semibold {{ $msg->is_read ? 'text-surface-200/80' : 'text-white' }} truncate" title="{{ $msg->name }}">{{ $msg->name }}</p>
                                    <a href="mailto:{{ $msg->email }}" class="text-xs text-brand-400/80 hover:text-brand-300 font-mono transition-colors block truncate mt-0.5" title="{{ $msg->email }}">{{ $msg->email }}</a>
                                </div>
                            </td>

                            {{-- Subject & Inquiry Snippet --}}
                            <td class="py-4 px-4 align-middle">
                                <div class="min-w-0 max-w-full">
                                    <a href="{{ route('admin.messages.show', $msg) }}" class="text-sm font-semibold {{ $msg->is_read ? 'text-surface-200/90' : 'text-white' }} hover:text-brand-300 transition-colors block truncate" title="{{ $msg->subject }}">
                                        {{ $msg->subject }}
                                    </a>
                                    <p class="text-xs text-surface-200/50 truncate mt-1 leading-relaxed" title="{{ $msg->message }}">
                                        {{ $msg->message }}
                                    </p>
                                </div>
                            </td>

                            {{-- Received Date --}}
                            <td class="py-4 px-4 align-middle text-xs text-surface-200/50 whitespace-nowrap">
                                <div class="font-medium text-surface-200/70 truncate">{{ $msg->created_at->format('M d, Y') }}</div>
                                <div class="text-[11px] text-surface-200/40 mt-0.5 truncate">{{ $msg->created_at->diffForHumans() }}</div>
                            </td>

                            {{-- Action Buttons --}}
                            <td class="py-4 px-5 align-middle text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5 whitespace-nowrap">
                                    {{-- Open Message & Direct Reply --}}
                                    <a href="{{ route('admin.messages.show', $msg) }}"
                                       class="btn-primary !text-xs !py-1.5 !px-2.5 inline-flex items-center gap-1 shadow-sm whitespace-nowrap shrink-0"
                                       title="View Message and Reply">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                        </svg>
                                        <span>Reply</span>
                                    </a>

                                    {{-- 1-Click Gmail --}}
                                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ urlencode($msg->email) }}&su={{ urlencode('Re: ' . $msg->subject) }}"
                                       target="_blank" rel="noopener"
                                       class="inline-flex items-center justify-center gap-1 px-2 py-1.5 rounded-lg text-xs font-medium text-red-400 hover:text-red-300 border border-red-500/25 hover:bg-red-500/10 transition-colors whitespace-nowrap shrink-0"
                                       title="Open in Gmail Web">
                                        <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                        <span class="hidden xl:inline">Gmail</span>
                                    </a>

                                    {{-- Delete Button --}}
                                    <form method="POST" action="{{ route('admin.messages.destroy', $msg) }}" class="inline" onsubmit="return confirm('Permanently delete this message?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 text-surface-200/40 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors inline-flex items-center justify-center shrink-0" title="Delete Inquiry">
                                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-16 px-6 text-center text-sm text-surface-200/40">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-8 h-8 text-surface-200/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                    <span>No messages received yet.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($messages->hasPages())
            <div class="border-t border-white/[0.08] px-6 py-4">
                {{ $messages->links() }}
            </div>
            @endif
        </div>

    </div>
@endsection
