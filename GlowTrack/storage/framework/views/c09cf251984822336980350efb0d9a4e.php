<?php $__env->startSection('title', 'Dashboard - GlowTrack'); ?>

<?php $__env->startSection('content'); ?>
<section class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-2">
                        Welcome back, <?php echo e(Auth::user()->username); ?>! ✨
                    </h1>
                    <p class="text-lg text-soft-brown opacity-75">
                        Your personalized skincare dashboard is ready
                    </p>
                </div>
                <div class="text-6xl">💫</div>
            </div>
        </div>

        <!-- Dashboard Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <!-- Orders Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-2xl font-bold text-soft-brown">My Orders</h3>
                    <span class="text-4xl">📦</span>
                </div>
                <p class="text-3xl font-bold text-jade-green mb-4">0</p>
                <a href="#" class="text-jade-green hover:text-soft-brown transition font-semibold">
                    View Orders →
                </a>
            </div>

            <!-- Favorites Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-2xl font-bold text-soft-brown">Favorites</h3>
                    <span class="text-4xl">❤️</span>
                </div>
                <p class="text-3xl font-bold text-jade-green mb-4">0</p>
                <a href="#" class="text-jade-green hover:text-soft-brown transition font-semibold">
                    View Favorites →
                </a>
            </div>

            <!-- Loyalty Points Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-2xl font-bold text-soft-brown">Loyalty Points</h3>
                    <span class="text-4xl">⭐</span>
                </div>
                <p class="text-3xl font-bold text-jade-green mb-4">250</p>
                <a href="#" class="text-jade-green hover:text-soft-brown transition font-semibold">
                    Redeem →
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-soft-brown mb-6">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <a href="#" class="p-4 rounded-xl bg-gradient-to-br from-mint-cream to-light-sage hover:shadow-lg transition text-center">
                    <p class="text-3xl mb-2">🛍️</p>
                    <p class="font-semibold text-soft-brown">Shop Now</p>
                </a>
                <a href="#" class="p-4 rounded-xl bg-gradient-to-br from-blush-pink to-warm-peach hover:shadow-lg transition text-center">
                    <p class="text-3xl mb-2">👤</p>
                    <p class="font-semibold text-soft-brown">My Profile</p>
                </a>
                <a href="#" class="p-4 rounded-xl bg-gradient-to-br from-pastel-green to-light-sage hover:shadow-lg transition text-center">
                    <p class="text-3xl mb-2">⚙️</p>
                    <p class="font-semibold text-soft-brown">Settings</p>
                </a>
                <a href="#" class="p-4 rounded-xl bg-gradient-to-br from-jade-green to-light-sage hover:shadow-lg transition text-center text-white">
                    <p class="text-3xl mb-2">💬</p>
                    <p class="font-semibold">Support</p>
                </a>
            </div>
        </div>

        <!-- Featured Products -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-soft-brown mb-6">Recommended For You</h2>
            <div class="text-center py-12">
                <p class="text-soft-brown opacity-75 text-lg">Your personalized product recommendations will appear here soon.</p>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sedriel Navasca\Desktop\COMPROG\GlowTrackCprog5\GlowTrack\resources\views/dashboard.blade.php ENDPATH**/ ?>