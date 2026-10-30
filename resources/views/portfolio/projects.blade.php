@extends('layouts.public')
@section('title', 'Portfolio Projects — Shahzad Labs')
@section('meta_description', 'Explore production-ready Laravel web applications, full-stack platforms, SaaS dashboards, and modern APIs crafted by Shahzad Labs.')

@section('content')
    {{-- Hero Header --}}
    <section class="relative pt-32 pb-16 overflow-hidden border-b border-white/[0.06]">
        <div class="absolute inset-0 bg-hero-pattern opacity-60"></div>
        <div class="absolute top-1/3 left-1/4 w-96 h-96 bg-brand-500/10 rounded-full blur-[140px]"></div>

        <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-brand-500/30 bg-brand-500/10 px-3.5 py-1.5 text-xs font-semibold text-brand-400 mb-6">
                    <span class="status-dot"></span>
                    <span>Engineering Showcase</span>
                    <span class="text-surface-200/40">&bull;</span>
                    <span>{{ $totalCount }} Projects</span>
                </div>

                <h1 class="font-display text-4xl sm:text-5xl font-extrabold text-white tracking-tight">
                    Engineered for Scale &amp;
                    <span class="bg-gradient-to-r from-brand-400 via-brand-500 to-accent-400 bg-clip-text text-transparent">
                        Performance
                    </span>
                </h1>
                <p class="mt-4 text-base sm:text-lg text-surface-200/60 leading-relaxed">
                    Explore our portfolio of bespoke web applications, enterprise SaaS platforms, and high-throughput APIs built with clean MVC architecture and optimized database schemas.
                </p>
            </div>

            {{-- Search & Filter Controls --}}
            <div class="mt-10 flex flex-col md:flex-row md:items-center justify-between gap-4 pt-8 border-t border-white/[0.08]">
                {{-- Category Filters --}}
                <div class="flex flex-wrap items-center gap-2">
                    @php $currentCat = request('category', 'all'); @endphp
                    <a href="{{ route('projects.index', array_merge(request()->except('category', 'page'), ['category' => 'all'])) }}"
                       class="px-4 py-2 rounded-xl text-xs font-medium transition-all {{ $currentCat === 'all' ? 'bg-brand-500/20 text-brand-300 ring-1 ring-brand-500/40 font-bold' : 'bg-white/[0.02] text-surface-200/60 hover:text-white hover:bg-white/[0.05]' }}">
                        All Projects ({{ $totalCount }})
                    </a>
                    <a href="{{ route('projects.index', array_merge(request()->except('category', 'page'), ['category' => 'laravel'])) }}"
                       class="px-4 py-2 rounded-xl text-xs font-medium transition-all {{ $currentCat === 'laravel' ? 'bg-brand-500/20 text-brand-300 ring-1 ring-brand-500/40 font-bold' : 'bg-white/[0.02] text-surface-200/60 hover:text-white hover:bg-white/[0.05]' }}">
                        Laravel / PHP
                    </a>
                    <a href="{{ route('projects.index', array_merge(request()->except('category', 'page'), ['category' => 'fullstack'])) }}"
                       class="px-4 py-2 rounded-xl text-xs font-medium transition-all {{ $currentCat === 'fullstack' ? 'bg-brand-500/20 text-brand-300 ring-1 ring-brand-500/40 font-bold' : 'bg-white/[0.02] text-surface-200/60 hover:text-white hover:bg-white/[0.05]' }}">
                        Full-Stack
                    </a>
                    <a href="{{ route('projects.index', array_merge(request()->except('category', 'page'), ['category' => 'saas'])) }}"
                       class="px-4 py-2 rounded-xl text-xs font-medium transition-all {{ $currentCat === 'saas' ? 'bg-brand-500/20 text-brand-300 ring-1 ring-brand-500/40 font-bold' : 'bg-white/[0.02] text-surface-200/60 hover:text-white hover:bg-white/[0.05]' }}">
                        SaaS WebApps
                    </a>
                    <a href="{{ route('projects.index', array_merge(request()->except('category', 'page'), ['category' => 'frontend'])) }}"
                       class="px-4 py-2 rounded-xl text-xs font-medium transition-all {{ $currentCat === 'frontend' ? 'bg-brand-500/20 text-brand-300 ring-1 ring-brand-500/40 font-bold' : 'bg-white/[0.02] text-surface-200/60 hover:text-white hover:bg-white/[0.05]' }}">
                        Frontend
                    </a>
                </div>

                {{-- Search Box --}}
                <form method="GET" action="{{ route('projects.index') }}" class="flex items-center gap-2">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="relative w-full sm:w-64">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search projects..."
                               class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] pl-9 pr-4 py-2 text-xs text-white placeholder-surface-200/40 focus:border-brand-500/50 focus:outline-none focus:ring-1 focus:ring-brand-500/30">
                        <svg class="w-4 h-4 text-surface-200/40 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <button type="submit" class="btn-outline !py-2 !px-3 !text-xs">Search</button>
                    @if(request('search'))
                        <a href="{{ route('projects.index', ['category' => request('category', 'all')]) }}" class="text-xs text-surface-200/40 hover:text-white">Clear</a>
                    @endif
                </form>
            </div>
        </div>
    </section>

    {{-- Projects Grid --}}
    <section class="py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            @if($projects->isEmpty())
                <div class="glass-card p-12 sm:p-16 text-center max-w-xl mx-auto border border-white/[0.08] shadow-2xl">
                    <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-500/10 text-brand-400 mb-5 ring-1 ring-brand-500/20">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-6A1.125 1.125 0 012.25 11.625v-4.5zM14.625 6A1.125 1.125 0 0013.5 7.125v10.5c0 .621.504 1.125 1.125 1.125h6c.621 0 1.125-.504 1.125-1.125V7.125C21.75 6.504 21.246 6 20.625 6h-6zM2.25 16.125c0-.621.504-1.125 1.125-1.125h6c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125h-6A1.125 1.125 0 012.25 17.625v-1.5z"/>
                        </svg>
                    </div>
                    @if($totalCount === 0)
                        <h3 class="font-display text-xl font-bold text-white tracking-tight">Case Studies Coming Soon</h3>
                        <p class="mt-2 text-sm text-surface-200/60 leading-relaxed max-w-md mx-auto">
                            Our portfolio showcase is currently being updated with recent enterprise deployments. Feel free to inspect our engineering stack or get in touch for project inquiries.
                        </p>
                        <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                            <a href="{{ route('skills.index') }}" class="btn-primary !text-xs flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                </svg>
                                <span>View Technical Stack</span>
                            </a>
                            <a href="{{ route('contact.index') }}" class="btn-outline !text-xs flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span>Get in Touch</span>
                            </a>
                        </div>
                    @else
                        <h3 class="font-display text-lg font-bold text-white">No Projects Match Your Filter</h3>
                        <p class="mt-2 text-sm text-surface-200/50">Try clearing search terms or selecting a different category.</p>
                        <div class="mt-6">
                            <a href="{{ route('projects.index') }}" class="btn-primary !text-xs">Reset All Filters</a>
                        </div>
                    @endif
                </div>
            @else
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($projects as $project)
                    <article class="glass-card group flex flex-col overflow-hidden hover:border-brand-500/40 transition-all duration-300 hover:-translate-y-1">
                        {{-- Project Thumbnail with Real Image --}}
                        <a href="{{ route('projects.show', $project->slug) }}" class="relative aspect-[16/10] overflow-hidden bg-surface-900 block">
                            <img src="{{ $project->image_url }}" alt="{{ $project->title }}"
                                 onerror="this.onerror=null;this.src='{{ asset('images/project-placeholder.svg') }}';"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            {{-- Category Badge --}}
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

                        {{-- Card Details --}}
                        <div class="p-6 flex-1 flex flex-col">
                            <h2 class="font-display text-lg font-bold text-white group-hover:text-brand-300 transition-colors">
                                <a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a>
                            </h2>
                            
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

                            {{-- Footer Links --}}
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
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($projects->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $projects->links() }}
                </div>
                @endif
            @endif
        </div>
    </section>

    {{-- Bottom CTA --}}
    <section class="border-t border-white/[0.08] bg-surface-950/60 py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-8 text-center">
            <h2 class="font-display text-2xl sm:text-3xl font-bold text-white">Have a specific project in mind?</h2>
            <p class="mt-2 text-sm text-surface-200/50 max-w-xl mx-auto">We architect high-performance Laravel backends, full-stack MVPs, and modern APIs tailored to your business.</p>
            <div class="mt-6">
                <a href="{{ route('contact.index') }}" class="btn-primary !px-6 !py-3 !text-sm">Start a Conversation →</a>
            </div>
        </div>
    </section>
@endsection
