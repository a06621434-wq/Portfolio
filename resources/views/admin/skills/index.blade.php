@extends('admin.layout')
@section('title', 'Skills & Technical Stack')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="font-display text-2xl font-bold text-white tracking-tight">Skills & Tech Stack</h1>
            <p class="mt-1 text-sm text-surface-200/50">Manage technical proficiencies, frameworks, and tools displayed on your portfolio.</p>
        </div>
        <a href="{{ route('admin.skills.create') }}" class="btn-primary !text-xs self-start sm:self-auto flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Add New Skill
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 mb-8">
        <div class="glass-card p-4">
            <div class="text-xs text-surface-200/40 uppercase font-semibold">Total Skills</div>
            <div class="mt-1 text-2xl font-display font-bold text-white">{{ $totalSkills }}</div>
        </div>
        <div class="glass-card p-4">
            <div class="text-xs text-surface-200/40 uppercase font-semibold">Backend</div>
            <div class="mt-1 text-2xl font-display font-bold text-brand-400">{{ \App\Models\Skill::category('backend')->count() }}</div>
        </div>
        <div class="glass-card p-4">
            <div class="text-xs text-surface-200/40 uppercase font-semibold">Frontend</div>
            <div class="mt-1 text-2xl font-display font-bold text-accent-400">{{ \App\Models\Skill::category('frontend')->count() }}</div>
        </div>
        <div class="glass-card p-4">
            <div class="text-xs text-surface-200/40 uppercase font-semibold">Database & DevOps</div>
            <div class="mt-1 text-2xl font-display font-bold text-purple-400">{{ \App\Models\Skill::whereIn('category', ['database', 'devops'])->count() }}</div>
        </div>
    </div>

    @if($skills->isEmpty())
        <div class="glass-card p-12 text-center">
            <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-500/10 ring-1 ring-brand-500/20 text-brand-400 mb-4">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                </svg>
            </div>
            <h3 class="font-display text-lg font-bold text-white">No Skills Added Yet</h3>
            <p class="mt-1 text-sm text-surface-200/50 max-w-sm mx-auto">Add your first technical skill, programming language, or framework to showcase your stack on the website.</p>
            <div class="mt-6">
                <a href="{{ route('admin.skills.create') }}" class="btn-primary !text-xs">Add First Skill</a>
            </div>
        </div>
    @else
        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-white/[0.08] bg-white/[0.02] text-xs font-semibold text-surface-200/60 uppercase tracking-wider">
                            <th class="px-6 py-4">Skill & Icon</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Proficiency</th>
                            <th class="px-6 py-4">Experience</th>
                            <th class="px-6 py-4">Featured</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/[0.04]">
                        @foreach($skills as $skill)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            {{-- Skill & Icon --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 shrink-0 rounded-xl bg-surface-900 border border-white/[0.08] flex items-center justify-center text-xl shadow-inner">
                                        {{ $skill->icon ?: '⚡' }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-white">{{ $skill->name }}</div>
                                        <div class="text-xs text-surface-200/40">Order: {{ $skill->order }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Category --}}
                            <td class="px-6 py-4">
                                @php
                                    $catBadges = [
                                        'backend'  => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                        'frontend' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                        'database' => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
                                        'devops'   => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                        'tools'    => 'bg-pink-500/10 text-pink-400 border-pink-500/20',
                                    ];
                                @endphp
                                <span class="inline-flex rounded-lg border px-2.5 py-1 text-xs font-semibold uppercase tracking-wider {{ $catBadges[$skill->category] ?? 'bg-white/[0.05] text-surface-200/70 border-white/[0.1]' }}">
                                    {{ $skill->category }}
                                </span>
                            </td>

                            {{-- Proficiency Bar --}}
                            <td class="px-6 py-4 min-w-[160px]">
                                <div class="flex items-center justify-between text-xs font-mono mb-1.5">
                                    <span class="text-surface-200/60">Level</span>
                                    <span class="text-brand-400 font-bold">{{ $skill->proficiency }}%</span>
                                </div>
                                <div class="h-2 w-full rounded-full bg-surface-900 overflow-hidden ring-1 ring-white/[0.06]">
                                    <div class="h-full rounded-full bg-gradient-to-r from-brand-500 to-accent-400 transition-all duration-500" style="width: {{ $skill->proficiency }}%;"></div>
                                </div>
                            </td>

                            {{-- Experience --}}
                            <td class="px-6 py-4 text-surface-200/70 text-xs font-medium">
                                {{ $skill->experience ?: '—' }}
                            </td>

                            {{-- Featured --}}
                            <td class="px-6 py-4">
                                @if($skill->is_featured)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/10 px-2.5 py-0.5 text-xs font-medium text-accent-400 border border-accent-500/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-accent-400"></span>
                                        Featured
                                    </span>
                                @else
                                    <span class="text-xs text-surface-200/30">Standard</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.skills.edit', $skill) }}" class="p-2 rounded-lg text-surface-200/50 hover:text-brand-400 hover:bg-brand-500/10 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" onsubmit="return confirm('Are you sure you want to delete this skill?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-surface-200/50 hover:text-red-400 hover:bg-red-500/10 transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($skills->hasPages())
            <div class="px-6 py-4 border-t border-white/[0.08]">
                {{ $skills->links() }}
            </div>
            @endif
        </div>
    @endif
@endsection
