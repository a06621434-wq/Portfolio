@extends('admin.layout')
@section('title', 'Projects')

@section('content')
    <div class="space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2">
            <div>
                <h1 class="font-display text-2xl font-bold text-white tracking-tight">Projects Portfolio</h1>
                <p class="mt-1 text-sm text-surface-200/50">Manage published projects, case studies, screenshots, and live demo links.</p>
            </div>
            <a href="{{ route('admin.projects.create') }}" class="btn-primary !text-xs !py-2.5 !px-4 self-start sm:self-auto flex items-center gap-2 shadow-sm shadow-brand-500/20 whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                <span>Add New Project</span>
            </a>
        </div>

        @if($projects->isEmpty())
            <div class="glass-card p-12 text-center">
                <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-500/10 ring-1 ring-brand-500/20 text-brand-400 mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-6A1.125 1.125 0 012.25 11.625v-4.5z"/>
                    </svg>
                </div>
                <h3 class="font-display text-lg font-bold text-white">No Projects Found</h3>
                <p class="mt-1 text-sm text-surface-200/50 max-w-sm mx-auto">Get started by adding your first project to display on the portfolio.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.projects.create') }}" class="btn-primary !text-xs">Add First Project</a>
                </div>
            </div>
        @else
            {{-- Responsive Table Container --}}
            <div class="glass-card overflow-hidden w-full max-w-full border border-white/[0.08]">
                <div class="overflow-x-auto scrollbar-thin w-full max-w-full block">
                    <table class="w-full text-left border-collapse min-w-[880px] table-fixed">
                        <colgroup>
                            <col class="w-[30%]">
                            <col class="w-[14%]">
                            <col class="w-[24%]">
                            <col class="w-[11%]">
                            <col class="w-[9%]">
                            <col class="w-[12%]">
                        </colgroup>
                        <thead>
                            <tr class="border-b border-white/[0.08] bg-white/[0.02]">
                                <th scope="col" class="py-4 px-5 text-xs font-semibold uppercase tracking-wider text-surface-200/50">Thumbnail &amp; Title</th>
                                <th scope="col" class="py-4 px-4 text-xs font-semibold uppercase tracking-wider text-surface-200/50">Category</th>
                                <th scope="col" class="py-4 px-4 text-xs font-semibold uppercase tracking-wider text-surface-200/50">Tech Stack</th>
                                <th scope="col" class="py-4 px-4 text-xs font-semibold uppercase tracking-wider text-surface-200/50">Featured</th>
                                <th scope="col" class="py-4 px-3 text-xs font-semibold uppercase tracking-wider text-surface-200/50">Links</th>
                                <th scope="col" class="py-4 px-5 text-right text-xs font-semibold uppercase tracking-wider text-surface-200/50">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/[0.04]">
                            @foreach($projects as $project)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                {{-- Thumbnail & Title --}}
                                <td class="py-4 px-5 align-middle">
                                    <div class="flex items-center gap-3.5 min-w-0 max-w-full">
                                        <div class="h-12 w-16 shrink-0 rounded-xl overflow-hidden bg-surface-900 border border-white/[0.08] shadow-sm relative">
                                            <img src="{{ $project->image_url }}" alt="{{ $project->title }}" onerror="this.onerror=null;this.src='{{ asset('images/project-placeholder.svg') }}';" class="h-full w-full object-cover">
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <a href="{{ route('admin.projects.edit', $project) }}" class="font-semibold text-white text-sm hover:text-brand-300 transition-colors block truncate" title="{{ $project->title }}">
                                                {{ $project->title }}
                                            </a>
                                            <div class="text-[11px] text-surface-200/40 mt-0.5 truncate font-mono">
                                                Order: {{ $project->order }} &bull; /{{ $project->slug }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Category --}}
                                <td class="py-4 px-4 align-middle">
                                    <span class="inline-flex items-center rounded-lg bg-white/[0.04] px-2.5 py-1 text-xs font-semibold uppercase tracking-wider text-surface-200/80 border border-white/[0.08] truncate max-w-full" title="{{ $project->category }}">
                                        {{ $project->category }}
                                    </span>
                                </td>

                                {{-- Tech Stack --}}
                                <td class="py-4 px-4 align-middle">
                                    <div class="flex flex-wrap gap-1.5 items-center max-w-full">
                                        @foreach(array_slice($project->tech_stack, 0, 3) as $tech)
                                        <span class="inline-flex items-center rounded-md bg-brand-500/10 px-2 py-0.5 text-[11px] font-medium text-brand-300 border border-brand-500/20 truncate max-w-[110px]" title="{{ $tech }}">
                                            {{ $tech }}
                                        </span>
                                        @endforeach
                                        @if(count($project->tech_stack) > 3)
                                        <span class="text-[10px] text-surface-200/40 font-mono font-medium self-center px-1 shrink-0">
                                            +{{ count($project->tech_stack) - 3 }}
                                        </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Featured --}}
                                <td class="py-4 px-4 align-middle whitespace-nowrap">
                                    @if($project->is_featured)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/10 px-2.5 py-1 text-xs font-medium text-accent-400 border border-accent-500/20 whitespace-nowrap">
                                        <span class="h-1.5 w-1.5 rounded-full bg-accent-400 animate-pulse"></span>
                                        Featured
                                    </span>
                                    @else
                                    <span class="inline-flex items-center rounded-full bg-white/[0.02] px-2.5 py-1 text-xs text-surface-200/40 border border-white/[0.06] whitespace-nowrap">
                                        Standard
                                    </span>
                                    @endif
                                </td>

                                {{-- Links --}}
                                <td class="py-4 px-3 align-middle whitespace-nowrap">
                                    <div class="flex items-center gap-2 whitespace-nowrap">
                                        @if($project->live_url)
                                        <a href="{{ $project->live_url }}" target="_blank" rel="noopener" class="p-1.5 rounded-lg text-brand-400 hover:text-white hover:bg-brand-500/20 transition-colors inline-flex items-center justify-center" title="Open Live Website: {{ $project->live_url }}">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                        @endif
                                        @if($project->github_url)
                                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener" class="p-1.5 rounded-lg text-surface-200/60 hover:text-white hover:bg-white/[0.08] transition-colors inline-flex items-center justify-center" title="View Source Code on GitHub">
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                        @endif
                                        @if(!$project->live_url && !$project->github_url)
                                        <span class="text-xs text-surface-200/30 font-mono">&mdash;</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="py-4 px-5 align-middle text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                        <a href="{{ route('admin.projects.edit', $project) }}" class="p-2 rounded-lg text-surface-200/60 hover:text-brand-400 hover:bg-brand-500/10 transition-colors inline-flex items-center justify-center shrink-0" title="Edit Project">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Delete this project permanently?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg text-surface-200/40 hover:text-red-400 hover:bg-red-500/10 transition-colors inline-flex items-center justify-center shrink-0" title="Delete Project">
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

                @if($projects->hasPages())
                <div class="px-6 py-4 border-t border-white/[0.08]">
                    {{ $projects->links() }}
                </div>
                @endif
            </div>
        @endif
    </div>
@endsection
