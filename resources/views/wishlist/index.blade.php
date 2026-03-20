@extends('layouts.app')

@section('title', 'My Wishlist - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">My Wishlist</h1>
                    <p class="text-soft-brown opacity-75">Save your favorite products for later</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-soft-brown opacity-75">{{ $wishlistItems->count() }} items</p>
                </div>
            </div>
        </div>

        <!-- Wishlist Items -->
        @if($wishlistItems->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($wishlistItems as $wishlistItem)
                    @if($wishlistItem->product)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <!-- Product Image -->
                            <div class="relative">
                                <img src="{{ asset('images/products/' . $wishlistItem->product->image ?? 'placeholder.jpg') }}" 
                                     alt="{{ $wishlistItem->product->name }}" 
                                     class="w-full h-48 object-cover object-center">
                                
                                <!-- Remove from Wishlist Button -->
                                <form action="{{ route('wishlist.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $wishlistItem->product->id }}">
                                    <button type="submit" 
                                            class="w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                                
                                <!-- Stock Status -->
                                @if($wishlistItem->product->quantity > 0)
                                    <div class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                                        In Stock
                                    </div>
                                @else
                                    <div class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                        Out of Stock
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Details -->
                            <div class="p-4">
                                <h3 class="font-semibold text-soft-brown mb-2 line-clamp-2">
                                    {{ $wishlistItem->product->name }}
                                </h3>
                                
                                <p class="text-sm text-soft-brown opacity-75 mb-3 line-clamp-2">
                                    {{ $wishlistItem->product->description }}
                                </p>
                                
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xl font-bold text-jade-green">
                                        ₱{{ number_format($wishlistItem->product->price, 2) }}
                                    </span>
                                    
                                    @if($wishlistItem->product->quantity > 0)
                                        <span class="text-xs text-green-600 font-medium">
                                            {{ $wishlistItem->product->quantity }} available
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <a href="{{ route('products.show', $wishlistItem->product->id) }}" 
                                       class="flex-1 text-center bg-light-sage text-soft-brown py-2 px-3 rounded-lg hover:bg-jade-green hover:text-white transition-colors text-sm font-medium">
                                        View Details
                                    </a>
                                    
                                    @if($wishlistItem->product->quantity > 0)
                                        <form action="{{ route('cart.add', $wishlistItem->product->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full bg-jade-green text-white py-2 px-3 rounded-lg hover:bg-soft-brown transition-colors text-sm font-medium">
                                                Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <button disabled 
                                                class="flex-1 bg-gray-300 text-gray-500 py-2 px-3 rounded-lg cursor-not-allowed text-sm font-medium">
                                            Out of Stock
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <!-- Empty Wishlist -->
            <div class="bg-white rounded-3xl shadow-xl p-12 text-center">
                <div class="w-24 h-24 bg-light-sage rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-soft-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Your Wishlist is Empty</h2>
                <p class="text-soft-brown opacity-75 mb-8">
                    Start adding products you love to your wishlist! Save items for later and get notified when they're on sale.
                </p>
                
                <div class="space-y-4">
                    <a href="{{ route('products.index') }}" 
                       class="inline-block bg-jade-green text-white px-6 py-3 rounded-full hover:shadow-lg transition font-semibold">
                        Browse Products
                    </a>
                    
                    <div class="text-sm text-soft-brown opacity-75">
                        <p>💡 <strong>Tip:</strong> Click the heart icon on any product to add it to your wishlist</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Add to Cart Success Modal -->
<div id="addToCartModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-3xl p-8 max-w-md mx-4">
        <div class="text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-soft-brown mb-2">Added to Cart!</h3>
            <p class="text-soft-brown opacity-75 mb-6">Product has been successfully added to your cart.</p>
            <div class="flex gap-3">
                <button onclick="closeAddToCartModal()" 
                        class="flex-1 bg-light-sage text-soft-brown py-2 px-4 rounded-lg hover:bg-jade-green hover:text-white transition-colors">
                    Continue Shopping
                </button>
                <a href="{{ route('cart.index') }}" 
                   class="flex-1 bg-jade-green text-white py-2 px-4 rounded-lg hover:bg-soft-brown transition-colors">
                    View Cart
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Close modal function
function closeAddToCartModal() {
    document.getElementById('addToCartModal').classList.add('hidden');
    document.getElementById('addToCartModal').classList.remove('flex');
}

// Handle add to cart success
document.addEventListener('DOMContentLoaded', function() {
    // Check if URL has success parameter
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('added') === 'cart') {
        document.getElementById('addToCartModal').classList.remove('hidden');
        document.getElementById('addToCartModal').classList.add('flex');
        
        // Remove parameter from URL
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});

// Handle form submissions for add to cart
document.querySelectorAll('form[action*="cart/add"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        // Show success modal after form submission
        setTimeout(() => {
            document.getElementById('addToCartModal').classList.remove('hidden');
            document.getElementById('addToCartModal').classList.add('flex');
        }, 500);
    });
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
