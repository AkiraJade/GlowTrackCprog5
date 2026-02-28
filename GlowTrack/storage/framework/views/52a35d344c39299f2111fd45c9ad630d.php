<?php $__env->startSection('title', 'Products - GlowTrack'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Skincare Products</h1>
            <p class="text-gray-600 mt-2">Discover the perfect products for your skin type</p>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-6">
                <form method="GET" action="<?php echo e(route('products.index')); ?>" class="space-y-4">
                    <!-- Search Bar -->
                    <div>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                               placeholder="Search products, brands, or ingredients..." 
                               class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                    </div>

                    <!-- Filter Options -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Classification -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Type</label>
                            <select name="classification" class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                <option value="">All Types</option>
                                <?php $__currentLoopData = $classifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($classification); ?>" <?php echo e(request('classification') == $classification ? 'selected' : ''); ?>>
                                        <?php echo e($classification); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Skin Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Skin Type</label>
                            <select name="skin_type" class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                <option value="">All Skin Types</option>
                                <option value="Oily" <?php echo e(request('skin_type') == 'Oily' ? 'selected' : ''); ?>>Oily</option>
                                <option value="Dry" <?php echo e(request('skin_type') == 'Dry' ? 'selected' : ''); ?>>Dry</option>
                                <option value="Combination" <?php echo e(request('skin_type') == 'Combination' ? 'selected' : ''); ?>>Combination</option>
                                <option value="Sensitive" <?php echo e(request('skin_type') == 'Sensitive' ? 'selected' : ''); ?>>Sensitive</option>
                                <option value="Normal" <?php echo e(request('skin_type') == 'Normal' ? 'selected' : ''); ?>>Normal</option>
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                            <input type="number" name="max_price" value="<?php echo e(request('max_price')); ?>" 
                                   placeholder="Max price" min="0" step="0.01"
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                        </div>

                        <!-- Ingredients -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Key Ingredient</label>
                            <select name="ingredient" class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                <option value="">All Ingredients</option>
                                <?php $__currentLoopData = $ingredients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingredient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($ingredient); ?>" <?php echo e(request('ingredient') == $ingredient ? 'selected' : ''); ?>>
                                        <?php echo e($ingredient); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <!-- Additional Filters -->
                    <div class="flex flex-wrap items-center gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="verified_only" value="1" 
                                   <?php echo e(request('verified_only') ? 'checked' : ''); ?>

                                   class="mr-2 border-gray-300 rounded text-jade-green focus:ring-jade-green">
                            <span class="text-sm text-gray-700">Verified sellers only</span>
                        </label>

                        <!-- Sort Options -->
                        <div class="flex items-center space-x-2">
                            <label class="text-sm font-medium text-gray-700">Sort by:</label>
                            <select name="sort_by" class="border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                <option value="created_at" <?php echo e(request('sort_by') == 'created_at' ? 'selected' : ''); ?>>Latest</option>
                                <option value="name" <?php echo e(request('sort_by') == 'name' ? 'selected' : ''); ?>>Name</option>
                                <option value="price" <?php echo e(request('sort_by') == 'price' ? 'selected' : ''); ?>>Price</option>
                                <option value="average_rating" <?php echo e(request('sort_by') == 'average_rating' ? 'selected' : ''); ?>>Rating</option>
                            </select>
                            <select name="sort_order" class="border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                <option value="desc" <?php echo e(request('sort_order') == 'desc' ? 'selected' : ''); ?>>Desc</option>
                                <option value="asc" <?php echo e(request('sort_order') == 'asc' ? 'selected' : ''); ?>>Asc</option>
                            </select>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex space-x-4">
                        <button type="submit" class="px-4 py-2 bg-jade-green text-white rounded-md hover:bg-opacity-90 transition">
                            Apply Filters
                        </button>
                        <a href="<?php echo e(route('products.index')); ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                            Clear Filters
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="mb-8">
            <?php if($products->count() > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
                            <!-- Product Image -->
                            <div class="relative">
                                <?php if($product->photo): ?>
                                    <img src="<?php echo e(asset('storage/' . $product->photo)); ?>" 
                                         alt="<?php echo e($product->name); ?>" 
                                         class="w-full h-48 object-cover rounded-t-lg">
                                <?php else: ?>
                                    <div class="w-full h-48 bg-gray-200 rounded-t-lg flex items-center justify-center">
                                        <span class="text-gray-400">No Image</span>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Verified Badge -->
                                <?php if($product->is_verified): ?>
                                    <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                        ✓ Verified
                                    </div>
                                <?php endif; ?>

                                <!-- Stock Status -->
                                <div class="absolute bottom-2 left-2">
                                    <?php if($product->isInStock()): ?>
                                        <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                            In Stock
                                        </span>
                                    <?php else: ?>
                                        <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                            Out of Stock
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <!-- Brand and Classification -->
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs text-gray-500"><?php echo e($product->brand); ?></span>
                                    <span class="text-xs bg-jade-green text-white px-2 py-1 rounded-full">
                                        <?php echo e($product->classification); ?>

                                    </span>
                                </div>

                                <!-- Product Name -->
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                    <a href="<?php echo e(route('products.show', $product)); ?>" class="hover:text-jade-green transition">
                                        <?php echo e($product->name); ?>

                                    </a>
                                </h3>

                                <!-- Price and Rating -->
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-lg font-bold text-gray-900">$<?php echo e(number_format($product->price, 2)); ?></span>
                                    <?php if($product->review_count > 0): ?>
                                        <div class="flex items-center">
                                            <span class="text-yellow-400">★</span>
                                            <span class="text-sm text-gray-600"><?php echo e(number_format($product->average_rating, 1)); ?> (<?php echo e($product->review_count); ?>)</span>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-sm text-gray-500">No reviews</span>
                                    <?php endif; ?>
                                </div>

                                <!-- Size and Skin Types -->
                                <div class="text-sm text-gray-600 mb-3">
                                    <div><?php echo e($product->size_volume); ?></div>
                                    <div class="text-xs">
                                        <?php $__currentLoopData = $product->skin_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skinType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="bg-gray-100 px-1 py-0.5 rounded"><?php echo e($skinType); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                <!-- Key Ingredients -->
                                <?php if($product->active_ingredients): ?>
                                    <div class="text-xs text-gray-500">
                                        <strong>Key ingredients:</strong> <?php echo e(implode(', ', array_slice($product->active_ingredients, 0, 2))); ?>

                                        <?php if(count($product->active_ingredients) > 2): ?>
                                            +<?php echo e(count($product->active_ingredients) - 2); ?> more
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    <?php echo e($products->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-500">Try adjusting your filters or search terms</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sedriel Navasca\Desktop\COMPROG\GlowTrackCprog5\GlowTrack\resources\views/products/index.blade.php ENDPATH**/ ?>