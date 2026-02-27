<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'brand',
        'classification',
        'price',
        'size_volume',
        'quantity',
        'skin_types',
        'active_ingredients',
        'photo',
        'seller_id',
        'status',
        'is_verified',
        'average_rating',
        'review_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'skin_types' => 'array',
        'active_ingredients' => 'array',
        'is_verified' => 'boolean',
        'average_rating' => 'decimal:2',
    ];

    /**
     * Get the seller that owns the product.
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . uniqid();
            }
        });
    }

    /**
     * Check if product is in stock.
     */
    public function isInStock(): bool
    {
        return $this->quantity > 0;
    }

    /**
     * Check if product is low stock.
     */
    public function isLowStock(): bool
    {
        return $this->quantity > 0 && $this->quantity <= 5;
    }

    /**
     * Get stock status label.
     */
    public function getStockStatusLabel(): string
    {
        if ($this->quantity <= 0) {
            return 'Out of Stock';
        } elseif ($this->quantity <= 5) {
            return 'Low Stock';
        }
        return 'In Stock';
    }

    /**
     * Get stock status color.
     */
    public function getStockStatusColor(): string
    {
        if ($this->quantity <= 0) {
            return 'red';
        } elseif ($this->quantity <= 5) {
            return 'yellow';
        }
        return 'green';
    }

    /**
     * Scope a query to only include approved products.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include products from verified sellers.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope a query to filter by classification.
     */
    public function scopeByClassification($query, $classification)
    {
        return $query->where('classification', $classification);
    }

    /**
     * Scope a query to filter by skin type.
     */
    public function scopeBySkinType($query, $skinType)
    {
        return $query->whereJsonContains('skin_types', $skinType);
    }

    /**
     * Scope a query to filter by price range.
     */
    public function scopeByPriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    /**
     * Scope a query to filter by ingredients.
     */
    public function scopeByIngredient($query, $ingredient)
    {
        return $query->whereJsonContains('active_ingredients', $ingredient);
    }

    /**
     * Scope a query to only include in-stock products.
     */
    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    /**
     * Update product average rating and review count.
     */
    public function updateAverageRating(): void
    {
        $this->average_rating = $this->reviews()->avg('rating') ?? 0;
        $this->review_count = $this->reviews()->count();
        $this->save();
    }
}
