@extends('admin.layout')
@section('title', $editing ? 'Edit Skill: ' . $skill->name : 'Add New Skill')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.skills.index') }}" class="inline-flex items-center gap-1.5 text-sm text-surface-200/50 hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Skills
        </a>
    </div>

    <div class="glass-card p-8 max-w-2xl">
        <div class="flex items-center gap-3 mb-6 pb-6 border-b border-white/[0.08]">
            <div class="h-10 w-10 rounded-xl bg-brand-500/15 ring-1 ring-brand-500/30 flex items-center justify-center text-xl">
                {{ $skill->icon ?: '⚡' }}
            </div>
            <div>
                <h1 class="font-display text-xl font-bold text-white">
                    {{ $editing ? 'Edit Skill: ' . $skill->name : 'Add New Skill' }}
                </h1>
                <p class="text-xs text-surface-200/50">Configure technical proficiency, category, and display preferences.</p>
            </div>
        </div>

        <form method="POST"
              action="{{ $editing ? route('admin.skills.update', $skill) : route('admin.skills.store') }}"
              class="space-y-6">
            @csrf
            @if($editing) @method('PUT') @endif

            {{-- Skill Name & Icon --}}
            <div class="grid gap-6 sm:grid-cols-3">
                <div class="sm:col-span-2">
                    <label for="skill-name" class="block text-sm font-medium text-surface-200/70 mb-2">Skill / Technology Name</label>
                    <input type="text" id="skill-name" name="name" required value="{{ old('name', $skill->name) }}"
                           class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20"
                           placeholder="e.g., Laravel, Vue.js, Docker">
                    @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="skill-icon" class="block text-sm font-medium text-surface-200/70 mb-2">Icon / Emoji</label>
                    <input type="text" id="skill-icon" name="icon" value="{{ old('icon', $skill->icon ?? '⚡') }}" maxlength="10"
                           class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 text-center focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20"
                           placeholder="🐘, ⚛️, 🐬">
                    @error('icon') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Quick Emoji Suggestions --}}
            <div class="flex items-center gap-2 text-xs text-surface-200/40">
                <span>Quick pick:</span>
                @foreach(['🐘', '🔴', '🐬', '⚡', '🎨', '🔥', '☁️', '🐳', '🗄️', '🚀'] as $emoji)
                <button type="button" onclick="document.getElementById('skill-icon').value = '{{ $emoji }}'" class="p-1 rounded hover:bg-white/[0.06] text-base transition-colors">{{ $emoji }}</button>
                @endforeach
            </div>

            {{-- Category & Experience --}}
            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="skill-category" class="block text-sm font-medium text-surface-200/70 mb-2">Category</label>
                    <select id="skill-category" name="category" required
                            class="w-full rounded-xl border border-white/[0.08] bg-surface-950 px-4 py-3 text-sm text-white focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                        <option value="backend" {{ old('category', $skill->category) === 'backend' ? 'selected' : '' }}>⚙️ Backend (PHP, Laravel, APIs)</option>
                        <option value="frontend" {{ old('category', $skill->category) === 'frontend' ? 'selected' : '' }}>🎨 Frontend (JS, Tailwind, HTML/CSS)</option>
                        <option value="database" {{ old('category', $skill->category) === 'database' ? 'selected' : '' }}>🗄️ Database (MySQL, Redis, Eloquent)</option>
                        <option value="devops" {{ old('category', $skill->category) === 'devops' ? 'selected' : '' }}>🚀 DevOps & Cloud (Docker, CI/CD, Git)</option>
                        <option value="tools" {{ old('category', $skill->category) === 'tools' ? 'selected' : '' }}>🛠️ Tools & Architecture (MVC, REST, Testing)</option>
                    </select>
                    @error('category') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="skill-experience" class="block text-sm font-medium text-surface-200/70 mb-2">Experience <span class="text-surface-200/30">(optional)</span></label>
                    <input type="text" id="skill-experience" name="experience" value="{{ old('experience', $skill->experience) }}"
                           class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20"
                           placeholder="e.g., 4+ Years, Advanced">
                    @error('experience') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Proficiency Slider --}}
            <div x-data="{ proficiency: {{ old('proficiency', $skill->proficiency ?? 85) }} }" class="p-4 rounded-xl border border-white/[0.06] bg-white/[0.02]">
                <div class="flex items-center justify-between mb-2">
                    <label for="skill-proficiency" class="text-sm font-medium text-surface-200/80">Proficiency Level</label>
                    <span class="text-sm font-mono font-bold text-brand-400" x-text="proficiency + '%'"></span>
                </div>
                <input type="range" id="skill-proficiency" name="proficiency" min="1" max="100"
                       x-model="proficiency"
                       class="w-full accent-brand-500 cursor-pointer">
                <div class="flex justify-between text-[10px] text-surface-200/30 mt-1">
                    <span>Beginner (25%)</span>
                    <span>Intermediate (50%)</span>
                    <span>Proficient (75%)</span>
                    <span>Expert (100%)</span>
                </div>
                @error('proficiency') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            {{-- Order & Featured --}}
            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="skill-order" class="block text-sm font-medium text-surface-200/70 mb-2">Display Order</label>
                    <input type="number" id="skill-order" name="order" min="0" value="{{ old('order', $skill->order ?? 0) }}"
                           class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                </div>

                <div>
                    <label class="block text-sm font-medium text-surface-200/70 mb-2">Featured on Homepage</label>
                    <label class="flex items-center gap-3 rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 cursor-pointer hover:border-brand-500/30 transition-colors">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" value="1"
                               {{ old('is_featured', $skill->is_featured ?? true) ? 'checked' : '' }}
                               class="rounded border-white/20 bg-white/[0.05] text-brand-500 focus:ring-brand-500/30">
                        <span class="text-sm text-surface-200/70">Highlight in stack summary</span>
                    </label>
                </div>
            </div>

            {{-- Submit Buttons --}}
            <div class="flex items-center gap-3 pt-4 border-t border-white/[0.08]">
                <button type="submit" class="btn-primary !text-xs">
                    {{ $editing ? 'Save Changes' : 'Create Skill' }}
                </button>
                <a href="{{ route('admin.skills.index') }}" class="text-sm text-surface-200/50 hover:text-white transition-colors">Cancel</a>
            </div>
        </form>
    </div>
@endsection
