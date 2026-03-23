<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(): void
    {
        $this->is_read = true;
        $this->read_at = now();
        $this->save();
    }

    /**
     * Mark notification as unread.
     */
    public function markAsUnread(): void
    {
        $this->is_read = false;
        $this->read_at = null;
        $this->save();
    }

    /**
     * Scope a query to only include unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope a query to only include read notifications.
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get formatted created at time.
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get notification icon based on type.
     */
    public function getIconAttribute(): string
    {
        return match($this->type) {
            'order_status' => '📦',
            'delivery_update' => '🚚',
            'low_stock' => '⚠️',
            'product_approved' => '✅',
            'product_rejected' => '❌',
            'seller_approved' => '🎉',
            'seller_rejected' => '😞',
            'new_review' => '⭐',
            'promotion' => '🎁',
            'admin_action' => '👨‍💼',
            'new_seller_application' => '📋',
            'system_alert' => '🚨',
            'security_alert' => '🔒',
            'account_reactivated' => '✅',
            'account_deactivated' => '🚫',
            default => '🔔',
        };
    }

    /**
     * Get notification color based on type.
     */
    public function getColorAttribute(): string
    {
        return match($this->type) {
            'order_status' => 'blue',
            'delivery_update' => 'green',
            'low_stock' => 'yellow',
            'product_rejected', 'seller_rejected' => 'red',
            'product_approved', 'seller_approved' => 'green',
            'new_review' => 'purple',
            'promotion' => 'pink',
            'admin_action' => 'indigo',
            'new_seller_application' => 'orange',
            'system_alert' => 'red',
            'security_alert' => 'red',
            'account_reactivated' => 'green',
            'account_deactivated' => 'red',
            default => 'gray',
        };
    }
}
