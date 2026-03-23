@extends('layouts.app')

@section('title', 'Reset Password - GlowTrack')

@section('content')
<section class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-block mb-4">
                    <span class="text-5xl">🔑</span>
                </div>
                <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-2">Set New Password</h1>
                <p class="text-soft-brown opacity-75">Choose a strong password for your account</p>
            </div>

            <!-- Reset Password Form -->
            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- Email Display -->
                <div class="bg-gray-50 p-3 rounded-xl">
                    <p class="text-sm text-gray-600">Resetting password for:</p>
                    <p class="font-semibold text-gray-900">{{ $email }}</p>
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-soft-brown">
                        New Password
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition @error('password') border-red-500 @enderror bg-mint-cream"
                        placeholder="Enter your new password"
                        minlength="8"
                    >
                    @error('password')
                        <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Password must be at least 8 characters long</p>
                </div>

                <!-- Confirm Password Field -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-semibold text-soft-brown">
                        Confirm New Password
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition @error('password_confirmation') border-red-500 @enderror bg-mint-cream"
                        placeholder="Confirm your new password"
                        minlength="8"
                    >
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full py-3 px-4 bg-gradient-to-r from-jade-green to-light-sage text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition transform duration-200"
                >
                    Reset Password
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 pt-6 border-t border-light-sage text-center">
                <p class="text-soft-brown text-sm">
                    <a href="{{ route('login') }}" class="text-jade-green hover:text-soft-brown transition font-semibold">
                        ← Back to Login
                    </a>
                </p>
            </div>
        </div>

        <!-- Trust Badge -->
        <div class="mt-8 text-center">
            <p class="text-soft-brown opacity-60 text-sm flex items-center justify-center gap-2">
                <span>🔒</span>
                <span>Your new password will be securely encrypted</span>
            </p>
        </div>
    </div>
</section>
@endsection
