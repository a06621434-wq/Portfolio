@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')
<div x-data="{
    modalOpen: false,
    replyId: null,
    replyName: '',
    replyEmail: '',
    replySubject: '',
    replyOriginal: '',
    replyBody: '',
    replyAction: '',
    openReply(msg) {
        this.replyId = msg.id;
        this.replyName = msg.name;
        this.replyEmail = msg.email;
        this.replySubject = 'Re: ' + msg.subject;
        this.replyOriginal = msg.message;
        this.replyBody = 'Hi ' + msg.name + ',\n\nThank you for reaching out to Shahzad Labs regarding \"' + msg.subject + '\".\n\n';
        this.replyAction = '/admin/messages/' + msg.id + '/reply';
        this.modalOpen = true;
    }
}" @keydown.escape.window="modalOpen = false">

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="font-display text-2xl font-bold text-white tracking-tight">Dashboard Overview</h1>
        <p class="mt-1 text-sm text-surface-200/50">Welcome back to the Shahzad Labs control center. Here's a summary of your portfolio activity.</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid gap-4 grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 mb-8">
        {{-- Total Projects --}}
        <div class="glass-card p-5 group hover:border-brand-500/40 transition-colors">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-surface-200/50 uppercase tracking-wider">Projects</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-500/10 text-brand-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-6A1.125 1.125 0 012.25 11.625v-4.5z"/>
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-display font-bold text-white">{{ $stats['total_projects'] }}</p>
            <span class="text-[11px] text-surface-200/40">{{ $stats['featured_projects'] }} featured</span>
        </div>

        {{-- Total Skills --}}
        <div class="glass-card p-5 group hover:border-accent-500/40 transition-colors">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-surface-200/50 uppercase tracking-wider">Skills</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-accent-500/10 text-accent-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-display font-bold text-white">{{ $stats['total_skills'] }}</p>
            <span class="text-[11px] text-accent-400/80">Tech stack active</span>
        </div>

        {{-- Total Inquiries --}}
        <div class="glass-card p-5 group hover:border-purple-500/40 transition-colors">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-surface-200/50 uppercase tracking-wider">Messages</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-purple-500/10 text-purple-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-display font-bold text-white">{{ $stats['total_messages'] }}</p>
            <span class="text-[11px] text-surface-200/40">Inbound leads</span>
        </div>

        {{-- Unread Inquiries --}}
        <div class="glass-card p-5 group hover:border-amber-500/40 transition-colors">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-surface-200/50 uppercase tracking-wider">Unread</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-500/10 text-amber-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-display font-bold {{ $stats['unread_messages'] > 0 ? 'text-amber-400' : 'text-white' }}">{{ $stats['unread_messages'] }}</p>
            <span class="text-[11px] text-surface-200/40">Requires review</span>
        </div>

        {{-- System Health --}}
        <div class="glass-card p-5 group hover:border-emerald-500/40 transition-colors">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-surface-200/50 uppercase tracking-wider">Health</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-ping"></span>
                </div>
            </div>
            <p class="mt-3 text-3xl font-display font-bold text-emerald-400">100%</p>
            <span class="text-[11px] text-surface-200/40">App operational</span>
        </div>
    </div>

    {{-- Content Columns --}}
    <div class="grid gap-6 lg:grid-cols-3">
        
        {{-- Recent Projects (2 Columns on large) --}}
        <div class="glass-card p-6 lg:col-span-2">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-white/[0.08]">
                <div>
                    <h2 class="font-display text-lg font-bold text-white">Recent Projects</h2>
                    <p class="text-xs text-surface-200/40">Latest additions to your portfolio showcase</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.projects.create') }}" class="btn-primary !py-1.5 !px-3 !text-[11px]">+ Add</a>
                    <a href="{{ route('admin.projects.index') }}" class="text-xs text-brand-400 hover:text-brand-300">View All →</a>
                </div>
            </div>

            <div class="space-y-3">
                @forelse($recentProjects as $proj)
                <div class="flex items-center justify-between p-3 rounded-xl bg-white/[0.02] border border-white/[0.06] hover:border-white/[0.12] transition-colors">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="h-12 w-16 shrink-0 rounded-lg overflow-hidden bg-surface-900 border border-white/[0.08]">
                            <img src="{{ $proj->image_url }}" alt="{{ $proj->title }}" class="h-full w-full object-cover">
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-sm font-semibold text-white truncate">{{ $proj->title }}</h3>
                            <div class="flex items-center gap-2 text-xs text-surface-200/40 mt-0.5">
                                <span class="capitalize">{{ $proj->category }}</span>
                                <span>&bull;</span>
                                <span>{{ count($proj->tech_stack) }} tech tags</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($proj->is_featured)
                        <span class="hidden sm:inline-block text-[10px] font-semibold uppercase px-2 py-0.5 rounded-full bg-accent-500/10 text-accent-400 border border-accent-500/20">Featured</span>
                        @endif
                        <a href="{{ route('admin.projects.edit', $proj) }}" class="p-1.5 rounded-lg text-surface-200/50 hover:text-white hover:bg-white/[0.05] transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-sm text-surface-200/40 text-center py-6">No projects created yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Sidebar Column: Skills & Recent Messages --}}
        <div class="space-y-6">
            
            {{-- Skills Summary Widget --}}
            <div class="glass-card p-6">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-white/[0.08]">
                    <h2 class="font-display text-sm font-bold text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Top Skills
                    </h2>
                    <a href="{{ route('admin.skills.index') }}" class="text-xs text-brand-400 hover:text-brand-300">Manage →</a>
                </div>

                <div class="space-y-3">
                    @forelse($recentSkills as $sk)
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <span>{{ $sk->icon ?: '⚡' }}</span>
                            <span class="font-medium text-white">{{ $sk->name }}</span>
                        </div>
                        <span class="font-mono text-brand-400 font-semibold">{{ $sk->proficiency }}%</span>
                    </div>
                    <div class="h-1.5 w-full rounded-full bg-surface-900 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-brand-500 to-accent-400" style="width: {{ $sk->proficiency }}%;"></div>
                    </div>
                    @empty
                    <p class="text-xs text-surface-200/40 text-center py-4">No skills added yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Recent Messages Widget --}}
            <div class="glass-card p-6">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-white/[0.08]">
                    <h2 class="font-display text-sm font-bold text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Inquiries Inbox
                    </h2>
                    <a href="{{ route('admin.messages') }}" class="text-xs text-brand-400 hover:text-brand-300">View All →</a>
                </div>

                <div class="space-y-3">
                    @forelse($recentMessages as $msg)
                    <div class="p-3 rounded-xl bg-white/[0.02] border border-white/[0.06] hover:border-white/[0.12] transition-colors">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-1.5 min-w-0">
                                @if($msg->is_replied)
                                <span class="h-2 w-2 rounded-full bg-emerald-400 shrink-0" title="Replied"></span>
                                @elseif(!$msg->is_read)
                                <span class="h-2 w-2 rounded-full bg-amber-400 animate-ping shrink-0" title="New Message"></span>
                                @else
                                <span class="h-1.5 w-1.5 rounded-full bg-surface-600 shrink-0"></span>
                                @endif
                                <span class="text-xs font-semibold {{ $msg->is_read ? 'text-surface-200/80' : 'text-white' }} truncate">{{ $msg->name }}</span>
                            </div>
                            <span class="text-[10px] text-surface-200/40 shrink-0">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-xs text-surface-200/60 truncate mt-1">{{ $msg->subject }}</div>
                        <div class="flex items-center justify-between mt-2.5 pt-2 border-t border-white/[0.04]">
                            <a href="{{ route('admin.messages.show', $msg) }}" class="text-[11px] text-surface-200/50 hover:text-white transition-colors">
                                View details →
                            </a>
                            <button type="button" @click="openReply({{ Js::from($msg) }})"
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[11px] font-semibold bg-brand-500/15 hover:bg-brand-500/25 text-brand-300 border border-brand-500/30 transition-all">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                <span>Direct Reply</span>
                            </button>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-surface-200/40 text-center py-4">No messages received yet.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════════
         QUICK REPLY POPUP MODAL (ALPINE.JS)
    ═══════════════════════════════════════════════════════════ --}}
    <div x-show="modalOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
         style="display: none;">
        
        <div class="glass-card w-full max-w-xl p-6 sm:p-7 border border-white/[0.12] shadow-2xl relative"
             @click.outside="modalOpen = false">
            
            {{-- Modal Header --}}
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-white/[0.08]">
                <div class="flex items-center gap-2.5">
                    <div class="h-8 w-8 rounded-lg bg-brand-500/15 flex items-center justify-center text-brand-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-display text-base font-bold text-white">Direct Reply</h3>
                        <p class="text-xs text-surface-200/50">Replying to <span class="text-white font-medium" x-text="replyName"></span> (<span x-text="replyEmail" class="font-mono text-brand-400"></span>)</p>
                    </div>
                </div>
                <button type="button" @click="modalOpen = false" class="text-surface-200/50 hover:text-white p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Original Message Preview Snippet --}}
            <div class="mb-4 p-3 rounded-xl bg-surface-950/70 border border-white/[0.04]">
                <span class="text-[10px] uppercase tracking-wider font-semibold text-surface-200/40 block mb-1">Inquiry Snippet:</span>
                <p class="text-xs text-surface-200/70 italic line-clamp-3" x-text="replyOriginal"></p>
            </div>

            {{-- Direct Reply Form --}}
            <form :action="replyAction" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-medium text-surface-200/70 mb-1">Subject *</label>
                    <input type="text" name="subject" required x-model="replySubject"
                           class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-3.5 py-2.5 text-xs text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                </div>

                <div>
                    <label class="block text-xs font-medium text-surface-200/70 mb-1">Response Message *</label>
                    <textarea name="reply_body" required rows="6" x-model="replyBody"
                              class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-3.5 py-2.5 text-xs text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20 resize-none"
                              placeholder="Type your official reply message here..."></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2 text-xs text-surface-200/60 hover:text-white">Cancel</button>
                    <button type="submit" class="btn-primary !text-xs !py-2.5 !px-5 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                        </svg>
                        <span>Send Email Reply</span>
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
