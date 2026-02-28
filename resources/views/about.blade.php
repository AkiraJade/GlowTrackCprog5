@extends('layouts.app')

@section('title', 'About GlowTrack - Premium Skincare Platform')

@section('content')
<!-- About Hero Section -->
<section class="py-20 bg-gradient-to-br from-mint-cream to-pastel-green">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-soft-brown font-playfair mb-6">About GlowTrack</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Your comprehensive skincare management and e-commerce platform, designed to revolutionize how you discover, purchase, and manage your skincare journey.
            </p>
        </div>
    </div>
</section>

<!-- Platform Overview -->
<section id="about" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-4xl font-bold text-soft-brown font-playfair mb-6">Revolutionizing Skincare Management</h2>
                <p class="text-gray-600 mb-6">
                    GlowTrack is a sophisticated skincare e-commerce platform developed by Navasca, Sedriel H. and Orlanda, Ardee Jade B. from BSIT-S-2A. Our platform combines cutting-edge technology with skincare expertise to deliver a seamless experience for skincare enthusiasts, sellers, and administrators.
                </p>
                <p class="text-gray-600 mb-6">
                    Built with Laravel and modern web technologies, GlowTrack offers a comprehensive ecosystem where users can discover personalized skincare products, track their skin progress, build customized routines, and connect with verified sellers.
                </p>
                <div class="flex space-x-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-jade-green">8+</div>
                        <div class="text-sm text-gray-600">Core Features</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-jade-green">139</div>
                        <div class="text-sm text-gray-600">Functional Requirements</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-jade-green">100%</div>
                        <div class="text-sm text-gray-600">Skincare Focused</div>
                    </div>
                </div>
            </div>
            <div class="bg-pastel-green rounded-2xl p-8">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white rounded-lg p-4 text-center">
                        <div class="text-2xl mb-2">🧴</div>
                        <div class="text-sm font-medium">Product Management</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 text-center">
                        <div class="text-2xl mb-2">📦</div>
                        <div class="text-sm font-medium">Order Tracking</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 text-center">
                        <div class="text-2xl mb-2">📊</div>
                        <div class="text-sm font-medium">Progress Tracking</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 text-center">
                        <div class="text-2xl mb-2">✨</div>
                        <div class="text-sm font-medium">Routine Builder</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Features -->
<section class="py-16 bg-mint-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-soft-brown font-playfair mb-4">Core Platform Features</h2>
            <p class="text-xl text-gray-600">Comprehensive skincare management at your fingertips</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Product Management -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition">
                <div class="text-3xl mb-4">🛍️</div>
                <h3 class="text-xl font-bold text-soft-brown mb-3">Product Management</h3>
                <ul class="text-gray-600 space-y-2 text-sm">
                    <li>• Complete product information display</li>
                    <li>• Advanced filtering and search</li>
                    <li>• Seller product management</li>
                    <li>• Admin approval system</li>
                    <li>• Customer reviews and ratings</li>
                    <li>• Verified seller badges</li>
                </ul>
            </div>

            <!-- Sales & Order Management -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition">
                <div class="text-3xl mb-4">💳</div>
                <h3 class="text-xl font-bold text-soft-brown mb-3">Sales & Order Management</h3>
                <ul class="text-gray-600 space-y-2 text-sm">
                    <li>• Persistent shopping cart</li>
                    <li>• Multiple payment options</li>
                    <li>• Unique order tracking</li>
                    <li>• Seller order fulfillment</li>
                    <li>• Admin oversight</li>
                    <li>• Real-time notifications</li>
                </ul>
            </div>

            <!-- Inventory Management -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition">
                <div class="text-3xl mb-4">📋</div>
                <h3 class="text-xl font-bold text-soft-brown mb-3">Inventory Management</h3>
                <ul class="text-gray-600 space-y-2 text-sm">
                    <li>• Real-time stock monitoring</li>
                    <li>• Automatic quantity updates</li>
                    <li>• Stock status indicators</li>
                    <li>• Low-stock alerts</li>
                    <li>• Manual adjustment logging</li>
                    <li>• Complete audit trails</li>
                </ul>
            </div>

            <!-- Skincare Routine Builder -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition">
                <div class="text-3xl mb-4">🌅</div>
                <h3 class="text-xl font-bold text-soft-brown mb-3">Skincare Routine Builder</h3>
                <ul class="text-gray-600 space-y-2 text-sm">
                    <li>• Personalized AM/PM routines</li>
                    <li>• Custom product assignments</li>
                    <li>• Ingredient conflict warnings</li>
                    <li>• Daily completion tracking</li>
                    <li>• Calendar adherence views</li>
                    <li>• Public/private routine options</li>
                </ul>
            </div>

            <!-- Skin Profile & Progress -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition">
                <div class="text-3xl mb-4">📈</div>
                <h3 class="text-xl font-bold text-soft-brown mb-3">Skin Profile & Progress</h3>
                <ul class="text-gray-600 space-y-2 text-sm">
                    <li>• Comprehensive skin profiles</li>
                    <li>• Daily skin journal entries</li>
                    <li>• Progress photo tracking</li>
                    <li>• Timeline visualization</li>
                    <li>• Personalized product suggestions</li>
                    <li>• Admin-managed classifications</li>
                </ul>
            </div>

            <!-- Delivery Management -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition">
                <div class="text-3xl mb-4">🚚</div>
                <h3 class="text-xl font-bold text-soft-brown mb-3">Delivery Management</h3>
                <ul class="text-gray-600 space-y-2 text-sm">
                    <li>• Delivery personnel assignment</li>
                    <li>• Dedicated delivery lists</li>
                    <li>• Status progression tracking</li>
                    <li>• Live delivery monitoring</li>
                    <li>• Staff reassignment</li>
                    <li>• Failed delivery handling</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Advanced Features -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-soft-brown font-playfair mb-4">Advanced Platform Capabilities</h2>
            <p class="text-xl text-gray-600">Enterprise-grade features for complete skincare ecosystem management</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Customer & Account Management -->
            <div class="bg-gradient-to-br from-jade-green to-light-sage rounded-xl p-8 text-white">
                <div class="text-4xl mb-4">👥</div>
                <h3 class="text-2xl font-bold mb-4">Customer & Account Management</h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <span class="mr-2">✓</span>
                        <span>Seamless user registration with buyer default roles</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">✓</span>
                        <span>Seller verification and brand credential review</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">✓</span>
                        <span>Complete transaction history and order tracking</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">✓</span>
                        <span>Comprehensive profile management capabilities</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">✓</span>
                        <span>Admin account management with soft-delete</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">✓</span>
                        <span>Public brand pages with aggregated ratings</span>
                    </li>
                </ul>
            </div>

            <!-- Reporting & Auditing -->
            <div class="bg-gradient-to-br from-blush-pink to-warm-peach rounded-xl p-8 text-white">
                <div class="text-4xl mb-4">📊</div>
                <h3 class="text-2xl font-bold mb-4">Reporting & Auditing</h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <span class="mr-2">✓</span>
                        <span>Comprehensive sales reports with filtering options</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">✓</span>
                        <span>Real-time inventory reports with stock alerts</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">✓</span>
                        <span>Customer skin trend analytics and insights</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">✓</span>
                        <span>Seller performance metrics and evaluations</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">✓</span>
                        <span>PDF and CSV export capabilities</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">✓</span>
                        <span>Complete admin action audit logging</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Technical Specifications -->
<section class="py-16 bg-mint-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-soft-brown font-playfair mb-4">Technical Excellence</h2>
            <p class="text-xl text-gray-600">Built with modern technologies for optimal performance</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="text-4xl mb-4">⚡</div>
                <h3 class="text-xl font-bold text-soft-brown mb-2">Laravel Framework</h3>
                <p class="text-gray-600">Robust PHP backend with elegant MVC architecture</p>
            </div>
            <div class="text-center">
                <div class="text-4xl mb-4">🎨</div>
                <h3 class="text-xl font-bold text-soft-brown mb-2">Tailwind CSS</h3>
                <p class="text-gray-600">Modern, responsive design with custom color palette</p>
            </div>
            <div class="text-center">
                <div class="text-4xl mb-4">🗄️</div>
                <h3 class="text-xl font-bold text-soft-brown mb-2">MySQL/MariaDB</h3>
                <p class="text-gray-600">Reliable database with optimized schema design</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-gradient-to-r from-jade-green to-light-sage">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold text-white font-playfair mb-6">Join the GlowTrack Revolution</h2>
        <p class="text-xl text-white mb-8">
            Experience the future of skincare management with our comprehensive platform. Whether you're a skincare enthusiast, a brand owner, or a delivery partner, GlowTrack has everything you need.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-jade-green rounded-full font-bold hover:bg-gray-100 transition">
                Get Started Today
            </a>
            <a href="{{ route('products.index') }}" class="px-8 py-3 bg-transparent border-2 border-white text-white rounded-full font-bold hover:bg-white hover:text-jade-green transition">
                Browse Products
            </a>
        </div>
    </div>
</section>

<!-- Project Info -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-soft-brown font-playfair mb-6">Project Information</h2>
        <div class="bg-mint-cream rounded-xl p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left">
                <div>
                    <h3 class="font-bold text-soft-brown mb-2">Developers</h3>
                    <p class="text-gray-600">Navasca, Sedriel H.<br>Orlanda, Ardee Jade B.</p>
                </div>
                <div>
                    <h3 class="font-bold text-soft-brown mb-2">Course & Section</h3>
                    <p class="text-gray-600">BSIT-S-2A</p>
                </div>
                <div>
                    <h3 class="font-bold text-soft-brown mb-2">Total Requirements</h3>
                    <p class="text-gray-600">139 Functional Requirements<br>8 Major Feature Categories</p>
                </div>
                <div>
                    <h3 class="font-bold text-soft-brown mb-2">Platform Focus</h3>
                    <p class="text-gray-600">Skincare Management<br>E-Commerce Solution<br>Progress Tracking</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
