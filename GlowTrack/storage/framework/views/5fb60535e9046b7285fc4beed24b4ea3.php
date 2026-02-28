<?php $__env->startSection('title', 'Login - GlowTrack'); ?>

<?php $__env->startSection('content'); ?>
<section class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-block mb-4">
                    <span class="text-5xl">✨</span>
                </div>
                <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-2">Welcome Back</h1>
                <p class="text-soft-brown opacity-75">Sign in to your GlowTrack account</p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>

                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-soft-brown">
                        Email Address
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?php echo e(old('email')); ?>"
                        required
                        autofocus
                        autocomplete="email"
                        class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> bg-mint-cream"
                        placeholder="your@email.com"
                    >
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm font-medium"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-soft-brown">
                        Password
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> bg-mint-cream"
                        placeholder="••••••••"
                    >
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm font-medium"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        class="w-4 h-4 rounded accent-jade-green cursor-pointer"
                    >
                    <label for="remember" class="ml-3 text-sm text-soft-brown cursor-pointer font-medium">
                        Remember me
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full py-3 px-4 bg-gradient-to-r from-jade-green to-light-sage text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition transform duration-200"
                >
                    Sign In
                </button>
            </form>

            <!-- Forgot Password & Register Links -->
            <div class="mt-6 pt-6 border-t border-light-sage space-y-4">
                <div class="text-center">
                    <?php if(Route::has('password.request')): ?>
                        <a href="<?php echo e(route('password.request')); ?>" class="text-jade-green hover:text-soft-brown transition font-medium text-sm">
                            Forgot your password?
                        </a>
                    <?php endif; ?>
                </div>

                <div class="text-center">
                    <p class="text-soft-brown text-sm">
                        Don't have an account?
                        <a href="<?php echo e(route('register')); ?>" class="text-jade-green hover:text-soft-brown transition font-semibold">
                            Create one now
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Trust Badge -->
        <div class="mt-8 text-center">
            <p class="text-soft-brown opacity-60 text-sm flex items-center justify-center gap-2">
                <span>🔒</span>
                <span>Your data is securely encrypted and protected</span>
            </p>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sedriel Navasca\Desktop\COMPROG\GlowTrackCprog5\GlowTrack\resources\views/auth/login.blade.php ENDPATH**/ ?>