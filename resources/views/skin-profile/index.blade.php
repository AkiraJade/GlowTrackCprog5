@extends('layouts.app')

@section('title', 'Skin Profile - GlowTrack')

@section('content')
<!-- Skin Profile Container -->
<section class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-4xl font-bold text-soft-brown font-playfair">My Skin Profile</h1>
                    <button onclick="window.location.href='{{ route("skin-profile.create") }}'" 
                            class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-semibold shadow-lg">
                        ✨ Create Profile
                    </button>
                </div>
                
                @if($profile)
                    <!-- Profile Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Skin Type -->
                        <div class="bg-gradient-to-br from-jade-green/10 to-jade-green/20 rounded-2xl p-6 border border-jade-green/30">
                            <div class="flex items-center mb-3">
                                <span class="text-2xl mr-3">🎨</span>
                                <h3 class="text-lg font-semibold text-soft-brown">Skin Type</h3>
                            </div>
                            <p class="text-2xl font-bold text-jade-green">{{ $profile->skin_type }}</p>
                        </div>
                        
                        <!-- Skin Concerns -->
                        <div class="bg-gradient-to-br from-blush-pink/10 to-blush-pink/20 rounded-2xl p-6 border border-blush-pink/30">
                            <div class="flex items-center mb-3">
                                <span class="text-2xl mr-3">🎯</span>
                                <h3 class="text-lg font-semibold text-soft-brown">Skin Concerns</h3>
                            </div>
                            <div class="space-y-2">
                                @if(!empty($profile->skin_concerns))
                                    @foreach($profile->skin_concerns as $concern)
                                        <span class="inline-block px-3 py-1 bg-blush-pink text-white rounded-full text-sm font-medium">
                                            {{ $concern }}
                                        </span>
                                    @endforeach
                                @else
                                    <p class="text-gray-500 italic">No concerns specified</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Ingredient Allergies -->
                        <div class="bg-gradient-to-br from-warm-peach/10 to-warm-peach/20 rounded-2xl p-6 border border-warm-peach/30">
                            <div class="flex items-center mb-3">
                                <span class="text-2xl mr-3">⚠️</span>
                                <h3 class="text-lg font-semibold text-soft-brown">Allergies</h3>
                            </div>
                            <div class="space-y-2">
                                @if(!empty($profile->ingredient_allergies))
                                    @foreach($profile->ingredient_allergies as $allergy)
                                        <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                            {{ $allergy }}
                                        </span>
                                    @endforeach
                                @else
                                    <p class="text-gray-500 italic">No allergies specified</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Notes -->
                        @if($profile->notes)
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 border border-gray-200">
                            <div class="flex items-center mb-3">
                                <span class="text-2xl mr-3">📝</span>
                                <h3 class="text-lg font-semibold text-soft-brown">Notes</h3>
                            </div>
                            <p class="text-gray-700 leading-relaxed">{{ $profile->notes }}</p>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex justify-center space-x-4 mt-8">
                        <button onclick="window.location.href='{{ route("skin-profile.edit", $profile) }}'" 
                                class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-semibold shadow-lg">
                            ✏️ Edit Profile
                        </button>
                        <button onclick="window.location.href='{{ route("skin-profile.timeline") }}'" 
                                class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                            📖 View Timeline
                        </button>
                    </div>
                @else
                    <!-- No Profile State -->
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">🎨</div>
                        <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-4">No Skin Profile Yet</h2>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            Create your personalized skin profile to get tailored product recommendations and track your skincare journey.
                        </p>
                        <button onclick="window.location.href='{{ route("skin-profile.create") }}'" 
                                class="px-8 py-4 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-bold text-lg shadow-xl">
                            ✨ Create My Skin Profile
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
