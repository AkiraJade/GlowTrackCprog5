@extends('layouts.app')

@section('title', 'Edit Product - GlowTrack')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Product</h1>
            <p class="text-gray-600 mt-2">Update your skincare product information</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-6">
                <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Product Name -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                                <input type="text" id="name" name="name" required
                                       value="{{ old('name', $product->name) }}"
                                       class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Brand -->
                            <div>
                                <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand *</label>
                                <input type="text" id="brand" name="brand" required
                                       value="{{ old('brand', $product->brand) }}"
                                       class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                @error('brand')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Classification -->
                            <div>
                                <label for="classification" class="block text-sm font-medium text-gray-700 mb-1">Product Type *</label>
                                <select id="classification" name="classification" required
                                        class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                    <option value="">Select Product Type</option>
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

                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (₱) *</label>
                                <input type="number" id="price" name="price" required step="0.01" min="0"
                                       value="{{ old('price', $product->price) }}"
                                       class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Size/Volume -->
                            <div>
                                <label for="size_volume" class="block text-sm font-medium text-gray-700 mb-1">Size/Volume *</label>
                                <input type="text" id="size_volume" name="size_volume" required
                                       value="{{ old('size_volume', $product->size_volume) }}"
                                       class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
                                       placeholder="e.g., 30ml, 50g">
                                @error('size_volume')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                                <input type="number" id="quantity" name="quantity" required min="0"
                                       value="{{ old('quantity', $product->quantity) }}"
                                       class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                @error('quantity')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Product Description</h2>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                            <textarea id="description" name="description" rows="4" required
                                      class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">{{ old('description', $product->description) }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">Describe your product, its benefits, and usage instructions</p>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Skin Types -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Suitable Skin Types</h2>
                        
                        @php
                            $currentSkinTypes = old('skin_types', $product->skin_types ?? []);
                        @endphp
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                            @foreach(['Oily', 'Dry', 'Combination', 'Sensitive', 'Normal'] as $skinType)
                                <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" name="skin_types[]" value="{{ $skinType }}"
                                           class="mr-3 text-jade-green focus:ring-jade-green"
                                           {{ in_array($skinType, $currentSkinTypes) ? 'checked' : '' }}>
                                    <span class="text-sm font-medium text-gray-700">{{ $skinType }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('skin_types')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Ingredients -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Active Ingredients</h2>
                        
                        <div id="ingredients-container" class="space-y-3">
                            @php
                                $ingredients = old('active_ingredients', $product->active_ingredients ?? []);
                                if (empty($ingredients)) {
                                    $ingredients = ['Vitamin C'];
                                }
                            @endphp
                            @foreach($ingredients as $index => $ingredient)
                                <div class="ingredient-input-group flex gap-3">
                                    <input type="text" name="active_ingredients[]" 
                                           class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
                                           placeholder="e.g., Hyaluronic Acid" value="{{ $ingredient }}">
                                    <button type="button" onclick="removeIngredient(this)" 
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-md" title="Remove ingredient">
                                        ×
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        
                        <button type="button" onclick="addIngredient()" 
                                class="mt-4 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                            + Add Another Ingredient
                        </button>
                        @error('active_ingredients')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Photos -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Product Photos</h2>
                        
                        <!-- Existing Images -->
                        @if($product->images->count() > 0)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                                    @foreach($product->images as $image)
                                        <div class="relative group">
                                            <img src="{{ $image->image_url }}" alt="Product Image" 
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

                        <!-- Add New Images -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Add New Images</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-jade-green transition-colors">
                                <input type="file" id="images" name="images[]" accept="image/*" multiple
                                       class="hidden" onchange="previewImages(this)">
                                <label for="images" class="cursor-pointer">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-600">Click to upload or drag and drop</p>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB each (Max 5 images total)</p>
                                    </div>
                                </label>
                            </div>
                            <div id="imagePreview" class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4"></div>
                            @error('images')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Single Image Upload (Legacy) -->
                        <div class="border-t pt-4">
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Single Image Upload (Optional)</label>
                            <input type="file" id="photo" name="photo" accept="image/*"
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                            <p class="text-sm text-gray-500 mt-1">Use this for single image upload (legacy support)</p>
                            @error('photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hidden field for primary image -->
                        <input type="hidden" name="primary_image" id="primary_image" value="{{ $product->images->where('is_primary', true)->first()->id ?? 0 }}">
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('products.show', $product) }}" 
                           class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-jade-green text-white rounded-md hover:bg-opacity-90 transition font-semibold">
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Box -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Review Process</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>Updating your product will require admin review before changes are published.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImages(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    if (input.files) {
        const files = Array.from(input.files);
        
        files.forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-32 object-cover rounded-lg border-2 border-gray-200';
                    
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity';
                    removeBtn.innerHTML = '×';
                    removeBtn.onclick = function() {
                        div.remove();
                        // Update file input
                        const dt = new DataTransfer();
                        files.splice(index, 1);
                        files.forEach(f => dt.items.add(f));
                        input.files = dt.files;
                    };
                    
                    div.appendChild(img);
                    div.appendChild(removeBtn);
                    preview.appendChild(div);
                };
                
                reader.readAsDataURL(file);
            }
        });
        
        // Show warning if too many images
        const currentImageCount = {{ $product->images->count() }};
        if (currentImageCount + files.length > 5) {
            const warning = document.createElement('div');
            warning.className = 'col-span-full text-sm text-yellow-600 mt-2';
            warning.textContent = 'Maximum 5 images allowed total. You currently have ' + currentImageCount + ' images.';
            preview.appendChild(warning);
        }
    }
}

function removeImage(imageId) {
    if (confirm('Are you sure you want to remove this image?')) {
        const checkbox = document.getElementById('remove_' + imageId);
        checkbox.style.display = 'block';
        checkbox.checked = true;
        
        // Hide the image container
        event.target.closest('.relative').style.display = 'none';
    }
}

function setPrimaryImage(imageId) {
    // Update hidden field
    document.getElementById('primary_image').value = imageId;
    
    // Remove primary indicator from all images
    document.querySelectorAll('.border-jade-green').forEach(el => {
        el.classList.remove('border-jade-green');
        el.classList.add('border-gray-200');
    });
    
    document.querySelectorAll('span').forEach(el => {
        if (el.textContent === 'Primary') {
            el.remove();
        }
    });
    
    // Add primary indicator to selected image
    const imageContainer = event.target.closest('.relative');
    const img = imageContainer.querySelector('img');
    img.classList.remove('border-gray-200');
    img.classList.add('border-jade-green');
    
    const primaryLabel = document.createElement('span');
    primaryLabel.className = 'absolute top-1 left-1 bg-jade-green text-white text-xs px-2 py-1 rounded';
    primaryLabel.textContent = 'Primary';
    imageContainer.appendChild(primaryLabel);
    
    // Disable the star button
    event.target.disabled = true;
    event.target.classList.add('opacity-50', 'cursor-not-allowed');
    
    // Enable other star buttons
    document.querySelectorAll('button[onclick^="setPrimaryImage"]').forEach(btn => {
        if (btn !== event.target) {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    });
}

// Add ingredient management functions
function addIngredient() {
    const container = document.getElementById('ingredients-container');
    const newGroup = document.createElement('div');
    newGroup.className = 'ingredient-input-group flex gap-3';
    newGroup.innerHTML = `
        <input type="text" name="active_ingredients[]" 
               class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
               placeholder="e.g., Hyaluronic Acid">
        <button type="button" onclick="removeIngredient(this)" 
                class="p-2 text-red-600 hover:bg-red-50 rounded-md" title="Remove ingredient">
            ×
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

// Add comprehensive form debugging
document.addEventListener('DOMContentLoaded', function() {
    // Try multiple selectors to find the form
    const form = document.querySelector('form[method="POST"]') || 
                   document.querySelector('form[enctype="multipart/form-data"]') ||
                   document.querySelector('form');
                   
    if (form) {
        console.log('✅ Form found:', form.action);
        console.log('✅ Form method:', form.method);
        console.log('✅ Form enctype:', form.enctype);
        
        form.addEventListener('submit', function(e) {
            console.log('🚀 Form submit triggered!');
            e.preventDefault(); // Prevent actual submission for debugging
            
            try {
                // Get all form data
                const formData = new FormData(form);
                const data = {};
                
                // Convert FormData to object
                for (let [key, value] of formData.entries()) {
                    if (data[key]) {
                        // Convert to array if multiple values
                        if (!Array.isArray(data[key])) {
                            data[key] = [data[key]];
                        }
                        data[key].push(value);
                    } else {
                        data[key] = value;
                    }
                }
                
                console.log('📊 Form data being submitted:', data);
                
                // Check required fields
                const requiredFields = ['name', 'description', 'brand', 'classification', 'price', 'size_volume', 'quantity'];
                const missingFields = requiredFields.filter(field => !data[field] || data[field] === '');
                
                if (missingFields.length > 0) {
                    console.error('❌ Missing required fields:', missingFields);
                    alert('Please fill in all required fields: ' + missingFields.join(', '));
                    return false;
                }
                
                // Check arrays
                const skinTypes = Array.isArray(data['skin_types']) ? data['skin_types'] : [data['skin_types']];
                const ingredients = Array.isArray(data['active_ingredients']) ? data['active_ingredients'] : [data['active_ingredients']];
                
                const cleanSkinTypes = skinTypes.filter(val => val && val.trim() !== '');
                const cleanIngredients = ingredients.filter(val => val && val.trim() !== '');
                
                console.log('🧑 Skin types:', cleanSkinTypes);
                console.log('🌿 Ingredients:', cleanIngredients);
                
                if (cleanSkinTypes.length === 0) {
                    console.error('❌ No skin types selected');
                    alert('Please select at least one skin type');
                    return false;
                }
                
                if (cleanIngredients.length === 0) {
                    console.error('❌ No ingredients provided');
                    alert('Please add at least one active ingredient');
                    return false;
                }
                
                console.log('✅ Validation passed, submitting form...');
                
                // Remove the preventDefault and submit
                e.target.removeEventListener('submit', arguments.callee);
                e.target.submit();
                
            } catch (error) {
                console.error('❌ Form submission error:', error);
                alert('Error submitting form: ' + error.message);
                return false;
            }
        });
    } else {
        console.error('❌ Form not found!');
    }
});
</script>
@endsection
