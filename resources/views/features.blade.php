@extends('layouts.app')

@section('title', 'Features - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage">
    <!-- Hero Section -->
    <section class="relative py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center">
            <div class="mb-8">
                <span class="text-6xl font-bold text-jade-green">✨</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-bold text-soft-brown font-playfair mb-6">
                GlowTrack Features
            </h1>
            <p class="text-xl text-soft-brown opacity-80 max-w-3xl mx-auto">
                Discover everything our skincare marketplace has to offer for customers, sellers, and beauty enthusiasts
            </p>
        </div>
    </section>

    <!-- Customer Features -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-soft-brown font-playfair mb-4">For Customers</h2>
                <p class="text-lg text-soft-brown opacity-75">Everything you need for your perfect skincare journey</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Product Discovery -->
                <div class="bg-gradient-to-br from-mint-cream to-pastel-green rounded-2xl p-8 shadow-lg hover:shadow-xl transition">
                    <div class="text-4xl mb-4">🔍</div>
                    <h3 class="text-2xl font-bold text-soft-brown mb-3">Smart Product Discovery</h3>
                    <p class="text-soft-brown opacity-80">
                        Browse curated skincare products with advanced filtering by skin type, concerns, and ingredients
                    </p>
                </div>

                <!-- Verified Reviews -->
                <div class="bg-gradient-to-br from-mint-cream to-pastel-green rounded-2xl p-8 shadow-lg hover:shadow-xl transition">
                    <div class="text-4xl mb-4">⭐</div>
                    <h3 class="text-2xl font-bold text-soft-brown mb-3">Verified Customer Reviews</h3>
                    <p class="text-soft-brown opacity-80">
                        Read authentic reviews from verified buyers with before/after photos and detailed skin type information
                    </p>
                </div>

                <!-- Shopping Cart -->
                <div class="bg-gradient-to-br from-mint-cream to-pastel-green rounded-2xl p-8 shadow-lg hover:shadow-xl transition">
                    <div class="text-4xl mb-4">🛒</div>
                    <h3 class="text-2xl font-bold text-soft-brown mb-3">Seamless Shopping Cart</h3>
                    <p class="text-soft-brown opacity-80">
                        Add products to cart, manage quantities, and proceed to secure checkout with real-time stock tracking
                    </p>
                </div>

                <!-- Order Tracking -->
                <div class="bg-gradient-to-br from-mint-cream to-pastel-green rounded-2xl p-8 shadow-lg hover:shadow-xl transition">
                    <div class="text-4xl mb-4">📦</div>
                    <h3 class="text-2xl font-bold text-soft-brown mb-3">Order Management</h3>
                    <p class="text-soft-brown opacity-80">
                        Track your orders, view purchase history, and manage cancellations with real-time status updates
                    </p>
                </div>

                <!-- Loyalty Program -->
                <div class="bg-gradient-to-br from-mint-cream to-pastel-green rounded-2xl p-8 shadow-lg hover:shadow-xl transition">
                    <div class="text-4xl mb-4">🎁</div>
                    <h3 class="text-2xl font-bold text-soft-brown mb-3">Loyalty Rewards</h3>
                    <p class="text-soft-brown opacity-80">
                        Earn points with every purchase and redeem them for discounts on future orders
                    </p>
                </div>

                <!-- Support Forum -->
                <div class="bg-gradient-to-br from-mint-cream to-pastel-green rounded-2xl p-8 shadow-lg hover:shadow-xl transition">
                    <div class="text-4xl mb-4">💬</div>
                    <h3 class="text-2xl font-bold text-soft-brown mb-3">Community Support</h3>
                    <p class="text-soft-brown opacity-80">
                        Connect with other skincare enthusiasts, share tips, and get advice in our community forum
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Seller Features -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-soft-brown font-playfair mb-4">For Sellers</h2>
                <p class="text-lg text-soft-brown opacity-75">Powerful tools to grow your skincare business</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Seller Dashboard -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition">
                    <div class="text-4xl mb-4">📊</div>
                    <h3 class="text-2xl font-bold text-soft-brown mb-3">Seller Dashboard</h3>
                    <p class="text-soft-brown opacity-80">
                        Track sales, inventory, and customer insights with comprehensive analytics
                    </p>
                </div>

                <!-- Product Management -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition">
                    <div class="text-4xl mb-4">📦</div>
                    <h3 class="text-2xl font-bold text-soft-brown mb-3">Product Management</h3>
                    <p class="text-soft-brown opacity-80">
                        Easily add, edit, and manage your product catalog with images and detailed descriptions
                    </p>
                </div>

                <!-- Inventory Tracking -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition">
                    <div class="text-4xl mb-4">📈</div>
                    <h3 class="text-2xl font-bold text-soft-brown mb-3">Real-time Inventory</h3>
                    <p class="text-soft-brown opacity-80">
                        Automatic stock management with real-time updates as customers place orders
                    </p>
                </div>

                <!-- Order Processing -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition">
                    <div class="text-4xl mb-4">🚚</div>
                    <h3 class="text-2xl font-bold text-soft-brown mb-3">Order Management</h3>
                    <p class="text-soft-brown opacity-80">
                        Process orders, update shipping status, and handle customer communications efficiently
                    </p>
                </div>

                <!-- Customer Insights -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition">
                    <div class="text-4xl mb-4">👥</div>
                    <h3 class="text-2xl font-bold text-soft-brown mb-3">Customer Analytics</h3>
                    <p class="text-soft-brown opacity-80">
                        Understand your customers better with detailed purchase patterns and feedback analysis
                    </p>
                </div>

                <!-- Seller Application -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition">
                    <div class="text-4xl mb-4">📝</div>
                    <h3 class="text-2xl font-bold text-soft-brown mb-3">Easy Onboarding</h3>
                    <p class="text-soft-brown opacity-80">
                        Simple application process to become a verified seller on our platform
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Platform Features -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-soft-brown font-playfair mb-4">Platform Features</h2>
                <p class="text-lg text-soft-brown opacity-75">Advanced functionality for everyone</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Admin Panel -->
                <div class="flex items-start space-x-6">
                    <div class="text-5xl">👨‍💼</div>
                    <div>
                        <h3 class="text-2xl font-bold text-soft-brown mb-3">Admin Management</h3>
                        <p class="text-soft-brown opacity-80 mb-4">
                            Comprehensive admin panel for managing users, products, orders, and platform settings
                        </p>
                        <ul class="text-soft-brown opacity-80 space-y-2">
                            <li>• User role management</li>
                            <li>• Product approval system</li>
                            <li>• Order monitoring</li>
                            <li>• Sales reporting</li>
                        </ul>
                    </div>
                </div>

                <!-- Security -->
                <div class="flex items-start space-x-6">
                    <div class="text-5xl">🔒</div>
                    <div>
                        <h3 class="text-2xl font-bold text-soft-brown mb-3">Secure Platform</h3>
                        <p class="text-soft-brown opacity-80 mb-4">
                            Enterprise-grade security to protect user data and transactions
                        </p>
                        <ul class="text-soft-brown opacity-80 space-y-2">
                            <li>• Secure authentication</li>
                            <li>• Data encryption</li>
                            <li>• Payment protection</li>
                            <li>• Privacy controls</li>
                        </ul>
                    </div>
                </div>

                <!-- Mobile Responsive -->
                <div class="flex items-start space-x-6">
                    <div class="text-5xl">📱</div>
                    <div>
                        <h3 class="text-2xl font-bold text-soft-brown mb-3">Mobile Optimized</h3>
                        <p class="text-soft-brown opacity-80 mb-4">
                            Fully responsive design that works perfectly on all devices
                        </p>
                        <ul class="text-soft-brown opacity-80 space-y-2">
                            <li>• Mobile-first design</li>
                            <li>• Touch-friendly interface</li>
                            <li>• Fast loading times</li>
                            <li>• Consistent experience</li>
                        </ul>
                    </div>
                </div>

                <!-- Support System -->
                <div class="flex items-start space-x-6">
                    <div class="text-5xl">🎧</div>
                    <div>
                        <h3 class="text-2xl font-bold text-soft-brown mb-3">24/7 Support</h3>
                        <p class="text-soft-brown opacity-80 mb-4">
                            Comprehensive support system for all users
                        </p>
                        <ul class="text-soft-brown opacity-80 space-y-2">
                            <li>• Help center</li>
                            <li>• Community forum</li>
                            <li>• Direct messaging</li>
                            <li>• FAQ resources</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-jade-green to-emerald-600">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-white font-playfair mb-6">
                Ready to Start Your Skincare Journey?
            </h2>
            <p class="text-xl text-white opacity-90 mb-8">
                Join thousands of satisfied customers and trusted sellers on GlowTrack
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products.index') }}" 
                   class="px-8 py-4 bg-white text-jade-green rounded-full hover:bg-gray-100 transition font-semibold text-lg">
                    Browse Products
                </a>
                <a href="{{ route('register') }}" 
                   class="px-8 py-4 bg-transparent text-white border-2 border-white rounded-full hover:bg-white hover:text-jade-green transition font-semibold text-lg">
                    Sign Up Free
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
