@extends('layouts.app')

@section('title', 'GlowTrack - Premium Skincare E-Commerce')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="space-y-8">
                <div class="space-y-4">
                    <h1 class="text-5xl md:text-6xl font-bold text-soft-brown font-playfair leading-tight">
                        Glow Like Never Before
                    </h1>
                    <p class="text-xl text-soft-brown opacity-80">
                        Discover premium skincare products carefully curated for your unique skin journey. Elevate your beauty routine with GlowTrack.
                    </p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-jade-green text-white rounded-full font-semibold hover:shadow-lg hover:scale-105 transition transform text-center">
                        Get Started
                    </a>
                    <a href="#products" class="px-8 py-4 border-2 border-jade-green text-jade-green rounded-full font-semibold hover:bg-jade-green hover:text-white transition text-center">
                        Explore Products
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="flex flex-wrap gap-6 pt-6 border-t border-jade-green opacity-75">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl">✓</span>
                        <span class="text-sm font-medium">100% Natural</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl">✓</span>
                        <span class="text-sm font-medium">Cruelty Free</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl">✓</span>
                        <span class="text-sm font-medium">Dermatologist Tested</span>
                    </div>
                </div>
            </div>

            <!-- Right Image Placeholder -->
            <div class="relative">
                <div class="aspect-square rounded-3xl shadow-2xl overflow-hidden group relative z-10">
                    <img src="{{ asset('storage/landingPagePic/Skin-Center-of-South-Miami-Facials-and-Skin-Care.jpg') }}" alt="Premium Skincare" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                </div>
                <!-- Floating decorative elements -->
                <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-warm-peach rounded-2xl opacity-60"></div>
                <div class="absolute -top-4 -right-4 w-20 h-20 bg-blush-pink rounded-2xl opacity-60"></div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-soft-brown font-playfair mb-4">Why Choose GlowTrack?</h2>
            <p class="text-lg text-soft-brown opacity-75 max-w-2xl mx-auto">
                We combine science-backed ingredients with luxurious formulations for visible results
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="group p-8 rounded-2xl bg-gradient-to-br from-mint-cream to-light-sage hover:shadow-lg transition transform hover:scale-105">
                <div class="text-5xl mb-4">🌿</div>
                <h3 class="text-xl font-bold text-soft-brown mb-3">Natural Ingredients</h3>
                <p class="text-soft-brown opacity-75">
                    Sourced from the finest organic farms, our formulations are packed with nature's best ingredients.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="group p-8 rounded-2xl bg-gradient-to-br from-blush-pink to-warm-peach hover:shadow-lg transition transform hover:scale-105">
                <div class="text-5xl mb-4">💎</div>
                <h3 class="text-xl font-bold text-soft-brown mb-3">Luxury Quality</h3>
                <p class="text-soft-brown opacity-75">
                    Premium ingredients blended with cutting-edge skincare technology for exceptional results.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="group p-8 rounded-2xl bg-gradient-to-br from-pastel-green to-light-sage hover:shadow-lg transition transform hover:scale-105">
                <div class="text-5xl mb-4">🎯</div>
                <h3 class="text-xl font-bold text-soft-brown mb-3">Results Guaranteed</h3>
                <p class="text-soft-brown opacity-75">
                    30-day money-back guarantee if you're not completely satisfied with your results.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section id="products" class="py-20 bg-gradient-to-r from-mint-cream to-pastel-green">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-soft-brown font-playfair mb-4">Featured Collection</h2>
            <p class="text-lg text-soft-brown opacity-75">
                Discover our most loved skincare essentials
            </p>
        </div>

        <!-- Products will be added here -->
        <div class="text-center py-12">
            <p class="text-soft-brown opacity-75 text-lg">Coming soon! Browse our collection of premium skincare products.</p>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h2 class="text-4xl font-bold text-soft-brown font-playfair">About GlowTrack</h2>
                <p class="text-lg text-soft-brown opacity-75 leading-relaxed">
                    At GlowTrack, we believe that beautiful, radiant skin is a journey, not a destination. Founded by skincare enthusiasts and backed by dermatological research, we curate only the finest products that deliver visible, transformative results.
                </p>
                <p class="text-lg text-soft-brown opacity-75 leading-relaxed">
                    Every product in our collection is carefully tested, sustainably sourced, and formulated without harmful chemicals. We're committed to helping you discover your skin's true potential.
                </p>
                <div class="flex flex-wrap gap-4 pt-4">
                    <span class="px-4 py-2 bg-mint-cream text-jade-green rounded-full font-semibold">Est. 2024</span>
                    <span class="px-4 py-2 bg-light-sage text-soft-brown rounded-full font-semibold">5000+ Happy Customers</span>
                </div>
            </div>
            <div class="aspect-square bg-gradient-to-br from-light-sage to-pastel-green rounded-3xl shadow-2xl flex items-center justify-center">
                <p class="text-6xl">💫</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-jade-green to-light-sage text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
        <h2 class="text-4xl font-bold font-playfair">Ready to Glow?</h2>
        <p class="text-xl opacity-90">
            Join thousands of satisfied customers on their skincare journey. Sign up today and get exclusive welcome offers!
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-jade-green rounded-full font-semibold hover:shadow-lg transition">
                Create Account
            </a>
            <a href="{{ route('login') }}" class="px-8 py-4 border-2 border-white text-white rounded-full font-semibold hover:bg-white hover:text-jade-green transition">
                Sign In
            </a>
        </div>
    </div>
</section>

@endsection
