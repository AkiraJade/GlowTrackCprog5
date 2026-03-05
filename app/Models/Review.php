<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'comment',
        'skin_type',
        'improvements_observed',
        'before_photo',
        'after_photo',
        'verified_purchase',
    ];

    protected $casts = [
        'rating' => 'integer',
        'verified_purchase' => 'boolean',
    ];

    /**
     * Get the product that owns the review.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that owns the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Update product average rating when review is created/updated/deleted
        static::saved(function ($review) {
            $review->product->updateAverageRating();
        });

        static::deleted(function ($review) {
            $review->product->updateAverageRating();
        });
    }

    /**
     * Get rating stars display.
     */
    public function getStarsAttribute(): string
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    /**
     * Scope a query to only include verified purchases.
     */
    public function scopeVerified($query)
    {
        return $query->where('verified_purchase', true);
    }

    /**
     * Scope a query to filter by rating.
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }
}
