@extends('admin.layout')
@section('title', $editing ? 'Edit: ' . $project->title : 'New Project')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center gap-1.5 text-sm text-surface-200/50 hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Projects
        </a>
    </div>

    <div class="glass-card p-8 max-w-4xl">
        <div class="flex items-center justify-between pb-6 mb-6 border-b border-white/[0.08]">
            <div>
                <h1 class="font-display text-xl font-bold text-white">
                    {{ $editing ? 'Edit Project: ' . $project->title : 'Create New Project' }}
                </h1>
                <p class="mt-1 text-xs text-surface-200/50">Provide project details, screenshots, live links, and technologies used.</p>
            </div>
            @if($editing)
                <a href="{{ route('projects.show', $project->slug) }}" target="_blank" class="text-xs text-brand-400 hover:text-brand-300 flex items-center gap-1">
                    <span>Preview Live</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            @endif
        </div>

        <form method="POST"
              action="{{ $editing ? route('admin.projects.update', $project) : route('admin.projects.store') }}"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf
            @if($editing) @method('PUT') @endif

            {{-- Title --}}
            <div>
                <label for="project-title" class="block text-sm font-medium text-surface-200/70 mb-2">Project Title *</label>
                <input type="text" id="project-title" name="title" required value="{{ old('title', $project->title) }}"
                       class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20"
                       placeholder="e.g., Enterprise SaaS Cloud Portal">
                @error('title') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            {{-- ═══════════════════════════════════════════════════════════
                 IMAGE UPLOAD & URL SECTION (ENHANCED)
            ═══════════════════════════════════════════════════════════ --}}
            <div class="rounded-2xl border border-brand-500/20 bg-brand-500/5 p-6" x-data="{ imagePreview: '{{ $editing && $project->image ? $project->image_url : '' }}', useUrl: false }">
                <div class="flex items-center justify-between mb-3">
                    <label class="block text-sm font-semibold text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                        </svg>
                        Project Thumbnail / Featured Image
                    </label>
                    <div class="flex items-center gap-2 text-xs">
                        <button type="button" @click="useUrl = false" :class="!useUrl ? 'text-brand-400 font-bold underline' : 'text-surface-200/50 hover:text-white'">Upload File</button>
                        <span class="text-surface-200/30">|</span>
                        <button type="button" @click="useUrl = true" :class="useUrl ? 'text-brand-400 font-bold underline' : 'text-surface-200/50 hover:text-white'">Paste Image URL</button>
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-3 items-start">
                    {{-- File Dropzone / URL Input --}}
                    <div class="sm:col-span-2 space-y-3">
                        <div x-show="!useUrl">
                            <label for="project-image-input" class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-white/20 rounded-2xl cursor-pointer bg-white/[0.02] hover:bg-white/[0.05] hover:border-brand-500/50 transition-all">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                    <svg class="w-8 h-8 mb-2 text-brand-400/80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                    </svg>
                                    <p class="text-xs text-white font-medium"><span class="text-brand-400 font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-[11px] text-surface-200/40 mt-1">PNG, JPG, WebP or SVG (Max 5MB)</p>
                                </div>
                                <input id="project-image-input" name="image" type="file" accept="image/*" class="hidden"
                                       @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => imagePreview = e.target.result; reader.readAsDataURL(file); }">
                            </label>
                        </div>

                        <div x-show="useUrl" style="display: none;">
                            <label for="project-image-url" class="block text-xs text-surface-200/60 mb-1">Direct Image URL</label>
                            <input type="url" id="project-image-url" name="image_url"
                                   @input="imagePreview = $event.target.value"
                                   value="{{ old('image_url', (str_starts_with($project->image ?? '', 'http') ? $project->image : '')) }}"
                                   class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20"
                                   placeholder="https://images.unsplash.com/photo-...">
                        </div>
                        @error('image') <p class="text-xs text-red-400">{{ $message }}</p> @enderror
                        @error('image_url') <p class="text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- Live Image Preview --}}
                    <div class="sm:col-span-1">
                        <div class="text-xs text-surface-200/50 mb-1 font-medium">Live Card Preview:</div>
                        <div class="relative aspect-[16/10] w-full rounded-xl overflow-hidden bg-surface-900 border border-white/[0.1] shadow-md flex items-center justify-center">
                            <template x-if="imagePreview">
                                <img :src="imagePreview" alt="Project preview" onerror="this.onerror=null;this.src='{{ asset('images/project-placeholder.svg') }}';" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!imagePreview">
                                <div class="text-center p-4">
                                    <svg class="w-8 h-8 text-surface-200/30 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-[10px] text-surface-200/40">No image chosen</span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════════
                 PROJECT IMAGE GALLERY (MULTIPLE SCREENSHOTS & VIEWS)
            ═══════════════════════════════════════════════════════════ --}}
            <div class="rounded-2xl border border-white/[0.08] bg-white/[0.02] p-6" x-data="{
                newImages: [],
                handleFileSelect(event) {
                    this.newImages = [];
                    const files = event.target.files;
                    for (let i = 0; i < files.length; i++) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.newImages.push({
                                name: files[i].name,
                                url: e.target.result,
                                size: (files[i].size / 1024).toFixed(1) + ' KB'
                            });
                        };
                        reader.readAsDataURL(files[i]);
                    }
                }
            }">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-semibold text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/>
                        </svg>
                        Project Screenshots Gallery (Detail Page Showcase)
                    </label>
                    <span class="text-[11px] text-surface-200/50">Multiple images allowed</span>
                </div>
                <p class="text-xs text-surface-200/50 mb-5">
                    Add high-resolution screenshots, mobile/tablet views, UI workflows, or architectural diagrams to display in the project case study detail page.
                </p>

                {{-- Existing Gallery Images (for edit mode) --}}
                @if($editing && $project->galleryImages->isNotEmpty())
                <div class="mb-6 p-4 rounded-xl border border-white/[0.06] bg-surface-950/60">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold text-white uppercase tracking-wider">
                            Current Gallery Images ({{ $project->galleryImages->count() }})
                        </span>
                        <span class="text-[11px] text-surface-200/40">Check "Remove" to delete on save</span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($project->galleryImages as $img)
                        <div class="relative group rounded-xl overflow-hidden border border-white/[0.1] bg-surface-900 aspect-[16/10]">
                            <img src="{{ $img->image_url }}" alt="Gallery image" onerror="this.onerror=null;this.src='{{ asset('images/project-placeholder.svg') }}';" class="w-full h-full object-cover">
                            
                            {{-- Delete Checkbox Overlay --}}
                            <label class="absolute inset-x-0 bottom-0 p-2 bg-gradient-to-t from-black/90 via-black/60 to-transparent flex items-center justify-between cursor-pointer">
                                <span class="text-[11px] font-medium text-red-300 flex items-center gap-1.5">
                                    <input type="checkbox" name="delete_gallery_images[]" value="{{ $img->id }}"
                                           class="rounded border-red-500/50 bg-red-950/50 text-red-500 focus:ring-red-500/40 w-3.5 h-3.5">
                                    Remove
                                </span>
                                <span class="text-[10px] text-surface-200/40">#{{ $loop->iteration }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="grid gap-6 sm:grid-cols-2">
                    {{-- Upload Multiple Files --}}
                    <div>
                        <label class="block text-xs font-medium text-surface-200/70 mb-2">Upload Files From Computer</label>
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-white/20 rounded-xl cursor-pointer bg-white/[0.01] hover:bg-white/[0.04] hover:border-accent-400/50 transition-all">
                            <div class="flex flex-col items-center justify-center p-3 text-center">
                                <svg class="w-6 h-6 mb-1 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                <p class="text-xs text-white font-medium">Select Multiple Images</p>
                                <p class="text-[10px] text-surface-200/40 mt-0.5">JPG, PNG, WebP (hold Ctrl to select multiple)</p>
                            </div>
                            <input name="gallery_images[]" type="file" accept="image/*" multiple class="hidden"
                                   @change="handleFileSelect($event)">
                        </label>
                    </div>

                    {{-- Or Paste Direct Image URLs --}}
                    <div>
                        <label for="project-gallery-urls" class="block text-xs font-medium text-surface-200/70 mb-2">
                            Or Paste Direct Image URLs <span class="text-surface-200/40">(one URL per line)</span>
                        </label>
                        <textarea id="project-gallery-urls" name="gallery_urls" rows="4"
                                  class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-3.5 py-2.5 text-xs text-white placeholder-surface-200/30 focus:border-accent-400/50 focus:outline-none focus:ring-2 focus:ring-accent-400/20 resize-none font-mono"
                                  placeholder="https://example.com/screenshot1.png&#10;https://example.com/screenshot2.png">{{ old('gallery_urls') }}</textarea>
                    </div>
                </div>

                {{-- Live Previews of Newly Selected Upload Files --}}
                <div x-show="newImages.length > 0" class="mt-4 pt-4 border-t border-white/[0.08]" style="display: none;">
                    <div class="text-xs font-semibold text-accent-400 mb-2 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Selected for Upload (<span x-text="newImages.length"></span> new images):</span>
                    </div>
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                        <template x-for="(img, idx) in newImages" :key="idx">
                            <div class="relative aspect-[16/10] rounded-lg overflow-hidden border border-accent-400/40 bg-surface-900 group shadow">
                                <img :src="img.url" :alt="img.name" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity p-1 flex items-end">
                                    <span class="text-[9px] text-white truncate" x-text="img.name"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                @error('gallery_images') <p class="mt-2 text-xs text-red-400">{{ $message }}</p> @enderror
                @error('gallery_images.*') <p class="mt-2 text-xs text-red-400">{{ $message }}</p> @enderror
                @error('gallery_urls') <p class="mt-2 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="project-desc" class="block text-sm font-medium text-surface-200/70 mb-2">Description & Case Study Details *</label>
                <textarea id="project-desc" name="description" required rows="4"
                          class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20 resize-none"
                          placeholder="Describe the application features, problem solved, architecture, and results...">{{ old('description', $project->description) }}</textarea>
                @error('description') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                {{-- Category --}}
                <div>
                    <label for="project-category" class="block text-sm font-medium text-surface-200/70 mb-2">Category *</label>
                    <select id="project-category" name="category" required
                            class="w-full rounded-xl border border-white/[0.08] bg-surface-950 px-4 py-3 text-sm text-white focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                        <option value="laravel" {{ old('category', $project->category) === 'laravel' ? 'selected' : '' }}>Laravel / PHP Core</option>
                        <option value="frontend" {{ old('category', $project->category) === 'frontend' ? 'selected' : '' }}>Modern Frontend</option>
                        <option value="fullstack" {{ old('category', $project->category) === 'fullstack' ? 'selected' : '' }}>Full-Stack WebApp</option>
                        <option value="saas" {{ old('category', $project->category) === 'saas' ? 'selected' : '' }}>SaaS Cloud Platform</option>
                    </select>
                    @error('category') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Tech Stack --}}
                <div>
                    <label for="project-tech" class="block text-sm font-medium text-surface-200/70 mb-2">Tech Stack <span class="text-surface-200/30">(comma-separated)</span> *</label>
                    <input type="text" id="project-tech" name="tech_stack" required
                           value="{{ old('tech_stack', is_array($project->tech_stack) ? implode(', ', $project->tech_stack) : $project->tech_stack) }}"
                           class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20"
                           placeholder="Laravel 11, MySQL, Tailwind CSS, Alpine.js">
                    @error('tech_stack') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                {{-- Live URL --}}
                <div>
                    <label for="project-live" class="block text-sm font-medium text-surface-200/70 mb-2">Live Demo URL</label>
                    <input type="url" id="project-live" name="live_url" value="{{ old('live_url', $project->live_url) }}"
                           class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20"
                           placeholder="https://demo.shahzadlabs.com/...">
                    @error('live_url') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- GitHub URL --}}
                <div>
                    <label for="project-github" class="block text-sm font-medium text-surface-200/70 mb-2">GitHub Repository URL</label>
                    <input type="url" id="project-github" name="github_url" value="{{ old('github_url', $project->github_url) }}"
                           class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20"
                           placeholder="https://github.com/shahzadlabs/...">
                    @error('github_url') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                {{-- Metric --}}
                <div>
                    <label for="project-metric" class="block text-sm font-medium text-surface-200/70 mb-2">Key Metric / Result</label>
                    <input type="text" id="project-metric" name="metric" value="{{ old('metric', $project->metric) }}"
                           class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20"
                           placeholder="e.g., 99.9% Uptime, 3x Speed">
                </div>

                {{-- Order --}}
                <div>
                    <label for="project-order" class="block text-sm font-medium text-surface-200/70 mb-2">Display Order</label>
                    <input type="number" id="project-order" name="order" min="0" value="{{ old('order', $project->order ?? 0) }}"
                           class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 text-sm text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                </div>

                {{-- Featured --}}
                <div>
                    <label class="block text-sm font-medium text-surface-200/70 mb-2">Featured Project</label>
                    <label class="flex items-center gap-3 rounded-xl border border-white/[0.08] bg-white/[0.03] px-4 py-3 cursor-pointer hover:border-brand-500/30 transition-colors">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" value="1"
                               {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}
                               class="rounded border-white/20 bg-white/[0.05] text-brand-500 focus:ring-brand-500/30">
                        <span class="text-sm text-surface-200/70">Pin to Hero</span>
                    </label>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-3 pt-6 border-t border-white/[0.08]">
                <button type="submit" class="btn-primary !text-xs">
                    {{ $editing ? 'Save Changes' : 'Create Project' }}
                </button>
                <a href="{{ route('admin.projects.index') }}" class="text-sm text-surface-200/50 hover:text-white transition-colors">Cancel</a>
            </div>
        </form>
    </div>
@endsection
