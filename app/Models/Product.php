<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'expiry_date',
        'inventory_notes',
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
        'expiry_date' => 'date',
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
     * Get the images for the product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->ordered();
    }

    /**
     * Get the primary image for the product.
     */
    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->primary();
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
     * Get the cart items for this product.
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
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

    /**
     * Check if product is expiring soon (within 30 days).
     */
    public function isExpiringSoon(): bool
    {
        if (!$this->expiry_date) {
            return false;
        }
        
        return $this->expiry_date->lte(now()->addDays(30));
    }

    /**
     * Check if product is expired.
     */
    public function isExpired(): bool
    {
        if (!$this->expiry_date) {
            return false;
        }
        
        return $this->expiry_date->lt(now());
    }

    /**
     * Get expiry status label.
     */
    public function getExpiryStatusLabel(): string
    {
        if (!$this->expiry_date) {
            return 'Not specified';
        }
        
        if ($this->isExpired()) {
            return 'Expired';
        }
        
        if ($this->isExpiringSoon()) {
            return 'Expiring Soon';
        }
        
        return 'Good';
    }

    /**
     * Get expiry status color.
     */
    public function getExpiryStatusColor(): string
    {
        if (!$this->expiry_date) {
            return 'gray';
        }
        
        if ($this->isExpired()) {
            return 'red';
        }
        
        if ($this->isExpiringSoon()) {
            return 'yellow';
        }
        
        return 'green';
    }

    /**
     * Scope a query to only include expired products.
     */
    public function scopeExpired($query)
    {
        return $query->whereNotNull('expiry_date')
                    ->where('expiry_date', '<', now());
    }

    /**
     * Scope a query to only include products expiring soon.
     */
    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->whereNotNull('expiry_date')
                    ->where('expiry_date', '<=', now()->addDays($days))
                    ->where('expiry_date', '>', now());
    }

    /**
     * Get the photo URL attribute (for backward compatibility).
     */
    public function getPhotoUrlAttribute(): string
    {
        // If product has multiple images, return the primary one
        if ($this->images()->exists()) {
            return $this->images()->first()->image_url;
        }
        
        // Fallback to old single photo field
        if ($this->photo) {
            $photoPath = $this->photo;

            // support both raw filename and products/<filename>
            if (!str_contains($photoPath, '/')) {
                $photoPath = 'products/' . $photoPath;
            }

            return asset('storage/' . $photoPath);
        }

        return asset('images/default-product.jpg');
    }

    /**
     * Get all image URLs for the product.
     */
    public function getAllImageUrlsAttribute(): array
    {
        if ($this->images()->exists()) {
            return $this->images->pluck('image_url')->toArray();
        }
        
        return $this->photo ? [asset('storage/' . $this->photo)] : [asset('images/default-product.jpg')];
    }
}
