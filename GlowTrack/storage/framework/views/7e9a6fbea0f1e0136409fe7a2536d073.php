<?php $__env->startSection('title', $product->name . ' - GlowTrack'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8 text-sm">
            <a href="<?php echo e(route('products.index')); ?>" class="text-gray-500 hover:text-gray-700">Products</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-900"><?php echo e($product->name); ?></span>
        </nav>

        <!-- Product Detail -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Product Image -->
                <div class="p-8">
                    <?php if($product->photo): ?>
                        <img src="<?php echo e(asset('storage/' . $product->photo)); ?>" 
                             alt="<?php echo e($product->name); ?>" 
                             class="w-full h-auto rounded-lg shadow-md">
                    <?php else: ?>
                        <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400 text-xl">No Product Image</span>
                        </div>
                    <?php endif; ?>

                    <!-- Stock Status -->
                    <div class="mt-4">
                        <?php if($product->isInStock()): ?>
                            <div class="flex items-center text-green-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-semibold"><?php echo e($product->quantity); ?> in stock</span>
                            </div>
                        <?php else: ?>
                            <div class="flex items-center text-red-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-semibold">Out of Stock</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-8">
                    <!-- Header -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-500"><?php echo e($product->brand); ?></span>
                            <?php if($product->is_verified): ?>
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    ✓ Verified Seller
                                </span>
                            <?php endif; ?>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2"><?php echo e($product->name); ?></h1>
                        <div class="flex items-center space-x-4">
                            <span class="bg-jade-green text-white px-3 py-1 rounded-full text-sm">
                                <?php echo e($product->classification); ?>

                            </span>
                            <span class="text-gray-600"><?php echo e($product->size_volume); ?></span>
                        </div>
                    </div>

                    <!-- Price and Rating -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-3xl font-bold text-gray-900">$<?php echo e(number_format($product->price, 2)); ?></span>
                            </div>
                            <?php if($product->review_count > 0): ?>
                                <div class="flex items-center">
                                    <div class="flex text-yellow-400">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($i <= floor($product->average_rating)): ?>
                                                <span class="text-yellow-400">★</span>
                                            <?php elseif($i - 0.5 <= $product->average_rating): ?>
                                                <span class="text-yellow-400">☆</span>
                                            <?php else: ?>
                                                <span class="text-gray-300">★</span>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="ml-2 text-gray-600"><?php echo e(number_format($product->average_rating, 1)); ?> (<?php echo e($product->review_count); ?> reviews)</span>
                                </div>
                            <?php else: ?>
                                <span class="text-gray-500">No reviews yet</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                        <p class="text-gray-600"><?php echo e($product->description); ?></p>
                    </div>

                    <!-- Skin Types -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Suitable for Skin Types</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php $__currentLoopData = $product->skin_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skinType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                    <?php echo e($skinType); ?>

                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Active Ingredients -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Active Ingredients</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php $__currentLoopData = $product->active_ingredients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingredient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="bg-jade-green text-white px-3 py-1 rounded-full text-sm">
                                    <?php echo e($ingredient); ?>

                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Seller Info -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">Sold by</h3>
                                <p class="text-gray-600"><?php echo e($product->seller->name); ?></p>
                            </div>
                            <?php if($product->isInStock()): ?>
                                <button class="px-6 py-3 bg-jade-green text-white rounded-lg hover:bg-opacity-90 transition font-semibold">
                                    Add to Cart
                                </button>
                            <?php else: ?>
                                <button disabled class="px-6 py-3 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed font-semibold">
                                    Out of Stock
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <?php if($product->reviews->count() > 0): ?>
            <div class="mt-12 bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Customer Reviews</h2>
                <div class="space-y-6">
                    <?php $__currentLoopData = $product->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border-b border-gray-200 pb-6 last:border-b-0">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-gray-600 font-medium"><?php echo e(strtoupper(substr($review->user->name, 0, 1))); ?></span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900"><?php echo e($review->user->name); ?></p>
                                        <div class="flex items-center">
                                            <div class="flex text-yellow-400 text-sm">
                                                <?php for($i = 1; $i <= 5; $i++): ?>
                                                    <?php if($i <= $review->rating): ?>
                                                        <span>★</span>
                                                    <?php else: ?>
                                                        <span class="text-gray-300">★</span>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                            <span class="ml-2 text-sm text-gray-500"><?php echo e($review->created_at->format('M d, Y')); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600"><?php echo e($review->comment); ?></p>
                            <?php if($review->skin_type): ?>
                                <p class="text-sm text-gray-500 mt-2">Skin Type: <?php echo e($review->skin_type); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Related Products -->
        <?php if($relatedProducts->count() > 0): ?>
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Products</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
                            <div class="relative">
                                <?php if($relatedProduct->photo): ?>
                                    <img src="<?php echo e(asset('storage/' . $relatedProduct->photo)); ?>" 
                                         alt="<?php echo e($relatedProduct->name); ?>" 
                                         class="w-full h-32 object-cover rounded-t-lg">
                                <?php else: ?>
                                    <div class="w-full h-32 bg-gray-200 rounded-t-lg flex items-center justify-center">
                                        <span class="text-gray-400 text-sm">No Image</span>
                                    </div>
                                <?php endif; ?>
                                <?php if($relatedProduct->is_verified): ?>
                                    <div class="absolute top-2 right-2 bg-red-500 text-white px-1 py-0.5 rounded-full text-xs">
                                        ✓
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 text-sm mb-1 line-clamp-2">
                                    <a href="<?php echo e(route('products.show', $relatedProduct)); ?>" class="hover:text-jade-green transition">
                                        <?php echo e($relatedProduct->name); ?>

                                    </a>
                                </h3>
                                <p class="text-lg font-bold text-gray-900">$<?php echo e(number_format($relatedProduct->price, 2)); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e($relatedProduct->brand); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sedriel Navasca\Desktop\COMPROG\GlowTrackCprog5\GlowTrack\resources\views/products/show.blade.php ENDPATH**/ ?>