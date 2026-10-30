<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates project creation and update payloads.
 * Handles image upload validation and tech_stack normalization.
 */
class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Auth middleware handles access control
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'],
            'image_url'   => ['nullable', 'url', 'max:500'],
            'tech_stack'  => ['required', 'string'],  // Comma-separated, parsed in controller
            'live_url'    => ['nullable', 'url', 'max:500'],
            'github_url'  => ['nullable', 'url', 'max:500'],
            'category'    => ['required', 'in:laravel,frontend,fullstack,saas'],
            'metric'      => ['nullable', 'string', 'max:255'],
            'order'       => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'gallery_images'   => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'],
            'gallery_urls'     => ['nullable', 'string', 'max:5000'],
            'delete_gallery_images'   => ['nullable', 'array'],
            'delete_gallery_images.*' => ['integer'],
        ];
    }
}
