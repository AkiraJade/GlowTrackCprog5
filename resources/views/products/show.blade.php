@extends('layouts.app')

@section('title', $product->name . ' - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-xl p-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-3">{{ $product->name }}</h1>
                        <p class="text-lg text-soft-brown opacity-75">Product details and reviews</p>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('cart.index') }}" class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                            🛒 Cart ({{ Auth::user()?->cartItems()->count() ?? 0 }})
                        </a>
                        <a href="{{ route('products.index') }}" class="px-6 py-3 border-2 border-soft-brown text-soft-brown rounded-full hover:bg-soft-brown hover:text-white transition font-semibold">
                            ← Products
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Detail -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Product Image -->
                <div class="p-8">
                    <!-- Main Image Display -->
                    <div class="mb-6">
                        @if($product->photo)
                            <img id="mainImage" src="{{ $product->photo_url }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-96 object-cover object-center rounded-xl shadow-lg cursor-pointer hover:scale-105 transition-transform duration-300"
                                 onclick="openImageModal('{{ $product->photo_url }}')">
                        @else
                            <div class="w-full h-96 bg-gradient-to-br from-mint-cream to-light-sage rounded-xl flex items-center justify-center">
                                <span class="text-8xl opacity-50">🧴</span>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnail Gallery -->
                    @if($product->images && $product->images->count() > 1)
                        <div class="grid grid-cols-4 gap-3">
                            @foreach($product->images as $index => $image)
                                <img src="{{ $image->image_url }}" 
                                     alt="{{ $product->name }} - Image {{ $index + 1 }}" 
                                     class="w-full h-20 object-cover object-center rounded-lg cursor-pointer hover:opacity-75 transition-opacity {{ $loop->first ? 'ring-2 ring-jade-green' : '' }}"
                                     onclick="changeMainImage('{{ $image->image_url }}', this)">
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="p-8">
                    <!-- Basic Info -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-3xl font-bold text-soft-brown font-playfair">{{ $product->name }}</h2>
                            @if($product->status === 'approved')
                                <span class="px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded-full">
                                    ✅ Available
                                </span>
                            @else
                                <span class="px-4 py-2 bg-red-500 text-white text-sm font-semibold rounded-full">
                                    ❌ Unavailable
                                </span>
                            @endif
                        </div>
                        <p class="text-soft-brown opacity-75 mb-6">{{ $product->brand }}</p>
                        <div class="text-2xl font-bold text-jade-green mb-6">₱{{ number_format($product->price, 2) }}</div>
                        <p class="text-sm text-soft-brown opacity-75">{{ $product->size_volume ?? '30ml' }}</p>
                    </div>

                    <!-- Rating -->
                    <div class="mb-8">
                        <div class="flex items-center mb-2">
                            @if($product->average_rating > 0)
                                <div class="flex text-yellow-400 text-2xl">
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
                                <span class="ml-3 text-lg font-semibold text-soft-brown">{{ number_format($product->average_rating, 1) }}</span>
                                <span class="ml-2 text-soft-brown opacity-75">({{ $product->review_count ?? 0 }} reviews)</span>
                            @else
                                <div class="flex text-gray-300 text-2xl">
                                    ⭐⭐⭐⭐⭐
                                </div>
                                <span class="ml-3 text-lg font-semibold text-soft-brown">No reviews yet</span>
                            @endif
                        </div>
                        <a href="#reviews" class="text-jade-green hover:text-soft-brown transition font-semibold">
                            See all reviews →
                        </a>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-soft-brown mb-3">Description</h3>
                        <p class="text-soft-brown opacity-75 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <!-- Product Details -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-soft-brown mb-4">Product Details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-soft-brown opacity-75">Classification:</span>
                                <span class="font-semibold text-soft-brown">{{ $product->classification }}</span>
                            </div>
                            <div>
                                <span class="text-sm text-soft-brown opacity-75">Brand:</span>
                                <span class="font-semibold text-soft-brown">{{ $product->brand }}</span>
                            </div>
                            <div>
                                <span class="text-sm text-soft-brown opacity-75">Stock:</span>
                                <span class="font-semibold {{ $product->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $product->quantity > 0 ? $product->quantity . ' available' : 'Out of stock' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm text-soft-brown opacity-75">Seller:</span>
                                <a href="{{ route('seller.products.index', $product->seller) }}" class="font-semibold text-jade-green hover:text-soft-brown transition">
                                    {{ $product->seller->name }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Skin Types -->
                    @if($product->skin_types)
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-soft-brown mb-3">Suitable for</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->skin_types as $skinType)
                                    <span class="px-3 py-1 bg-gradient-to-r from-mint-cream to-light-sage text-sm font-medium rounded-full text-soft-brown">
                                        {{ $skinType }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Active Ingredients -->
                    @if($product->active_ingredients)
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-soft-brown mb-3">Active Ingredients</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->active_ingredients as $ingredient)
                                    <span class="px-3 py-1 bg-gradient-to-r from-jade-green to-light-sage text-sm font-medium rounded-full text-white">
                                        {{ $ingredient }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex gap-4">
                        @if($product->quantity > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" 
                                        class="w-full px-6 py-3 bg-jade-green text-white rounded-full hover:bg-opacity-90 transition font-bold text-lg shadow-lg">
                                    🛒 Add to Cart
                                </button>
                            </form>
                        @else
                            <button disabled 
                                    class="w-full px-6 py-3 bg-gray-300 text-gray-500 rounded-full cursor-not-allowed font-bold text-lg">
                                ❌ Out of Stock
                            </button>
                        @endif
                        
                        <button onclick="toggleWishlist({{ $product->id }})" 
                                class="px-6 py-3 border-2 border-red-500 text-red-500 rounded-full hover:bg-red-500 hover:text-white transition font-semibold">
                            ❤️ Wishlist
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recently Viewed Section -->
        <div class="mt-12 bg-white rounded-3xl shadow-xl p-8">
            <h3 class="text-2xl font-bold text-soft-brown font-playfair mb-6">Recently Viewed</h3>
            <div id="recentlyViewedProducts" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Recently viewed products will be loaded here by JavaScript -->
                <p id="noRecentlyViewed" class="text-soft-brown opacity-75">No items viewed yet. <a href="{{ route('products.index') }}" class="text-teal-600 hover:underline">Browse Products</a></p>
            </div>
        </div>

        <!-- Reviews Section -->
        <div id="reviews" class="mt-12">
            <!-- Review Form Section - Always Visible at Top -->
            <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
                <h3 class="text-2xl font-bold text-soft-brown font-playfair mb-6">Write Your Review ⭐</h3>
                
                @if(!auth()->check())
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                        <div class="text-blue-800 text-center">
                            <div class="text-2xl mb-2">🔐</div>
                            <h4 class="font-bold mb-2">Login Required</h4>
                            <p class="text-sm mb-4">Please login to write a review for this product.</p>
                            <a href="{{ route('login') }}" 
                               class="inline-block px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition font-semibold text-sm">
                                Login to Review
                            </a>
                        </div>
                    </div>
                @elseif(!auth()->user()->hasDeliveredProduct($product->id))
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-6">
                        <div class="text-yellow-800 text-center">
                            <div class="text-2xl mb-2">🛒</div>
                            <h4 class="font-bold mb-2">Purchase Required to Review</h4>
                            <p class="text-sm mb-4">You can only review products after they have been delivered to your account.</p>
                            <a href="{{ route('products.index') }}" 
                               class="inline-block px-6 py-2 bg-yellow-600 text-white rounded-full hover:bg-yellow-700 transition font-semibold text-sm">
                                Browse Products
                            </a>
                        </div>
                    </div>
                @endif
                
                <!-- Review Form (Always Visible) -->
                <form id="reviewForm" class="space-y-4" 
                      @if(!auth()->check() || !auth()->user()->hasDeliveredProduct($product->id))
                      onsubmit="event.preventDefault(); showReviewRestriction();"
                      @endif>
                    @csrf
                    <input type="hidden" name="product_id" id="reviewProductId" value="{{ $product->id }}">
                    <div>
                        <label class="block text-sm font-semibold text-soft-brown mb-2">Rating</label>
                        <div class="flex gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" onclick="setRating({{ $i }})" 
                                        class="w-10 h-10 text-2xl border-2 border-gray-200 rounded-full hover:border-yellow-400 transition rating-btn"
                                        data-rating="{{ $i }}"
                                        @if(!auth()->check() || !auth()->user()->hasDeliveredProduct($product->id)) disabled @endif>
                                    ⭐
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-soft-brown mb-2">Review</label>
                        <textarea name="comment" rows="4" 
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-jade-green"
                                  placeholder="Share your experience with this product..." 
                                  @if(!auth()->check() || !auth()->user()->hasDeliveredProduct($product->id)) disabled @endif
                                  required></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-soft-brown mb-2">Skin Type</label>
                        <select name="skin_type" 
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-jade-green"
                                @if(!auth()->check() || !auth()->user()->hasDeliveredProduct($product->id)) disabled @endif>
                            <option value="">Select your skin type</option>
                            <option value="Oily">Oily</option>
                            <option value="Dry">Dry</option>
                            <option value="Combination">Combination</option>
                            <option value="Sensitive">Sensitive</option>
                            <option value="Normal">Normal</option>
                        </select>
                    </div>
                    <div class="flex gap-4">
                        <button type="submit" 
                                class="flex-1 px-4 py-3 bg-jade-green text-white rounded-full hover:bg-opacity-90 transition font-semibold"
                                @if(!auth()->check() || !auth()->user()->hasDeliveredProduct($product->id)) disabled @endif>
                            Submit Review
                        </button>
                        <button type="button" onclick="resetReviewForm()" 
                                class="flex-1 px-4 py-3 border-2 border-gray-300 text-gray-600 rounded-full hover:bg-gray-100 transition font-semibold">
                            Clear
                        </button>
                    </div>
                </form>
            </div>

            <!-- Existing Reviews Section -->
            <div class="bg-white rounded-3xl shadow-xl p-8">
                <h2 class="text-3xl font-bold text-soft-brown font-playfair mb-8">Customer Reviews ⭐</h2>
                
                @if($product->reviews && $product->reviews->count() > 0)
                    <div class="space-y-6">
                        @foreach($product->reviews as $review)
                            <div class="border-b border-gray-200 pb-6 last:border-b-0">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-gradient-to-br from-mint-cream to-light-sage rounded-full flex items-center justify-center">
                                            <span class="text-lg font-bold text-soft-brown">{{ strtoupper(substr($review->user->name, 0, 1)) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <div>
                                                <div class="font-semibold text-soft-brown">{{ $review->user->name }}</div>
                                                <div class="flex text-yellow-400">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            ⭐
                                                        @else
                                                            ⭐
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="text-sm text-soft-brown opacity-75">
                                                {{ $review->created_at->format('F d, Y') }}
                                            </div>
                                        </div>
                                        <div class="text-soft-brown mb-4">{{ $review->comment }}</div>
                                        @if($review->skin_type)
                                            <div class="text-sm text-soft-brown opacity-75">
                                                Skin Type: {{ $review->skin_type }}
                                            </div>
                                        @endif
                                        @if(auth()->check() && $review->user_id == auth()->id())
                                            <div class="flex gap-2 mt-3">
                                                <button onclick="editReview({{ $review->id }}, '{{ $review->rating }}', '{{ $review->comment }}')" 
                                                        class="text-sm px-3 py-1 bg-blue-100 text-blue-600 hover:bg-blue-200 rounded-full transition font-medium">
                                                    ✏️ Edit
                                                </button>
                                                <button onclick="deleteReview({{ $review->id }})" 
                                                        class="text-sm px-3 py-1 bg-red-100 text-red-600 hover:bg-red-200 rounded-full transition font-medium">
                                                    🗑️ Delete
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4 opacity-50">📝</div>
                        <h3 class="text-xl font-bold text-soft-brown mb-4">No Reviews Yet</h3>
                        <p class="text-soft-brown opacity-75 mb-6">Be the first to review this product!</p>
                        
                        @if(!auth()->check())
                            <a href="{{ route('login') }}" 
                               class="inline-block px-8 py-3 bg-jade-green text-white rounded-full hover:bg-opacity-90 transition font-bold text-lg shadow-lg">
                                🔐 Login to Review
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-4xl max-h-full" onclick="event.stopPropagation()">
        <img id="modalImage" src="" alt="Product Image" class="max-w-full max-h-full object-contain rounded-lg">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75 transition">
            ✕
        </button>
    </div>
</div>

<!-- Review Modal -->
<div id="reviewModal" class="fixed inset-0 bg-black bg-opacity-50 z-[9999] hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-soft-brown font-playfair">Leave a Review ⭐</h3>
            <button onclick="closeReviewModal()" class="text-gray-500 hover:text-gray-700 text-2xl">
                ✕
            </button>
        </div>
        <form id="reviewForm" class="space-y-4">
            @csrf
            <input type="hidden" name="product_id" id="reviewProductId">
            <div>
                <label class="block text-sm font-semibold text-soft-brown mb-2">Rating</label>
                <div class="flex gap-2">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" onclick="setRating({{ $i }})" 
                                class="w-10 h-10 text-2xl border-2 border-gray-200 rounded-full hover:border-yellow-400 transition rating-btn"
                                data-rating="{{ $i }}">
                            ⭐
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="ratingInput" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-soft-brown mb-2">Review</label>
                <textarea name="comment" rows="4" 
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-jade-green"
                          placeholder="Share your experience with this product..." required></textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-soft-brown mb-2">Skin Type</label>
                <select name="skin_type" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-jade-green">
                    <option value="">Select your skin type</option>
                    <option value="Oily">Oily</option>
                    <option value="Dry">Dry</option>
                    <option value="Combination">Combination</option>
                    <option value="Sensitive">Sensitive</option>
                    <option value="Normal">Normal</option>
                </select>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="flex-1 px-4 py-3 bg-jade-green text-white rounded-full hover:bg-opacity-90 transition font-semibold">
                    Submit Review
                </button>
                <button type="button" onclick="closeReviewModal()" class="flex-1 px-4 py-3 border-2 border-gray-300 text-gray-600 rounded-full hover:bg-gray-100 transition font-semibold">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function changeMainImage(imageSrc, element) {
    document.getElementById('mainImage').src = imageSrc;
    // Remove ring from all thumbnails
    document.querySelectorAll('img').forEach(img => img.classList.remove('ring-2', 'ring-jade-green'));
    // Add ring to clicked thumbnail
    element.classList.add('ring-2', 'ring-jade-green');
}

function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

function toggleWishlist(productId) {
    fetch(`/wishlist/toggle/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update UI to show wishlist status
            const button = event.currentTarget;
            if (data.action === 'added') {
                button.innerHTML = '❤️ Added to Wishlist';
                button.classList.add('bg-green-500', 'text-white');
                button.classList.remove('border-red-500', 'text-red-500');
            } else {
                button.innerHTML = '❤️ Wishlist';
                button.classList.remove('bg-green-500', 'text-white');
                button.classList.add('border-red-500', 'text-red-500');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating wishlist');
    });
}

function openReviewModal(productId) {
    document.getElementById('reviewProductId').value = productId;
    const modal = document.getElementById('reviewModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeReviewModal() {
    const modal = document.getElementById('reviewModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.getElementById('reviewForm').reset();
    // Reset rating stars
    document.querySelectorAll('.rating-btn').forEach(btn => {
        btn.classList.remove('border-yellow-400', 'bg-yellow-50');
        btn.classList.add('border-gray-200');
    });
}

function setRating(rating) {
    document.getElementById('ratingInput').value = rating;
    // Update star buttons
    document.querySelectorAll('.rating-btn').forEach((btn, index) => {
        if (index < rating) {
            btn.classList.remove('border-gray-200');
            btn.classList.add('border-yellow-400', 'bg-yellow-50');
        } else {
            btn.classList.remove('border-yellow-400', 'bg-yellow-50');
            btn.classList.add('border-gray-200');
        }
    });
}

function showReviewRestriction() {
    if (!{{ auth()->check() ? 'false' : 'true' }}) {
        alert('Please login to write a review for this product.');
        window.location.href = '{{ route('login') }}';
    } else if (!{{ auth()->user()->hasDeliveredProduct($product->id) ? 'false' : 'true' }}) {
        alert('You can only review products after they have been delivered to your account.');
        window.location.href = '{{ route('products.index') }}';
    }
}

function resetReviewForm() {
    document.getElementById('reviewForm').reset();
    // Reset rating stars
    document.querySelectorAll('.rating-btn').forEach(btn => {
        btn.classList.remove('border-yellow-400', 'bg-yellow-50');
        btn.classList.add('border-gray-200');
    });
    document.getElementById('ratingInput').value = '';
}

// Handle review form submission
document.getElementById('reviewForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('/products/' + document.getElementById('reviewProductId').value + '/reviews', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeReviewModal();
            // Show success message
            alert('Review submitted successfully!');
            // Reload page to show new review
            location.reload();
        } else {
            alert('Error submitting review: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error submitting review');
    });
});

// Edit review function
function editReview(reviewId, rating, comment) {
    // Set the form values for editing
    document.getElementById('reviewProductId').value = document.getElementById('reviewProductId').value;
    setRating(rating);
    document.querySelector('textarea[name="comment"]').value = comment;
    
    // Change submit button text
    const submitBtn = document.querySelector('button[type="submit"]');
    submitBtn.textContent = 'Update Review';
    submitBtn.onclick = function(e) {
        e.preventDefault();
        updateReview(reviewId);
    };
    
    // Scroll to form
    document.getElementById('reviewForm').scrollIntoView({ behavior: 'smooth' });
}

// Update review function
function updateReview(reviewId) {
    const formData = new FormData(document.getElementById('reviewForm'));
    
    fetch('/products/' + document.getElementById('reviewProductId').value + '/reviews', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Review updated successfully!');
            location.reload();
        } else {
            alert('Error updating review: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating review');
    });
}

// Delete review function
function deleteReview(reviewId) {
    if (!confirm('Are you sure you want to delete this review?')) {
        return;
    }
    
    fetch('/products/' + document.getElementById('reviewProductId').value + '/reviews', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Review deleted successfully!');
            location.reload();
        } else {
            alert('Error deleting review: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error deleting review');
    });
}

// Recently Viewed Products functionality
document.addEventListener('DOMContentLoaded', function() {
    // Track current product as recently viewed
    const productId = {{ $product->id }};
    const productName = '{{ $product->name }}';
    const productImage = '{{ $product->image ?? 'placeholder.jpg' }}';
    const productPrice = '{{ $product->price }}';
    
    // Get recently viewed products from localStorage
    let recentlyViewed = JSON.parse(localStorage.getItem('recentlyViewed') || '[]');
    
    // Remove current product if it already exists (to move it to the top)
    recentlyViewed = recentlyViewed.filter(item => item.id !== productId);
    
    // Add current product to the beginning
    recentlyViewed.unshift({
        id: productId,
        name: productName,
        image: productImage,
        price: productPrice
    });
    
    // Keep only the most recent product (as requested)
    recentlyViewed = recentlyViewed.slice(0, 1);
    
    // Save back to localStorage
    localStorage.setItem('recentlyViewed', JSON.stringify(recentlyViewed));
    
    // Display recently viewed products
    displayRecentlyViewed();
});

function displayRecentlyViewed() {
    const recentlyViewed = JSON.parse(localStorage.getItem('recentlyViewed') || '[]');
    const container = document.getElementById('recentlyViewedProducts');
    const noItemsMsg = document.getElementById('noRecentlyViewed');
    
    if (recentlyViewed.length === 0) {
        noItemsMsg.style.display = 'block';
        return;
    }
    
    noItemsMsg.style.display = 'none';
    
    // Clear existing content
    container.innerHTML = '';
    
    recentlyViewed.forEach(product => {
        const productCard = `
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <a href="/products/${product.id}" class="block">
                    <div class="relative">
                        <img src="/images/products/${product.image}" 
                             alt="${product.name}" 
                             class="w-full h-48 object-cover">
                        <div class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                            In Stock
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-soft-brown mb-2">${product.name}</h4>
                        <p class="text-jade-green font-bold">$${product.price}</p>
                    </div>
                </a>
            </div>
        `;
        container.innerHTML += productCard;
    });
}
</script>
@endsection
