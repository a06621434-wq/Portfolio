@extends('layouts.public')
@section('title', 'Shahzad Labs — Engineering Scalable Web Applications & Digital Experiences')
@section('meta_description', 'Shahzad Labs is a premier web engineering studio specializing in Laravel, PHP, MySQL, and modern JavaScript. We build high-performance web applications and scalable SaaS platforms.')

@section('content')
    {{-- ═══════════════════════════════════════════════════════════
         HERO SECTION
    ═══════════════════════════════════════════════════════════ --}}
    <section id="overview" class="relative min-h-[85vh] lg:min-h-[90vh] flex items-center overflow-hidden pt-24 pb-14 lg:pt-28 lg:pb-18 bg-surface-950">
        {{-- Brand Hero Background Pattern & Ambient Glows --}}
        <div class="absolute inset-0 bg-hero-pattern opacity-80 pointer-events-none"></div>
        <div class="absolute top-1/4 left-1/12 w-[30rem] h-[30rem] bg-brand-500/15 rounded-full blur-[140px] pointer-events-none animate-pulse-slow"></div>
        <div class="absolute bottom-1/4 right-1/12 w-[28rem] h-[28rem] bg-accent-500/12 rounded-full blur-[130px] pointer-events-none animate-float"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full">
            {{-- STRICT 2-Column Split Grid (Side-by-Side on md: and lg: screens, Stacked on Mobile) --}}
            <div class="grid grid-cols-1 md:grid-cols-12 lg:grid-cols-12 gap-8 lg:gap-12 items-center py-6 sm:py-8 lg:py-12">
                
                {{-- ═══════════════════════════════════════════════════════
                     LEFT COLUMN: BRAND & PROFILE DETAILS (md:col-span-7)
                ═══════════════════════════════════════════════════════ --}}
                <div class="md:col-span-7 lg:col-span-7 flex flex-col justify-center text-left">
                    
                    {{-- Status Badge (Aligned Left) --}}
                    <div class="mb-5 animate-fade-in self-start">
                        <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-accent-500/10 border border-accent-500/30 text-xs font-semibold text-accent-400 shadow-sm backdrop-blur-md">
                            <span class="status-dot"></span>
                            <span>Available for Full-Stack &amp; Web Engineering Projects</span>
                        </div>
                    </div>

                    {{-- Main Title / Brand Name (H1) --}}
                    <h1 class="font-display text-4xl sm:text-5xl md:text-5xl lg:text-6xl xl:text-7xl font-extrabold tracking-tight text-white leading-tight animate-slide-up" style="animation-delay: 0.1s;">
                        Shahzad<span class="text-brand-400">Labs</span>
                    </h1>

                    {{-- Professional Role / Studio Title (H2) in Brand Gradient --}}
                    <h2 class="mt-2 text-lg sm:text-xl md:text-2xl font-bold tracking-tight bg-gradient-to-r from-brand-400 via-indigo-300 to-accent-400 bg-clip-text text-transparent animate-slide-up" style="animation-delay: 0.2s;">
                        Full-Stack Web Engineering &amp; Cloud Solutions Studio
                    </h2>

                    {{-- Specialization Pill / Project Theme Sub-headline --}}
                    <div class="mt-3.5 inline-flex items-center gap-2 text-xs sm:text-sm font-medium text-brand-300 bg-brand-500/10 border border-brand-500/25 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl self-start backdrop-blur-sm animate-slide-up" style="animation-delay: 0.3s;">
                        <svg class="w-4 h-4 text-brand-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                        </svg>
                        <span>Building Scalable Web Applications • High-Performance SaaS • Custom APIs</span>
                    </div>

                    {{-- Bio Quote Text Aligned with Project Scope --}}
                    <p class="mt-5 max-w-xl text-sm sm:text-base md:text-lg text-surface-200/70 leading-relaxed font-normal animate-slide-up" style="animation-delay: 0.4s;">
                        &ldquo;We architect and build modern, resilient, and user-focused digital solutions using PHP, Laravel, MySQL, JavaScript (ES6+), RESTful APIs, and scalable cloud architectures.&rdquo;
                    </p>

                    {{-- Action Buttons (CTAs) in Clean Horizontal Flex Row --}}
                    <div class="mt-7 flex flex-row flex-wrap items-center gap-3.5 sm:gap-4 animate-slide-up" style="animation-delay: 0.5s;">
                        {{-- Button 1 (Primary Solid): Explore Projects Portfolio --}}
                        <a href="#projects" class="btn-primary group !py-3 sm:!py-3.5 !px-6 sm:!px-7 !text-xs sm:!text-sm flex items-center gap-2 shadow-lg shadow-brand-500/25 hover:shadow-brand-500/40">
                            <span>Explore Projects Portfolio</span>
                            <span class="text-base leading-none font-sans group-hover:translate-x-0.5 transition-transform">&nearr;</span>
                        </a>

                        {{-- Button 2 (Secondary Outlined): Let's Work Together / Consultation --}}
                        <a href="#contact" class="btn-outline !py-3 sm:!py-3.5 !px-6 sm:!px-7 !text-xs sm:!text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                            <span>Let&rsquo;s Work Together</span>
                        </a>
                    </div>

                    {{-- Verified Profiles Footer --}}
                    <div class="mt-8 sm:mt-10 pt-6 sm:pt-7 border-t border-white/[0.08] flex items-center gap-4 animate-slide-up" style="animation-delay: 0.6s;">
                        <span class="text-xs font-bold uppercase tracking-wider text-surface-200/50">VERIFIED PROFILES:</span>
                        <div class="flex items-center gap-2.5">
                            {{-- WhatsApp Direct Chat Link --}}
                            <a href="https://wa.me/923105447307?text={{ urlencode('Hello Shahzad! I visited your portfolio (shahzadlabs.com) and would like to discuss a project with you.') }}" target="_blank" rel="noopener" class="h-9 w-9 rounded-full bg-surface-900 border border-white/[0.1] flex items-center justify-center text-emerald-400 hover:text-white hover:border-emerald-500/50 hover:bg-emerald-500/20 shadow-sm transition-all duration-200" title="Chat on WhatsApp (+92 310 5447307)">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            </a>
                            {{-- LinkedIn Icon Link --}}
                            <a href="https://www.linkedin.com/in/shahzad-ali-b2a0063a9" target="_blank" rel="noopener" class="h-9 w-9 rounded-full bg-surface-900 border border-white/[0.1] flex items-center justify-center text-surface-200 hover:text-white hover:border-brand-500/50 hover:bg-brand-500/10 shadow-sm transition-all duration-200" title="Shahzad Ali on LinkedIn">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m1.4 9.74v-8.37H5.06v8.37h2.8z"/></svg>
                            </a>
                        </div>
                    </div>

                </div>

                {{-- ═══════════════════════════════════════════════════════
                     RIGHT COLUMN: CIRCULAR PORTRAIT & BRAND BADGES (md:col-span-5)
                ═══════════════════════════════════════════════════════ --}}
                <div class="md:col-span-5 lg:col-span-5 flex justify-center md:justify-end lg:justify-end items-center animate-slide-up" style="animation-delay: 0.35s;">
                    
                    {{-- Ambient Brand Glow --}}
                    <div class="absolute w-72 h-72 sm:w-88 sm:h-88 rounded-full bg-brand-500/20 blur-3xl opacity-80 animate-pulse-slow pointer-events-none"></div>

                    {{-- Circular Portrait Frame Container --}}
                    <div class="relative w-full max-w-[280px] sm:max-w-xs md:max-w-sm lg:max-w-[360px] aspect-square group">
                        
                        {{-- Outer Glowing Brand Ring (Indigo to Emerald/Cyan Gradient) --}}
                        <div class="relative w-full h-full p-2.5 sm:p-3 rounded-full bg-gradient-to-tr from-brand-500 via-indigo-500 to-accent-400 border border-brand-500/40 shadow-[0_0_60px_rgba(99,102,241,0.35)] transition-all duration-500 group-hover:shadow-[0_0_80px_rgba(99,102,241,0.55)]">
                            
                            {{-- Inner Dark Circle Spacer --}}
                            <div class="w-full h-full p-1.5 sm:p-2 rounded-full bg-surface-950">
                                
                                {{-- Large Clean Circular Crop Container --}}
                                <div class="w-full h-full rounded-full overflow-hidden bg-surface-900 relative shadow-inner">
                                    <img src="{{ $siteSettings['hero_image_url'] }}"
                                         alt="{{ $siteSettings['developer_name'] }}"
                                         onerror="this.onerror=null;this.src='{{ asset('images/shahzad-ali.png') }}';"
                                         class="w-full h-full object-cover rounded-full group-hover:scale-105 transition-transform duration-700 ease-out">
                                </div>

                            </div>
                        </div>

                        {{-- Floating Tech Badge 1 (Bottom-Left): PHP & Laravel --}}
                        <div class="absolute bottom-2 -left-2 sm:bottom-4 sm:-left-3 inline-flex items-center gap-2 px-3 sm:px-3.5 py-1.5 rounded-full bg-surface-950/95 backdrop-blur-xl border border-brand-500/40 text-[11px] sm:text-xs font-semibold text-brand-300 shadow-2xl z-10">
                            <span class="w-2 h-2 rounded-full bg-red-400"></span>
                            <span>PHP &amp; Laravel</span>
                        </div>

                        {{-- Floating Tech Badge 2 (Bottom-Right): MySQL & APIs --}}
                        <div class="absolute bottom-2 -right-2 sm:bottom-4 sm:-right-3 inline-flex items-center gap-2 px-3 sm:px-3.5 py-1.5 rounded-full bg-surface-950/95 backdrop-blur-xl border border-accent-500/40 text-[11px] sm:text-xs font-semibold text-accent-300 shadow-2xl z-10">
                            <span class="w-2 h-2 rounded-full bg-sky-400"></span>
                            <span>MySQL &amp; APIs</span>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         STATS / METRICS ROW
    ═══════════════════════════════════════════════════════════ --}}
    <section class="relative border-y border-white/[0.08] bg-surface-950/60 py-14">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-6 lg:grid-cols-4">
                <div class="glass-card p-6 text-center reveal">
                    <div class="text-3xl font-display font-extrabold text-white sm:text-4xl">
                        <span data-counter="50" data-suffix="+">0</span>
                    </div>
                    <p class="mt-1.5 text-xs sm:text-sm text-surface-200/50 font-medium">Projects Delivered</p>
                    <div class="mt-3 h-1 w-12 mx-auto rounded-full bg-gradient-to-r from-brand-500 to-brand-400"></div>
                </div>

                <div class="glass-card p-6 text-center reveal">
                    <div class="text-3xl font-display font-extrabold text-accent-400 sm:text-4xl">
                        <span data-counter="98" data-suffix="%">0</span>
                    </div>
                    <p class="mt-1.5 text-xs sm:text-sm text-surface-200/50 font-medium">Client Satisfaction</p>
                    <div class="mt-3 h-1 w-12 mx-auto rounded-full bg-gradient-to-r from-accent-500 to-accent-400"></div>
                </div>

                <div class="glass-card p-6 text-center reveal">
                    <div class="text-3xl font-display font-extrabold text-brand-400 sm:text-4xl">
                        <span data-counter="16" data-suffix="+">0</span>
                    </div>
                    <p class="mt-1.5 text-xs sm:text-sm text-surface-200/50 font-medium">Core Stack Technologies</p>
                    <div class="mt-3 h-1 w-12 mx-auto rounded-full bg-gradient-to-r from-brand-400 to-accent-400"></div>
                </div>

                <div class="glass-card p-6 text-center reveal">
                    <div class="text-3xl font-display font-extrabold text-emerald-400 sm:text-4xl">
                        <span data-counter="99" data-suffix=".9%">0</span>
                    </div>
                    <p class="mt-1.5 text-xs sm:text-sm text-surface-200/50 font-medium">Uptime Guarantee</p>
                    <div class="mt-3 h-1 w-12 mx-auto rounded-full bg-gradient-to-r from-accent-400 to-brand-500"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         FEATURED PROJECTS SHOWCASE (WITH REAL IMAGES)
    ═══════════════════════════════════════════════════════════ --}}
    <section id="projects" class="relative py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 reveal">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full bg-brand-500/10 px-3.5 py-1 text-xs font-semibold uppercase tracking-wider text-brand-400 ring-1 ring-inset ring-brand-500/20">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-6A1.125 1.125 0 012.25 11.625v-4.5z"/>
                        </svg>
                        Portfolio Showcase
                    </span>
                    <h2 class="mt-3 section-heading">Featured Projects</h2>
                    <p class="section-subheading">A selection of recent applications engineered for scale, responsiveness, and performance.</p>
                </div>
                <a href="{{ route('projects.index') }}" class="btn-outline !py-2.5 !px-4 !text-xs self-start sm:self-auto flex items-center gap-2 shrink-0">
                    <span>View All Projects ({{ $projects->count() }})</span>
                    <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            {{-- Filter Buttons --}}
            <div class="mt-10 flex flex-wrap gap-2 reveal">
                <button data-filter="all" class="filter-btn active">All Projects</button>
                <button data-filter="laravel" class="filter-btn">Laravel / PHP</button>
                <button data-filter="fullstack" class="filter-btn">Full-Stack</button>
                <button data-filter="saas" class="filter-btn">SaaS WebApps</button>
                <button data-filter="frontend" class="filter-btn">Frontend</button>
            </div>

            {{-- Project Grid with Real Thumbnails --}}
            <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($projects as $project)
                <article data-category="{{ $project->category }}" class="glass-card group flex flex-col overflow-hidden hover:border-brand-500/40 transition-all duration-300 hover:-translate-y-1 reveal">
                    {{-- Real Project Thumbnail Image --}}
                    <a href="{{ route('projects.show', $project->slug) }}" class="relative aspect-[16/10] overflow-hidden bg-surface-900 block">
                        <img src="{{ $project->image_url }}" alt="{{ $project->title }}"
                             onerror="this.onerror=null;this.src='{{ asset('images/project-placeholder.svg') }}';"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex rounded-lg bg-surface-950/80 backdrop-blur-md px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wider text-surface-200/90 ring-1 ring-white/[0.1]">
                                {{ $project->category }}
                            </span>
                        </div>

                        @if($project->is_featured)
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center gap-1 rounded-lg bg-brand-500/90 backdrop-blur-md px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider text-white shadow">
                                ★ Featured
                            </span>
                        </div>
                        @endif
                    </a>

                    {{-- Content --}}
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="font-display text-lg font-bold text-white group-hover:text-brand-300 transition-colors">
                            <a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a>
                        </h3>
                        
                        <p class="mt-2 text-sm text-surface-200/50 leading-relaxed line-clamp-2">
                            {{ $project->description }}
                        </p>

                        {{-- Tech Badges --}}
                        <div class="mt-4 flex flex-wrap gap-1.5">
                            @foreach($project->tech_stack as $tech)
                            <span class="tech-badge !text-[10px] !px-2 !py-0.5">{{ $tech }}</span>
                            @endforeach
                        </div>

                        {{-- Metric --}}
                        @if($project->metric)
                        <div class="mt-4 flex items-center gap-2 text-xs font-semibold text-accent-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            <span>{{ $project->metric }}</span>
                        </div>
                        @endif

                        {{-- Card Footer --}}
                        <div class="mt-auto pt-5 border-t border-white/[0.06] flex items-center justify-between">
                            <a href="{{ route('projects.show', $project->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-400 hover:text-brand-300 transition-colors">
                                <span>Case Study</span>
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>

                            <div class="flex items-center gap-3">
                                @if($project->live_url)
                                <a href="{{ $project->live_url }}" target="_blank" rel="noopener" class="text-xs font-semibold text-brand-400 hover:text-brand-300 flex items-center gap-1.5 transition-colors" title="Live Preview">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    <span>Live Preview</span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
                @empty
                <div class="col-span-full">
                    <div class="glass-card p-12 sm:p-16 text-center max-w-2xl mx-auto border border-white/[0.08] shadow-2xl">
                        <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-500/10 text-brand-400 mb-5 ring-1 ring-brand-500/20">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-6A1.125 1.125 0 012.25 11.625v-4.5zM14.625 6A1.125 1.125 0 0013.5 7.125v10.5c0 .621.504 1.125 1.125 1.125h6c.621 0 1.125-.504 1.125-1.125V7.125C21.75 6.504 21.246 6 20.625 6h-6zM2.25 16.125c0-.621.504-1.125 1.125-1.125h6c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125h-6A1.125 1.125 0 012.25 17.625v-1.5z"/>
                            </svg>
                        </div>
                        <h3 class="font-display text-xl font-bold text-white tracking-tight">Featured Projects Coming Soon</h3>
                        <p class="mt-2 text-sm text-surface-200/60 leading-relaxed max-w-md mx-auto">
                            Production case studies and web applications are currently being curated for display. In the meantime, explore our technical competencies or reach out to discuss your project.
                        </p>
                        <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                            <a href="{{ route('skills.index') }}" class="btn-primary !text-xs flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                </svg>
                                <span>Explore Tech Stack &amp; Skills</span>
                            </a>
                            <a href="{{ route('contact.index') }}" class="btn-outline !text-xs flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span>Contact Shahzad Labs</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         TECH STACK (DYNAMIC FROM DATABASE)
    ═══════════════════════════════════════════════════════════ --}}
    <section id="stack" class="relative py-24 sm:py-32 border-t border-white/[0.08]">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 reveal">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full bg-accent-500/10 px-3.5 py-1 text-xs font-semibold uppercase tracking-wider text-accent-400 ring-1 ring-inset ring-accent-500/20">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                        Technology
                    </span>
                    <h2 class="mt-3 section-heading">Tech Stack &amp; Skills</h2>
                    <p class="section-subheading">Active production technologies powering our web engineering projects.</p>
                </div>
                <a href="{{ route('skills.index') }}" class="btn-outline !py-2.5 !px-4 !text-xs self-start sm:self-auto flex items-center gap-2 shrink-0">
                    <span>View All Skills &amp; Stack &rarr;</span>
                </a>
            </div>

            {{-- Interactive Dynamic Tabs --}}
            <div x-data="{ activeTab: 'backend' }" class="mt-12">
                <div class="flex flex-wrap gap-2 pb-6 border-b border-white/[0.08]">
                    <button @click="activeTab = 'backend'" :class="activeTab === 'backend' ? 'bg-brand-500/20 text-brand-300 ring-1 ring-brand-500/30 font-bold' : 'text-surface-200/60 hover:text-white hover:bg-white/[0.04]'" class="rounded-xl px-4 py-2 text-xs font-medium transition-all">
                        ⚙️ Backend &amp; APIs
                    </button>
                    <button @click="activeTab = 'frontend'" :class="activeTab === 'frontend' ? 'bg-brand-500/20 text-brand-300 ring-1 ring-brand-500/30 font-bold' : 'text-surface-200/60 hover:text-white hover:bg-white/[0.04]'" class="rounded-xl px-4 py-2 text-xs font-medium transition-all">
                        🎨 Frontend &amp; UI
                    </button>
                    <button @click="activeTab = 'database'" :class="activeTab === 'database' ? 'bg-brand-500/20 text-brand-300 ring-1 ring-brand-500/30 font-bold' : 'text-surface-200/60 hover:text-white hover:bg-white/[0.04]'" class="rounded-xl px-4 py-2 text-xs font-medium transition-all">
                        🗄️ Database &amp; Cache
                    </button>
                    <button @click="activeTab = 'devops'" :class="activeTab === 'devops' ? 'bg-brand-500/20 text-brand-300 ring-1 ring-brand-500/30 font-bold' : 'text-surface-200/60 hover:text-white hover:bg-white/[0.04]'" class="rounded-xl px-4 py-2 text-xs font-medium transition-all">
                        🚀 DevOps &amp; Tools
                    </button>
                </div>

                {{-- Tab Contents --}}
                <div class="mt-8">
                    @foreach(['backend', 'frontend', 'database', 'devops'] as $tabKey)
                    <div x-show="activeTab === '{{ $tabKey }}'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        @if(isset($skills[$tabKey]))
                            @foreach($skills[$tabKey] as $sk)
                            <div class="glass-card p-5 group hover:border-brand-500/40 transition-all">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-2xl">{{ $sk->icon ?: '⚡' }}</span>
                                    <span class="text-xs font-mono font-bold text-brand-400">{{ $sk->proficiency }}%</span>
                                </div>
                                <h3 class="font-display text-base font-bold text-white group-hover:text-brand-300 transition-colors">{{ $sk->name }}</h3>
                                <div class="mt-3 h-1.5 w-full rounded-full bg-surface-900 overflow-hidden ring-1 ring-white/[0.06]">
                                    <div class="h-full rounded-full bg-gradient-to-r from-brand-500 to-accent-400" style="width: {{ $sk->proficiency }}%;"></div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p class="text-xs text-surface-200/40 col-span-4 py-6">Skills in this category will display here.</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         SERVICES SUMMARY (Bento Grid)
    ═══════════════════════════════════════════════════════════ --}}
    <section id="services" class="relative py-24 sm:py-32 border-t border-white/[0.08]">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 reveal">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full bg-brand-500/10 px-3.5 py-1 text-xs font-semibold uppercase tracking-wider text-brand-400 ring-1 ring-inset ring-brand-500/20">
                        Capabilities
                    </span>
                    <h2 class="mt-3 section-heading">What We Deliver</h2>
                    <p class="section-subheading">End-to-end web engineering capabilities designed for performance and scale.</p>
                </div>
                <a href="{{ route('services.index') }}" class="btn-outline !py-2.5 !px-4 !text-xs self-start sm:self-auto flex items-center gap-2 shrink-0">
                    <span>View All Services &amp; Workflow &rarr;</span>
                </a>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="glass-card p-6">
                    <div class="h-10 w-10 rounded-xl bg-brand-500/15 text-brand-400 flex items-center justify-center font-bold mb-4">01</div>
                    <h3 class="font-display text-lg font-bold text-white">Custom Web Applications</h3>
                    <p class="mt-2 text-xs sm:text-sm text-surface-200/50 leading-relaxed">Full-stack Laravel platforms, SaaS architectures, and internal portals tailored to business logic.</p>
                </div>
                <div class="glass-card p-6">
                    <div class="h-10 w-10 rounded-xl bg-accent-500/15 text-accent-400 flex items-center justify-center font-bold mb-4">02</div>
                    <h3 class="font-display text-lg font-bold text-white">RESTful API Design</h3>
                    <p class="mt-2 text-xs sm:text-sm text-surface-200/50 leading-relaxed">High-performance endpoints, Sanctum tokens, rate limiting, and comprehensive Swagger documentation.</p>
                </div>
                <div class="glass-card p-6">
                    <div class="h-10 w-10 rounded-xl bg-purple-500/15 text-purple-400 flex items-center justify-center font-bold mb-4">03</div>
                    <h3 class="font-display text-lg font-bold text-white">Database Optimization</h3>
                    <p class="mt-2 text-xs sm:text-sm text-surface-200/50 leading-relaxed">MySQL schema design, indexing, elimination of N+1 queries, and automated backup strategies.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         CONTACT HUB
    ═══════════════════════════════════════════════════════════ --}}
    <section id="contact" class="relative py-24 sm:py-32 border-t border-white/[0.08]">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 reveal">
                <span class="inline-flex items-center gap-2 rounded-full bg-brand-500/10 px-3.5 py-1 text-xs font-semibold uppercase tracking-wider text-brand-400 ring-1 ring-inset ring-brand-500/20">
                    Contact Us
                </span>
                <h2 class="mt-3 section-heading">Let's Discuss Your Project</h2>
                <p class="section-subheading mx-auto">Fill in the form or reach out directly for a rapid architectural review.</p>
            </div>

            <div class="grid gap-10 lg:grid-cols-5">
                <div class="lg:col-span-3 glass-card p-8">
                    <form id="contact-form" action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="form-group">
                                <label for="contact-name" class="block text-xs font-medium text-surface-200/70 mb-2">Full Name *</label>
                                <input type="text" id="contact-name" name="name" required data-label="Name" maxlength="100"
                                       class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-1 focus:ring-brand-500/30"
                                       placeholder="John Doe">
                                <p class="field-error mt-1.5 text-xs text-red-400" data-error="name"></p>
                            </div>
                            <div class="form-group">
                                <label for="contact-email" class="block text-xs font-medium text-surface-200/70 mb-2">Email Address *</label>
                                <input type="email" id="contact-email" name="email" required data-label="Email" maxlength="255"
                                       class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-1 focus:ring-brand-500/30"
                                       placeholder="john@example.com">
                                <p class="field-error mt-1.5 text-xs text-red-400" data-error="email"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact-subject" class="block text-xs font-medium text-surface-200/70 mb-2">Subject *</label>
                            <input type="text" id="contact-subject" name="subject" required data-label="Subject" maxlength="200"
                                   class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-1 focus:ring-brand-500/30"
                                   placeholder="Project inquiry — e.g., Laravel SaaS Portal">
                            <p class="field-error mt-1.5 text-xs text-red-400" data-error="subject"></p>
                        </div>
                        <div class="form-group">
                            <label for="contact-message" class="block text-xs font-medium text-surface-200/70 mb-2">Message *</label>
                            <textarea id="contact-message" name="message" required data-label="Message" maxlength="5000" rows="4"
                                      class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-1 focus:ring-brand-500/30 resize-none"
                                      placeholder="Tell us about your project requirements, goals, and timeline..."></textarea>
                            <p class="field-error mt-1.5 text-xs text-red-400" data-error="message"></p>
                        </div>
                        <button type="submit" class="btn-primary w-full sm:w-auto !py-3 !px-6 !text-xs">
                            <span class="btn-text">Send Message Now</span>
                            <span class="btn-loader hidden">Sending...</span>
                        </button>
                    </form>
                </div>
                <div class="lg:col-span-2 space-y-6">
                    <div class="glass-card p-6 border-emerald-500/20 bg-emerald-500/5">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <h3 class="text-sm font-semibold text-white">Instant WhatsApp Chat</h3>
                        </div>
                        <p class="text-xs text-surface-200/60 mb-3">Prefer direct chat? Connect with Shahzad on WhatsApp:</p>
                        <a href="https://wa.me/923105447307?text={{ urlencode('Hello Shahzad! I visited your portfolio (shahzadlabs.com) and would like to discuss a project with you.') }}"
                           target="_blank" rel="noopener"
                           class="inline-flex items-center justify-center gap-2 w-full rounded-xl bg-emerald-500 hover:bg-emerald-400 text-surface-950 font-semibold px-4 py-2.5 text-xs shadow-lg shadow-emerald-500/20 transition-all">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span>Chat on WhatsApp (+92 310 5447307)</span>
                        </a>
                    </div>

                    <div class="glass-card p-6">
                        <h3 class="text-sm font-semibold text-white mb-2">Email Directly</h3>
                        <p class="text-xs text-surface-200/50 mb-3">Copy our email or write to us directly:</p>
                        <div class="flex items-center justify-between">
                            <a href="mailto:info@shahzadlabs.com" class="text-xs font-mono text-brand-400 hover:text-brand-300">info@shahzadlabs.com</a>
                            <button id="copy-email" class="text-[11px] px-2.5 py-1 rounded-md border border-white/[0.08] text-surface-200/60 hover:text-white">Copy</button>
                        </div>
                    </div>

                    <div class="glass-card p-6">
                        <h3 class="text-sm font-semibold text-white mb-1">Response Guarantee</h3>
                        <p class="text-xs text-surface-200/50">We respond to all technical inquiries within 24 hours on business days.</p>
                    </div>

                    <div class="glass-card p-6">
                        <h3 class="text-sm font-semibold text-white mb-1">Current Availability</h3>
                        <p class="text-xs text-surface-200/50">Accepting new projects for this quarter. Let's build your software right.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
