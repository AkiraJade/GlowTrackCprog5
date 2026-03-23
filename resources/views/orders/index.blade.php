@extends('layouts.app')

@section('title', 'My Orders - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-xl p-8 flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-3">My Orders 📦</h1>
                    <p class="text-lg text-soft-brown opacity-75">Track your orders and view purchase history</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('cart.index') }}" class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                        🛒 Shopping Cart
                    </a>
                    <a href="{{ route('products.index') }}" class="px-6 py-3 border-2 border-soft-brown text-soft-brown rounded-full hover:bg-soft-brown hover:text-white transition font-semibold">
                        ← Shop More
                    </a>
                </div>
            </div>
        </div>

        <!-- Order Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-mint-cream to-light-sage rounded-xl p-6 text-center">
                <div class="text-3xl mb-2">📊</div>
                <h3 class="text-lg font-bold text-soft-brown mb-1">Total Orders</h3>
                <p class="text-2xl font-bold text-jade-green">{{ $orders->count() }}</p>
                <p class="text-sm text-soft-brown opacity-75">All time</p>
            </div>
            
            <div class="bg-gradient-to-r from-blush-pink to-warm-peach rounded-xl p-6 text-center">
                <div class="text-3xl mb-2">💰</div>
                <h3 class="text-lg font-bold text-soft-brown mb-1">Total Spent</h3>
                <p class="text-2xl font-bold text-jade-green">₱{{ number_format($orders->sum('total_amount'), 2) }}</p>
                <p class="text-sm text-soft-brown opacity-75">Lifetime value</p>
            </div>
            
            <div class="bg-gradient-to-r from-jade-green to-light-sage rounded-xl p-6 text-center text-white">
                <div class="text-3xl mb-2">⏳</div>
                <h3 class="text-lg font-bold mb-1">Pending Orders</h3>
                <p class="text-2xl font-bold">{{ $orders->whereIn('status', ['pending', 'confirmed'])->count() }}</p>
                <p class="text-sm opacity-90">Awaiting processing</p>
            </div>
            
            <div class="bg-gradient-to-r from-warm-peach to-blush-pink rounded-xl p-6 text-center">
                <div class="text-3xl mb-2">✅</div>
                <h3 class="text-lg font-bold text-soft-brown mb-1">Completed</h3>
                <p class="text-2xl font-bold text-jade-green">{{ $orders->where('status', 'delivered')->count() }}</p>
                <p class="text-sm text-soft-brown opacity-75">Successfully delivered</p>
            </div>
        </div>

        <!-- Orders List -->
        @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
                        <!-- Order Header -->
                        <div class="p-6 bg-gradient-to-r from-mint-cream to-light-sage">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-xl font-bold text-soft-brown">
                                            Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                        </h3>
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'confirmed' => 'bg-blue-100 text-blue-800',
                                                'processing' => 'bg-purple-100 text-purple-800',
                                                'shipped' => 'bg-indigo-100 text-indigo-800',
                                                'delivered' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                            ];
                                            $statusClass = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-soft-brown opacity-75">
                                        Placed on {{ $order->created_at->format('F d, Y, g:i A') }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-jade-green mb-1">
                                        ₱{{ number_format($order->total_amount, 2) }}
                                    </div>
                                    <div class="text-sm text-soft-brown opacity-75">
                                        {{ $order->orderItems->sum('quantity') }} items
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items Preview -->
                        <div class="p-6">
                            <div class="flex items-center gap-4 mb-4">
                                @php
                                    $previewItems = $order->orderItems->take(3);
                                @endphp
                                @foreach($previewItems as $item)
                                    @if($item->product->photo)
                                        <img src="{{ $item->product->photo_url }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="w-16 h-16 object-cover rounded-lg shadow-md">
                                    @else
                                        <div class="w-16 h-16 bg-gradient-to-br from-mint-cream to-light-sage rounded-lg flex items-center justify-center">
                                            <span class="text-2xl opacity-50">🧴</span>
                                        </div>
                                    @endif
                                @endforeach
                                @if($order->orderItems->count() > 3)
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <span class="text-sm font-bold text-gray-600">+{{ $order->orderItems->count() - 3 }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('orders.show', $order) }}" 
                                   class="px-4 py-2 bg-jade-green text-white rounded-full hover:bg-opacity-90 transition font-semibold text-sm">
                                    📋 View Details
                                </a>
                                
                                @if($order->status === 'delivered' && auth()->user()->hasDeliveredProduct($order->orderItems->first()->product_id))
                                    <button onclick="openReviewModal({{ $order->orderItems->first()->product_id }})" 
                                            class="px-4 py-2 border-2 border-yellow-500 text-yellow-500 rounded-full hover:bg-yellow-500 hover:text-white transition font-semibold text-sm">
                                        ⭐ Leave Review
                                    </button>
                                @endif
                                
                                @if(in_array($order->status, ['pending', 'confirmed']))
                                    <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="px-4 py-2 border-2 border-red-500 text-red-500 rounded-full hover:bg-red-500 hover:text-white transition font-semibold text-sm"
                                                onclick="return confirm('Are you sure you want to cancel this order?')">
                                            ❌ Cancel Order
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $orders->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-3xl shadow-xl p-16 text-center">
                <div class="text-8xl mb-6 opacity-50">📦</div>
                <h3 class="text-3xl font-bold text-soft-brown font-playfair mb-4">No Orders Yet</h3>
                <p class="text-lg text-soft-brown opacity-75 mb-8">Start shopping to see your orders here!</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('products.index') }}" 
                       class="inline-flex items-center px-8 py-3 bg-jade-green text-white font-semibold rounded-full hover:bg-opacity-90 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 15M7 13l-2.293 2.293c-.63.63-1.707.184-2.122 2.122L3 16V7z"></path>
                        </svg>
                        Start Shopping
                    </a>
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-8 py-3 border-2 border-soft-brown text-soft-brown font-semibold rounded-full hover:bg-soft-brown hover:text-white transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1 1v4a1 1 0 001 1h3m-6 0a1 1 0 01-1-1v-4a1 1 0 011-1h3"></path>
                        </svg>
                        Dashboard
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Review Modal -->
<div id="reviewModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-soft-brown font-playfair">Leave a Review ⭐</h3>
            <button onclick="closeReviewModal()" class="text-gray-500 hover:text-gray-700">
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
function openReviewModal(productId) {
    document.getElementById('reviewProductId').value = productId;
    document.getElementById('reviewModal').classList.remove('hidden');
}

function closeReviewModal() {
    document.getElementById('reviewModal').classList.add('hidden');
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
</script>
@endsection
