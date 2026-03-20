<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\SellerApplication;
use App\Models\SkinProfile;
use App\Models\SkinJournal;
use App\Models\SkincareRoutine;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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
        ];
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
}
