@extends('layouts.public')
@section('title', $project->title . ' — Shahzad Labs Portfolio')
@section('meta_description', Str::limit($project->description, 150))

@section('content')
    <article class="pt-32 pb-24">
        {{-- Breadcrumb & Back --}}
        <div class="mx-auto max-w-7xl px-6 lg:px-8 mb-8">
            <nav class="flex items-center gap-2 text-xs text-surface-200/50">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span>/</span>
                <a href="{{ route('projects.index') }}" class="hover:text-white transition-colors">Projects</a>
                <span>/</span>
                <span class="text-white font-medium truncate">{{ $project->title }}</span>
            </nav>
        </div>

        {{-- Hero Header --}}
        <header class="mx-auto max-w-7xl px-6 lg:px-8 mb-12">
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <span class="inline-flex rounded-lg bg-brand-500/15 border border-brand-500/30 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-brand-300">
                    {{ $project->category }}
                </span>
                @if($project->is_featured)
                <span class="inline-flex items-center gap-1.5 rounded-lg bg-accent-500/15 border border-accent-500/30 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-accent-300">
                    ★ Featured Project
                </span>
                @endif
                @if($project->metric)
                <span class="inline-flex items-center gap-1.5 rounded-lg bg-white/[0.04] border border-white/[0.08] px-3 py-1 text-xs font-medium text-emerald-400">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    {{ $project->metric }}
                </span>
                @endif
            </div>

            <h1 class="font-display text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
                {{ $project->title }}
            </h1>

            <div class="mt-6 flex flex-wrap items-center gap-4 pt-6 border-t border-white/[0.08]">
                @if($project->live_url)
                <a href="{{ $project->live_url }}" target="_blank" rel="noopener" class="btn-primary !py-2.5 !px-5 !text-xs flex items-center gap-2 shadow-lg shadow-brand-500/20 hover:shadow-brand-500/40">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                    </span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    <span>Launch Live Application</span>
                </a>
                @endif

                <a href="{{ route('projects.index') }}" class="text-xs text-surface-200/50 hover:text-white transition-colors ml-auto">
                    &larr; Back to all projects
                </a>
            </div>
        </header>

        @php
            $galleryItems = collect();
            if ($project->image) {
                $galleryItems->push([
                    'url' => $project->image_url,
                    'title' => $project->title . ' - Cover Showcase',
                ]);
            }
            foreach ($project->galleryImages as $idx => $gImg) {
                $galleryItems->push([
                    'url' => $gImg->image_url,
                    'title' => $gImg->caption ?: ($project->title . ' - Screenshot ' . ($idx + 1)),
                ]);
            }
        @endphp

        {{-- Interactive Image & Screenshot Gallery Showcase --}}
        <div class="mx-auto max-w-7xl px-6 lg:px-8 mb-16"
             x-data="{
                activeIndex: 0,
                lightboxOpen: false,
                items: {{ Js::from($galleryItems) }},
                next() {
                    if (this.items.length > 0) {
                        this.activeIndex = (this.activeIndex + 1) % this.items.length;
                    }
                },
                prev() {
                    if (this.items.length > 0) {
                        this.activeIndex = (this.activeIndex - 1 + this.items.length) % this.items.length;
                    }
                }
             }"
             @keydown.window.escape="lightboxOpen = false"
             @keydown.window.arrow-right="if (lightboxOpen) next()"
             @keydown.window.arrow-left="if (lightboxOpen) prev()">

            <div class="glass-card overflow-hidden p-3 sm:p-4 ring-1 ring-white/[0.1] shadow-2xl relative">
                
                {{-- Main Active Stage Image Display --}}
                <div class="aspect-[16/9] w-full rounded-2xl overflow-hidden bg-surface-900 relative group cursor-pointer"
                     @click="lightboxOpen = true">
                    
                    {{-- Active Image with Transition --}}
                    <template x-for="(item, idx) in items" :key="idx">
                        <img x-show="activeIndex === idx"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             :src="item.url"
                             :alt="item.title"
                             onerror="this.onerror=null;this.src='{{ asset('images/project-placeholder.svg') }}';"
                             class="w-full h-full object-cover">
                    </template>

                    {{-- Hover Zoom & Expand Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-between p-6">
                        <div>
                            <span class="text-xs uppercase tracking-wider font-semibold text-brand-300" x-text="items[activeIndex]?.title"></span>
                            <p class="text-xs text-surface-200/60 mt-0.5">Click anywhere to open high-resolution view</p>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-white/10 backdrop-blur border border-white/20 flex items-center justify-center text-white shadow-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9m11.25-5.25v4.5m0-4.5h-4.5m4.5 0L15 9m-11.25 11.25v-4.5m0 4.5h4.5m-4.5 0L9 15m11.25 5.25v-4.5m0 4.5h-4.5m4.5 0L15 15"/>
                            </svg>
                        </div>
                    </div>

                    {{-- On-Stage Left/Right Navigation Controls (if multiple images) --}}
                    <template x-if="items.length > 1">
                        <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 flex items-center justify-between px-4 pointer-events-none">
                            <button type="button" @click.stop="prev()"
                                    class="pointer-events-auto h-10 w-10 rounded-full bg-surface-950/80 hover:bg-brand-500 text-white backdrop-blur border border-white/20 flex items-center justify-center shadow-lg transition-all transform hover:scale-110 active:scale-95"
                                    title="Previous Image">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <button type="button" @click.stop="next()"
                                    class="pointer-events-auto h-10 w-10 rounded-full bg-surface-950/80 hover:bg-brand-500 text-white backdrop-blur border border-white/20 flex items-center justify-center shadow-lg transition-all transform hover:scale-110 active:scale-95"
                                    title="Next Image">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </template>

                    {{-- Image Counter Badge --}}
                    <template x-if="items.length > 1">
                        <div class="absolute top-4 right-4 bg-surface-950/80 backdrop-blur border border-white/10 rounded-full px-3 py-1 text-[11px] font-semibold text-white/90 shadow">
                            <span x-text="activeIndex + 1"></span> / <span x-text="items.length"></span>
                        </div>
                    </template>
                </div>

                {{-- Interactive Thumbnail Navigation Strip --}}
                <template x-if="items.length > 1">
                    <div class="mt-4 pt-4 border-t border-white/[0.08]">
                        <div class="flex items-center justify-between mb-3 px-1">
                            <span class="text-xs font-semibold text-white uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-4 h-4 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Screenshots &amp; Views Gallery
                            </span>
                            <span class="text-[11px] text-surface-200/50">Click thumbnail to inspect</span>
                        </div>

                        <div class="flex items-center gap-3 overflow-x-auto pb-2 scrollbar-thin scrollbar-thumb-white/20">
                            <template x-for="(item, idx) in items" :key="idx">
                                <button type="button" @click="activeIndex = idx"
                                        :class="activeIndex === idx ? 'ring-2 ring-brand-400 border-transparent shadow-lg shadow-brand-500/20 scale-[1.02]' : 'opacity-60 hover:opacity-100 border-white/10'"
                                        class="relative flex-shrink-0 w-24 sm:w-32 aspect-[16/10] rounded-xl overflow-hidden border bg-surface-900 transition-all duration-200">
                                    <img :src="item.url" :alt="item.title" onerror="this.onerror=null;this.src='{{ asset('images/project-placeholder.svg') }}';" class="w-full h-full object-cover">
                                </button>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Fullscreen Lightbox Modal --}}
            <div x-show="lightboxOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/95 backdrop-blur-md p-4 sm:p-8"
                 style="display: none;">
                
                {{-- Top Control Bar --}}
                <div class="absolute top-4 inset-x-4 sm:inset-x-8 flex items-center justify-between text-white z-10">
                    <div class="text-xs sm:text-sm font-semibold truncate max-w-md" x-text="items[activeIndex]?.title"></div>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-surface-200/60" x-text="(activeIndex + 1) + ' of ' + items.length"></span>
                        <button type="button" @click="lightboxOpen = false" class="p-2 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors" title="Close (Esc)">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Image Display in Lightbox --}}
                <div class="relative max-w-6xl max-h-[85vh] w-full h-full flex items-center justify-center p-2"
                     @click.outside="lightboxOpen = false">
                    <img :src="items[activeIndex]?.url" :alt="items[activeIndex]?.title"
                         onerror="this.onerror=null;this.src='{{ asset('images/project-placeholder.svg') }}';"
                         class="max-w-full max-h-[82vh] object-contain rounded-xl shadow-2xl ring-1 ring-white/10">
                </div>

                {{-- Lightbox Previous / Next Buttons --}}
                <template x-if="items.length > 1">
                    <button type="button" @click.stop="prev()"
                            class="absolute left-4 top-1/2 -translate-y-1/2 h-12 w-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center backdrop-blur border border-white/20 shadow-xl transition-all"
                            title="Previous (Left Arrow)">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                </template>
                <template x-if="items.length > 1">
                    <button type="button" @click.stop="next()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 h-12 w-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center backdrop-blur border border-white/20 shadow-xl transition-all"
                            title="Next (Right Arrow)">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </template>
            </div>

        </div>

        {{-- Case Study Content & Specifications Grid --}}
        <div class="mx-auto max-w-7xl px-6 lg:px-8 grid gap-12 lg:grid-cols-3">
            
            {{-- Main Content (2 cols) --}}
            <div class="lg:col-span-2 space-y-10">
                <section class="glass-card p-8">
                    <h2 class="font-display text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Project Overview
                    </h2>
                    <p class="text-base text-surface-200/70 leading-relaxed whitespace-pre-line">
                        {{ $project->description }}
                    </p>
                </section>

                <section class="glass-card p-8">
                    <h2 class="font-display text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        Architecture &amp; Engineering Highlights
                    </h2>
                    <ul class="space-y-3 text-sm text-surface-200/60">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-accent-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>Clean MVC Pattern:</strong> Strict separation of concerns with domain services, form request validation, and lean controllers.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-accent-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>Database Optimization:</strong> Indexed relational queries, eager loading prevention of N+1 bottlenecks, and automated migrations.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-accent-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>Robust Security:</strong> Full CSRF protection, input sanitization, prepared SQL statements, and secure authentication tokens.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-accent-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>Responsive Frontend:</strong> Fluid mobile-first user interface with smooth transitions and high Core Web Vitals score.</span>
                        </li>
                    </ul>
                </section>
            </div>

            {{-- Sidebar Specs (1 col) --}}
            <div class="space-y-6">
                <div class="glass-card p-6">
                    <h3 class="font-display text-sm font-bold text-white uppercase tracking-wider mb-4 pb-3 border-b border-white/[0.08]">
                        Technical Specification
                    </h3>

                    <dl class="space-y-4 text-xs">
                        <div>
                            <dt class="text-surface-200/40 uppercase font-semibold">Category</dt>
                            <dd class="text-white font-medium capitalize mt-0.5">{{ $project->category }}</dd>
                        </div>
                        <div>
                            <dt class="text-surface-200/40 uppercase font-semibold">Primary Architecture</dt>
                            <dd class="text-white font-medium mt-0.5">Laravel MVC &bull; MySQL Relational</dd>
                        </div>
                        @if($project->metric)
                        <div>
                            <dt class="text-surface-200/40 uppercase font-semibold">Key Benchmark</dt>
                            <dd class="text-accent-400 font-semibold mt-0.5">{{ $project->metric }}</dd>
                        </div>
                        @endif
                        <div>
                            <dt class="text-surface-200/40 uppercase font-semibold">Tech Stack Breakdown</dt>
                            <dd class="mt-2 flex flex-wrap gap-1.5">
                                @foreach($project->tech_stack as $tech)
                                <span class="tech-badge !text-[11px] !px-2.5 !py-1">{{ $tech }}</span>
                                @endforeach
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-8 pt-6 border-t border-white/[0.08]">
                        <a href="{{ route('contact.index') }}" class="btn-primary w-full !text-xs justify-center">
                            Hire Us for Similar Project
                        </a>
                    </div>
                </div>
            </div>

        </div>

        {{-- Related Projects --}}
        @if($relatedProjects->isNotEmpty())
        <section class="mx-auto max-w-7xl px-6 lg:px-8 mt-24 pt-16 border-t border-white/[0.08]">
            <h2 class="font-display text-2xl font-bold text-white mb-8">Related Projects</h2>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($relatedProjects as $rel)
                <a href="{{ route('projects.show', $rel->slug) }}" class="glass-card group overflow-hidden block hover:border-brand-500/30 transition-all">
                    <div class="aspect-[16/10] overflow-hidden bg-surface-900">
                        <img src="{{ $rel->image_url }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-5">
                        <h3 class="font-display text-base font-bold text-white group-hover:text-brand-300 transition-colors">{{ $rel->title }}</h3>
                        <p class="mt-1 text-xs text-surface-200/50 line-clamp-2">{{ $rel->description }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif
    </article>
@endsection
