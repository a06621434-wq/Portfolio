<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard') — Shahzad Labs Admin</title>

    {{-- Favicons --}}
    <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    @if (!empty($siteSettings['favicon_url']))
        <link rel="alternate icon" href="{{ $siteSettings['favicon_url'] }}">
    @endif

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface-950 text-surface-200 font-sans antialiased selection:bg-brand-500/30 overflow-x-hidden w-full max-w-full">

    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex w-full max-w-full overflow-x-hidden">

        {{-- Mobile Sidebar Backdrop --}}
        <div x-show="sidebarOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 z-40 bg-black/70 backdrop-blur-sm lg:hidden"
             style="display: none;"></div>

        {{-- ═══════════════════════════════════════════════════════════
             ADMIN SIDEBAR
        ═══════════════════════════════════════════════════════════ --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed inset-y-0 left-0 z-50 w-64 shrink-0 bg-surface-950 border-r border-white/[0.08] flex flex-col transition-transform duration-300 ease-in-out lg:static lg:translate-x-0">
            
            {{-- Brand Header with dynamic Logo --}}
            <div class="h-16 flex items-center justify-between px-6 border-b border-white/[0.08] bg-surface-950/50">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="h-9 w-9 rounded-full overflow-hidden shrink-0 border border-brand-500/40 ring-2 ring-brand-500/20 bg-surface-900 flex items-center justify-center shadow-md">
                        <img src="{{ $siteSettings['site_logo_url'] }}" alt="Logo" onerror="this.onerror=null;this.src='{{ asset('images/shahzad-ali.png') }}';" class="w-full h-full object-cover rounded-full">
                    </div>
                    <div>
                        <div class="font-display text-sm font-bold text-white tracking-tight">Shahzad<span class="text-brand-400">Labs</span></div>
                        <span class="text-[9px] uppercase tracking-wider font-semibold text-accent-400">Admin Control</span>
                    </div>
                </a>

                {{-- Close on Mobile --}}
                <button @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-lg text-surface-200/50 hover:text-white hover:bg-white/[0.05]">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Sidebar Navigation --}}
            <div class="flex-1 overflow-y-auto px-4 py-6 space-y-6">
                {{-- Main Menu --}}
                <div>
                    <div class="px-3 mb-2 text-[10px] font-semibold uppercase tracking-wider text-surface-200/40">Management</div>
                    <nav class="space-y-1">
                        {{-- Dashboard --}}
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-brand-500/15 text-brand-300 ring-1 ring-brand-500/30 shadow-lg shadow-brand-500/10' : 'text-surface-200/60 hover:text-white hover:bg-white/[0.04]' }}">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-brand-400' : 'text-surface-200/40' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        {{-- Projects --}}
                        <a href="{{ route('admin.projects.index') }}"
                           class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.projects.*') ? 'bg-brand-500/15 text-brand-300 ring-1 ring-brand-500/30 shadow-lg shadow-brand-500/10' : 'text-surface-200/60 hover:text-white hover:bg-white/[0.04]' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.projects.*') ? 'text-brand-400' : 'text-surface-200/40' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-6A1.125 1.125 0 012.25 11.625v-4.5zM13.5 7.125c0-.621.504-1.125 1.125-1.125h6c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 01-1.125-1.125v-4.5zM2.25 16.875c0-.621.504-1.125 1.125-1.125h6c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 16.875c0-.621.504-1.125 1.125-1.125h6c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 01-1.125-1.125v-4.5z"/>
                                </svg>
                                <span>Projects</span>
                            </div>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-white/[0.06] text-surface-200/60">{{ \App\Models\Project::count() }}</span>
                        </a>

                        {{-- Skills --}}
                        <a href="{{ route('admin.skills.index') }}"
                           class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.skills.*') ? 'bg-brand-500/15 text-brand-300 ring-1 ring-brand-500/30 shadow-lg shadow-brand-500/10' : 'text-surface-200/60 hover:text-white hover:bg-white/[0.04]' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.skills.*') ? 'text-brand-400' : 'text-surface-200/40' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                                </svg>
                                <span>Skills</span>
                            </div>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-white/[0.06] text-surface-200/60">{{ \App\Models\Skill::count() }}</span>
                        </a>

                        {{-- Messages --}}
                        @php
                            $unreadCount = \App\Models\Message::unread()->count();
                        @endphp
                        <a href="{{ route('admin.messages') }}"
                           class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.messages*') ? 'bg-brand-500/15 text-brand-300 ring-1 ring-brand-500/30 shadow-lg shadow-brand-500/10' : 'text-surface-200/60 hover:text-white hover:bg-white/[0.04]' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.messages*') ? 'text-brand-400' : 'text-surface-200/40' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                </svg>
                                <span>Messages</span>
                            </div>
                            @if($unreadCount > 0)
                            <span class="text-xs px-2 py-0.5 rounded-full bg-red-500/20 text-red-400 font-semibold ring-1 ring-red-500/30 animate-pulse">{{ $unreadCount }}</span>
                            @else
                            <span class="text-xs px-2 py-0.5 rounded-full bg-white/[0.06] text-surface-200/40">0</span>
                            @endif
                        </a>

                        {{-- Site Branding, Hero Image & Favicon --}}
                        <a href="{{ route('admin.settings.edit') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-brand-500/15 text-brand-300 ring-1 ring-brand-500/30 shadow-lg shadow-brand-500/10' : 'text-surface-200/60 hover:text-white hover:bg-white/[0.04]' }}">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.settings.*') ? 'text-brand-400' : 'text-surface-200/40' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                            </svg>
                            <span>Hero, Logo &amp; Favicon</span>
                        </a>
                    </nav>
                </div>

                {{-- System & External Links --}}
                <div>
                    <div class="px-3 mb-2 text-[10px] font-semibold uppercase tracking-wider text-surface-200/40">System & Quick Links</div>
                    <nav class="space-y-1">
                        {{-- Profile --}}
                        <a href="{{ route('admin.profile.edit') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.profile.*') || request()->routeIs('profile.*') ? 'bg-brand-500/15 text-brand-300 ring-1 ring-brand-500/30' : 'text-surface-200/60 hover:text-white hover:bg-white/[0.04]' }}">
                            <svg class="w-5 h-5 shrink-0 text-surface-200/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                            <span>Profile & Account</span>
                        </a>

                        {{-- View Site --}}
                        <a href="{{ route('home') }}" target="_blank"
                           class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium text-surface-200/60 hover:text-accent-400 hover:bg-accent-500/10 transition-all duration-200">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0 text-accent-400/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                </svg>
                                <span>Live Portfolio</span>
                            </div>
                            <span class="text-[10px] text-surface-200/40">↗</span>
                        </a>
                    </nav>
                </div>
            </div>

            {{-- Sidebar Footer / User Profile --}}
            <div class="p-4 border-t border-white/[0.08] bg-surface-950/70">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="h-9 w-9 shrink-0 rounded-xl bg-gradient-to-tr from-brand-600 to-accent-500 flex items-center justify-center font-display text-xs font-bold text-white shadow-md">
                            {{ substr(auth()->user()->name ?? 'Admin', 0, 2) }}
                        </div>
                        <div class="truncate">
                            <div class="text-xs font-semibold text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</div>
                            <div class="text-[10px] text-surface-200/40 truncate">{{ auth()->user()->email ?? 'admin@shahzadlabs.com' }}</div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Logout" class="p-2 rounded-lg text-surface-200/40 hover:text-red-400 hover:bg-red-500/10 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- ═══════════════════════════════════════════════════════════
             MAIN CONTENT WRAPPER
        ═══════════════════════════════════════════════════════════ --}}
        <div class="flex-1 flex flex-col min-w-0 w-full max-w-full overflow-x-hidden bg-surface-950">
            
            {{-- Top Header --}}
            <header class="h-16 sticky top-0 z-30 border-b border-white/[0.08] bg-surface-950/80 backdrop-blur-xl flex items-center justify-between px-4 sm:px-6 lg:px-8 w-full max-w-full">
                <div class="flex items-center gap-3 sm:gap-4">
                    {{-- Mobile Hamburger --}}
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl text-surface-200 hover:bg-white/[0.06] transition-colors" aria-label="Open sidebar">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                    </button>

                    <div>
                        <h1 class="font-display text-base font-bold text-white tracking-tight">@yield('title', 'Dashboard')</h1>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="{{ route('admin.projects.create') }}" class="btn-primary !py-2 !px-3 sm:!px-3.5 !text-xs flex items-center gap-1.5 shadow-sm whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        <span class="hidden sm:inline">New Project</span>
                    </a>
                    <a href="{{ route('admin.skills.create') }}" class="btn-outline !py-2 !px-3 sm:!px-3.5 !text-xs flex items-center gap-1.5 whitespace-nowrap">
                        <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span class="hidden sm:inline">New Skill</span>
                    </a>
                </div>
            </header>

            {{-- Flash Alert Messages --}}
            @if(session('success'))
            <div class="mx-auto max-w-7xl w-full px-4 sm:px-6 lg:px-8 pt-6">
                <div class="rounded-xl border border-accent-500/30 bg-accent-500/10 px-4 py-3 text-sm text-accent-300 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mx-auto max-w-7xl w-full px-4 sm:px-6 lg:px-8 pt-6">
                <div class="rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
            @endif

            {{-- Main Page Content --}}
            <main class="flex-1 mx-auto max-w-7xl w-full px-4 sm:px-6 lg:px-8 py-6 sm:py-8 min-w-0 max-w-full">
                @yield('content')
            </main>

            {{-- Admin Footer --}}
            <footer class="border-t border-white/[0.06] py-4 px-4 sm:px-6 lg:px-8 text-center text-xs text-surface-200/40">
                &copy; {{ date('Y') }} Shahzad Labs Administration &bull; High-Performance Digital Studio
            </footer>
        </div>
    </div>

</body>
</html>
