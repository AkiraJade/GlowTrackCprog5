@extends('layouts.app')

@section('title', 'Create Product - GlowTrack')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Create New Product</h1>
            <p class="text-gray-600 mt-2">Add your skincare product to our marketplace</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-6">
                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Basic Information -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Product Name -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                                <input type="text" id="name" name="name" required
                                       class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
                                       placeholder="e.g., Vitamin C Brightening Serum">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Brand -->
                            <div>
                                <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand *</label>
                                <input type="text" id="brand" name="brand" required
                                       class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
                                       placeholder="e.g., GlowLab">
                                @error('brand')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Classification -->
                            <div>
                                <label for="classification" class="block text-sm font-medium text-gray-700 mb-1">Product Type *</label>
                                <select id="classification" name="classification" required
                                        class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                    <option value="">Select a type</option>
                                    @foreach($classifications as $classification)
                                        <option value="{{ $classification }}">{{ $classification }}</option>
                                    @endforeach
                                </select>
                                @error('classification')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                                <textarea id="description" name="description" rows="4" required
                                          class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
                                          placeholder="Describe your product, its benefits, and key features..."></textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pricing and Inventory -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Pricing & Inventory</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price ($) *</label>
                                <input type="number" id="price" name="price" step="0.01" min="0" required
                                       class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
                                       placeholder="29.99">
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Size/Volume -->
                            <div>
                                <label for="size_volume" class="block text-sm font-medium text-gray-700 mb-1">Size/Volume *</label>
                                <input type="text" id="size_volume" name="size_volume" required
                                       class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
                                       placeholder="e.g., 30ml, 50g">
                                @error('size_volume')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Initial Stock *</label>
                                <input type="number" id="quantity" name="quantity" min="0" required
                                       class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
                                       placeholder="100">
                                @error('quantity')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Skin Types -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Suitable Skin Types *</h2>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                            @foreach(['Oily', 'Dry', 'Combination', 'Sensitive', 'Normal'] as $skinType)
                                <label class="flex items-center">
                                    <input type="checkbox" name="skin_types[]" value="{{ $skinType }}"
                                           class="mr-2 border-gray-300 rounded text-jade-green focus:ring-jade-green">
                                    <span class="text-sm text-gray-700">{{ $skinType }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('skin_types')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Ingredients -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Active Ingredients *</h2>
                        <div class="space-y-2">
                            <div id="ingredients-container">
                                <div class="flex items-center space-x-2">
                                    <input type="text" name="active_ingredients[]" 
                                           class="flex-1 border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
                                           placeholder="e.g., Niacinamide">
                                    <button type="button" onclick="addIngredientField()" 
                                            class="px-3 py-2 bg-jade-green text-white rounded-md hover:bg-opacity-90 transition">
                                        +
                                    </button>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500">Add at least one active ingredient</p>
                        </div>
                        @error('active_ingredients')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Photo -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Product Photo</h2>
                        <div class="flex items-center space-x-6">
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
                                <input type="file" id="photo" name="photo" accept="image/*"
                                       class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                <p class="text-sm text-gray-500 mt-1">JPG, PNG, GIF up to 2MB</p>
                                @error('photo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('products.index') }}" 
                           class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-jade-green text-white rounded-md hover:bg-opacity-90 transition font-semibold">
                            Submit for Review
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
                        <p>Your product will be submitted for admin review before being published. This typically takes 1-2 business days.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function addIngredientField() {
    const container = document.getElementById('ingredients-container');
    const newField = document.createElement('div');
    newField.className = 'flex items-center space-x-2 mt-2';
    newField.innerHTML = `
        <input type="text" name="active_ingredients[]" 
               class="flex-1 border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
               placeholder="e.g., Hyaluronic Acid">
        <button type="button" onclick="removeIngredientField(this)" 
                class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
            -
        </button>
    `;
    container.appendChild(newField);
}

function removeIngredientField(button) {
    button.parentElement.remove();
}
</script>
@endsection
