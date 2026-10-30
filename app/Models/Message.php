<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Message model for contact form inquiries.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $message
 * @property bool $is_read
 */
class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'is_read',
        'replied_at',
    ];

    protected $casts = [
        'is_read'    => 'boolean',
        'replied_at' => 'datetime',
    ];

    /**
     * Replies sent to this message.
     */
    public function replies(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MessageReply::class)->latest();
    }

    /**
     * Check if this message has been replied to.
     */
    public function getIsRepliedAttribute(): bool
    {
        return !is_null($this->replied_at);
    }

    /**
     * Scope: unread messages.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
