@extends('layouts.app')

@section('title', 'Public Skincare Routines - GlowTrack')

@section('content')
<!-- Public Routines Container -->
<section class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-xl p-8 text-center">
                <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-4">🌍 Public Skincare Routines</h1>
                <p class="text-gray-600 text-lg mb-6">
                    Discover and get inspired by skincare routines shared by the GlowTrack community
                </p>
                <a href="{{ route('skincare-routines.index') }}"
                   class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-semibold shadow-lg">
                    My Routines
                </a>
            </div>

            <!-- Schedule Tabs -->
            <div class="bg-white rounded-3xl shadow-xl p-8 mt-6">
                <div class="flex space-x-4 justify-center">
                    <button onclick="filterRoutines('all')"
                            class="px-6 py-2 rounded-full font-semibold transition filter-btn active"
                            data-filter="all">
                        All Routines
                    </button>
                    <button onclick="filterRoutines('AM')"
                            class="px-6 py-2 rounded-full font-semibold transition filter-btn"
                            data-filter="am">
                        ☀️ AM Routines
                    </button>
                    <button onclick="filterRoutines('PM')"
                            class="px-6 py-2 rounded-full font-semibold transition filter-btn"
                            data-filter="pm">
                        🌙 PM Routines
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Routines Grid -->
        @if($routines->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($routines as $routine)
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105 routine-card"
                         data-schedule="{{ $routine->schedule }}">
                        
                        <!-- Routine Header -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                <span class="text-2xl">{{ $routine->schedule == 'AM' ? '☀️' : '🌙' }}</span>
                                <h3 class="text-xl font-bold text-soft-brown">{{ $routine->name }}</h3>
                            </div>
                            <span class="px-2 py-1 bg-jade-green text-white rounded-full text-xs font-medium">
                                Public
                            </span>
                        </div>
                        
                        <!-- Author Info -->
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-8 h-8 bg-jade-green rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold">{{ substr($routine->user->name, 0, 1) }}</span>
                            </div>
                            <p class="text-sm text-gray-600">by {{ $routine->user->name }}</p>
                        </div>
                        
                        <!-- Routine Steps Preview -->
                        <div class="space-y-2 mb-6">
                            @foreach($routine->steps->take(3) as $step)
                                <div class="flex items-center space-x-2 p-2 bg-gray-50 rounded">
                                    <span class="text-lg">{{ $step->getStepIcon() }}</span>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-soft-brown">{{ $step->step_type }}</p>
                                        <p class="text-xs text-gray-600 truncate">
                                            {{ $step->isCustomProduct() ? $step->product_name : $step->product?->name ?? 'Custom Product' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                            
                            @if($routine->steps->count() > 3)
                                <p class="text-sm text-gray-500 text-center">
                                    ... and {{ $routine->steps->count() - 3 }} more steps
                                </p>
                            @endif
                        </div>
                        
                        <!-- Routine Stats -->
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-gray-600">
                                    📝 {{ $routine->steps->count() }} steps
                                </span>
                                <span class="text-sm text-gray-600">
                                    📅 {{ $routine->created_at->format('M d') }}
                                </span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <!-- Rating Display -->
                                <div class="flex items-center space-x-1">
                                    <span class="text-sm text-yellow-500">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($routine->getAverageRating()))
                                                ⭐
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </span>
                                    <span class="text-xs text-gray-500">({{ $routine->ratings_count }})</span>
                                </div>
                                <!-- Favorite Count -->
                                <span class="text-sm text-gray-600">
                                    ❤️ {{ $routine->favorites_count }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-2 mb-4">
                            <!-- Favorite Button -->
                            @auth
                                <button onclick="toggleFavorite({{ $routine->id }})"
                                        class="flex-1 px-3 py-2 {{ $routine->isFavoritedBy(auth()->user()) ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700' }} rounded-full hover:opacity-80 transition font-semibold text-sm favorite-btn"
                                        data-routine-id="{{ $routine->id }}"
                                        data-favorited="{{ $routine->isFavoritedBy(auth()->user()) ? 'true' : 'false' }}">
                                    {{ $routine->isFavoritedBy(auth()->user()) ? '❤️ Favorited' : '🤍 Favorite' }}
                                </button>
                            @endauth
                            
                            <!-- View Button -->
                            <a href="{{ route('skincare-routines.show', $routine) }}" 
                               class="flex-1 text-center px-3 py-2 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-semibold text-sm">
                                View Full
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-12">
                {{ $routines->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-3xl shadow-xl p-12 text-center">
                <div class="text-6xl mb-4">🌍</div>
                <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-4">No Public Routines Yet</h2>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Be the first to share your skincare routine with the community!
                </p>
                <a href="{{ route('skincare-routines.create') }}" 
                   class="px-8 py-4 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-bold text-lg shadow-xl">
                    ✨ Create Public Routine
                </a>
            </div>
        @endif
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.routine-card');
    const buttons = document.querySelectorAll('.filter-btn');

    function setActiveButton(activeFilter) {
        buttons.forEach(btn => {
            const bf = btn.dataset.filter?.toLowerCase() || '';
            if (bf === activeFilter) {
                btn.classList.add('active', 'bg-jade-green', 'text-white');
                btn.classList.remove('bg-gray-100', 'text-gray-700');
            } else {
                btn.classList.remove('active', 'bg-jade-green', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            }
        });
    }

    function filterRoutines(filter) {
        const normalizedFilter = (filter || 'all').toString().trim().toLowerCase();

        setActiveButton(normalizedFilter);

        cards.forEach(card => {
            const schedule = (card.dataset.schedule || '').toString().trim().toLowerCase();
            if (normalizedFilter === 'all' || schedule === normalizedFilter) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', function (event) {
            event.preventDefault();
            const filterValue = (this.dataset.filter || 'all').toString().trim();
            filterRoutines(filterValue);
        });
    });

    // Initial filter state
    filterRoutines('all');

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

            const btn = document.querySelector(`[data-routine-id="${routineId}"]`);
            if (data.favorited) {
                btn.classList.remove('bg-gray-200', 'text-gray-700');
                btn.classList.add('bg-red-500', 'text-white');
                btn.innerHTML = '❤️ Favorited';
                btn.setAttribute('data-favorited', 'true');
            } else {
                btn.classList.remove('bg-red-500', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-700');
                btn.innerHTML = '🤍 Favorite';
                btn.setAttribute('data-favorited', 'false');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    };
});
</script>
@endsection
