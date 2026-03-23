<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\SellerApplication;
use App\Models\SkinProfile;
use App\Models\SkinJournal;
use App\Models\SkincareRoutine;
use App\Models\Notification;
use App\Models\RoutineFavorite;
use App\Models\RoutineRating;
use App\Models\RoutineReview;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, CanResetPassword, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'address',
        'role',
        'status',
        'active',
        'deactivation_reason',
        'deactivated_at',
        'loyalty_points',
        'password',
        'last_seen_at',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'string',
            'active' => 'boolean',
            'deactivated_at' => 'datetime',
            'last_seen_at' => 'datetime',
        ];
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->active === true;
    }

    /**
     * Check if user is inactive
     */
    public function isInactive(): bool
    {
        return $this->active === false;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is seller
     */
    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    /**
     * Check if user is customer
     */
    public function isCustomer(): bool
    {
        // Treat any user who is not an admin or seller as a customer.
        return $this->role === 'customer' || (!in_array($this->role, ['admin', 'seller']));
    }

    /**
     * Get cart items for this user.
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get orders for this user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get wishlist items for this user.
     */
    public function wishlistItems()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get seller application for this user.
     */
    public function sellerApplication()
    {
        return $this->hasOne(SellerApplication::class);
    }

    /**
     * Get products for this user (if seller).
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    /**
     * Get skin profile for this user.
     */
    public function skinProfile()
    {
        return $this->hasOne(SkinProfile::class);
    }

    /**
     * Get skin journals for this user.
     */
    public function skinJournals()
    {
        return $this->hasMany(SkinJournal::class);
    }

    /**
     * Get skincare routines for this user.
     */
    public function skincareRoutines()
    {
        return $this->hasMany(SkincareRoutine::class);
    }

    /**
     * Get routine favorites for this user.
     */
    public function routineFavorites()
    {
        return $this->hasMany(RoutineFavorite::class);
    }

    /**
     * Get routine ratings for this user.
     */
    public function routineRatings()
    {
        return $this->hasMany(RoutineRating::class);
    }

    /**
     * Get routine reviews for this user.
     */
    public function routineReviews()
    {
        return $this->hasMany(RoutineReview::class);
    }

    /**
     * Get notifications for this user.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Check if the user has purchased a given product (non-cancelled orders).
     */
    public function hasPurchasedProduct(int $productId): bool
    {
        return $this->orders()
            ->where('status', '!=', 'cancelled')
            ->whereHas('orderItems', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();
    }

    /**
     * Check if user has a delivered order item for the product.
     */
    public function hasDeliveredProduct(int $productId): bool
    {
        return $this->orders()
            ->where('status', 'delivered')
            ->whereHas('orderItems', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();
    }

    /**
     * Calculate total revenue for this seller.
     */
    public function calculateRevenue($startDate = null, $endDate = null): float
    {
        return $this->products()
            ->where('status', 'approved')
            ->whereHas('orderItems', function ($query) use ($startDate, $endDate) {
                $query->whereHas('order', function ($orderQuery) use ($startDate, $endDate) {
                    if ($startDate && $endDate) {
                        $orderQuery->whereBetween('created_at', [$startDate, $endDate]);
                    }
                });
            })
            ->with(['orderItems.order'])
            ->get()
            ->sum(function ($product) {
                return $product->orderItems->sum('price');
            });
    }

    /**
     * Calculate total orders for this seller.
     */
    public function calculateOrders($startDate = null, $endDate = null): int
    {
        $query = Order::where('seller_id', $this->id);
        
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        return $query->count();
    }

    /**
     * Calculate fulfillment rate for this seller.
     */
    public function calculateFulfillmentRate($startDate = null, $endDate = null): float
    {
        $query = Order::where('seller_id', $this->id);
        
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        $totalOrders = $query->count();
        if ($totalOrders === 0) return 0;
        
        $deliveredOrders = $query->where('status', 'delivered')->count();
        
        return ($deliveredOrders / $totalOrders) * 100;
    }

    /**
     * Calculate average satisfaction score for this seller.
     */
    public function calculateSatisfactionScore($startDate = null, $endDate = null): float
    {
        $query = $this->products()
            ->where('status', 'approved')
            ->with('reviews');
        
        if ($startDate && $endDate) {
            $query->whereHas('reviews', function ($reviewQuery) use ($startDate, $endDate) {
                $reviewQuery->whereBetween('created_at', [$startDate, $endDate]);
            });
        }
        
        $products = $query->get();
        
        $totalReviews = 0;
        $totalRating = 0;
        
        foreach ($products as $product) {
            if ($product->reviews->isNotEmpty()) {
                $totalReviews += $product->reviews->count();
                $totalRating += $product->reviews->sum('rating');
            }
        }
        
        return $totalReviews > 0 ? $totalRating / $totalReviews : 0;
    }

    /**
     * Get seller performance metrics.
     */
    public function getPerformanceMetrics($startDate = null, $endDate = null): array
    {
        return [
            'revenue' => $this->calculateRevenue($startDate, $endDate),
            'orders' => $this->calculateOrders($startDate, $endDate),
            'fulfillment_rate' => $this->calculateFulfillmentRate($startDate, $endDate),
            'satisfaction_score' => $this->calculateSatisfactionScore($startDate, $endDate),
            'product_count' => $this->products()->where('status', 'approved')->count(),
            'avg_product_rating' => $this->products()->where('status', 'approved')->avg('average_rating') ?? 0,
            'total_reviews' => $this->products()->where('status', 'approved')->sum('review_count'),
        ];
    }

    /**
     * Get monthly performance trends.
     */
    public function getMonthlyPerformanceTrends($months = 12): array
    {
        $trends = [];
        $currentDate = now()->copy()->subMonths($months);
        
        for ($i = 0; $i < $months; $i++) {
            $monthStart = $currentDate->copy()->startOfMonth();
            $monthEnd = $currentDate->copy()->endOfMonth();
            
            $trends[$currentDate->format('Y-m')] = [
                'revenue' => $this->calculateRevenue($monthStart, $monthEnd),
                'orders' => $this->calculateOrders($monthStart, $monthEnd),
                'fulfillment_rate' => $this->calculateFulfillmentRate($monthStart, $monthEnd),
                'satisfaction_score' => $this->calculateSatisfactionScore($monthStart, $monthEnd),
            ];
            
            $currentDate->addMonth();
        }
        
        return $trends;
    }

    /**
     * Get top performing products for this seller.
     */
    public function getTopPerformingProducts($limit = 10, $startDate = null, $endDate = null): array
    {
        $query = $this->products()
            ->where('status', 'approved')
            ->with('reviews');
        
        if ($startDate && $endDate) {
            $query->whereHas('orderItems', function ($query) use ($startDate, $endDate) {
                $query->whereHas('order', function ($orderQuery) use ($startDate, $endDate) {
                    $orderQuery->whereBetween('created_at', [$startDate, $endDate]);
                });
            });
        }
        
        $products = $query->get();
        
        $performingProducts = [];
        foreach ($products as $product) {
            $revenue = $product->orderItems()
                ->whereHas('order', function ($query) use ($startDate, $endDate) {
                    if ($startDate && $endDate) {
                        $query->whereBetween('created_at', [$startDate, $endDate]);
                    }
                })
                ->sum('price');
            
            $orders = $product->orderItems()
                ->whereHas('order', function ($query) use ($startDate, $endDate) {
                    if ($startDate && $endDate) {
                        $query->whereBetween('created_at', [$startDate, $endDate]);
                    }
                })
                ->count();
            
            $performingProducts[] = [
                'product' => $product,
                'revenue' => $revenue,
                'orders' => $orders,
                'rating' => $product->average_rating,
                'reviews' => $product->review_count,
                'performance_score' => $this->calculateProductPerformanceScore($revenue, $orders, $product->average_rating, $product->review_count),
            ];
        }
        
        // Sort by performance score
        usort($performingProducts, function ($a, $b) {
            return $b['performance_score'] <=> $a['performance_score'];
        });
        
        return array_slice($performingProducts, 0, $limit);
    }

    /**
     * Calculate performance score for a product.
     */
    private function calculateProductPerformanceScore($revenue, $orders, $rating, $reviews): float
    {
        $revenueScore = min(40, ($revenue / 100) * 40); // Max 40 points
        $orderScore = min(30, ($orders / 5) * 30); // Max 30 points
        $ratingScore = ($rating / 5) * 20; // Max 20 points
        $reviewScore = min(10, ($reviews / 10) * 10); // Max 10 points
        
        return $revenueScore + $orderScore + $ratingScore + $reviewScore;
    }

    /**
     * Check if seller is active based on recent activity.
     */
    public function isSellerActive(): bool
    {
        return $this->seller_status === 'active' && 
               $this->calculateOrders(now()->subDays(30), now()) > 0;
    }

    /**
     * Get seller tier based on performance.
     */
    public function getSellerTier(): string
    {
        $metrics = $this->getPerformanceMetrics(now()->subDays(90), now());
        
        if ($metrics['revenue'] >= 50000 && $metrics['fulfillment_rate'] >= 95 && $metrics['satisfaction_score'] >= 4.5) {
            return 'Platinum';
        } elseif ($metrics['revenue'] >= 25000 && $metrics['fulfillment_rate'] >= 90 && $metrics['satisfaction_score'] >= 4.0) {
            return 'Gold';
        } elseif ($metrics['revenue'] >= 10000 && $metrics['fulfillment_rate'] >= 85 && $metrics['satisfaction_score'] >= 3.5) {
            return 'Silver';
        } elseif ($metrics['revenue'] >= 5000 && $metrics['fulfill_rate'] >= 80 && $metrics['satisfaction_score'] >= 3.0) {
            return 'Bronze';
        }
        
        return 'Standard';
    }

    /**
     * Check if a product is in user's wishlist.
     */
    public function isInWishlist($productId)
    {
        return $this->wishlistItems()->where('product_id', $productId)->exists();
    }

    /**
     * Add product to wishlist.
     */
    public function addToWishlist($productId)
    {
        if (!$this->isInWishlist($productId)) {
            return $this->wishlistItems()->create(['product_id' => $productId]);
        }
        return null;
    }

    /**
     * Remove product from wishlist.
     */
    public function removeFromWishlist($productId)
    {
        return $this->wishlistItems()->where('product_id', $productId)->delete();
    }

    /**
     * Add loyalty points to user's account
     */
    public function addLoyaltyPoints(int $points): void
    {
        $this->increment('loyalty_points', $points);
    }

    /**
     * Calculate loyalty points for an order based on quantity
     * 1 point per quantity (1 quantity = 1 point, 10 quantity = 10 points)
     */
    public static function calculateLoyaltyPoints(int $quantity): int
    {
        return $quantity;
    }

    /**
     * Get the user's photo URL with fallback to default avatar
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            // Check if file exists in storage
            if (Storage::disk('public')->exists('user_photos/' . $this->photo)) {
                return asset('storage/user_photos/' . $this->photo);
            }
        }
        
        // Return default avatar based on user's name initials
        $initials = collect(explode(' ', $this->name))
            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
            ->take(2)
            ->implode('');
            
        return "https://ui-avatars.com/api/?name={$initials}&color=ffffff&background=4a7c59&size=200&bold=true";
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new \App\Notifications\CustomPasswordResetNotification($token));
    }

}
