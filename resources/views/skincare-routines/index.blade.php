@extends('layouts.app')

@section('title', 'My Skincare Routines - GlowTrack')

@section('content')
<!-- Routines Container -->
<section class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            @if(session('success'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
                    <strong>Oops, something went wrong:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-xl p-8">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-3xl font-bold text-soft-brown font-playfair">My Skincare Routines</h1>
                    <div class="flex space-x-4">
                        <a href="{{ route('skincare-routines.create') }}" 
                           class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-semibold shadow-lg">
                            ✨ Create Routine
                        </a>
                        <a href="{{ route('skincare-routines.public') }}" 
                           class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                            🌍 Browse Public
                        </a>
                    </div>
                </div>
                
                <!-- Schedule Tabs -->
                <div class="flex space-x-4 mb-8">
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
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition routine-card" 
                         data-schedule="{{ $routine->schedule }}">
                        
                        <!-- Routine Header -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                <span class="text-2xl">{{ $routine->schedule == 'AM' ? '☀️' : '🌙' }}</span>
                                <h3 class="text-xl font-bold text-soft-brown">{{ $routine->name }}</h3>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($routine->is_favorited)
                                    <span class="px-2 py-1 bg-red-500 text-white rounded-full text-xs font-medium">
                                        ❤️ Favorited
                                    </span>
                                @endif
                                @if($routine->is_public)
                                    <span class="px-2 py-1 bg-jade-green text-white rounded-full text-xs font-medium">
                                        Public
                                    </span>
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
                                @endif
                            </div>
                        </div>
                        
                        <!-- Routine Steps -->
                        <div class="space-y-3 mb-6">
                            @foreach($routine->steps as $step)
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                    <span class="text-xl">{{ $step->getStepIcon() }}</span>
                                    <div class="flex-1">
                                        <p class="font-medium text-soft-brown">{{ $step->step_type }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $step->isCustomProduct() ? $step->product_name : $step->product?->name ?? 'Custom Product' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex justify-between items-center">
                            <div class="flex space-x-2">
                                <a href="{{ route('skincare-routines.show', $routine) }}" 
                                   class="px-4 py-2 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition text-sm font-semibold">
                                    View
                                </a>
                                @if($routine->is_owned)
                                    <a href="{{ route('skincare-routines.edit', $routine) }}" 
                                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-full hover:bg-gray-100 transition text-sm font-semibold">
                                        Edit
                                    </a>
                                @else
                                    <button onclick="toggleFavorite({{ $routine->id }})"
                                            class="px-4 py-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition text-sm font-semibold">
                                        ❤️ Unfavorite
                                    </button>
                                @endif
                            </div>
                            
                            @if($routine->is_owned)
                                <form method="POST" action="{{ route('skincare-routines.destroy', $routine) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this routine?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-4 py-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition text-sm font-semibold">
                                        Delete
                                    </button>
                                </form>
                            @else
                                <div class="text-sm text-gray-500">
                                    by {{ $routine->user->name }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-3xl shadow-xl p-12 text-center">
                <div class="text-6xl mb-4">✨</div>
                <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-4">No Skincare Routines Yet</h2>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Create your personalized skincare routines to organize your daily regimen and track your progress.
                </p>
                <a href="{{ route('skincare-routines.create') }}" 
                   class="px-8 py-4 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-bold text-lg shadow-xl">
                    ✨ Create Your First Routine
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
            // Reload the page to update the routine list
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    };
});
</script>
@endsection
