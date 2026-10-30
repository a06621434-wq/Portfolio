<x-guest-layout>

    <div x-data="{
        showPassword: false,
        email: '{{ old('email', 'info@shahzadlabs.com') }}',
        password: '',
        fillDemo() {
            this.email = 'info@shahzadlabs.com';
            this.password = 'password';
        }
    }" class="w-full">

        {{-- Main Glass Card Container --}}
        <div class="relative overflow-hidden rounded-3xl border border-white/[0.08] bg-surface-900/70 p-7 sm:p-9 backdrop-blur-2xl shadow-[0_25px_70px_-15px_rgba(0,0,0,0.8)]">
            
            {{-- Top Accent Gradient Bar --}}
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-brand-500 via-indigo-500 to-accent-500"></div>

            {{-- Security Badge & Header --}}
            <div class="text-center mb-7">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 border border-brand-500/20 text-brand-300 text-xs font-mono mb-4">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Admin Authentication</span>
                </div>
                <h1 class="font-display text-2xl sm:text-3xl font-bold text-white tracking-tight">
                    Welcome Back
                </h1>
                <p class="text-xs sm:text-sm text-surface-200/60 mt-1.5 leading-relaxed">
                    Sign in to access your administrative control center.
                </p>
            </div>

            {{-- 1-Click Demo Credentials Card --}}
            <div class="mb-6 p-3.5 rounded-2xl bg-white/[0.02] border border-white/[0.06] flex items-center justify-between gap-3">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-7 h-7 rounded-lg bg-brand-500/15 border border-brand-500/30 flex items-center justify-center text-brand-400 shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <div class="truncate text-[11px] leading-tight">
                        <span class="text-white font-medium">Default:</span>
                        <span class="text-surface-200/60 font-mono">info@shahzadlabs.com</span>
                    </div>
                </div>
                <button type="button"
                        @click="fillDemo()"
                        class="px-2.5 py-1 rounded-lg text-[11px] font-medium text-brand-400 hover:text-white bg-brand-500/10 hover:bg-brand-500/20 border border-brand-500/30 transition-colors shrink-0">
                    Auto-Fill
                </button>
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-5 p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{-- Error Alerts --}}
            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-red-500/10 border border-red-500/30 text-red-300 text-xs space-y-1">
                    <div class="flex items-center gap-2 font-semibold text-red-200">
                        <svg class="w-4 h-4 shrink-0 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span>Authentication Failed</span>
                    </div>
                    @foreach ($errors->all() as $error)
                        <p class="text-red-300/80 pl-6">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email Address --}}
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-surface-200/80 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-surface-200/40">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                        <input id="email"
                               type="email"
                               name="email"
                               x-model="email"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="you@shahzadlabs.com"
                               class="w-full pl-10 pr-4 py-3 bg-surface-950/80 border border-white/[0.08] rounded-xl text-sm text-white placeholder-surface-200/30 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-surface-200/80">
                            Password
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-brand-400 hover:text-brand-300 transition-colors">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-surface-200/40">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input id="password"
                               :type="showPassword ? 'text' : 'password'"
                               name="password"
                               x-model="password"
                               required
                               autocomplete="current-password"
                               placeholder="••••••••••••"
                               class="w-full pl-10 pr-11 py-3 bg-surface-950/80 border border-white/[0.08] rounded-xl text-sm text-white placeholder-surface-200/30 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all">
                        <button type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-surface-200/40 hover:text-surface-200 transition-colors focus:outline-none">
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center">
                    <label for="remember_me" class="inline-flex items-center gap-2.5 cursor-pointer">
                        <input id="remember_me"
                               type="checkbox"
                               name="remember"
                               class="w-4 h-4 rounded border-white/[0.1] bg-surface-950 text-brand-500 focus:ring-brand-500/20 focus:ring-offset-surface-950 cursor-pointer">
                        <span class="text-xs text-surface-200/70 select-none">Remember this browser session</span>
                    </label>
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                        class="w-full relative group overflow-hidden rounded-xl bg-gradient-to-r from-brand-500 via-indigo-600 to-accent-500 p-[1px] font-semibold text-white shadow-lg shadow-brand-500/20 hover:shadow-brand-500/35 transition-all duration-300 hover:scale-[1.01] active:scale-[0.99]">
                    <div class="w-full h-full bg-surface-950/40 group-hover:bg-transparent rounded-[11px] px-6 py-3.5 flex items-center justify-center gap-2 transition-all duration-300">
                        <span class="text-sm font-semibold tracking-wide">Enter Admin Console</span>
                        <svg class="w-4 h-4 text-brand-300 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </div>
                </button>
            </form>

        </div>

    </div>

</x-guest-layout>
