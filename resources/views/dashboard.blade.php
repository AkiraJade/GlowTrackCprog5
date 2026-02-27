@extends('layouts.app')

@section('title', 'My Dashboard - GlowTrack')

@section('content')
<!-- Dashboard Container -->
<section class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Welcome Section -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
                <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-bold text-soft-brown font-playfair mb-3">
                            Welcome back, {{ Auth::user()->username }}! ✨
                        </h1>
                        <p class="text-lg text-soft-brown opacity-75 mb-4">
                            Your personalized skincare dashboard
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('products.index') }}" class="px-6 py-2 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                                Continue Shopping
                            </a>
                            <a href="#" class="px-6 py-2 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                                Help Center
                            </a>
                        </div>
                    </div>
                    <div class="text-8xl opacity-50">✨</div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Orders -->
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-soft-brown">Total Orders</h3>
                    <span class="text-4xl">📦</span>
                </div>
                <p class="text-4xl font-bold text-jade-green mb-2">{{ $orders_count ?? 0 }}</p>
                <p class="text-sm text-soft-brown opacity-75">View order history</p>
            </div>

            <!-- Total Spent -->
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-soft-brown">Amount Spent</h3>
                    <span class="text-4xl">💰</span>
                </div>
                <p class="text-4xl font-bold text-jade-green mb-2">${{ number_format($total_spent ?? 0, 2) }}</p>
                <p class="text-sm text-soft-brown opacity-75">Lifetime value</p>
            </div>

            <!-- Loyalty Points -->
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-soft-brown">Loyalty Points</h3>
                    <span class="text-4xl">⭐</span>
                </div>
                <p class="text-4xl font-bold text-jade-green mb-2">{{ $loyalty_points ?? 0 }}</p>
                <p class="text-sm text-soft-brown opacity-75">Redeem rewards</p>
            </div>

            <!-- Wishlist Items -->
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-soft-brown">Wishlist Items</h3>
                    <span class="text-4xl">❤️</span>
                </div>
                <p class="text-4xl font-bold text-jade-green mb-2">{{ $wishlist_count ?? 0 }}</p>
                <p class="text-sm text-soft-brown opacity-75">Your favorites</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Recent Orders Section -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-soft-brown font-playfair">Recent Orders</h2>
                        <a href="{{ route('orders.index') }}" class="text-jade-green hover:text-soft-brown transition font-semibold text-sm">View All</a>
                    </div>
                    
                    @if(isset($recent_orders) && $recent_orders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recent_orders as $order)
                                <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-semibold text-soft-brown">#{{ $order->order_id }}</span>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                               ($order->status === 'confirmed' ? 'bg-blue-100 text-blue-800' :
                                               ($order->status === 'processing' ? 'bg-purple-100 text-purple-800' :
                                               ($order->status === 'shipped' ? 'bg-indigo-100 text-indigo-800' :
                                               ($order->status === 'delivered' ? 'bg-green-100 text-green-800' :
                                               ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' :
                                               'bg-gray-100 text-gray-800'))))) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-soft-brown opacity-75">{{ $order->created_at->format('M d, Y') }}</span>
                                        <span class="font-bold text-jade-green">${{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('orders.show', $order) }}" class="text-jade-green hover:text-soft-brown transition font-semibold text-sm">
                                            View Details →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4 opacity-50">📭</div>
                            <p class="text-soft-brown opacity-75 text-lg">No orders yet</p>
                            <p class="text-soft-brown opacity-60 text-sm mb-6">Start your skincare journey today!</p>
                            <a href="{{ route('products.index') }}" class="inline-block px-6 py-2 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                                Shop Now
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Wishlist Section -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-soft-brown font-playfair">My Wishlist</h2>
                        <a href="#" class="text-jade-green hover:text-soft-brown transition font-semibold text-sm">View All</a>
                    </div>
                    
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4 opacity-50">💕</div>
                        <p class="text-soft-brown opacity-75 text-lg">No items in wishlist</p>
                        <p class="text-soft-brown opacity-60 text-sm mb-6">Save your favorite products for later</p>
                        <a href="{{ route('products.index') }}" class="inline-block px-6 py-2 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                            Explore Products
                        </a>
                    </div>
                </div>

            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-8">
                
                <!-- Quick Account Actions -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-xl font-bold text-soft-brown font-playfair mb-6">Account</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('profile.show') }}" class="flex items-center gap-3 p-3 rounded-xl bg-gradient-to-r from-mint-cream to-light-sage hover:shadow-lg transition">
                            <span class="text-2xl">👤</span>
                            <div>
                                <p class="font-semibold text-soft-brown">Profile</p>
                                <p class="text-xs text-soft-brown opacity-60">Edit your information</p>
                            </div>
                        </a>

                        <a href="{{ route('profile.show') }}#password" class="flex items-center gap-3 p-3 rounded-xl bg-gradient-to-r from-blush-pink to-warm-peach hover:shadow-lg transition">
                            <span class="text-2xl">🔐</span>
                            <div>
                                <p class="font-semibold text-soft-brown">Password</p>
                                <p class="text-xs text-soft-brown opacity-60">Change password</p>
                            </div>
                        </a>

                        <a href="{{ route('profile.show') }}#addresses" class="flex items-center gap-3 p-3 rounded-xl bg-gradient-to-r from-pastel-green to-light-sage hover:shadow-lg transition">
                            <span class="text-2xl">📍</span>
                            <div>
                                <p class="font-semibold text-soft-brown">Addresses</p>
                                <p class="text-xs text-soft-brown opacity-60">Manage addresses</p>
                            </div>
                        </a>

                        <a href="{{ route('profile.show') }}#settings" class="flex items-center gap-3 p-3 rounded-xl bg-gradient-to-r from-jade-green to-light-sage hover:shadow-lg transition text-white">
                            <span class="text-2xl">⚙️</span>
                            <div>
                                <p class="font-semibold">Settings</p>
                                <p class="text-xs opacity-80">Preferences & privacy</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Loyalty & Rewards -->
                <div class="bg-gradient-to-br from-jade-green to-light-sage rounded-2xl shadow-lg p-8 text-white">
                    <h3 class="text-xl font-bold font-playfair mb-4">Loyalty Program</h3>
                    <p class="opacity-90 mb-6 text-sm">Earn points on every purchase and redeem exclusive rewards!</p>
                    
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold">Your Points</span>
                            <span class="text-2xl font-bold">{{ $loyalty_points ?? 0 }}</span>
                        </div>
                        <div class="w-full bg-white bg-opacity-30 rounded-full h-2">
                            <div class="bg-white rounded-full h-2" style="width: {{ min(($loyalty_points ?? 0) / 10, 100) }}%"></div>
                        </div>
                    </div>

                    <button class="w-full py-2 bg-white text-jade-green rounded-full font-semibold hover:bg-opacity-90 transition">
                        Learn More
                    </button>
                </div>

                <!-- Recently Viewed -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-xl font-bold text-soft-brown font-playfair mb-6">Recently Viewed</h3>
                    
                    <div class="text-center py-8">
                        <p class="text-soft-brown opacity-75">No items viewed yet</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- Help & Support Section -->
        <div class="mt-8 bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6">Need Help?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="#" class="p-6 rounded-xl border-2 border-light-sage hover:border-jade-green hover:shadow-lg transition">
                    <p class="text-3xl mb-3">📧</p>
                    <h3 class="font-bold text-soft-brown mb-2">Contact Support</h3>
                    <p class="text-sm text-soft-brown opacity-75">Response within 24 hours</p>
                </a>

                <a href="#" class="p-6 rounded-xl border-2 border-light-sage hover:border-jade-green hover:shadow-lg transition">
                    <p class="text-3xl mb-3">📚</p>
                    <h3 class="font-bold text-soft-brown mb-2">Knowledge Base</h3>
                    <p class="text-sm text-soft-brown opacity-75">FAQs and guides</p>
                </a>

                <a href="#" class="p-6 rounded-xl border-2 border-light-sage hover:border-jade-green hover:shadow-lg transition">
                    <p class="text-3xl mb-3">💬</p>
                    <h3 class="font-bold text-soft-brown mb-2">Forum</h3>
                    <p class="text-sm text-soft-brown opacity-75">Join community discussions</p>
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
