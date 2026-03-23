@extends('layouts.app')

@section('title', 'Products - GlowTrack')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Skincare Products</h1>
            <p class="text-gray-600 mt-2">Discover the perfect products for your skin type</p>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-6">
                <form method="GET" action="{{ route('products.index') }}" class="space-y-4">
                    <!-- Search Bar -->
                    <div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search products, brands, or ingredients..." 
                               class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                    </div>

                    <!-- Filter Options -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Classification -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Type</label>
                            <select name="classification" class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
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
                            <label class="block text-sm font-medium text-gray-700 mb-1">Skin Type</label>
                            <select name="skin_type" class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
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
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min Price</label>
                            <input type="number" name="min_price" value="{{ request('min_price') }}" 
                                   placeholder="Min price" min="0" step="0.01"
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                        </div>

                        <!-- Max Price -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                            <input type="number" name="max_price" value="{{ request('max_price') }}" 
                                   placeholder="Max price" min="0" step="0.01"
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                        </div>

                        <!-- Stock Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock Status</label>
                            <select name="stock_filter" class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                <option value="all" {{ request('stock_filter', 'all') === 'all' ? 'selected' : '' }}>All Stock Levels</option>
                                <option value="in_stock" {{ request('stock_filter') === 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                <option value="low_stock" {{ request('stock_filter') === 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                                <option value="out_of_stock" {{ request('stock_filter') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </div>

                        <!-- Min Rating -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min Rating</label>
                            <select name="min_rating" class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                <option value="">Any Rating</option>
                                @foreach([1,2,3,4,5] as $rating)
                                    <option value="{{ $rating }}" {{ request('min_rating') == $rating ? 'selected' : '' }}>{{ $rating }}+</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Ingredients -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Key Ingredient</label>
                            <select name="ingredient" class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                <option value="">All Ingredients</option>
                                @foreach($ingredients as $ingredient)
                                    <option value="{{ $ingredient }}" {{ request('ingredient') == $ingredient ? 'selected' : '' }}>
                                        {{ $ingredient }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Additional Filters -->
                    <div class="flex flex-wrap items-center gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="verified_only" value="1" 
                                   {{ request('verified_only') ? 'checked' : '' }}
                                   class="mr-2 border-gray-300 rounded text-jade-green focus:ring-jade-green">
                            <span class="text-sm text-gray-700">Verified sellers only</span>
                        </label>

                        <!-- Sort Options -->
                        <div class="flex items-center space-x-2">
                            <label class="text-sm font-medium text-gray-700">Sort by:</label>
                            <select name="sort_by" class="border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Latest</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Price</option>
                                <option value="average_rating" {{ request('sort_by') == 'average_rating' ? 'selected' : '' }}>Rating</option>
                            </select>
                            <select name="sort_order" class="border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Desc</option>
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Asc</option>
                            </select>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex space-x-4">
                        <button type="submit" class="px-4 py-2 bg-jade-green text-white rounded-md hover:bg-opacity-90 transition">
                            Apply Filters
                        </button>
                        <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                            Clear Filters
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="mb-8">
            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
                            <!-- Product Image -->
                            <div class="relative">
                                @if($product->photo)
                                    <img src="{{ $product->photo_url }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-48 object-cover object-center rounded-t-lg">
                                @else
                                    <div class="w-full h-48 bg-gray-200 rounded-t-lg flex items-center justify-center">
                                        <span class="text-gray-400">No Image</span>
                                    </div>
                                @endif
                                
                                <!-- Verified Badge -->
                                @if($product->is_verified)
                                    <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                        ✓ Verified
                                    </div>
                                @endif

                                <!-- Stock Status -->
                                <div class="absolute bottom-2 left-2">
                                    @if($product->isInStock())
                                        <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                            In Stock
                                        </span>
                                    @else
                                        <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <!-- Brand and Classification -->
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs text-gray-500">{{ $product->brand }}</span>
                                    <span class="text-xs bg-jade-green text-white px-2 py-1 rounded-full">
                                        {{ $product->classification }}
                                    </span>
                                </div>

                                <!-- Product Name -->
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                    <a href="{{ route('products.show', $product) }}" class="hover:text-jade-green transition">
                                        {{ $product->name }}
                                    </a>
                                </h3>

                                <!-- Price and Rating -->
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-lg font-bold text-gray-900">₱{{ number_format($product->price, 2) }}</span>
                                    @if($product->review_count > 0)
                                        <div class="flex items-center">
                                            <span class="text-yellow-400">★</span>
                                            <span class="text-sm text-gray-600">{{ number_format($product->average_rating, 1) }} ({{ $product->review_count }})</span>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500">No reviews</span>
                                    @endif
                                </div>

                                <!-- Size and Skin Types -->
                                <div class="text-sm text-gray-600 mb-3">
                                    <div>{{ $product->size_volume }}</div>
                                    <div class="text-xs">
                                        @foreach((array) $product->skin_types as $skinType)
                                            <span class="bg-gray-100 px-1 py-0.5 rounded">{{ $skinType }}</span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Key Ingredients -->
                                @if($product->active_ingredients)
                                    <div class="text-xs text-gray-500 mb-3">
                                        <strong>Key ingredients:</strong> {{ implode(', ', array_slice((array) $product->active_ingredients, 0, 2)) }}
                                        @if(count((array) $product->active_ingredients) > 2)
                                            +{{ count((array) $product->active_ingredients) - 2 }} more
                                        @endif
                                    </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    @auth
                                        <form method="POST" action="{{ route('wishlist.toggle') }}" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="button" 
                                                    onclick="toggleWishlist(this, {{ $product->id }})"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md hover:bg-gray-50 transition flex items-center justify-center gap-2 wishlist-btn"
                                                    data-in-wishlist="{{ in_array($product->id, $wishlistProductIds) ? 'true' : 'false' }}">
                                                <span class="wishlist-icon">
                                                    @if(in_array($product->id, $wishlistProductIds))
                                                        ❤️
                                                    @else
                                                        🤍
                                                    @endif
                                                </span>
                                                <span class="wishlist-text">
                                                    @if(in_array($product->id, $wishlistProductIds))
                                                        In Wishlist
                                                    @else
                                                        Wishlist
                                                    @endif
                                                </span>
                                            </button>
                                        </form>
                                        @if($product->isInStock())
                                            <form method="POST" action="{{ route('cart.add', $product->id) }}" class="flex-1">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="w-full px-3 py-2 bg-jade-green text-white rounded-md hover:bg-opacity-90 transition">
                                                    Add to Cart
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-md hover:bg-gray-50 transition flex items-center justify-center gap-2">
                                            🤍 Wishlist
                                        </a>
                                        @if($product->isInStock())
                                            <a href="{{ route('login') }}" class="flex-1 px-3 py-2 bg-jade-green text-white rounded-md hover:bg-opacity-90 transition text-center">
                                                Add to Cart
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-500">Try adjusting your filters or search terms</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function toggleWishlist(button, productId) {
    const form = button.closest('form');
    const formData = new FormData(form);
    
    fetch('{{ route("wishlist.toggle") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const icon = button.querySelector('.wishlist-icon');
            const text = button.querySelector('.wishlist-text');
            const isInWishlist = button.dataset.inWishlist === 'true';
            
            if (data.action === 'added') {
                icon.textContent = '❤️';
                text.textContent = 'In Wishlist';
                button.dataset.inWishlist = 'true';
                button.classList.add('border-red-300', 'bg-red-50');
            } else {
                icon.textContent = '🤍';
                text.textContent = 'Wishlist';
                button.dataset.inWishlist = 'false';
                button.classList.remove('border-red-300', 'bg-red-50');
            }
            
            // Show toast notification
            showToast(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred. Please try again.', 'error');
    });
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
@endsection
