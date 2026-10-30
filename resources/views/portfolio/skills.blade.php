@extends('layouts.public')
@section('title', 'Tech Stack & Engineering Skills — Shahzad Labs')
@section('meta_description', 'Discover our core technical competencies: Laravel, PHP 8+, MySQL, JavaScript ES6+, Tailwind CSS, and scalable cloud architecture.')

@section('content')
    {{-- Hero Header --}}
    <section class="relative pt-32 pb-16 overflow-hidden border-b border-white/[0.06]">
        <div class="absolute inset-0 bg-hero-pattern opacity-60"></div>
        <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-accent-500/10 rounded-full blur-[140px]"></div>

        <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-accent-500/30 bg-accent-500/10 px-3.5 py-1.5 text-xs font-semibold text-accent-400 mb-6">
                    <span class="status-dot"></span>
                    <span>Engineering Capabilities</span>
                    <span class="text-surface-200/40">&bull;</span>
                    <span>{{ $totalSkills }} Core Technologies</span>
                </div>

                <h1 class="font-display text-4xl sm:text-5xl font-extrabold text-white tracking-tight">
                    Battle-Tested Technologies &amp;
                    <span class="bg-gradient-to-r from-accent-400 via-brand-400 to-brand-500 bg-clip-text text-transparent">
                        Modern Stack
                    </span>
                </h1>
                <p class="mt-4 text-base sm:text-lg text-surface-200/60 leading-relaxed">
                    We select our technical stack deliberately. Every language, database, framework, and tool is chosen for reliability, developer ergonomics, security, and long-term maintainability.
                </p>
            </div>
        </div>
    </section>

    {{-- Skills Grouped by Category --}}
    <section class="py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8 space-y-16">
            
            @php
                $categoryTitles = [
                    'backend'  => ['title' => 'Backend & Server Architecture', 'icon' => '⚙️', 'desc' => 'High-throughput APIs, domain-driven services, queue workers, and clean Laravel architecture.'],
                    'frontend' => ['title' => 'Frontend & User Interface', 'icon' => '🎨', 'desc' => 'Modern, lightweight client-side reactivity, utility-first CSS, and accessible semantic markup.'],
                    'database' => ['title' => 'Database & Data Layer', 'icon' => '🗄️', 'desc' => 'Production-grade MySQL relational modeling, Redis caching, indexing, and query optimization.'],
                    'devops'   => ['title' => 'DevOps, CI/CD & Cloud', 'icon' => '🚀', 'desc' => 'Automated deployment pipelines, containerization, Git branching workflows, and monitoring.'],
                    'tools'    => ['title' => 'Architecture & Testing Tools', 'icon' => '🛠️', 'desc' => 'Standards-compliant REST APIs, automated testing, API documentation, and code profiling.'],
                ];
            @endphp

            @foreach($categoryTitles as $catKey => $catInfo)
                @if(isset($groupedSkills[$catKey]) && $groupedSkills[$catKey]->isNotEmpty())
                <div class="space-y-6">
                    <div class="flex items-center gap-3 pb-4 border-b border-white/[0.08]">
                        <span class="text-2xl">{{ $catInfo['icon'] }}</span>
                        <div>
                            <h2 class="font-display text-xl sm:text-2xl font-bold text-white tracking-tight">{{ $catInfo['title'] }}</h2>
                            <p class="text-xs sm:text-sm text-surface-200/50 mt-0.5">{{ $catInfo['desc'] }}</p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach($groupedSkills[$catKey] as $skill)
                        <div class="glass-card p-6 flex flex-col justify-between group hover:border-brand-500/40 transition-all duration-300 hover:-translate-y-1">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-3xl">{{ $skill->icon ?: '⚡' }}</span>
                                    @if($skill->experience)
                                    <span class="text-[10px] font-mono px-2 py-0.5 rounded-md bg-white/[0.05] text-surface-200/60 border border-white/[0.08]">
                                        {{ $skill->experience }}
                                    </span>
                                    @endif
                                </div>

                                <h3 class="font-display text-base font-bold text-white group-hover:text-brand-300 transition-colors">
                                    {{ $skill->name }}
                                </h3>
                            </div>

                            <div class="mt-6 pt-4 border-t border-white/[0.06]">
                                <div class="flex items-center justify-between text-xs font-mono mb-2">
                                    <span class="text-surface-200/40">Proficiency</span>
                                    <span class="text-brand-400 font-bold">{{ $skill->proficiency }}%</span>
                                </div>
                                <div class="h-2 w-full rounded-full bg-surface-900 overflow-hidden ring-1 ring-white/[0.06]">
                                    <div class="h-full rounded-full bg-gradient-to-r from-brand-500 to-accent-400 transition-all duration-700" style="width: {{ $skill->proficiency }}%;"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach

        </div>
    </section>

    {{-- Engineering Principles --}}
    <section class="border-t border-white/[0.08] bg-surface-950/70 py-20">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-semibold uppercase tracking-wider text-brand-400">Philosophy</span>
                <h2 class="mt-2 font-display text-3xl font-bold text-white">How We Build Software</h2>
                <p class="mt-3 text-sm text-surface-200/50">Core architectural values that guide every line of code we ship.</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="glass-card p-6">
                    <div class="h-10 w-10 rounded-xl bg-brand-500/10 text-brand-400 flex items-center justify-center font-bold text-lg mb-4">01</div>
                    <h3 class="font-display text-base font-bold text-white">Pragmatic MVC &amp; Modularity</h3>
                    <p class="mt-2 text-xs sm:text-sm text-surface-200/50 leading-relaxed">
                        We avoid over-engineering. Clean controllers, explicit Form Requests, Eloquent scopes, and dedicated service classes keep codebases approachable and easy to maintain.
                    </p>
                </div>

                <div class="glass-card p-6">
                    <div class="h-10 w-10 rounded-xl bg-accent-500/10 text-accent-400 flex items-center justify-center font-bold text-lg mb-4">02</div>
                    <h3 class="font-display text-base font-bold text-white">Database-First Optimization</h3>
                    <p class="mt-2 text-xs sm:text-sm text-surface-200/50 leading-relaxed">
                        Slow applications almost always stem from database bottlenecks. We use proper indexes, eager loading (`with()`), query profiling, and Redis caching.
                    </p>
                </div>

                <div class="glass-card p-6">
                    <div class="h-10 w-10 rounded-xl bg-purple-500/10 text-purple-400 flex items-center justify-center font-bold text-lg mb-4">03</div>
                    <h3 class="font-display text-base font-bold text-white">Defense in Depth Security</h3>
                    <p class="mt-2 text-xs sm:text-sm text-surface-200/50 leading-relaxed">
                        CSRF tokens, parameterized queries preventing SQL injection, strict input sanitization, rate limiting on sensitive endpoints, and encrypted session data.
                    </p>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('contact.index') }}" class="btn-primary !px-6 !py-3 !text-xs">Discuss Your Tech Requirements →</a>
            </div>
        </div>
    </section>
@endsection
