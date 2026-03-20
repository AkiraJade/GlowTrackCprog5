@extends('layouts.app')

@section('title', '{{ $routine->name }} - Skincare Routine')

@section('content')
<!-- Routine Detail Container -->
<section class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Routine Header -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <span class="text-4xl">{{ $routine->schedule == 'AM' ? '☀️' : '🌙' }}</span>
                    <div>
                        <h1 class="text-3xl font-bold text-soft-brown font-playfair">{{ $routine->name }}</h1>
                        <p class="text-gray-600">by {{ $routine->user->name }}</p>
                    </div>
                </div>
                
                @if($routine->is_public)
                    <span class="px-4 py-2 bg-jade-green text-white rounded-full text-sm font-medium">
                        🌍 Public Routine
                    </span>
                @endif
            </div>
            
            <!-- Favorite Button (for all authenticated users) -->
            @auth
                <div class="mb-6">
                    <button onclick="toggleFavorite({{ $routine->id }})"
                            class="px-6 py-3 {{ $routine->isFavoritedBy(auth()->user()) ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700' }} rounded-full hover:opacity-80 transition font-semibold favorite-btn"
                            data-routine-id="{{ $routine->id }}"
                            data-favorited="{{ $routine->isFavoritedBy(auth()->user()) ? 'true' : 'false' }}">
                        {{ $routine->isFavoritedBy(auth()->user()) ? '❤️ Favorited' : '🤍 Add to Favorites' }}
                    </button>
                </div>
            @endauth
            
            <!-- Action Buttons (owner only) -->
            @if(auth()->check() && auth()->user()->id === $routine->user_id)
                <div class="flex space-x-4">
                    <a href="{{ route('skincare-routines.edit', $routine) }}" 
                       class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-semibold">
                        ✏️ Edit Routine
                    </a>
                    <form method="POST" action="{{ route('skincare-routines.destroy', $routine) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this routine?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-6 py-3 bg-red-500 text-white rounded-full hover:bg-red-600 transition font-semibold">
                            🗑️ Delete Routine
                        </button>
                    </form>
                </div>
            @endif
        </div>
        
        <!-- Routine Steps -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6">Routine Steps</h2>
            
            <div class="space-y-6">
                @foreach($routine->steps->sortBy('step_order') as $step)
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-6 border-l-4 border-jade-green">
                        <div class="flex items-start space-x-4">
                            <div class="text-3xl">{{ $step->getStepIcon() }}</div>
                            
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-xl font-semibold text-soft-brown">
                                        Step {{ $step->step_order }}: {{ $step->step_type }}
                                    </h3>
                                    @if($step->product)
                                        <a href="{{ route('products.show', $step->product) }}" 
                                           class="px-3 py-1 bg-jade-green text-white rounded-full text-sm font-medium hover:bg-jade-green/80 transition">
                                            View Product
                                        </a>
                                    @endif
                                </div>
                                
                                <div class="bg-white rounded-lg p-4">
                                    @if($step->isCustomProduct())
                                        <p class="text-gray-700">
                                            <strong>Custom Product:</strong> {{ $step->product_name }}
                                        </p>
                                    @elseif($step->product)
                                        <div class="space-y-2">
                                            <p class="text-gray-700">
                                                <strong>Product:</strong> {{ $step->product->name }}
                                            </p>
                                            <p class="text-gray-600 text-sm">
                                                <strong>Brand:</strong> {{ $step->product->brand ?? 'Unknown' }}
                                            </p>
                                            <p class="text-gray-600 text-sm">
                                                <strong>Price:</strong> ${{ number_format($step->product->price, 2) }}
                                            </p>
                                            @if($step->product->description)
                                                <p class="text-gray-600 text-sm mt-2">
                                                    <strong>Description:</strong> {{ $step->product->description }}
                                                </p>
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-gray-500 italic">No product specified</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Routine Info -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-3xl mb-2">{{ $routine->schedule == 'AM' ? '☀️' : '🌙' }}</div>
                        <p class="text-sm text-gray-600">Schedule</p>
                        <p class="font-semibold text-soft-brown">{{ $routine->schedule }} Routine</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-3xl mb-2">📝</div>
                        <p class="text-sm text-gray-600">Total Steps</p>
                        <p class="font-semibold text-soft-brown">{{ $routine->steps->count() }} Steps</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-3xl mb-2">📅</div>
                        <p class="text-sm text-gray-600">Created</p>
                        <p class="font-semibold text-soft-brown">{{ $routine->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Rating and Review Section -->
        @auth
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6">Rate & Review This Routine</h2>
            
            <!-- Current Rating Display -->
            <div class="mb-6">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-lg font-semibold">Average Rating:</span>
                        <div class="flex items-center space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($routine->getAverageRating()))
                                    <span class="text-2xl text-yellow-500 cursor-pointer" onclick="rateRoutine({{ $i }})">⭐</span>
                                @else
                                    <span class="text-2xl text-gray-300 cursor-pointer" onclick="rateRoutine({{ $i }})">☆</span>
                                @endif
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600">({{ $routine->getRatingCount() }} ratings)</span>
                    </div>
                </div>
                
                @if($userRating = $routine->getUserRating(auth()->user()))
                    <p class="text-sm text-green-600">Your rating: {{ $userRating }} stars</p>
                @else
                    <p class="text-sm text-gray-500">Click on a star to rate this routine</p>
                @endif
            </div>
            
            <!-- Review Form -->
            @php $userReview = $routine->getUserReview(auth()->user()) @endphp
            <form id="reviewForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Review</label>
                    <textarea name="comment" rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent"
                              placeholder="Share your experience with this routine...">{{ $userReview?->comment }}</textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Your Skin Type</label>
                        <select name="skin_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
                            <option value="">Select skin type</option>
                            <option value="Oily" {{ $userReview?->skin_type === 'Oily' ? 'selected' : '' }}>Oily</option>
                            <option value="Dry" {{ $userReview?->skin_type === 'Dry' ? 'selected' : '' }}>Dry</option>
                            <option value="Combination" {{ $userReview?->skin_type === 'Combination' ? 'selected' : '' }}>Combination</option>
                            <option value="Sensitive" {{ $userReview?->skin_type === 'Sensitive' ? 'selected' : '' }}>Sensitive</option>
                            <option value="Normal" {{ $userReview?->skin_type === 'Normal' ? 'selected' : '' }}>Normal</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Results Observed</label>
                        <input type="text" name="results_observed" value="{{ $userReview?->results_observed }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent"
                               placeholder="e.g., Clearer skin, reduced acne">
                    </div>
                </div>
                
                <button type="submit" 
                        class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-semibold">
                    {{ $userReview ? 'Update Review' : 'Submit Review' }}
                </button>
            </form>
        </div>
        @endauth
        
        <!-- Reviews List -->
        @if($routine->reviews->count() > 0)
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6">Reviews ({{ $routine->reviews->count() }})</h2>
            
            <div class="space-y-6">
                @foreach($routine->reviews as $review)
                    <div class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 bg-jade-green rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white text-sm font-bold">{{ substr($review->user->name, 0, 1) }}</span>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-2">
                                        <h4 class="font-semibold text-soft-brown">{{ $review->user->name }}</h4>
                                        <span class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                                    </div>
                                    
                                    @if(auth()->check() && auth()->user()->id === $review->user_id)
                                        <div class="flex space-x-2">
                                            <button onclick="editReview({{ $review->id }})" 
                                                    class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                                Edit
                                            </button>
                                            <button onclick="deleteReview({{ $review->id }})" 
                                                    class="text-sm text-red-600 hover:text-red-800 font-medium">
                                                Delete
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                
                                @if($review->skin_type)
                                    <p class="text-sm text-gray-600 mb-2">
                                        <strong>Skin Type:</strong> {{ $review->skin_type }}
                                    </p>
                                @endif
                                
                                <p class="text-gray-700 mb-3">{{ $review->comment }}</p>
                                
                                @if($review->results_observed)
                                    <p class="text-sm text-green-600">
                                        <strong>Results:</strong> {{ $review->results_observed }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- Back Button -->
        <div class="text-center mt-8">
            <a href="{{ route('skincare-routines.index') }}" 
               class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                ← Back to My Routines
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Favorite toggle function
    window.toggleFavorite = function(routineId) {
        fetch(`/skincare-routines/${routineId}/favorite`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            const btn = document.querySelector('.favorite-btn');
            if (data.favorited) {
                btn.classList.remove('bg-gray-200', 'text-gray-700');
                btn.classList.add('bg-red-500', 'text-white');
                btn.innerHTML = '❤️ Favorited';
                btn.setAttribute('data-favorited', 'true');
            } else {
                btn.classList.remove('bg-red-500', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-700');
                btn.innerHTML = '🤍 Add to Favorites';
                btn.setAttribute('data-favorited', 'false');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    };

    // Rating function
    window.rateRoutine = function(rating) {
        fetch(`{{ route('skincare-routines.rate', $routine) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ rating: rating })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Refresh to show updated rating
            } else {
                alert('Error submitting rating. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    };

    // Review form submission
    document.getElementById('reviewForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = {
            comment: formData.get('comment'),
            skin_type: formData.get('skin_type'),
            results_observed: formData.get('results_observed')
        };

        fetch(`{{ route('skincare-routines.review', $routine) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Refresh to show updated review
            } else {
                alert('Error submitting review. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });

    // Delete review function
    window.deleteReview = function(reviewId) {
        if (!confirm('Are you sure you want to delete this review?')) {
            return;
        }

        fetch(`{{ route('skincare-routines.review.delete', $routine) }}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Refresh to show updated reviews
            } else {
                alert(data.error || 'Error deleting review. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    };

    // Edit review function - for now, just scroll to the form
    window.editReview = function(reviewId) {
        // Scroll to the review form
        document.getElementById('reviewForm').scrollIntoView({ behavior: 'smooth' });
        
        // Focus on the comment textarea
        document.querySelector('textarea[name="comment"]').focus();
        
        // Optional: Add a visual indicator
        const formSection = document.querySelector('.bg-white.rounded-3xl.shadow-xl.p-8.mb-8');
        formSection.style.boxShadow = '0 0 0 3px rgba(34, 197, 94, 0.3)';
        setTimeout(() => {
            formSection.style.boxShadow = '';
        }, 3000);
    };
});
</script>
@endsection
