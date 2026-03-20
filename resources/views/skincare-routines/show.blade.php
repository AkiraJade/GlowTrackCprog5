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
            
            <!-- Action Buttons -->
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
        
        <!-- Back Button -->
        <div class="text-center mt-8">
            <a href="{{ route('skincare-routines.index') }}" 
               class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                ← Back to My Routines
            </a>
        </div>
    </div>
</section>
@endsection
