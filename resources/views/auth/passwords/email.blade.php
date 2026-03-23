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
                    <span class="text-5xl">🔐</span>
                </div>
                <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-2">Reset Password</h1>
                <p class="text-soft-brown opacity-75">Enter your email to receive a password reset link</p>
            </div>

            <!-- Success Message -->
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl">
                    <p class="font-medium">{{ session('status') }}</p>
                    @if (session('success'))
                        <p class="text-sm mt-1">{{ session('success') }}</p>
                    @endif
                </div>
            @endif

            <!-- Reset Password Form -->
            @if (!session('status'))
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full py-3 px-4 bg-gradient-to-r from-jade-green to-light-sage text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition transform duration-200"
                    >
                        Send Password Reset Link
                    </button>
                </form>
            @endif

            <!-- Back to Login -->
            <div class="mt-6 pt-6 border-t border-light-sage text-center">
                <p class="text-soft-brown text-sm">
                    Remember your password?
                    <a href="{{ route('login') }}" class="text-jade-green hover:text-soft-brown transition font-semibold">
                        Back to Login
                    </a>
                </p>
            </div>
        </div>

        <!-- Trust Badge -->
        <div class="mt-8 text-center">
            <p class="text-soft-brown opacity-60 text-sm flex items-center justify-center gap-2">
                <span>🔒</span>
                <span>Your password reset link is securely sent to your email</span>
            </p>
        </div>
    </div>
</section>
@endsection
