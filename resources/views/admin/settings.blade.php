@extends('admin.layout')
@section('title', 'Site Branding & Media')

@section('content')
    <div class="mb-8">
        <h1 class="font-display text-2xl font-bold text-white tracking-tight">Site Branding, Hero Image &amp; Favicon</h1>
        <p class="mt-1 text-sm text-surface-200/50">Upload or change the primary image used across the Hero Section, Navbar Logo, and Browser Favicon.</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-8 max-w-4xl"
          x-data="{
              heroPreview: '{{ $siteSettings['hero_image_url'] }}',
              logoPreview: '{{ $siteSettings['site_logo_url'] }}',
              faviconPreview: '{{ $siteSettings['favicon_url'] }}',
              syncHero: true
          }">
        @csrf

        {{-- ═══════════════════════════════════════════════════════════
             1. HERO PROFILE / AVATAR IMAGE (PRIMARY)
        ═══════════════════════════════════════════════════════════ --}}
        <div class="glass-card p-8 ring-1 ring-brand-500/30 bg-gradient-to-br from-brand-500/5 to-surface-950">
            <div class="flex items-start justify-between mb-6 pb-4 border-b border-white/[0.08]">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-brand-500/20 text-brand-300 text-xs font-semibold uppercase tracking-wider mb-2">
                        Primary Brand Visual
                    </div>
                    <h2 class="font-display text-lg font-bold text-white">Hero Section Profile / Brand Image</h2>
                    <p class="text-xs text-surface-200/50 mt-0.5">This image is showcased prominently in the Hero Section of your website.</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-brand-500/15 flex items-center justify-center text-brand-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-3 items-center">
                {{-- Dropzone / URL --}}
                <div class="sm:col-span-2 space-y-4">
                    <label for="hero-image-upload" class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-white/20 rounded-2xl cursor-pointer bg-white/[0.02] hover:bg-white/[0.05] hover:border-brand-500/50 transition-all">
                        <div class="flex flex-col items-center justify-center text-center px-4">
                            <svg class="w-8 h-8 mb-2 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                            </svg>
                            <p class="text-xs text-white font-medium"><span class="text-brand-400 font-semibold">Click to upload photo</span> or drag &amp; drop</p>
                            <p class="text-[11px] text-surface-200/40 mt-1">PNG, JPG, WebP, or SVG (Max 5MB)</p>
                        </div>
                        <input id="hero-image-upload" name="hero_image" type="file" accept="image/*" class="hidden"
                               @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { heroPreview = e.target.result; if(syncHero) { logoPreview = e.target.result; faviconPreview = e.target.result; } }; reader.readAsDataURL(file); }">
                    </label>

                    <div>
                        <label for="hero-url" class="block text-xs text-surface-200/60 mb-1">Or Paste Direct Image URL:</label>
                        <input type="url" id="hero-url" name="hero_image_url"
                               @input="heroPreview = $event.target.value; if(syncHero) { logoPreview = $event.target.value; faviconPreview = $event.target.value; }"
                               value="{{ $settings['hero_image_url'] ?? (str_starts_with($settings['hero_image'] ?? '', 'http') ? $settings['hero_image'] : '') }}"
                               placeholder="https://images.unsplash.com/photo-..."
                               class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-2.5 text-xs text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none">
                    </div>

                    {{-- ONE-CLICK SYNC TOGGLE (Exactly what user asked for) --}}
                    <div class="pt-2">
                        <label class="flex items-start gap-3 p-3.5 rounded-xl border border-accent-500/30 bg-accent-500/10 cursor-pointer hover:bg-accent-500/15 transition-colors">
                            <input type="checkbox" name="sync_hero_to_all" value="1" x-model="syncHero" checked
                                   class="mt-0.5 rounded border-accent-500/40 bg-surface-950 text-accent-500 focus:ring-accent-500/30">
                            <div>
                                <span class="text-xs font-bold text-accent-300 block">Use this same image for Navbar Logo &amp; Favicon automatically</span>
                                <span class="text-[11px] text-surface-200/60">One upload instantly updates your Hero profile card, Navbar logo icon, and browser tab Favicon.</span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Hero Preview Box --}}
                <div class="sm:col-span-1 text-center">
                    <span class="text-xs text-surface-200/50 font-medium block mb-2">Live Hero Preview (Round Shape):</span>
                    <div class="relative mx-auto w-36 h-36 rounded-full overflow-hidden border-2 border-brand-500/40 shadow-xl bg-surface-900 ring-4 ring-brand-500/20">
                        <img :src="heroPreview" alt="Hero preview" class="w-full h-full object-cover rounded-full">
                        <div class="absolute bottom-2 right-2 h-4 w-4 rounded-full bg-emerald-400 ring-2 ring-surface-950 animate-pulse" title="Online Status"></div>
                    </div>
                    <span class="text-[10px] text-surface-200/40 mt-2 block">Hero Round Visual</span>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════
             2. LIVE PREVIEW SIMULATOR (NAVBAR & BROWSER TAB)
        ═══════════════════════════════════════════════════════════ --}}
        <div class="glass-card p-6">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-surface-200/50 mb-4">Live Preview Simulator</h3>
            <div class="grid gap-6 sm:grid-cols-2">
                
                {{-- Simulated Browser Tab with Favicon --}}
                <div class="p-4 rounded-xl border border-white/[0.08] bg-surface-900/90">
                    <span class="text-[10px] uppercase font-semibold text-surface-200/40 block mb-2">Browser Tab &bull; Favicon Preview</span>
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-t-lg bg-surface-950 border border-white/[0.08] max-w-xs">
                        <div class="w-4 h-4 rounded-full overflow-hidden shrink-0 border border-white/20 bg-surface-800">
                            <img :src="faviconPreview" alt="Favicon" class="w-full h-full object-cover rounded-full">
                        </div>
                        <span class="text-xs text-white/90 truncate font-sans">Shahzad Labs — Portfolio</span>
                        <span class="ml-auto text-[10px] text-surface-200/30">&times;</span>
                    </div>
                </div>

                {{-- Simulated Navbar Brand Logo --}}
                <div class="p-4 rounded-xl border border-white/[0.08] bg-surface-900/90">
                    <span class="text-[10px] uppercase font-semibold text-surface-200/40 block mb-2">Navbar Header &bull; Brand Icon Preview</span>
                    <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-surface-950/80 border border-white/[0.08]">
                        <div class="w-8 h-8 rounded-full overflow-hidden shrink-0 border border-brand-500/40 ring-2 ring-brand-500/20 bg-surface-800 shadow">
                            <img :src="logoPreview" alt="Logo icon" class="w-full h-full object-cover rounded-full">
                        </div>
                        <span class="font-display text-sm font-bold text-white tracking-tight">Shahzad<span class="text-brand-400">Labs</span></span>
                    </div>
                </div>

            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════
             3. CUSTOM OVERRIDES (OPTIONAL SEPARATE LOGO / FAVICON)
        ═══════════════════════════════════════════════════════════ --}}
        <div x-show="!syncHero" style="display: none;" class="glass-card p-6 space-y-6">
            <h3 class="text-sm font-bold text-white">Custom Logo &amp; Favicon Overrides (Optional)</h3>
            <p class="text-xs text-surface-200/50">Only fill these if you want a separate custom icon different from your Hero image.</p>

            <div class="grid gap-6 sm:grid-cols-2">
                {{-- Custom Logo --}}
                <div class="p-4 rounded-xl border border-white/[0.08] bg-white/[0.02]">
                    <label class="block text-xs font-semibold text-white mb-2">Custom Navbar Logo</label>
                    <input type="file" name="site_logo" accept="image/*" class="w-full text-xs text-surface-200/50 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-brand-500/15 file:text-brand-400"
                           @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => logoPreview = e.target.result; reader.readAsDataURL(file); }">
                    <input type="url" name="site_logo_url" placeholder="Or logo URL..." @input="logoPreview = $event.target.value" class="mt-2 w-full rounded-lg border border-white/[0.08] bg-white/[0.03] px-3 py-1.5 text-xs text-white placeholder-surface-200/30">
                </div>

                {{-- Custom Favicon --}}
                <div class="p-4 rounded-xl border border-white/[0.08] bg-white/[0.02]">
                    <label class="block text-xs font-semibold text-white mb-2">Custom Favicon (.ico / .png)</label>
                    <input type="file" name="favicon" accept="image/*,.ico" class="w-full text-xs text-surface-200/50 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-brand-500/15 file:text-brand-400"
                           @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => faviconPreview = e.target.result; reader.readAsDataURL(file); }">
                    <input type="url" name="favicon_url" placeholder="Or favicon URL..." @input="faviconPreview = $event.target.value" class="mt-2 w-full rounded-lg border border-white/[0.08] bg-white/[0.03] px-3 py-1.5 text-xs text-white placeholder-surface-200/30">
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════
             4. BRANDING TEXT & HERO HEADLINES
        ═══════════════════════════════════════════════════════════ --}}
        <div class="glass-card p-6 space-y-4">
            <h3 class="text-sm font-bold text-white mb-2">Developer Information &amp; Hero Headlines</h3>
            
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="dev-name" class="block text-xs font-medium text-surface-200/70 mb-1">Developer / Brand Name</label>
                    <input type="text" id="dev-name" name="developer_name" value="{{ $siteSettings['developer_name'] }}"
                           class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-2.5 text-xs text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none">
                </div>
                <div>
                    <label for="dev-role" class="block text-xs font-medium text-surface-200/70 mb-1">Professional Role / Title</label>
                    <input type="text" id="dev-role" name="developer_role" value="{{ $siteSettings['developer_role'] }}"
                           class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-2.5 text-xs text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none">
                </div>
            </div>

            <div>
                <label for="hero-tagline" class="block text-xs font-medium text-surface-200/70 mb-1">Hero Sub-Headline / Tagline</label>
                <input type="text" id="hero-tagline" name="hero_tagline" value="{{ $siteSettings['hero_tagline'] }}"
                       class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-2.5 text-xs text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none">
            </div>
        </div>

        {{-- Save Button --}}
        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="btn-primary !px-6 !py-3 !text-xs flex items-center gap-2 shadow-lg">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Save All Branding &amp; Media</span>
            </button>
        </div>
    </form>
@endsection
