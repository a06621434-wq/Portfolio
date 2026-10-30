<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model representing an admin reply sent to a contact inquiry message.
 *
 * @property int $id
 * @property int $message_id
 * @property int|null $user_id
 * @property string $subject
 * @property string $reply_body
 */
class MessageReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'user_id',
        'subject',
        'reply_body',
    ];

    /**
     * Parent inquiry message.
     */
    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * Admin user who sent this reply.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
