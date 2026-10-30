<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Full CRUD resource controller for managing portfolio projects.
 */
class ProjectController extends Controller
{
    /**
     * List all projects (admin view).
     */
    public function index()
    {
        $projects = Project::displayOrder()->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show create project form.
     */
    public function create()
    {
        return view('admin.projects.form', [
            'project' => new Project(),
            'editing' => false,
        ]);
    }

    /**
     * Store a new project with optional gallery images.
     */
    public function store(ProjectRequest $request)
    {
        $data = $request->validated();
        $data['tech_stack'] = array_map('trim', explode(',', $data['tech_stack']));
        $data['slug'] = Str::slug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $data['image'] = $file->store('projects', 'public');
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->input('image_url');
        }

        unset($data['image_url'], $data['gallery_images'], $data['gallery_urls'], $data['delete_gallery_images']);
        $project = Project::create($data);

        // Handle uploaded gallery files
        if ($request->hasFile('gallery_images')) {
            $order = 1;
            foreach ($request->file('gallery_images') as $galleryFile) {
                if ($galleryFile && $galleryFile->isValid()) {
                    $path = $galleryFile->store('projects/gallery', 'public');
                    $project->galleryImages()->create([
                        'image' => $path,
                        'order' => $order++,
                    ]);
                }
            }
        }

        // Handle gallery URLs (newline or comma separated)
        if ($request->filled('gallery_urls')) {
            $urls = preg_split('/[\r\n,]+/', $request->input('gallery_urls'));
            $order = $project->galleryImages()->count() + 1;
            foreach ($urls as $url) {
                $trimmed = trim($url);
                if (!empty($trimmed) && filter_var($trimmed, FILTER_VALIDATE_URL)) {
                    $project->galleryImages()->create([
                        'image' => $trimmed,
                        'order' => $order++,
                    ]);
                }
            }
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully with gallery images.');
    }

    /**
     * Show edit project form.
     */
    public function edit(Project $project)
    {
        $project->load('galleryImages');

        return view('admin.projects.form', [
            'project' => $project,
            'editing' => true,
        ]);
    }

    /**
     * Update an existing project and its gallery.
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        $data['tech_stack'] = array_map('trim', explode(',', $data['tech_stack']));
        $data['slug'] = Str::slug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($project->image && !str_starts_with($project->image, 'http') && !str_starts_with($project->image, 'data:image')) {
                Storage::disk('public')->delete($project->image);
            }
            $data['image'] = $file->store('projects', 'public');
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->input('image_url');
        }

        // Handle deletion of existing gallery images
        if ($request->filled('delete_gallery_images')) {
            $deleteIds = $request->input('delete_gallery_images');
            $imagesToDelete = $project->galleryImages()->whereIn('id', $deleteIds)->get();
            foreach ($imagesToDelete as $img) {
                if ($img->image && !str_starts_with($img->image, 'http') && !str_starts_with($img->image, 'images/')) {
                    Storage::disk('public')->delete($img->image);
                }
                $img->delete();
            }
        }

        // Handle newly uploaded gallery files
        if ($request->hasFile('gallery_images')) {
            $order = ($project->galleryImages()->max('order') ?? 0);
            foreach ($request->file('gallery_images') as $galleryFile) {
                if ($galleryFile && $galleryFile->isValid()) {
                    $order++;
                    $path = $galleryFile->store('projects/gallery', 'public');
                    $project->galleryImages()->create([
                        'image' => $path,
                        'order' => $order,
                    ]);
                }
            }
        }

        // Handle newly added gallery URLs
        if ($request->filled('gallery_urls')) {
            $urls = preg_split('/[\r\n,]+/', $request->input('gallery_urls'));
            $order = ($project->galleryImages()->max('order') ?? 0) + 1;
            foreach ($urls as $url) {
                $trimmed = trim($url);
                if (!empty($trimmed) && filter_var($trimmed, FILTER_VALIDATE_URL)) {
                    $project->galleryImages()->create([
                        'image' => $trimmed,
                        'order' => $order++,
                    ]);
                }
            }
        }

        unset($data['image_url'], $data['gallery_images'], $data['gallery_urls'], $data['delete_gallery_images']);
        $project->update($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Delete a project and associated gallery images.
     */
    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        foreach ($project->galleryImages as $galleryImg) {
            if ($galleryImg->image && !str_starts_with($galleryImg->image, 'http') && !str_starts_with($galleryImg->image, 'images/')) {
                Storage::disk('public')->delete($galleryImg->image);
            }
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
