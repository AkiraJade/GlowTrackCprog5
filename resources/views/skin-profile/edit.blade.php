@extends('layouts.app')

@section('title', 'Edit Skin Profile - GlowTrack')

@section('content')
<!-- Edit Profile Container -->
<section class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Form Card -->
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-4">Edit Your Skin Profile</h1>
                <p class="text-gray-600 text-lg">Update your skin information and preferences</p>
            </div>
            
            <form method="POST" action="{{ route('skin-profile.update', $skinProfile) }}" class="space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Skin Type -->
                <div class="bg-gradient-to-br from-jade-green/10 to-jade-green/20 rounded-2xl p-6 border border-jade-green/30">
                    <h3 class="text-xl font-semibold text-soft-brown mb-6 flex items-center">
                        <span class="text-2xl mr-3">🎨</span>
                        Skin Type
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        @foreach($availableTypes as $type)
                            <label class="relative">
                                <input type="radio" name="skin_type" value="{{ $type }}" 
                                       class="sr-only peer" required
                                       {{ $skinProfile->skin_type == $type ? 'checked' : '' }}>
                                <div class="w-12 h-12 bg-white border-2 border-gray-300 rounded-full peer-checked:border-jade-green peer-checked:bg-jade-green transition-all cursor-pointer flex items-center justify-center">
                                    <span class="text-sm font-medium">{{ $type }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Skin Concerns -->
                <div class="bg-gradient-to-br from-blush-pink/10 to-blush-pink/20 rounded-2xl p-6 border border-blush-pink/30">
                    <h3 class="text-xl font-semibold text-soft-brown mb-6 flex items-center">
                        <span class="text-2xl mr-3">🎯</span>
                        Skin Concerns (Select all that apply)
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach($availableConcerns as $concern)
                            <label class="flex items-center space-x-3 p-3 rounded-lg border border-gray-200 hover:border-blush-pink cursor-pointer transition">
                                <input type="checkbox" name="skin_concerns[]" value="{{ $concern }}" 
                                       class="form-checkbox h-5 w-5 text-jade-green rounded focus:ring-jade-green"
                                       {{ in_array($concern, $skinProfile->skin_concerns ?? []) ? 'checked' : '' }}>
                                <span class="text-sm font-medium">{{ $concern }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Ingredient Allergies -->
                <div class="bg-gradient-to-br from-warm-peach/10 to-warm-peach/20 rounded-2xl p-6 border border-warm-peach/30">
                    <h3 class="text-xl font-semibold text-soft-brown mb-6 flex items-center">
                        <span class="text-2xl mr-3">⚠️</span>
                        Known Allergies (Select all that apply)
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach($availableAllergies as $allergy)
                            <label class="flex items-center space-x-3 p-3 rounded-lg border border-gray-200 hover:border-warm-peach cursor-pointer transition">
                                <input type="checkbox" name="ingredient_allergies[]" value="{{ $allergy }}" 
                                       class="form-checkbox h-5 w-5 text-jade-green rounded focus:ring-jade-green"
                                       {{ in_array($allergy, $skinProfile->ingredient_allergies ?? []) ? 'checked' : '' }}>
                                <span class="text-sm font-medium">{{ $allergy }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Notes -->
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 border border-gray-200">
                    <h3 class="text-xl font-semibold text-soft-brown mb-6 flex items-center">
                        <span class="text-2xl mr-3">📝</span>
                        Additional Notes
                    </h3>
                    <textarea name="notes" rows="4" 
                              placeholder="Any additional information about your skin type, concerns, or preferences..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent resize-none">{{ old('notes', $skinProfile->notes) }}</textarea>
                </div>
                
                <!-- Submit Button -->
                <div class="flex justify-center space-x-4 pt-8">
                    <button type="submit" 
                            class="px-8 py-4 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-bold text-lg shadow-xl transform hover:scale-105">
                        💾 Update Profile
                    </button>
                    <a href="{{ route('skin-profile.index') }}" 
                       class="px-8 py-4 border-2 border-gray-300 text-gray-700 rounded-full hover:bg-gray-100 transition font-bold text-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
.form-checkbox:checked + div {
    background-color: #7EC8B3;
    border-color: #7EC8B3;
}

.form-checkbox:checked + div span {
    color: white;
}
</style>
@endsection
