<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model representing an additional screenshot or gallery image for a Project.
 *
 * @property int $id
 * @property int $project_id
 * @property string $image
 * @property string|null $caption
 * @property int $order
 */
class ProjectImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'image',
        'caption',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Parent project relationship.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Public image URL accessor.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && (
            str_starts_with($this->image, 'http://') ||
            str_starts_with($this->image, 'https://') ||
            str_starts_with($this->image, 'data:image') ||
            str_starts_with($this->image, '/')
        )) {
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
