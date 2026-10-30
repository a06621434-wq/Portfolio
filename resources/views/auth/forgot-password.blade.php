<x-guest-layout>
    <div class="w-full">
        <div class="relative overflow-hidden rounded-3xl border border-white/[0.08] bg-surface-900/70 p-7 sm:p-9 backdrop-blur-2xl shadow-[0_25px_70px_-15px_rgba(0,0,0,0.8)]">
            
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-brand-500 via-indigo-500 to-accent-500"></div>

            <div class="text-center mb-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 border border-brand-500/20 text-brand-300 text-xs font-mono mb-3">
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    <span>Account Recovery</span>
                </div>
                <h1 class="font-display text-2xl font-bold text-white tracking-tight">
                    Reset Password
                </h1>
                <p class="text-xs text-surface-200/60 mt-1.5 leading-relaxed">
                    Enter your administrator email to receive a secure password reset link.
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-5 p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Error Alerts -->
            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-red-500/10 border border-red-500/30 text-red-300 text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-300/90">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-surface-200/80 mb-2">
                        Admin Email Address
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
                               value="{{ old('email') }}"
                               required
                               autofocus
                               placeholder="info@shahzadlabs.com"
                               class="w-full pl-10 pr-4 py-3 bg-surface-950/80 border border-white/[0.08] rounded-xl text-sm text-white placeholder-surface-200/30 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all">
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit"
                            class="w-full relative group overflow-hidden rounded-xl bg-gradient-to-r from-brand-500 via-indigo-600 to-accent-500 p-[1px] font-semibold text-white shadow-lg shadow-brand-500/20 hover:shadow-brand-500/35 transition-all duration-300 hover:scale-[1.01] active:scale-[0.99]">
                        <div class="w-full h-full bg-surface-950/40 group-hover:bg-transparent rounded-[11px] px-6 py-3.5 flex items-center justify-center gap-2 transition-all duration-300">
                            <span class="text-sm font-semibold tracking-wide">Send Password Reset Link</span>
                        </div>
                    </button>

                    <a href="{{ route('login') }}" class="text-center text-xs text-surface-200/60 hover:text-white transition-colors py-1">
                        ← Back to Sign In
                    </a>
                </div>
            </form>

        </div>
    </div>
</x-guest-layout>
