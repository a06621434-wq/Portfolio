<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>{{ config('app.name', 'Shahzad Labs') }} — Secure Admin Portal</title>

    {{-- Favicons --}}
    <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface-950 text-surface-200 font-sans antialiased selection:bg-brand-500/30 min-h-screen flex flex-col relative overflow-x-hidden">

    {{-- Ambient Background Glows --}}
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-brand-500/15 rounded-full blur-[120px]"></div>
        <div class="absolute top-1/3 -right-40 w-96 h-96 bg-purple-600/15 rounded-full blur-[140px]"></div>
        <div class="absolute -bottom-40 left-1/3 w-96 h-96 bg-accent-500/10 rounded-full blur-[130px]"></div>
        
        {{-- Subtle Grid Pattern --}}
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff05_1px,transparent_1px),linear-gradient(to_bottom,#ffffff05_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_50%,#000_70%,transparent_100%)]"></div>
    </div>

    {{-- Top Header / Nav --}}
    <header class="relative z-10 w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
            <div class="h-10 w-10 rounded-full overflow-hidden border border-brand-500/40 ring-2 ring-brand-500/20 bg-surface-900 flex items-center justify-center shadow-lg transition-all duration-300 group-hover:ring-brand-400/50">
                <img src="{{ $siteSettings['site_logo_url'] ?? asset('images/shahzad-ali.png') }}" alt="Logo" onerror="this.onerror=null;this.src='{{ asset('images/shahzad-ali.png') }}';" class="w-full h-full object-cover rounded-full">
            </div>
            <div>
                <div class="font-display text-base font-bold text-white tracking-tight flex items-center gap-1.5">
                    <span>Shahzad</span><span class="text-brand-400">Labs</span>
                </div>
                <div class="text-[10px] uppercase font-mono tracking-wider text-surface-200/50">Admin Console</div>
            </div>
        </a>

        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-medium text-surface-200/70 hover:text-white bg-white/[0.03] hover:bg-white/[0.08] border border-white/[0.08] transition-all duration-200">
            <svg class="w-3.5 h-3.5 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Back to Portfolio</span>
        </a>
    </header>

    {{-- Main Content Slot --}}
    <main class="relative z-10 flex-1 flex flex-col justify-center items-center px-4 sm:px-6 py-8">
        <div class="w-full sm:max-w-md">
            {{ $slot }}
        </div>
    </main>

    {{-- Footer --}}
    <footer class="relative z-10 py-6 text-center text-xs text-surface-200/40 border-t border-white/[0.04]">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p>&copy; {{ date('Y') }} Shahzad Labs. All rights reserved.</p>
            <div class="inline-flex items-center gap-2 font-mono text-[11px] text-surface-200/50">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>TLS 256-bit Encrypted Session</span>
            </div>
        </div>
    </footer>

</body>
</html>
