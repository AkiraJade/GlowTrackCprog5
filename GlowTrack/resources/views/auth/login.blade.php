@extends('layouts.app')

@section('title', 'Login - GlowTrack')

@section('content')
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
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-soft-brown">
                        Email Address
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition @error('email') border-red-500 @enderror bg-mint-cream"
                        placeholder="your@email.com"
                    >
                    @error('email')
                        <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                    @enderror
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
                        class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition @error('password') border-red-500 @enderror bg-mint-cream"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                    @enderror
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
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-jade-green hover:text-soft-brown transition font-medium text-sm">
                            Forgot your password?
                        </a>
                    @endif
                </div>

                <div class="text-center">
                    <p class="text-soft-brown text-sm">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-jade-green hover:text-soft-brown transition font-semibold">
                            Create one now
                        </a>
                    </p>
                </div>
            </div>

            <!-- Decorative Elements -->
            <div class="mt-8 pt-8 border-t border-light-sage">
                <p class="text-center text-xs text-soft-brown opacity-60 mb-4">
                    Sign in with other methods
                </p>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" class="py-3 px-4 border-2 border-light-sage rounded-xl hover:bg-mint-cream transition font-semibold text-soft-brown">
                        Google
                    </button>
                    <button type="button" class="py-3 px-4 border-2 border-light-sage rounded-xl hover:bg-mint-cream transition font-semibold text-soft-brown">
                        Apple
                    </button>
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
@endsection
