@extends('layouts.public')
@section('title', 'Services & Engineering Capabilities — Shahzad Labs')
@section('meta_description', 'End-to-end web engineering services: Custom Laravel applications, SaaS platforms, high-performance REST APIs, database architecture, and security hardening.')

@section('content')
    {{-- Hero Header --}}
    <section class="relative pt-32 pb-16 overflow-hidden border-b border-white/[0.06]">
        <div class="absolute inset-0 bg-hero-pattern opacity-60"></div>
        <div class="absolute top-1/4 left-1/3 w-96 h-96 bg-brand-500/10 rounded-full blur-[140px]"></div>

        <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-brand-500/30 bg-brand-500/10 px-3.5 py-1.5 text-xs font-semibold text-brand-400 mb-6">
                    <span class="status-dot"></span>
                    <span>What We Deliver</span>
                </div>

                <h1 class="font-display text-4xl sm:text-5xl font-extrabold text-white tracking-tight">
                    Custom Web Engineering &amp;
                    <span class="bg-gradient-to-r from-brand-400 via-brand-500 to-accent-400 bg-clip-text text-transparent">
                        Digital Solutions
                    </span>
                </h1>
                <p class="mt-4 text-base sm:text-lg text-surface-200/60 leading-relaxed">
                    From early-stage MVPs to mature enterprise web applications, we partner with founders and engineering leaders to design, build, and scale resilient software.
                </p>
            </div>
        </div>
    </section>

    {{-- Services Bento Grid --}}
    <section class="py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                
                {{-- Service 1 --}}
                <div class="glass-card p-8 flex flex-col justify-between group hover:border-brand-500/40 transition-all duration-300">
                    <div>
                        <div class="h-12 w-12 rounded-xl bg-brand-500/15 ring-1 ring-brand-500/30 text-brand-400 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/>
                            </svg>
                        </div>
                        <h2 class="font-display text-xl font-bold text-white group-hover:text-brand-300 transition-colors">Custom Web Applications</h2>
                        <p class="mt-3 text-sm text-surface-200/60 leading-relaxed">
                            Bespoke software built on Laravel's battle-tested MVC architecture. Multi-tenant SaaS platforms, internal business portals, and customer dashboards.
                        </p>
                        <ul class="mt-6 space-y-2.5 text-xs text-surface-200/50">
                            <li class="flex items-center gap-2">&bull; Multi-tenant SaaS architecture</li>
                            <li class="flex items-center gap-2">&bull; Role-based access control (RBAC)</li>
                            <li class="flex items-center gap-2">&bull; Stripe / PayPal subscription billing</li>
                            <li class="flex items-center gap-2">&bull; Real-time notifications &amp; events</li>
                        </ul>
                    </div>
                    <div class="mt-8 pt-4 border-t border-white/[0.06]">
                        <a href="{{ route('contact.index') }}" class="text-xs font-semibold text-brand-400 hover:text-brand-300 flex items-center gap-1">Request Quote &rarr;</a>
                    </div>
                </div>

                {{-- Service 2 --}}
                <div class="glass-card p-8 flex flex-col justify-between group hover:border-accent-500/40 transition-all duration-300">
                    <div>
                        <div class="h-12 w-12 rounded-xl bg-accent-500/15 ring-1 ring-accent-500/30 text-accent-400 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/>
                            </svg>
                        </div>
                        <h2 class="font-display text-xl font-bold text-white group-hover:text-accent-300 transition-colors">API Architecture &amp; Integration</h2>
                        <p class="mt-3 text-sm text-surface-200/60 leading-relaxed">
                            High-throughput RESTful APIs designed for mobile applications, third-party partners, and microservices with Sanctum or JWT authentication.
                        </p>
                        <ul class="mt-6 space-y-2.5 text-xs text-surface-200/50">
                            <li class="flex items-center gap-2">&bull; Semantic versioned endpoints</li>
                            <li class="flex items-center gap-2">&bull; Rate limiting &amp; throttling protection</li>
                            <li class="flex items-center gap-2">&bull; Interactive Swagger / OpenAPI docs</li>
                            <li class="flex items-center gap-2">&bull; Webhook listeners &amp; queue dispatch</li>
                        </ul>
                    </div>
                    <div class="mt-8 pt-4 border-t border-white/[0.06]">
                        <a href="{{ route('contact.index') }}" class="text-xs font-semibold text-accent-400 hover:text-accent-300 flex items-center gap-1">Request Quote &rarr;</a>
                    </div>
                </div>

                {{-- Service 3 --}}
                <div class="glass-card p-8 flex flex-col justify-between group hover:border-purple-500/40 transition-all duration-300">
                    <div>
                        <div class="h-12 w-12 rounded-xl bg-purple-500/15 ring-1 ring-purple-500/30 text-purple-400 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125v-3.75m16.5 3.75v3.75c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125v-3.75"/>
                            </svg>
                        </div>
                        <h2 class="font-display text-xl font-bold text-white group-hover:text-purple-300 transition-colors">Database Engineering &amp; Tuning</h2>
                        <p class="mt-3 text-sm text-surface-200/60 leading-relaxed">
                            Relational schema design, index strategy, slow query optimization, data normalization, and caching layers with Redis.
                        </p>
                        <ul class="mt-6 space-y-2.5 text-xs text-surface-200/50">
                            <li class="flex items-center gap-2">&bull; Schema migrations &amp; seeders</li>
                            <li class="flex items-center gap-2">&bull; Elimination of N+1 query traps</li>
                            <li class="flex items-center gap-2">&bull; Multi-table index optimization</li>
                            <li class="flex items-center gap-2">&bull; Automated backups &amp; recovery scripts</li>
                        </ul>
                    </div>
                    <div class="mt-8 pt-4 border-t border-white/[0.06]">
                        <a href="{{ route('contact.index') }}" class="text-xs font-semibold text-purple-400 hover:text-purple-300 flex items-center gap-1">Request Quote &rarr;</a>
                    </div>
                </div>

                {{-- Service 4 --}}
                <div class="glass-card p-8 flex flex-col justify-between group hover:border-amber-500/40 transition-all duration-300">
                    <div>
                        <div class="h-12 w-12 rounded-xl bg-amber-500/15 ring-1 ring-amber-500/30 text-amber-400 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/>
                            </svg>
                        </div>
                        <h2 class="font-display text-xl font-bold text-white group-hover:text-amber-300 transition-colors">UI/UX &amp; Modern Frontend</h2>
                        <p class="mt-3 text-sm text-surface-200/60 leading-relaxed">
                            Fluid, accessible, modern interfaces built with Tailwind CSS, ES6+ JavaScript, and micro-interactions that leave a lasting impression.
                        </p>
                        <ul class="mt-6 space-y-2.5 text-xs text-surface-200/50">
                            <li class="flex items-center gap-2">&bull; Dark/Light mode color palettes</li>
                            <li class="flex items-center gap-2">&bull; Mobile-first responsive layouts</li>
                            <li class="flex items-center gap-2">&bull; Micro-animations &amp; hover physics</li>
                            <li class="flex items-center gap-2">&bull; 95+ Core Web Vitals performance</li>
                        </ul>
                    </div>
                    <div class="mt-8 pt-4 border-t border-white/[0.06]">
                        <a href="{{ route('contact.index') }}" class="text-xs font-semibold text-amber-400 hover:text-amber-300 flex items-center gap-1">Request Quote &rarr;</a>
                    </div>
                </div>

                {{-- Service 5 --}}
                <div class="glass-card p-8 flex flex-col justify-between group hover:border-rose-500/40 transition-all duration-300">
                    <div>
                        <div class="h-12 w-12 rounded-xl bg-rose-500/15 ring-1 ring-rose-500/30 text-rose-400 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                            </svg>
                        </div>
                        <h2 class="font-display text-xl font-bold text-white group-hover:text-rose-300 transition-colors">Security Auditing &amp; Hardening</h2>
                        <p class="mt-3 text-sm text-surface-200/60 leading-relaxed">
                            Comprehensive code review, dependency vulnerability patching, authentication audits, and secure deployment configurations.
                        </p>
                        <ul class="mt-6 space-y-2.5 text-xs text-surface-200/50">
                            <li class="flex items-center gap-2">&bull; OWASP Top 10 mitigation</li>
                            <li class="flex items-center gap-2">&bull; Encrypted sessions &amp; credentials</li>
                            <li class="flex items-center gap-2">&bull; Strict CORS &amp; CSP headers</li>
                            <li class="flex items-center gap-2">&bull; Penetration &amp; sanitization checks</li>
                        </ul>
                    </div>
                    <div class="mt-8 pt-4 border-t border-white/[0.06]">
                        <a href="{{ route('contact.index') }}" class="text-xs font-semibold text-rose-400 hover:text-rose-300 flex items-center gap-1">Request Quote &rarr;</a>
                    </div>
                </div>

                {{-- Service 6 --}}
                <div class="glass-card p-8 flex flex-col justify-between group hover:border-emerald-500/40 transition-all duration-300">
                    <div>
                        <div class="h-12 w-12 rounded-xl bg-emerald-500/15 ring-1 ring-emerald-500/30 text-emerald-400 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.67 2.67 0 0021 17.25l-5.83-5.83M3 3l6.59 6.59m0 0L7.5 11.66 9 13.16l2.07-2.07m-1.48-1.5L12 8.25 15.75 12l-1.34 1.34"/>
                            </svg>
                        </div>
                        <h2 class="font-display text-xl font-bold text-white group-hover:text-emerald-300 transition-colors">Ongoing Maintenance &amp; SLAs</h2>
                        <p class="mt-3 text-sm text-surface-200/60 leading-relaxed">
                            Proactive uptime monitoring, automated patch deployment, server health management, and rapid incident response.
                        </p>
                        <ul class="mt-6 space-y-2.5 text-xs text-surface-200/50">
                            <li class="flex items-center gap-2">&bull; 24/7 server health monitoring</li>
                            <li class="flex items-center gap-2">&bull; Framework version upgrades</li>
                            <li class="flex items-center gap-2">&bull; Automated error logging &amp; alerting</li>
                            <li class="flex items-center gap-2">&bull; Priority support turnaround</li>
                        </ul>
                    </div>
                    <div class="mt-8 pt-4 border-t border-white/[0.06]">
                        <a href="{{ route('contact.index') }}" class="text-xs font-semibold text-emerald-400 hover:text-emerald-300 flex items-center gap-1">Request Quote &rarr;</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- 5-Step Process Roadmap --}}
    <section class="border-t border-white/[0.08] bg-surface-950/70 py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-semibold uppercase tracking-wider text-brand-400">Our Workflow</span>
                <h2 class="mt-2 font-display text-3xl font-bold text-white">How We Turn Ideas Into Production</h2>
                <p class="mt-3 text-sm text-surface-200/50">A structured 5-phase engineering methodology that delivers predictability and high quality.</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-5">
                <div class="glass-card p-6 relative">
                    <span class="text-3xl font-display font-extrabold text-brand-500/20">01</span>
                    <h3 class="mt-2 font-display text-base font-bold text-white">Discovery</h3>
                    <p class="mt-2 text-xs text-surface-200/50">Technical requirements scoping, user stories, architecture roadmap, and milestone definition.</p>
                </div>
                <div class="glass-card p-6 relative">
                    <span class="text-3xl font-display font-extrabold text-brand-500/20">02</span>
                    <h3 class="mt-2 font-display text-base font-bold text-white">Architecture</h3>
                    <p class="mt-2 text-xs text-surface-200/50">Database schema modeling, API contract design, UI component hierarchy, and security baseline.</p>
                </div>
                <div class="glass-card p-6 relative">
                    <span class="text-3xl font-display font-extrabold text-brand-500/20">03</span>
                    <h3 class="mt-2 font-display text-base font-bold text-white">Build &amp; Iterate</h3>
                    <p class="mt-2 text-xs text-surface-200/50">Sprint-based feature development, continuous integration, and frequent staging demos.</p>
                </div>
                <div class="glass-card p-6 relative">
                    <span class="text-3xl font-display font-extrabold text-brand-500/20">04</span>
                    <h3 class="mt-2 font-display text-base font-bold text-white">Testing</h3>
                    <p class="mt-2 text-xs text-surface-200/50">Unit testing, edge-case validation, cross-device responsiveness, and database query profiling.</p>
                </div>
                <div class="glass-card p-6 relative">
                    <span class="text-3xl font-display font-extrabold text-brand-500/20">05</span>
                    <h3 class="mt-2 font-display text-base font-bold text-white">Deploy &amp; Scale</h3>
                    <p class="mt-2 text-xs text-surface-200/50">Zero-downtime production deployment, SSL setup, automated backups, and handover training.</p>
                </div>
            </div>

            <div class="mt-16 text-center">
                <a href="{{ route('contact.index') }}" class="btn-primary !px-6 !py-3 !text-xs">Schedule a Project Consultation →</a>
            </div>
        </div>
    </section>
@endsection
