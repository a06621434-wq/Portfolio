<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Project model for the Shahzad Labs portfolio.
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string|null $image
 * @property array $tech_stack
 * @property string|null $live_url
 * @property string|null $github_url
 * @property string $category
 * @property string|null $metric
 * @property int $order
 * @property bool $is_featured
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'tech_stack',
        'live_url',
        'github_url',
        'category',
        'metric',
        'order',
        'is_featured',
    ];

    protected $casts = [
        'tech_stack'  => 'array',
        'is_featured' => 'boolean',
        'order'       => 'integer',
    ];

    /**
     * Auto-generate slug from title on creation.
     */
    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    /**
     * Scope: filter by category.
     */
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: featured projects only.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: ordered display.
     */
    public function scopeDisplayOrder($query)
    {
        return $query->orderBy('order')->orderByDesc('created_at');
    }

    /**
     * Gallery images relationship.
     */
    public function galleryImages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('order')->orderBy('id');
    }

    /**
     * Get the public image URL.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://') || str_starts_with($this->image, 'data:image') || str_starts_with($this->image, '/'))) {
            return $this->image;
        }

        if ($this->image && str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }

        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/project-placeholder.svg');
    }
}
