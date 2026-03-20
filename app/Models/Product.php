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
        'low_stock_threshold',
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
     * Get the inventory logs for the product.
     */
    public function inventoryLogs(): HasMany
    {
        return $this->hasMany(InventoryLog::class);
    }

    /**
     * Adjust stock quantity directly and log the adjustment.
     */
    public function adjustStock(int $quantityChange, ?string $reason = null, ?string $referenceType = null, ?int $referenceId = null, ?string $notes = null): void
    {
        if ($quantityChange === 0) return;
        
        $previousStock = $this->quantity;
        $this->quantity += $quantityChange;
        $this->save();
        
        $this->inventoryLogs()->create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'previous_stock' => $previousStock,
            'quantity_change' => $quantityChange,
            'new_stock' => $this->quantity,
            'reason' => $reason,
            'notes' => $notes,
        ]);

        // Check if product is now low stock and notify seller
        if ($this->isLowStock() && $this->seller_id) {
            $notificationController = new \App\Http\Controllers\NotificationController();
            $notificationController::createNotification(
                $this->seller_id,
                'low_stock',
                'Low Stock Alert',
                "Your product '{$this->name}' is running low on stock ({$this->quantity} units remaining).",
                [
                    'product_id' => $this->id,
                    'current_stock' => $this->quantity,
                    'threshold' => $this->low_stock_threshold ?? 10
                ]
            );
        }
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
        $threshold = $this->low_stock_threshold ?? 10;
        return $this->quantity > 0 && $this->quantity <= $threshold;
    }

    /**
     * Get stock status label.
     */
    public function getStockStatusLabel(): string
    {
        if ($this->quantity <= 0) {
            return 'Out of Stock';
        }
        $threshold = $this->low_stock_threshold ?? 10;
        if ($this->quantity <= $threshold) {
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
        }
        $threshold = $this->low_stock_threshold ?? 10;
        if ($this->quantity <= $threshold) {
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

    /**
     * Calculate revenue for this product within a date range.
     */
    public function calculateRevenue($startDate = null, $endDate = null): float
    {
        return $this->orderItems()
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            })
            ->sum('price');
    }

    /**
     * Calculate order count for this product within a date range.
     */
    public function calculateOrders($startDate = null, $endDate = null): int
    {
        $query = $this->orderItems();
        
        if ($startDate && $endDate) {
            $query->whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            });
        }
        
        return $query->count();
    }

    /**
     * Calculate stock turnover rate for this product.
     */
    public function calculateStockTurnover($startDate = null, $endDate = null): float
    {
        $initialStock = $this->quantity + ($this->calculateOrders($startDate, $endDate) * 0);
        $finalStock = $this->quantity;
        
        if ($initialStock <= 0) return 0;
        
        $soldUnits = $this->calculateOrders($startDate, $endDate);
        $periodDays = $startDate && $endDate ? $startDate->diffInDays($endDate) : 30;
        
        return ($soldUnits / $initialStock) * ($periodDays / 30);
    }

    /**
     * Get seller performance metrics for this product.
     */
    public function getSellerPerformanceMetrics($startDate = null, $endDate = null): array
    {
        return [
            'revenue' => $this->calculateRevenue($startDate, $endDate),
            'orders' => $this->calculateOrders($startDate, $endDate),
            'rating' => $this->average_rating,
            'reviews' => $this->review_count,
            'stock_turnover' => $this->calculateStockTurnover($startDate, $endDate),
            'stock_status' => $this->getStockStatusLabel(),
            'is_performing' => $this->isPerforming($startDate, $endDate),
        ];
    }

    /**
     * Check if product is performing well.
     */
    public function isPerforming($startDate = null, $endDate = null): bool
    {
        $metrics = $this->getSellerPerformanceMetrics($startDate, $endDate);
        
        return $metrics['revenue'] >= 100 && 
               $metrics['orders'] >= 5 && 
               $metrics['rating'] >= 4.0;
    }

    /**
     * Get product category performance comparison.
     */
    public function getCategoryPerformance($allProducts = null): array
    {
        if (!$allProducts) {
            $allProducts = Product::where('classification', $this->classification)
                ->where('status', 'approved')
                ->get();
        }

        $categoryProducts = $allProducts->filter(function ($product) {
            return $product->classification === $this->classification;
        });

        if ($categoryProducts->isEmpty()) {
            return [
                'category' => $this->classification,
                'avg_revenue' => 0,
                'avg_orders' => 0,
                'avg_rating' => 0,
                'total_products' => 0,
                'rank' => 0,
                'percentile' => 0,
            ];
        }

        $totalRevenue = $categoryProducts->sum(function ($product) {
            return $product->calculateRevenue();
        });
        $totalOrders = $categoryProducts->sum(function ($product) {
            return $product->calculateOrders();
        });
        $avgRating = $categoryProducts->avg('average_rating');

        $productRevenue = $this->calculateRevenue();
        $productOrders = $this->calculateOrders();
        
        $rank = $categoryProducts
            ->sortByDesc('calculateRevenue')
            ->search(function ($product) use ($productRevenue) {
                return $product->calculateRevenue() === $productRevenue;
            })
            ->keys()
            ->first() + 1;

        $percentile = ($totalRevenue > 0) ? ($productRevenue / $totalRevenue) * 100 : 0;

        return [
            'category' => $this->classification,
            'avg_revenue' => $categoryProducts->avg('calculateRevenue'),
            'avg_orders' => $categoryProducts->avg('calculateOrders'),
            'avg_rating' => $avgRating,
            'total_products' => $categoryProducts->count(),
            'rank' => $rank,
            'percentile' => $percentile,
        ];
    }
}
