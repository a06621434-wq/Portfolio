<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Skill model for technical proficiencies at Shahzad Labs.
 *
 * @property int $id
 * @property string $name
 * @property string $category
 * @property int $proficiency
 * @property string|null $icon
 * @property string|null $experience
 * @property int $order
 * @property bool $is_featured
 */
class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'proficiency',
        'icon',
        'experience',
        'order',
        'is_featured',
    ];

    protected $casts = [
        'proficiency' => 'integer',
        'order'       => 'integer',
        'is_featured' => 'boolean',
    ];

    /**
     * Scope: filter by category.
     */
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: featured skills only.
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
        return $query->orderBy('order')->orderBy('name');
    }
}
