@extends('layouts.admin')

@section('title', 'Add Product - Admin')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 font-playfair">Add New Product</h1>
                <p class="text-gray-600 mt-2">Create a new product listing</p>
            </div>
            <a href="{{ route('admin.products') }}" class="px-6 py-2 border-2 border-admin-primary text-admin-primary rounded-full hover:bg-admin-primary hover:text-white transition font-semibold">
                ← Back to Products
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Basic Information -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-soft-brown mb-6 pb-2 border-b border-gray-200">Basic Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-soft-brown mb-2">Product Name *</label>
                        <input type="text" id="name" name="name" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green"
                               value="{{ old('name') }}" placeholder="Enter product name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="brand" class="block text-sm font-medium text-soft-brown mb-2">Brand *</label>
                        <input type="text" id="brand" name="brand" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green"
                               value="{{ old('brand') }}" placeholder="Enter brand name">
                        @error('brand')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="classification" class="block text-sm font-medium text-soft-brown mb-2">Product Type *</label>
                        <select id="classification" name="classification" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green">
                            <option value="">Select product type</option>
                            @foreach(['Cleanser', 'Moisturizer', 'Serum', 'Toner', 'Sunscreen', 'Mask', 'Exfoliant', 'Treatment'] as $classification)
                                <option value="{{ $classification }}" {{ old('classification') == $classification ? 'selected' : '' }}>
                                    {{ $classification }}
                                </option>
                            @endforeach
                        </select>
                        @error('classification')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="size_volume" class="block text-sm font-medium text-soft-brown mb-2">Size/Volume *</label>
                        <input type="text" id="size_volume" name="size_volume" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green"
                               value="{{ old('size_volume') }}" placeholder="e.g., 50ml, 100g">
                        @error('size_volume')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-soft-brown mb-2">Price (₱) *</label>
                        <input type="number" id="price" name="price" required step="0.01" min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green"
                               value="{{ old('price') }}" placeholder="0.00">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="quantity" class="block text-sm font-medium text-soft-brown mb-2">Initial Stock *</label>
                        <input type="number" id="quantity" name="quantity" required min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green"
                               value="{{ old('quantity', 0) }}" placeholder="0">
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-soft-brown mb-2">Description *</label>
                    <textarea id="description" name="description" required rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green"
                              placeholder="Describe the product, its benefits, and usage instructions">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Product Images -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-soft-brown mb-6 pb-2 border-b border-gray-200">Product Images</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="photo" class="block text-sm font-medium text-soft-brown mb-2">Primary Image</label>
                        <input type="file" id="photo" name="photo" accept="image/*"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green">
                        <p class="mt-1 text-sm text-gray-500">Main product image (JPEG, PNG, max 2MB)</p>
                        @error('photo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="images" class="block text-sm font-medium text-soft-brown mb-2">Additional Images</label>
                        <input type="file" id="images" name="images[]" accept="image/*" multiple
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green">
                        <p class="mt-1 text-sm text-gray-500">Up to 5 additional images (JPEG, PNG, max 2MB each)</p>
                        @error('images')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Skin Types & Ingredients -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-soft-brown mb-6 pb-2 border-b border-gray-200">Target Skin & Ingredients</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-soft-brown mb-3">Suitable Skin Types *</label>
                        <div class="space-y-2">
                            @foreach(['Oily', 'Dry', 'Combination', 'Sensitive', 'Normal'] as $skinType)
                                <label class="flex items-center">
                                    <input type="checkbox" name="skin_types[]" value="{{ $skinType }}"
                                           class="mr-2 border-gray-300 rounded text-jade-green focus:ring-jade-green"
                                           {{ in_array($skinType, old('skin_types', [])) ? 'checked' : '' }}>
                                    <span class="text-sm">{{ $skinType }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('skin_types')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-soft-brown mb-3">Active Ingredients *</label>
                        <div class="space-y-2">
                            @foreach(['Niacinamide', 'Retinol', 'Hyaluronic Acid', 'Vitamin C', 'Salicylic Acid', 'Glycolic Acid', 'Ceramides', 'Peptides', 'Azelaic Acid', 'Bakuchiol'] as $ingredient)
                                <label class="flex items-center">
                                    <input type="checkbox" name="active_ingredients[]" value="{{ $ingredient }}"
                                           class="mr-2 border-gray-300 rounded text-jade-green focus:ring-jade-green"
                                           {{ in_array($ingredient, old('active_ingredients', [])) ? 'checked' : '' }}>
                                    <span class="text-sm">{{ $ingredient }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('active_ingredients')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.products') }}" 
                   class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-full hover:bg-gray-50 transition font-semibold">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-opacity-90 transition font-semibold">
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
