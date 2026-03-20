@extends('layouts.app')

@section('title', 'My Skincare Routines - GlowTrack')

@section('content')
<!-- Routines Container -->
<section class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
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
                            @if($routine->is_public)
                                <span class="px-2 py-1 bg-jade-green text-white rounded-full text-xs font-medium">
                                    Public
                                </span>
                            @endif
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
                                <a href="{{ route('skincare-routines.edit', $routine) }}" 
                                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded-full hover:bg-gray-100 transition text-sm font-semibold">
                                    Edit
                                </a>
                            </div>
                            
                            <form method="POST" action="{{ route('skincare-routines.destroy', $routine) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this routine?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-4 py-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition text-sm font-semibold">
                                    Delete
                                </button>
                            </form>
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
function filterRoutines(filter) {
    const cards = document.querySelectorAll('.routine-card');
    const buttons = document.querySelectorAll('.filter-btn');
    
    // Update button states
    buttons.forEach(btn => {
        btn.classList.remove('active', 'bg-jade-green', 'text-white');
        btn.classList.add('bg-gray-100', 'text-gray-700');
    });
    
    const activeBtn = document.querySelector(`[data-filter="${filter}"]`);
    activeBtn.classList.add('active', 'bg-jade-green', 'text-white');
    activeBtn.classList.remove('bg-gray-100', 'text-gray-700');
    
    // Filter cards
    cards.forEach(card => {
        if (filter === 'all' || card.dataset.schedule.toLowerCase() === filter.toLowerCase()) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Initialize active button
document.querySelector('[data-filter="all"]').classList.add('bg-jade-green', 'text-white');
document.querySelector('[data-filter="all"]').classList.remove('bg-gray-100', 'text-gray-700');
</script>
@endsection
