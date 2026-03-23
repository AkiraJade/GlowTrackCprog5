@extends('layouts.app')

@section('title', 'Edit Product - Seller Dashboard - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="glass-card rounded-3xl shadow-lg p-8 border border-gray-200">
                <div class="flex items-center justify-between gap-6">
                    <div>
                        <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-3">
                            Edit Product ✏️
                        </h1>
                        <p class="text-lg text-soft-brown opacity-75">
                            Update your product information
                        </p>
                    </div>
                    <a href="{{ route('seller.products.index') }}" class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                        ← Back to Products
                    </a>
                </div>
            </div>
        </div>

        <!-- Product Form -->
        <div class="glass-card rounded-2xl shadow-lg p-8 border border-gray-200">
            <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Basic Information -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6 flex items-center gap-3">
                        <span class="text-3xl">📝</span> Basic Information
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-soft-brown mb-2">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" required value="{{ old('name', $product->name) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-soft-brown mb-2">
                                Brand Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="brand" required value="{{ old('brand', $product->brand) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition">
                            @error('brand')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-soft-brown mb-2">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" required rows="4" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Product Details -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6 flex items-center gap-3">
                        <span class="text-3xl">🧴</span> Product Details
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-soft-brown mb-2">
                                Classification <span class="text-red-500">*</span>
                            </label>
                            <select name="classification" required 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition">
                                <option value="">Select category</option>
                                @foreach($classifications as $classification)
                                    <option value="{{ $classification }}" {{ old('classification', $product->classification) == $classification ? 'selected' : '' }}>
                                        {{ $classification }}
                                    </option>
                                @endforeach
                            </select>
                            @error('classification')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-soft-brown mb-2">
                                Price ($) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="price" required step="0.01" min="0" 
                                   value="{{ old('price', $product->price) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-soft-brown mb-2">
                                Size/Volume <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="size_volume" required 
                                   value="{{ old('size_volume', $product->size_volume) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition">
                            @error('size_volume')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-soft-brown mb-2">
                            Quantity Available <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="quantity" required min="0" 
                               value="{{ old('quantity', $product->quantity) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition">
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Skin Types -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6 flex items-center gap-3">
                        <span class="text-3xl">🧑</span> Suitable Skin Types
                    </h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        @foreach($skinTypes as $skinType)
                            @php
                                $currentSkinTypes = is_array($product->skin_types) ? $product->skin_types : json_decode($product->skin_types ?? '[]', true);
                            @endphp
                            <label class="flex items-center p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition">
                                <input type="checkbox" name="skin_types[]" value="{{ $skinType }}"
                                       class="mr-3 text-jade-green focus:ring-jade-green"
                                       {{ in_array($skinType, old('skin_types', $currentSkinTypes)) ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-soft-brown">{{ $skinType }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('skin_types')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Ingredients -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6 flex items-center gap-3">
                        <span class="text-3xl">🌿</span> Active Ingredients
                    </h2>
                    
                    <div id="ingredients-container" class="space-y-3">
                        @php
                            $currentIngredients = is_array($product->active_ingredients) ? $product->active_ingredients : json_decode($product->active_ingredients ?? '[]', true);
                            $ingredients = old('active_ingredients', $currentIngredients);
                            if(empty($ingredients)) $ingredients = ['Vitamin C']; // Default ingredient instead of empty string
                        @endphp
                        @foreach($ingredients as $index => $ingredient)
                            <div class="ingredient-input-group flex gap-3">
                                <input type="text" name="active_ingredients[]" 
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition"
                                       placeholder="e.g., Hyaluronic Acid" value="{{ $ingredient }}">
                                <button type="button" onclick="removeIngredient(this)" 
                                        class="p-3 text-red-600 hover:bg-red-50 rounded-xl transition" title="Remove ingredient">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    
                    <button type="button" onclick="addIngredient()" 
                            class="mt-4 px-4 py-2 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                        + Add Another Ingredient
                    </button>
                    @error('active_ingredients')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Product Photos -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6 flex items-center gap-3">
                        <span class="text-3xl">📷</span> Product Photos
                    </h2>

                    <!-- Existing Images -->
                    @if($product->images->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-soft-brown mb-4">Current Images ({{ $product->images->count() }})</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($product->images->sortBy('sort_order') as $image)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/products/' . $image->image_path) }}"
                                             alt="Product image"
                                             class="w-full h-32 object-cover rounded-lg border-2 {{ $image->is_primary ? 'border-jade-green' : 'border-gray-200' }}">
                                        @if($image->is_primary)
                                            <span class="absolute top-1 left-1 bg-jade-green text-white text-xs px-2 py-1 rounded">Primary</span>
                                        @endif
                                        <div class="absolute top-1 right-1 flex space-x-1">
                                            <button type="button" onclick="setPrimaryImage({{ $image->id }})"
                                                    class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-blue-600 {{ $image->is_primary ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                    {{ $image->is_primary ? 'disabled' : '' }}>
                                                ★
                                            </button>
                                            <button type="button" onclick="removeImage({{ $image->id }})"
                                                    class="bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                                ×
                                            </button>
                                        </div>
                                        <input type="hidden" name="remove_images[]" value="{{ $image->id }}" id="remove_{{ $image->id }}" style="display:none;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Primary Image (if no existing images) -->
                        @if($product->images->count() === 0)
                        <div>
                            <label class="block text-sm font-medium text-soft-brown mb-2">
                                Primary Image <span class="text-red-500">*</span>
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-jade-green transition">
                                <input type="file"
                                       name="photo"
                                       accept="image/*"
                                       class="hidden"
                                       id="photo-upload"
                                       onchange="previewPhoto(event)"
                                       required>

                                <label for="photo-upload" class="cursor-pointer">
                                    <div id="photo-preview" class="mb-4">
                                        @if($product->photo)
                                            <img src="{{ $product->photo_url }}" alt="Current product photo" class="mx-auto h-32 w-32 object-cover object-center rounded-lg">
                                        @else
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <p class="text-sm text-soft-brown opacity-75">Click to upload primary photo</p>
                                    <p class="text-xs text-soft-brown opacity-60 mt-1">PNG, JPG, GIF up to 2MB</p>
                                </label>
                            </div>
                            @error('photo')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif

                        <!-- Additional Images -->
                        <div>
                            <label class="block text-sm font-medium text-soft-brown mb-2">
                                Add More Images (Optional)
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-jade-green transition">
                                <input type="file"
                                       name="images[]"
                                       accept="image/*"
                                       multiple
                                       class="hidden"
                                       id="images-upload"
                                       onchange="previewImages(event)">

                                <label for="images-upload" class="cursor-pointer">
                                    <div id="images-preview" class="mb-4">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-soft-brown opacity-75">Click to upload additional photos</p>
                                    <p class="text-xs text-soft-brown opacity-60 mt-1">Up to {{ 5 - $product->images->count() }} more images, PNG, JPG, GIF up to 2MB each</p>
                                </label>
                            </div>
                            @error('images')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('images.*')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Hidden field for primary image -->
                    <input type="hidden" name="primary_image" id="primary_image" value="{{ $product->images->where('is_primary', true)->first()->id ?? 0 }}">
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col md:flex-row gap-4 justify-end">
                    <a href="{{ route('seller.products.index') }}" 
                       class="px-6 py-3 border-2 border-gray-300 text-gray-600 rounded-full hover:bg-gray-50 transition font-semibold text-center">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function addIngredient() {
    const container = document.getElementById('ingredients-container');
    const newGroup = document.createElement('div');
    newGroup.className = 'ingredient-input-group flex gap-3';
    newGroup.innerHTML = `
        <input type="text" name="active_ingredients[]" class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition" placeholder="e.g., Hyaluronic Acid">
        <button type="button" onclick="removeIngredient(this)" class="p-3 text-red-600 hover:bg-red-50 rounded-xl transition" title="Remove ingredient">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;
    container.appendChild(newGroup);
}

function removeIngredient(button) {
    const container = document.getElementById('ingredients-container');
    if (container.children.length > 1) {
        button.parentElement.remove();
    }
}

function previewPhoto(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('photo-preview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Product preview" class="mx-auto h-32 w-32 object-cover object-center rounded-lg">`;
        }
        reader.readAsDataURL(file);
    }
}

function previewImages(event) {
    const files = Array.from(event.target.files);
    const preview = document.getElementById('images-preview');
    
    // Clear previous previews
    preview.innerHTML = '';
    
    // Calculate remaining slots
    const currentImages = {{ $product->images->count() }};
    const maxImages = 5;
    const remainingSlots = maxImages - currentImages;
    const displayFiles = files.slice(0, remainingSlots);
    
    if (displayFiles.length > 0) {
        const grid = document.createElement('div');
        grid.className = 'grid grid-cols-2 md:grid-cols-3 gap-2';
        
        displayFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-20 object-cover rounded-lg';
                
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-700';
                removeBtn.textContent = '×';
                removeBtn.onclick = function(e) {
                    e.preventDefault();
                    div.remove();
                    
                    // Remove from file input
                    const dt = new DataTransfer();
                    const newFiles = Array.from(event.target.files).filter((f, i) => i !== index);
                    newFiles.forEach(f => dt.items.add(f));
                    event.target.files = dt.files;
                    
                    // Update preview
                    previewImages(event);
                };
                
                div.appendChild(img);
                div.appendChild(removeBtn);
                grid.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
        
        preview.appendChild(grid);
        
        // Show warning if more than allowed images
        if (files.length > remainingSlots) {
            const warning = document.createElement('p');
            warning.className = 'text-sm text-yellow-600 mt-2';
            warning.textContent = `Maximum ${maxImages} images total. You can add ${remainingSlots} more. Only first ${remainingSlots} will be uploaded.`;
            preview.appendChild(warning);
        }
    } else {
        // Reset to default icon
        preview.innerHTML = `
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
        `;
    }
}

function setPrimaryImage(imageId) {
    document.getElementById('primary_image').value = imageId;
    // Update UI to show new primary
    document.querySelectorAll('.bg-blue-500').forEach(btn => {
        btn.classList.remove('opacity-50', 'cursor-not-allowed');
        btn.disabled = false;
    });
    document.querySelectorAll('.bg-jade-green').forEach(span => span.remove());
    
    const imageDiv = event.target.closest('.relative');
    const starBtn = imageDiv.querySelector('.bg-blue-500');
    starBtn.classList.add('opacity-50', 'cursor-not-allowed');
    starBtn.disabled = true;
    
    const primaryBadge = document.createElement('span');
    primaryBadge.className = 'absolute top-1 left-1 bg-jade-green text-white text-xs px-2 py-1 rounded';
    primaryBadge.textContent = 'Primary';
    imageDiv.appendChild(primaryBadge);
}

function removeImage(imageId) {
    if (confirm('Are you sure you want to remove this image?')) {
        document.getElementById(`remove_${imageId}`).style.display = 'block';
        event.target.closest('.relative').remove();
    }
}

// Add form submission debugging
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="update"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form submitted!');
            
            // Check ingredients
            const ingredients = document.querySelectorAll('input[name="active_ingredients[]"]');
            const ingredientValues = Array.from(ingredients).map(input => input.value.trim()).filter(val => val !== '');
            console.log('Ingredients found:', ingredientValues);
            
            if (ingredientValues.length === 0) {
                alert('Please add at least one active ingredient.');
                e.preventDefault();
                return false;
            }
            
            // Check skin types
            const skinTypes = document.querySelectorAll('input[name="skin_types[]"]:checked');
            if (skinTypes.length === 0) {
                alert('Please select at least one skin type.');
                e.preventDefault();
                return false;
            }
            
            console.log('Form validation passed, submitting...');
        });
    }
});
</script>
@endsection
