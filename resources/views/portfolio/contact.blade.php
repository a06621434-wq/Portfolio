@extends('layouts.public')
@section('title', 'Contact Us & Hire — Shahzad Labs')
@section('meta_description', 'Get in touch with the Shahzad Labs engineering team. Request a quote or discuss your next Laravel, MySQL, or full-stack web project.')

@section('content')
    {{-- Hero Header --}}
    <section class="relative pt-32 pb-16 overflow-hidden border-b border-white/[0.06]">
        <div class="absolute inset-0 bg-hero-pattern opacity-60"></div>
        <div class="absolute top-1/4 right-1/3 w-96 h-96 bg-brand-500/10 rounded-full blur-[140px]"></div>

        <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-brand-500/30 bg-brand-500/10 px-3.5 py-1.5 text-xs font-semibold text-brand-400 mb-6">
                    <span class="status-dot"></span>
                    <span>Accepting New Clients</span>
                </div>

                <h1 class="font-display text-4xl sm:text-5xl font-extrabold text-white tracking-tight">
                    Let's Build Something
                    <span class="bg-gradient-to-r from-brand-400 via-brand-500 to-accent-400 bg-clip-text text-transparent">
                        Exceptional
                    </span>
                </h1>
                <p class="mt-4 text-base sm:text-lg text-surface-200/60 leading-relaxed">
                    Have an idea for a web application, need an MVP engineered fast, or looking to scale your existing Laravel infrastructure? Send us a message and we'll respond within 24 hours.
                </p>
            </div>
        </div>
    </section>

    {{-- Contact Content Hub --}}
    <section class="py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-5">
                
                {{-- Form Column (3 cols) --}}
                <div class="lg:col-span-3">
                    <div class="glass-card p-8 sm:p-10">
                        <h2 class="font-display text-2xl font-bold text-white mb-2">Send an Inquiry</h2>
                        <p class="text-xs text-surface-200/50 mb-8">Fill out the form below and our lead engineer will get back to you with timeline and architectural feedback.</p>

                        <form id="contact-form" action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid gap-6 sm:grid-cols-2">
                                {{-- Name --}}
                                <div class="form-group">
                                    <label for="contact-name" class="block text-sm font-medium text-surface-200/70 mb-2">Your Name *</label>
                                    <input type="text" id="contact-name" name="name" required data-label="Name" maxlength="100"
                                           class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 backdrop-blur-sm transition-all focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20"
                                           placeholder="e.g., Alex Johnson">
                                    <p class="field-error mt-1.5 text-xs text-red-400" data-error="name"></p>
                                </div>

                                {{-- Email --}}
                                <div class="form-group">
                                    <label for="contact-email" class="block text-sm font-medium text-surface-200/70 mb-2">Work Email *</label>
                                    <input type="email" id="contact-email" name="email" required data-label="Email" maxlength="255"
                                           class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 backdrop-blur-sm transition-all focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20"
                                           placeholder="alex@company.com">
                                    <p class="field-error mt-1.5 text-xs text-red-400" data-error="email"></p>
                                </div>
                            </div>

                            {{-- Subject --}}
                            <div class="form-group">
                                <label for="contact-subject" class="block text-sm font-medium text-surface-200/70 mb-2">Project Subject / Type *</label>
                                <input type="text" id="contact-subject" name="subject" required data-label="Subject" maxlength="200"
                                       class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 backdrop-blur-sm transition-all focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20"
                                       placeholder="e.g., SaaS Platform Architecture, API Development, Custom Laravel MVP">
                                <p class="field-error mt-1.5 text-xs text-red-400" data-error="subject"></p>
                            </div>

                            {{-- Message --}}
                            <div class="form-group">
                                <label for="contact-message" class="block text-sm font-medium text-surface-200/70 mb-2">Project Details &amp; Timeline *</label>
                                <textarea id="contact-message" name="message" required data-label="Message" maxlength="5000" rows="5"
                                          class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 backdrop-blur-sm transition-all focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20 resize-none"
                                          placeholder="Tell us about the scope of the project, desired features, timeline constraints, and any technical preferences..."></textarea>
                                <p class="field-error mt-1.5 text-xs text-red-400" data-error="message"></p>
                            </div>

                            {{-- Submit Button --}}
                            <button type="submit" class="btn-primary w-full sm:w-auto !py-3.5 !px-8 !text-sm">
                                <span class="btn-text flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    Send Message Now
                                </span>
                                <span class="btn-loader hidden flex items-center gap-2">
                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Sending...
                                </span>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Information Sidebar (2 cols) --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Direct Contact Card --}}
                    <div class="glass-card p-6">
                        <div class="flex items-center gap-3 mb-4 pb-4 border-b border-white/[0.08]">
                            <div class="h-10 w-10 rounded-xl bg-brand-500/15 text-brand-400 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-display text-sm font-bold text-white">Direct Email</h3>
                                <p class="text-xs text-surface-200/40">Inquiries &amp; proposals</p>
                            </div>
                        </div>

                        <p class="text-xs text-surface-200/50 mb-3">Copy our engineering desk email address or click to compose:</p>
                        <div class="flex items-center gap-2">
                            <a href="mailto:info@shahzadlabs.com" class="text-xs font-mono text-brand-400 hover:text-brand-300 font-semibold truncate">info@shahzadlabs.com</a>
                            <button id="copy-email" class="ml-auto inline-flex items-center gap-1 rounded-lg border border-white/[0.08] bg-white/[0.03] px-2.5 py-1 text-[11px] text-surface-200/60 hover:text-white transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                <span>Copy</span>
                            </button>
                        </div>
                    </div>

                    {{-- Response Guarantee --}}
                    <div class="glass-card p-6">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="h-8 w-8 rounded-lg bg-accent-500/15 text-accent-400 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="font-display text-sm font-bold text-white">24-Hour Response</h3>
                        </div>
                        <p class="text-xs text-surface-200/50 leading-relaxed">
                            Every inquiry receives a direct architectural assessment from a senior full-stack developer within one business day.
                        </p>
                    </div>

                    {{-- Engagement Models --}}
                    <div class="glass-card p-6">
                        <h3 class="font-display text-sm font-bold text-white mb-3">Engagement Models</h3>
                        <ul class="space-y-2 text-xs text-surface-200/60">
                            <li class="flex items-center gap-2">&bull; <strong>Fixed-Scope MVP:</strong> Clear deliverables and milestone pricing.</li>
                            <li class="flex items-center gap-2">&bull; <strong>Dedicated Retainer:</strong> Ongoing feature development &amp; support.</li>
                            <li class="flex items-center gap-2">&bull; <strong>Architecture Consulting:</strong> Code &amp; database performance audit.</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
