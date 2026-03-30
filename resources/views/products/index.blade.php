@extends('layouts.app')

@section('title', 'Products - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-xl p-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-3">Skincare Products 🧴</h1>
                        <p class="text-lg text-soft-brown opacity-75">Discover perfect products for your skin type</p>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('cart.index') }}" class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                            🛒 Cart ({{ Auth::user()?->cartItems()->count() ?? 0 }})
                        </a>
                        <a href="{{ route('dashboard') }}" class="px-6 py-3 border-2 border-soft-brown text-soft-brown rounded-full hover:bg-soft-brown hover:text-white transition font-semibold">
                            ← Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <div class="text-3xl mb-2">🧴</div>
                <div class="text-2xl font-bold text-jade-green">{{ $products->count() }}</div>
                <div class="text-sm text-soft-brown opacity-75">Total Products</div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <div class="text-3xl mb-2">⭐</div>
                <div class="text-2xl font-bold text-jade-green">{{ $products->where('status', 'approved')->count() }}</div>
                <div class="text-sm text-soft-brown opacity-75">Available</div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <div class="text-3xl mb-2">🏷️</div>
                <div class="text-2xl font-bold text-jade-green">{{ $products->avg('price') > 0 ? '₱' . number_format($products->avg('price'), 0) : 'N/A' }}</div>
                <div class="text-sm text-soft-brown opacity-75">Avg Price</div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <div class="text-3xl mb-2">🏪</div>
                <div class="text-2xl font-bold text-jade-green">{{ $products->pluck('seller_id')->unique()->count() }}</div>
                <div class="text-sm text-soft-brown opacity-75">Sellers</div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-2">Find Your Perfect Product 🔍</h2>
                <p class="text-soft-brown opacity-75">Filter by type, skin type, price, and more</p>
            </div>
            <form method="GET" action="{{ route('products.index') }}" class="space-y-6">
                <!-- Search Bar -->
                <div>
                    <label class="block text-sm font-semibold text-soft-brown mb-2">Search Products</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search products, brands, or ingredients..." 
                               class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-jade-green text-lg">
                        <span class="absolute left-4 top-3.5 text-2xl">🔍</span>
                    </div>
                </div>

                <!-- Filter Options -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Classification -->
                    <div>
                        <label class="block text-sm font-semibold text-soft-brown mb-2">Product Type</label>
                        <select name="classification" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-jade-green">
                            <option value="">All Types</option>
                            @foreach($classifications as $classification)
                                <option value="{{ $classification }}" {{ request('classification') == $classification ? 'selected' : '' }}>
                                    {{ $classification }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Skin Type -->
                    <div>
                        <label class="block text-sm font-semibold text-soft-brown mb-2">Skin Type</label>
                        <select name="skin_type" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-jade-green">
                            <option value="">All Skin Types</option>
                            <option value="Oily" {{ request('skin_type') == 'Oily' ? 'selected' : '' }}>Oily</option>
                            <option value="Dry" {{ request('skin_type') == 'Dry' ? 'selected' : '' }}>Dry</option>
                            <option value="Combination" {{ request('skin_type') == 'Combination' ? 'selected' : '' }}>Combination</option>
                            <option value="Sensitive" {{ request('skin_type') == 'Sensitive' ? 'selected' : '' }}>Sensitive</option>
                            <option value="Normal" {{ request('skin_type') == 'Normal' ? 'selected' : '' }}>Normal</option>
                        </select>
                    </div>

                    <!-- Min Price -->
                    <div>
                        <label class="block text-sm font-semibold text-soft-brown mb-2">Min Price</label>
                        <div class="relative">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" 
                                   placeholder="Min price" min="0" step="0.01"
                                   class="w-full pl-8 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-jade-green">
                            <span class="absolute left-3 top-3.5 text-lg">💰</span>
                        </div>
                    </div>

                    <!-- Max Price -->
                    <div>
                        <label class="block text-sm font-semibold text-soft-brown mb-2">Max Price</label>
                        <div class="relative">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" 
                                   placeholder="Max price" min="0" step="0.01"
                                   class="w-full pl-8 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-jade-green">
                            <span class="absolute left-3 top-3.5 text-lg">💵</span>
                        </div>
                    </div>
                </div>

                <!-- Filter Actions -->
                <div class="flex gap-4">
                    <button type="submit" class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-opacity-90 transition font-semibold">
                        Apply Filters
                    </button>
                    <a href="{{ route('products.index') }}" class="px-6 py-3 border-2 border-soft-brown text-soft-brown rounded-full hover:bg-soft-brown hover:text-white transition font-semibold">
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden h-64">
                            @if($product->photo)
                                <img src="{{ $product->photo_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-mint-cream to-light-sage flex items-center justify-center">
                                    <span class="text-6xl opacity-50">🧴</span>
                                </div>
                            @endif
                            
                            <!-- Status Badges -->
                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                @if($product->status === 'approved')
                                    <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">
                                        Available
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full">
                                        Unavailable
                                    </span>
                                @endif
                                
                                @if($product->quantity <= 10 && $product->quantity > 0)
                                    <span class="px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-full">
                                        Only {{ $product->quantity }} left
                                    </span>
                                @elseif($product->quantity === 0)
                                    <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full">
                                        Out of Stock
                                    </span>
                                @endif
                            </div>

                            <!-- Quick Actions -->
                            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                @if(auth()->check())
                                    <button onclick="event.stopPropagation(); toggleWishlist({{ $product->id }}, this)" 
                                            class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-red-50 transition">
                                        <span class="text-red-500">{{ in_array($product->id, $wishlistProductIds ?? []) ? '❤️' : '🤍' }}</span>
                                    </button>
                                @else
                                    <button onclick="event.stopPropagation(); alert('Please login to add items to your wishlist!')" 
                                            class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-red-50 transition">
                                        <span class="text-gray-400">🤍</span>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-6">
                            <div class="mb-4">
                                <h3 class="text-lg font-bold text-soft-brown mb-1 line-clamp-2 group-hover:text-jade-green transition">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-sm text-soft-brown opacity-75">{{ $product->brand }}</p>
                            </div>

                            <!-- Rating -->
                            @if($product->average_rating > 0)
                                <div class="flex items-center mb-4">
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($product->average_rating))
                                                ⭐
                                            @elseif($i - 0.5 <= $product->average_rating)
                                                ⭐
                                            @else
                                                ⭐
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-sm text-soft-brown opacity-75 ml-2">
                                        ({{ $product->review_count }} reviews)
                                    </span>
                                </div>
                            @else
                                <div class="text-sm text-soft-brown opacity-75 mb-4">No reviews yet</div>
                            @endif

                            <!-- Price and Actions -->
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <div class="text-2xl font-bold text-jade-green">
                                        ₱{{ number_format($product->price, 2) }}
                                    </div>
                                    <div class="text-sm text-soft-brown opacity-75">
                                        {{ $product->size_volume ?? '30ml' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Skin Types -->
                            @if($product->skin_types)
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach(explode(', ', $product->skin_types) as $skinType)
                                        <span class="px-2 py-1 bg-gradient-to-r from-mint-cream to-light-sage text-xs font-medium rounded-full text-soft-brown">
                                            {{ $skinType }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex gap-3">
                                <a href="{{ route('products.show', $product) }}" 
                                   class="flex-1 text-center px-4 py-2 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                                    View Details
                                </a>
                                @if($product->quantity > 0)
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" 
                                                class="w-full px-4 py-2 bg-jade-green text-white rounded-full hover:bg-opacity-90 transition font-semibold">
                                            Add to Cart
                                        </button>
                                    </form>
                                @else
                                    <button disabled 
                                            class="flex-1 px-4 py-2 bg-gray-300 text-gray-500 rounded-full cursor-not-allowed font-semibold">
                                        Out of Stock
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $products->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-3xl shadow-xl p-16 text-center">
                <div class="text-8xl mb-6 opacity-50">🔍</div>
                <h3 class="text-3xl font-bold text-soft-brown font-playfair mb-4">No Products Found</h3>
                <p class="text-lg text-soft-brown opacity-75 mb-8">Try adjusting your filters or search terms</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('products.index') }}" 
                       class="inline-flex items-center px-8 py-3 bg-jade-green text-white font-semibold rounded-full hover:bg-opacity-90 transition">
                        Clear Filters
                    </a>
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-8 py-3 border-2 border-soft-brown text-soft-brown font-semibold rounded-full hover:bg-soft-brown hover:text-white transition">
                        ← Dashboard
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function toggleWishlist(productId, button) {
    console.log('toggleWishlist called for product:', productId);
    console.log('Button element:', button);
    
    if (!button) {
        console.error('Error: button parameter is null or undefined.');
        return;
    }
    
    fetch(`/wishlist/toggle/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        console.log('data.success:', data.success);
        console.log('data.action:', data.action);
        console.log('data.message:', data.message);
        
        if (data.success) {
            // Update UI to show wishlist status
            if (data.action === 'added') {
                button.innerHTML = '<span class="text-red-500">❤️</span>';
            } else if (data.action === 'removed') {
                button.innerHTML = '<span class="text-gray-400">🤍</span>';
            } else {
                console.log('Unknown action:', data.action);
                alert('Unknown action received: ' + data.action);
            }
        } else {
            alert('Error updating wishlist: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating wishlist');
    });
}
</script>
@endsection
