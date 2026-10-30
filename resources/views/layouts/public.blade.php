<!DOCTYPE html>
<html lang="en" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Dynamic SEO Tags --}}
    <title>@yield('title', 'Shahzad Labs — Engineering Scalable Web Applications & Digital Experiences')</title>
    <meta name="description" content="@yield('meta_description', 'Shahzad Labs is a premier web engineering studio specializing in Laravel, PHP, MySQL, and modern JavaScript. We build high-performance web applications and scalable SaaS platforms.')">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow">

    {{-- Favicons --}}
    <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    @if (!empty($siteSettings['favicon_url']))
        <link rel="alternate icon" href="{{ $siteSettings['favicon_url'] }}">
    @endif

    {{-- OpenGraph Tags --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Shahzad Labs — Scalable Web Applications')">
    <meta property="og:description" content="@yield('meta_description', 'Specializing in Laravel, PHP, MySQL, and modern JavaScript.')">
    <meta property="og:site_name" content="Shahzad Labs">

    {{-- Structured Data --}}
    @verbatim
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": ["ProfessionalService", "Organization"],
        "name": "Shahzad Labs",
        "url": "https://shahzadlabs.com",
        "email": "info@shahzadlabs.com",
        "description": "Professional web development studio specializing in Laravel, PHP, MySQL, and modern JavaScript.",
        "knowsAbout": ["Laravel", "PHP", "MySQL", "JavaScript", "Web Development", "SaaS"]
    }
    </script>
    @endverbatim

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface-950 text-surface-200 font-sans antialiased selection:bg-brand-500/30 min-h-screen flex flex-col">

    {{-- Ambient Noise Overlay --}}
    <div class="noise-overlay pointer-events-none"></div>

    {{-- ═══════════════════════════════════════════════════════════════
         NAVBAR
    ═══════════════════════════════════════════════════════════════ --}}
    <header id="navbar" class="fixed top-0 left-0 right-0 z-50 border-b border-white/[0.06] bg-surface-950/80 backdrop-blur-xl transition-all duration-300">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8">
            {{-- Logo with Dynamic Image (Round Shape) --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="flex h-10 w-10 items-center justify-center rounded-full overflow-hidden border border-brand-500/40 ring-2 ring-brand-500/20 bg-surface-900 transition-all duration-300 group-hover:ring-brand-400/50 shadow-md">
                    <img src="{{ $siteSettings['site_logo_url'] }}" alt="Logo" onerror="this.onerror=null;this.src='{{ asset('images/shahzad-ali.png') }}';" class="w-full h-full object-cover rounded-full">
                </div>
                <span class="font-display text-lg font-bold text-white tracking-tight">Shahzad<span class="text-brand-400">Labs</span></span>
            </a>

            {{-- Desktop Navigation (Separate Dedicated Pages) --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}"
                   class="px-3.5 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('home') ? 'text-white bg-white/[0.08] shadow-sm' : 'text-surface-200/70 hover:text-white hover:bg-white/[0.04]' }}">
                    Overview
                </a>
                <a href="{{ route('projects.index') }}"
                   class="px-3.5 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('projects.*') ? 'text-white bg-white/[0.08] shadow-sm' : 'text-surface-200/70 hover:text-white hover:bg-white/[0.04]' }}">
                    Projects
                </a>
                <a href="{{ route('skills.index') }}"
                   class="px-3.5 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('skills.*') ? 'text-white bg-white/[0.08] shadow-sm' : 'text-surface-200/70 hover:text-white hover:bg-white/[0.04]' }}">
                    Tech Stack
                </a>
                <a href="{{ route('services.index') }}"
                   class="px-3.5 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('services.*') ? 'text-white bg-white/[0.08] shadow-sm' : 'text-surface-200/70 hover:text-white hover:bg-white/[0.04]' }}">
                    Services
                </a>
                <a href="{{ route('contact.index') }}"
                   class="px-3.5 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('contact.*') ? 'text-white bg-white/[0.08] shadow-sm' : 'text-surface-200/70 hover:text-white hover:bg-white/[0.04]' }}">
                    Contact
                </a>
            </div>

            {{-- CTA Button + Mobile Toggle --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('contact.index') }}" class="hidden sm:inline-flex btn-primary !py-2 !px-4 !text-xs items-center gap-1.5 shadow-md">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Hire Us / Get Quote
                </a>

                {{-- Mobile Hamburger --}}
                <button id="mobile-nav-toggle" class="md:hidden p-2 rounded-xl text-surface-200 hover:bg-white/[0.06] transition-colors" aria-label="Toggle navigation">
                    <svg class="icon-open w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg class="icon-close w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </nav>

        {{-- Mobile Drawer Menu --}}
        <div id="mobile-menu" class="fixed inset-y-0 right-0 w-72 bg-surface-900/95 backdrop-blur-2xl border-l border-white/[0.08] transform translate-x-full transition-transform duration-300 ease-out md:hidden z-50">
            <div class="flex flex-col gap-2 p-6 pt-20">
                <div class="text-[10px] uppercase font-semibold text-surface-200/40 px-3 mb-1">Navigation</div>
                <a href="{{ route('home') }}" class="px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('home') ? 'bg-brand-500/15 text-brand-400 font-bold' : 'text-surface-200 hover:text-white hover:bg-white/[0.06]' }}">Overview</a>
                <a href="{{ route('projects.index') }}" class="px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('projects.*') ? 'bg-brand-500/15 text-brand-400 font-bold' : 'text-surface-200 hover:text-white hover:bg-white/[0.06]' }}">Projects</a>
                <a href="{{ route('skills.index') }}" class="px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('skills.*') ? 'bg-brand-500/15 text-brand-400 font-bold' : 'text-surface-200 hover:text-white hover:bg-white/[0.06]' }}">Tech Stack</a>
                <a href="{{ route('services.index') }}" class="px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('services.*') ? 'bg-brand-500/15 text-brand-400 font-bold' : 'text-surface-200 hover:text-white hover:bg-white/[0.06]' }}">Services</a>
                <a href="{{ route('contact.index') }}" class="px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('contact.*') ? 'bg-brand-500/15 text-brand-400 font-bold' : 'text-surface-200 hover:text-white hover:bg-white/[0.06]' }}">Contact</a>
                <div class="mt-4 pt-4 border-t border-white/[0.08]">
                    <a href="{{ route('contact.index') }}" class="btn-primary w-full !text-xs justify-center">Hire Us / Get Quote</a>
                </div>
            </div>
        </div>
    </header>

    {{-- Mobile Overlay Backdrop --}}
    <div id="mobile-overlay" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-40 hidden md:hidden"></div>

    {{-- Main View Body --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- ═══════════════════════════════════════════════════════════════
         GLOBAL FOOTER
    ═══════════════════════════════════════════════════════════════ --}}
    <footer class="border-t border-white/[0.08] bg-surface-950 mt-auto">
        <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4 mb-8 pb-8 border-b border-white/[0.06]">
                {{-- Brand Column --}}
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-500/15 ring-1 ring-brand-500/30">
                            <svg class="h-4 w-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                            </svg>
                        </div>
                        <span class="font-display text-base font-bold text-white">Shahzad<span class="text-brand-400">Labs</span></span>
                    </div>
                    <p class="text-xs text-surface-200/50 leading-relaxed">
                        Engineering scalable web applications, robust RESTful APIs, and modern SaaS platforms with Laravel, PHP, MySQL, and modern JavaScript.
                    </p>
                </div>

                {{-- Quick Pages --}}
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-white mb-3">Pages</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('home') }}" class="text-surface-200/60 hover:text-white transition-colors">Overview</a></li>
                        <li><a href="{{ route('projects.index') }}" class="text-surface-200/60 hover:text-white transition-colors">Portfolio Projects</a></li>
                        <li><a href="{{ route('skills.index') }}" class="text-surface-200/60 hover:text-white transition-colors">Tech Stack & Skills</a></li>
                        <li><a href="{{ route('services.index') }}" class="text-surface-200/60 hover:text-white transition-colors">Services & Offerings</a></li>
                        <li><a href="{{ route('contact.index') }}" class="text-surface-200/60 hover:text-white transition-colors">Contact Hub</a></li>
                    </ul>
                </div>

                {{-- Expertise --}}
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-white mb-3">Core Expertise</h3>
                    <ul class="space-y-2 text-xs text-surface-200/60">
                        <li>Laravel MVC Framework</li>
                        <li>High-Performance MySQL</li>
                        <li>Modern JavaScript & ES6+</li>
                        <li>Tailwind CSS & Responsive UI</li>
                        <li>RESTful API Architecture</li>
                    </ul>
                </div>

                {{-- Direct Contact & Connect --}}
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-white mb-3">Connect &amp; Contact</h3>
                    <div class="space-y-3 text-xs">
                        <div>
                            <p class="text-surface-200/50 mb-1">Direct Email:</p>
                            <a href="mailto:info@shahzadlabs.com" class="text-brand-400 font-mono hover:text-brand-300 transition-colors">info@shahzadlabs.com</a>
                        </div>
                        <div>
                            <p class="text-surface-200/50 mb-1">WhatsApp Direct:</p>
                            <a href="https://wa.me/923105447307?text={{ urlencode('Hello Shahzad! I visited your portfolio (shahzadlabs.com) and would like to discuss a project with you.') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-emerald-400 hover:text-emerald-300 font-medium transition-colors">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                                <span>+92 310 5447307</span>
                            </a>
                        </div>
                        <div>
                            <p class="text-surface-200/50 mb-1">LinkedIn Profile:</p>
                            <a href="https://www.linkedin.com/in/shahzad-ali-b2a0063a9" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-blue-400 hover:text-blue-300 font-medium transition-colors">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                    <path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m1.4 9.74v-8.37H5.06v8.37h2.8z"/>
                                </svg>
                                <span>Shahzad Ali on LinkedIn &nearr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bottom copyright --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-surface-200/40">
                <p>&copy; {{ date('Y') }} Shahzad Labs (shahzadlabs.com). All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('sitemap') }}" class="hover:text-surface-200/70 transition-colors">Sitemap XML</a>
                    <span>&bull;</span>
                    <span>Built with Laravel &amp; Tailwind CSS</span>
                </div>
            </div>
        </div>
    </footer>

    {{-- Floating WhatsApp Quick-Action Button --}}
    <div class="fixed bottom-6 left-6 z-40">
        <a href="https://wa.me/923105447307?text={{ urlencode('Hello Shahzad! I visited your portfolio (shahzadlabs.com) and would like to discuss a project with you.') }}"
           target="_blank" rel="noopener"
           class="flex items-center gap-2 rounded-full bg-emerald-500 hover:bg-emerald-400 text-surface-950 font-semibold px-4 py-2.5 shadow-[0_8px_20px_rgba(16,185,129,0.35)] hover:shadow-[0_12px_28px_rgba(16,185,129,0.5)] transition-all duration-300 hover:scale-105"
           title="Chat on WhatsApp (+92 310 5447307)">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
            </svg>
            <span class="text-xs font-bold tracking-wide">Chat on WhatsApp</span>
        </a>
    </div>

    {{-- Toast Notification Container --}}
    <div id="toast-container" class="fixed bottom-6 right-6 z-50 flex flex-col gap-3"></div>

</body>
</html>
