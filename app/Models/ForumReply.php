<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumReply extends Model
{
    protected $fillable = [
        'discussion_id',
        'user_id',
        'parent_reply_id',
        'content',
        'is_best_answer',
    ];

    protected $casts = [
        'is_best_answer' => 'boolean',
    ];

    /**
     * Get the discussion this reply belongs to.
     */
    public function discussion(): BelongsTo
    {
        return $this->belongsTo(ForumDiscussion::class, 'discussion_id');
    }

    /**
     * Get the user that created the reply.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent reply this reply is responding to.
     */
    public function parentReply(): BelongsTo
    {
        return $this->belongsTo(ForumReply::class, 'parent_reply_id');
    }

    /**
     * Get the child replies for this reply.
     */
    public function childReplies(): HasMany
    {
        return $this->hasMany(ForumReply::class, 'parent_reply_id');
    }
}
