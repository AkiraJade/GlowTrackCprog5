<?php $__env->startSection('title', 'Register - GlowTrack'); ?>

<?php $__env->startSection('content'); ?>
<section class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-block mb-4">
                    <span class="text-5xl">💫</span>
                </div>
                <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-2">Join GlowTrack</h1>
                <p class="text-soft-brown opacity-75">Start your skincare journey today</p>
            </div>

            <!-- Register Form -->
            <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>

                <!-- Username Field -->
                <div class="space-y-2">
                    <label for="username" class="block text-sm font-semibold text-soft-brown">
                        Username
                    </label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="<?php echo e(old('username')); ?>"
                        required
                        autofocus
                        class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> bg-mint-cream"
                        placeholder="Choose your username"
                    >
                    <?php $__errorArgs = ['username'];
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

                <!-- Phone Number Field -->
                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-semibold text-soft-brown">
                        Phone Number
                    </label>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="<?php echo e(old('phone')); ?>"
                        required
                        class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> bg-mint-cream"
                        placeholder="Your phone number"
                    >
                    <?php $__errorArgs = ['phone'];
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

                <!-- Address Field -->
                <div class="space-y-2">
                    <label for="address" class="block text-sm font-semibold text-soft-brown">
                        Address
                    </label>
                    <input
                        type="text"
                        id="address"
                        name="address"
                        value="<?php echo e(old('address')); ?>"
                        required
                        class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> bg-mint-cream"
                        placeholder="Your address"
                    >
                    <?php $__errorArgs = ['address'];
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
                        autocomplete="new-password"
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
                    <p class="text-xs text-soft-brown opacity-60 mt-1">At least 8 characters with uppercase, lowercase, and numbers</p>
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

                <!-- Confirm Password Field -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-semibold text-soft-brown">
                        Confirm Password
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition bg-mint-cream"
                        placeholder="••••••••"
                    >
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start space-x-2">
                    <input
                        type="checkbox"
                        id="agree"
                        name="agree"
                        required
                        class="w-4 h-4 rounded accent-jade-green cursor-pointer mt-1"
                    >
                    <label for="agree" class="text-sm text-soft-brown cursor-pointer">
                        I agree to the
                        <a href="#" class="text-jade-green hover:underline font-semibold">Terms of Service</a>
                        and
                        <a href="#" class="text-jade-green hover:underline font-semibold">Privacy Policy</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full py-3 px-4 bg-gradient-to-r from-jade-green to-light-sage text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition transform duration-200 mt-6"
                >
                    Create Account
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 pt-6 border-t border-light-sage text-center">
                <p class="text-soft-brown text-sm">
                    Already have an account?
                    <a href="<?php echo e(route('login')); ?>" class="text-jade-green hover:text-soft-brown transition font-semibold">
                        Sign in here
                    </a>
                </p>
            </div>
        </div>

        <!-- Benefits -->
        <div class="mt-8 grid grid-cols-3 gap-3 text-center">
            <div class="text-sm">
                <p class="text-2xl mb-2">🎁</p>
                <p class="font-semibold text-soft-brown">Welcome Bonus</p>
            </div>
            <div class="text-sm">
                <p class="text-2xl mb-2">🚚</p>
                <p class="font-semibold text-soft-brown">Free Shipping</p>
            </div>
            <div class="text-sm">
                <p class="text-2xl mb-2">⭐</p>
                <p class="font-semibold text-soft-brown">Loyalty Points</p>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sedriel Navasca\Desktop\COMPROG\GlowTrackCprog5\GlowTrack\resources\views/auth/register.blade.php ENDPATH**/ ?>