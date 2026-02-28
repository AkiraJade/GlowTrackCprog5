<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumDiscussion extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'category',
        'views',
        'reply_count',
        'is_pinned',
        'is_locked',
        'last_reply_at',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
        'last_reply_at' => 'datetime',
    ];

    /**
     * Get the user that created the discussion.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the replies for the discussion.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(ForumReply::class, 'discussion_id');
    }

    /**
     * Get the latest reply for the discussion.
     */
    public function latestReply()
    {
        return $this->hasOne(ForumReply::class, 'discussion_id')->latest();
    }
}
