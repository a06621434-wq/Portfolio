@extends('admin.layout')
@section('title', 'Inquiry: ' . $message->subject)

@section('content')
    {{-- Top Navigation & Status Bar --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 max-w-4xl mx-auto w-full min-w-0">
        <a href="{{ route('admin.messages') }}" class="inline-flex items-center gap-2 text-sm text-surface-200/60 hover:text-white transition-colors self-start">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Back to All Messages</span>
        </a>

        @if($message->is_replied)
            <span id="header-status-badge" class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-3.5 py-1 text-xs font-semibold text-emerald-400 border border-emerald-500/20 shadow-sm self-start sm:self-auto whitespace-nowrap">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Replied {{ $message->replied_at ? $message->replied_at->diffForHumans() : '' }}
            </span>
        @else
            <span id="header-status-badge" class="inline-flex items-center gap-1.5 rounded-full bg-amber-500/10 px-3.5 py-1 text-xs font-semibold text-amber-400 border border-amber-500/20 shadow-sm self-start sm:self-auto whitespace-nowrap">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                Awaiting Reply
            </span>
        @endif
    </div>

    {{-- Main Inquiry Card --}}
    <div class="glass-card p-4 sm:p-7 max-w-4xl mx-auto space-y-6 w-full min-w-0 overflow-hidden box-border">

        {{-- Header: Subject & Delete Action --}}
        <div class="flex flex-col sm:flex-row sm:items-start justify-between pb-6 border-b border-white/[0.08] gap-4 w-full min-w-0">
            <div class="min-w-0 flex-1">
                <span class="text-[11px] font-semibold uppercase tracking-wider text-brand-400">Inbound Inquiry #{{ $message->id }}</span>
                <h1 class="font-display text-xl sm:text-2xl font-bold text-white mt-1 leading-snug break-words" style="overflow-wrap: anywhere; word-break: break-word;">{{ $message->subject }}</h1>
                <p class="mt-1 text-xs text-surface-200/40">Received {{ $message->created_at->format('M d, Y \a\t h:i A') }} ({{ $message->created_at->diffForHumans() }})</p>
            </div>

            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Permanently delete this inquiry?');" class="self-start sm:self-auto shrink-0">
                @csrf @method('DELETE')
                <button type="submit" class="text-xs text-red-400/70 hover:text-red-400 transition-colors border border-red-500/20 rounded-lg px-3 py-1.5 hover:bg-red-500/10 whitespace-nowrap" title="Delete Message">
                    Delete Inquiry
                </button>
            </form>
        </div>

        {{-- Sender Information Badge --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 rounded-xl bg-white/[0.03] border border-white/[0.06] p-4 w-full min-w-0 overflow-hidden">
            <div class="flex items-center gap-3.5 min-w-0 flex-1">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-tr from-brand-500/20 to-accent-400/20 text-sm font-bold text-brand-300 border border-brand-500/30 shadow-sm">
                    {{ strtoupper(substr($message->name, 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-white truncate max-w-full">{{ $message->name }}</p>
                    <a href="mailto:{{ $message->email }}" class="text-xs font-mono text-brand-400 hover:text-brand-300 transition-colors break-all block max-w-full" style="overflow-wrap: anywhere; word-break: break-all;" title="{{ $message->email }}">
                        {{ $message->email }}
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-2 self-start sm:self-auto shrink-0 w-full sm:w-auto">
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ urlencode($message->email) }}&su={{ urlencode('Re: ' . $message->subject) }}"
                   target="_blank" rel="noopener"
                   class="text-xs text-red-400/90 hover:text-red-300 transition-colors flex items-center justify-center gap-1.5 rounded-lg px-3.5 py-2 bg-red-500/10 border border-red-500/20 hover:bg-red-500/20 w-full sm:w-auto whitespace-nowrap"
                   title="Open in Gmail">
                    <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    <span>Open in Gmail</span>
                </a>
            </div>
        </div>

        {{-- Message Content Body --}}
        <div class="pt-2 w-full min-w-0">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-surface-200/40 mb-2">Original Message Content:</h3>
            <div class="rounded-xl bg-surface-950/60 border border-white/[0.04] p-4 sm:p-5 text-sm text-surface-200/90 leading-relaxed whitespace-pre-wrap break-words font-sans select-text shadow-inner w-full max-w-full overflow-hidden box-border" style="overflow-wrap: anywhere; word-break: break-word;">
                {{ $message->message }}
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════
             REPLY COMPOSER FORM (OPEN & ACTIVE)
        ═══════════════════════════════════════════════════════════ --}}
        <div id="reply-composer-form" class="rounded-2xl border border-brand-500/30 bg-surface-900/95 p-4 sm:p-7 shadow-2xl space-y-5 w-full max-w-full overflow-hidden box-border">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-white/[0.08] w-full min-w-0">
                <div class="flex items-center gap-2">
                    <span class="flex h-2 w-2 rounded-full bg-brand-400 animate-ping"></span>
                    <h2 class="font-display text-sm font-bold text-white uppercase tracking-wider">
                        Compose Direct Reply
                    </h2>
                </div>
                <span class="text-[11px] text-surface-200/50 truncate">Replying to: <strong class="text-white">{{ $message->name }}</strong></span>
            </div>

            {{-- Dynamic Alert Notice (Appears upon sending) --}}
            <div id="reply-status-alert" class="hidden rounded-xl border px-4 py-3 text-xs flex items-center gap-2 w-full min-w-0"></div>

            {{-- Quick Templates --}}
            <div class="w-full min-w-0">
                <span class="block text-[11px] font-semibold text-surface-200/50 uppercase tracking-wider mb-2">Quick Insert Templates:</span>
                <div class="flex flex-wrap gap-2 w-full max-w-full">
                    <button type="button" onclick="setReplyTemplate('thanks')" class="text-xs rounded-lg px-3 py-1.5 bg-white/[0.04] hover:bg-brand-500/20 hover:text-brand-300 text-surface-200/70 border border-white/[0.06] transition-colors cursor-pointer max-w-full break-words">
                        + Thank You &amp; Discovery Call
                    </button>
                    <button type="button" onclick="setReplyTemplate('quote')" class="text-xs rounded-lg px-3 py-1.5 bg-white/[0.04] hover:bg-brand-500/20 hover:text-brand-300 text-surface-200/70 border border-white/[0.06] transition-colors cursor-pointer max-w-full break-words">
                        + Scope &amp; Quotation
                    </button>
                    <button type="button" onclick="setReplyTemplate('whatsapp')" class="text-xs rounded-lg px-3 py-1.5 bg-white/[0.04] hover:bg-emerald-500/20 hover:text-emerald-300 text-surface-200/70 border border-white/[0.06] transition-colors cursor-pointer max-w-full break-words">
                        + WhatsApp Direct
                    </button>
                </div>
            </div>

            <form id="reply-form" method="POST" action="{{ route('admin.messages.reply', $message) }}" class="space-y-4 w-full min-w-0">
                @csrf

                {{-- Recipient & Subject fields --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full min-w-0">
                    <div class="min-w-0">
                        <label class="block text-xs font-medium text-surface-200/60 mb-1">To (Recipient)</label>
                        <div class="rounded-xl border border-white/[0.08] bg-white/[0.02] px-3.5 py-2.5 text-xs text-white/90 font-mono truncate w-full min-w-0" title="{{ $message->name }} &lt;{{ $message->email }}&gt;">
                            {{ $message->name }} &lt;{{ $message->email }}&gt;
                        </div>
                    </div>

                    <div class="min-w-0">
                        <label for="reply-subject-input" class="block text-xs font-medium text-surface-200/60 mb-1">Email Subject *</label>
                        <input type="text" id="reply-subject-input" name="subject" required
                               value="Re: {{ $message->subject }}"
                               autocomplete="off"
                               class="w-full min-w-0 rounded-xl border border-white/[0.08] bg-white/[0.03] px-3.5 py-2.5 text-xs text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    </div>
                </div>

                {{-- Reply Message Body --}}
                <div class="w-full min-w-0">
                    <div class="flex items-center justify-between mb-1">
                        <label for="reply-body-input" class="block text-xs font-medium text-surface-200/60">Your Reply Message *</label>
                        <span id="char-counter" class="text-[11px] text-surface-200/40">0 characters</span>
                    </div>
                    <textarea id="reply-body-input" name="reply_body" required rows="7"
                              class="w-full min-w-0 rounded-xl border border-white/[0.08] bg-white/[0.03] p-3.5 text-xs text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20 font-sans leading-relaxed resize-y"
                              placeholder="Hi {{ $message->name }},&#10;&#10;Type your reply message here..."></textarea>
                </div>

                {{-- Action Buttons Row (Responsive Stack on Mobile, Flex Row on Desktop) --}}
                <div class="pt-4 border-t border-white/[0.08] flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 w-full min-w-0">
                    {{-- Primary Send Button --}}
                    <button type="submit" id="btn-submit-reply"
                            class="btn-primary !text-xs !py-3 !px-6 w-full sm:w-auto inline-flex items-center justify-center gap-2 shadow-lg shadow-brand-500/25 min-h-[44px] cursor-pointer shrink-0">
                        <svg id="btn-submit-icon" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                        </svg>
                        <span id="btn-submit-label" class="font-semibold whitespace-nowrap">Send Reply via Email</span>
                    </button>

                    {{-- Secondary Actions: Gmail, WhatsApp --}}
                    <div class="flex items-center gap-2 w-full sm:w-auto min-w-0">
                        {{-- 1-Click Open In Gmail --}}
                        <a id="btn-open-gmail"
                           href="https://mail.google.com/mail/?view=cm&fs=1&to={{ urlencode($message->email) }}&su={{ urlencode('Re: ' . $message->subject) }}"
                           target="_blank" rel="noopener"
                           class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 rounded-xl bg-red-500/15 hover:bg-red-500/25 text-red-300 border border-red-500/30 px-3.5 py-2.5 text-xs font-semibold transition-all min-h-[44px] whitespace-nowrap">
                            <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                            <span class="whitespace-nowrap">Gmail</span>
                        </a>

                        {{-- 1-Click WhatsApp with Typed Reply Message --}}
                        <a id="btn-open-whatsapp"
                           href="https://wa.me/923105447307?text={{ urlencode('Hi ' . $message->name . ', regarding your inquiry on Shahzad Labs: ' . $message->subject) }}"
                           target="_blank" rel="noopener"
                           class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-500/15 hover:bg-emerald-500/25 text-emerald-300 border border-emerald-500/30 px-3.5 py-2.5 text-xs font-semibold transition-all min-h-[44px] whitespace-nowrap">
                            <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span class="whitespace-nowrap">WhatsApp</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>

    </div>

    {{-- Sent Replies History Thread --}}
    <div id="replies-history-card" class="glass-card p-4 sm:p-7 max-w-4xl mx-auto mt-6 w-full min-w-0 overflow-hidden box-border {{ $message->replies->isEmpty() ? 'hidden' : '' }}">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-white/[0.08] w-full min-w-0">
            <h2 class="font-display text-sm font-bold text-white flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                <span>Sent Replies History (<span id="replies-count">{{ $message->replies->count() }}</span>)</span>
            </h2>
            <span class="text-[11px] text-surface-200/40 truncate">Delivered to {{ $message->email }}</span>
        </div>

        <div id="replies-container" class="space-y-4 w-full min-w-0">
            @foreach($message->replies as $reply)
            <div class="rounded-xl border border-emerald-500/20 bg-emerald-500/5 p-4 sm:p-4.5 space-y-2 w-full min-w-0 overflow-hidden box-border">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-xs w-full min-w-0">
                    <span class="font-semibold text-white flex items-center gap-1.5 truncate">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 shrink-0"></span>
                        <span class="truncate">Sent by {{ $reply->user?->name ?? 'Admin' }}</span>
                    </span>
                    <span class="text-surface-200/40 text-[11px] whitespace-nowrap">{{ $reply->created_at->format('M d, Y \a\t h:i A') }}</span>
                </div>
                <div class="text-xs font-medium text-emerald-300 break-words" style="overflow-wrap: anywhere; word-break: break-word;">
                    Subject: {{ $reply->subject }}
                </div>
                <div class="text-xs text-surface-200/80 whitespace-pre-wrap break-words leading-relaxed pt-2 border-t border-white/[0.04] font-sans" style="overflow-wrap: anywhere; word-break: break-word;">
                    {{ $reply->reply_body }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Interactive Logic for Templates, Char Counter, Live Links & Seamless Form Submission --}}
    <script>
        const recipientName = @json($message->name);
        const recipientEmail = @json($message->email);
        const originalSubject = @json($message->subject);

        function setReplyTemplate(type) {
            const textarea = document.getElementById('reply-body-input');
            if (!textarea) return;

            if (type === 'thanks') {
                textarea.value = `Hi ${recipientName},\n\nThank you for reaching out to Shahzad Labs! We have received your inquiry regarding "${originalSubject}".\n\nOur team would love to discuss your project requirements in detail. What is your preferred time for a quick discovery chat?\n\nBest regards,\nShahzad Ali\nshahzadlabs.com`;
            } else if (type === 'quote') {
                textarea.value = `Hi ${recipientName},\n\nThanks for contacting us! To provide you with an accurate scope and quotation for your project, could you please share a few more details regarding your target timeline and specific feature requirements?\n\nLooking forward to collaborating with you.\n\nBest regards,\nShahzad Ali\nshahzadlabs.com`;
            } else if (type === 'whatsapp') {
                textarea.value = `Hi ${recipientName},\n\nThank you for your message! You can also connect with me directly on WhatsApp at +92 310 5447307 for instant project coordination and discussions.\n\nBest regards,\nShahzad Ali\nshahzadlabs.com`;
            }

            updateCharCounter();
            updateExternalLinks();
            textarea.focus();
        }

        function updateCharCounter() {
            const textarea = document.getElementById('reply-body-input');
            const counter = document.getElementById('char-counter');
            if (textarea && counter) {
                counter.textContent = textarea.value.length + ' characters';
            }
        }

        function updateExternalLinks() {
            const textarea = document.getElementById('reply-body-input');
            const subjectInput = document.getElementById('reply-subject-input');
            const gmailBtn = document.getElementById('btn-open-gmail');
            const whatsappBtn = document.getElementById('btn-open-whatsapp');

            const subject = subjectInput ? subjectInput.value : ('Re: ' + originalSubject);
            const text = textarea ? textarea.value : '';

            if (gmailBtn) {
                gmailBtn.href = `https://mail.google.com/mail/?view=cm&fs=1&to=${encodeURIComponent(recipientEmail)}&su=${encodeURIComponent(subject)}&body=${encodeURIComponent(text)}`;
            }
            if (whatsappBtn) {
                whatsappBtn.href = `https://wa.me/923105447307?text=${encodeURIComponent('Hi ' + recipientName + ',\n\n' + text)}`;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('reply-form');
            const textarea = document.getElementById('reply-body-input');
            const subjectInput = document.getElementById('reply-subject-input');
            const submitBtn = document.getElementById('btn-submit-reply');
            const submitLabel = document.getElementById('btn-submit-label');
            const alertBox = document.getElementById('reply-status-alert');
            const repliesCard = document.getElementById('replies-history-card');
            const repliesContainer = document.getElementById('replies-container');
            const repliesCount = document.getElementById('replies-count');
            const statusBadge = document.getElementById('header-status-badge');

            if (textarea) {
                textarea.addEventListener('input', () => {
                    updateCharCounter();
                    updateExternalLinks();
                });
            }
            if (subjectInput) {
                subjectInput.addEventListener('input', updateExternalLinks);
            }

            // AJAX Form Submit with immediate response and seamless history append
            if (form) {
                form.addEventListener('submit', async function (e) {
                    e.preventDefault();

                    const replyBody = textarea ? textarea.value.trim() : '';
                    const subject = subjectInput ? subjectInput.value.trim() : '';

                    if (!replyBody || !subject) {
                        alert('Please fill in both the subject and reply message.');
                        return;
                    }

                    // Loading State
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                    submitLabel.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Sending Reply...
                    `;

                    try {
                        const formData = new FormData(form);
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            // Show success notice
                            alertBox.className = 'rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-xs text-emerald-300 flex items-center gap-2';
                            alertBox.innerHTML = `
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                <span>${data.message}</span>
                            `;
                            alertBox.classList.remove('hidden');

                            // Update Status badge at the top
                            if (statusBadge) {
                                statusBadge.className = 'inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-3.5 py-1 text-xs font-semibold text-emerald-400 border border-emerald-500/20 shadow-sm self-start sm:self-auto';
                                statusBadge.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Replied just now`;
                            }

                            // Append to replies history thread
                            if (data.reply && repliesContainer) {
                                const newReplyHtml = `
                                    <div class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4 sm:p-4.5 space-y-2 animate-fade-in w-full min-w-0 overflow-hidden box-border">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-xs w-full min-w-0">
                                            <span class="font-semibold text-white flex items-center gap-1.5 truncate">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 shrink-0"></span>
                                                <span class="truncate">Sent by ${data.reply.user_name} (Just now)</span>
                                            </span>
                                            <span class="text-surface-200/40 text-[11px] whitespace-nowrap">${data.reply.date}</span>
                                        </div>
                                        <div class="text-xs font-medium text-emerald-300 break-words" style="overflow-wrap: anywhere; word-break: break-word;">
                                            Subject: ${data.reply.subject}
                                        </div>
                                        <div class="text-xs text-surface-200/90 whitespace-pre-wrap break-words leading-relaxed pt-2 border-t border-white/[0.06] font-sans" style="overflow-wrap: anywhere; word-break: break-word;">
                                            ${data.reply.reply_body}
                                        </div>
                                    </div>
                                `;
                                repliesContainer.insertAdjacentHTML('afterbegin', newReplyHtml);
                                if (repliesCard) repliesCard.classList.remove('hidden');
                                if (repliesCount) {
                                    repliesCount.textContent = parseInt(repliesCount.textContent || 0, 10) + 1;
                                }
                            }

                            // Clear input
                            textarea.value = '';
                            updateCharCounter();
                        } else {
                            throw new Error(data.message || 'Server error occurred while sending reply.');
                        }
                    } catch (err) {
                        alertBox.className = 'rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-xs text-red-300 flex items-center gap-2';
                        alertBox.innerHTML = `
                            <svg class="w-4 h-4 text-red-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            <span>Error: ${err.message || 'Could not send reply. Please try Open in Gmail.'}</span>
                        `;
                        alertBox.classList.remove('hidden');
                    } finally {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                        submitLabel.textContent = 'Send Reply via Email';
                    }
                });
            }
        });
    </script>
@endsection
