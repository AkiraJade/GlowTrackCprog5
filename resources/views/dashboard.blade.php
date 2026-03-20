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
                    <div class="flex items-center gap-6">
                        <div class="flex-shrink-0">
                            <img src="{{ Auth::user()->photo_url }}" 
                                 alt="{{ Auth::user()->name }}" 
                                 class="w-20 h-20 rounded-full object-cover border-4 border-jade-green shadow-lg">
                        </div>
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
                                <a href="#help" class="px-6 py-2 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                                    Help Center
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="px-6 py-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition font-semibold">
                                        🛡️ Admin Panel
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="text-8xl opacity-50">✨</div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Orders -->
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition cursor-pointer" onclick="window.location.href='{{ route('orders.index') }}'">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-soft-brown">Total Orders</h3>
                    <span class="text-4xl">📦</span>
                </div>
                <p class="text-4xl font-bold text-jade-green mb-2">{{ $orders_count ?? 0 }}</p>
                <p class="text-sm text-soft-brown opacity-75">View order history</p>
            </div>

            <!-- Total Spent -->
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition cursor-pointer" onclick="window.location.href='{{ route('orders.index') }}'">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-soft-brown">Amount Spent</h3>
                    <span class="text-4xl">💰</span>
                </div>
                <p class="text-4xl font-bold text-jade-green mb-2">₱{{ number_format($total_spent ?? 0, 2) }}</p>
                <p class="text-sm text-soft-brown opacity-75">Lifetime value</p>
            </div>

            <!-- Loyalty Points -->
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition cursor-pointer" onclick="window.location.href='{{ route('loyalty.points') }}'">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-soft-brown">Loyalty Points</h3>
                    <span class="text-4xl">⭐</span>
                </div>
                <p class="text-4xl font-bold text-jade-green mb-2">{{ $loyalty_points ?? 0 }}</p>
                <p class="text-sm text-soft-brown opacity-75">Redeem rewards</p>
            </div>

            <!-- Wishlist Items -->
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition cursor-pointer" onclick="window.location.href='{{ route('profile.show') }}#wishlist'">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-soft-brown">Wishlist Items</h3>
                    <span class="text-4xl">❤️</span>
                </div>
                <p class="text-4xl font-bold text-jade-green mb-2">{{ $wishlist_count ?? 0 }}</p>
                <p class="text-sm text-soft-brown opacity-75">Your favorites</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">
            
            <!-- Left Column -->
            <div class="lg:col-span-2 flex flex-col gap-8">
                
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
                                        <span class="font-bold text-jade-green">₱{{ number_format($order->total_amount, 2) }}</span>
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
                <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-soft-brown font-playfair">My Wishlist</h2>
                        <a href="{{ route('wishlist.index') }}" class="text-jade-green hover:text-soft-brown transition font-semibold text-sm">View All</a>
                    </div>
                    
                    @if($wishlist_items->count() > 0)
                        <div class="flex-grow">
                            <div class="grid grid-cols-2 gap-4">
                                @foreach($wishlist_items as $wishlistItem)
                                    @if($wishlistItem->product)
                                        <div class="group cursor-pointer" onclick="window.location.href='{{ route('products.show', $wishlistItem->product) }}'">
                                            <div class="relative overflow-hidden rounded-lg mb-3">
                                                @if($wishlistItem->product->photo)
                                                    <img src="{{ asset('storage/' . $wishlistItem->product->photo) }}" 
                                                         alt="{{ $wishlistItem->product->name }}" 
                                                         class="w-full h-32 object-cover object-center group-hover:scale-105 transition-transform duration-300">
                                                @else
                                                    <div class="w-full h-32 bg-gray-200 flex items-center justify-center">
                                                        <span class="text-gray-400 text-sm">No img</span>
                                                    </div>
                                                @endif
                                                
                                                <!-- Remove from wishlist button -->
                                                <form method="POST" action="{{ route('wishlist.remove') }}" 
                                                      class="absolute top-2 right-2"
                                                      onclick="event.stopPropagation()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="product_id" value="{{ $wishlistItem->product_id }}">
                                                    <button type="submit" 
                                                            class="w-8 h-8 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-red-50 transition">
                                                        <span class="text-red-500 hover:text-red-700">✕</span>
                                                    </button>
                                                </form>
                                            </div>
                                            
                                            <div>
                                                <h4 class="font-semibold text-soft-brown text-sm mb-1 line-clamp-2 group-hover:text-jade-green transition">
                                                    {{ $wishlistItem->product->name }}
                                                </h4>
                                                <p class="text-xs text-gray-500 mb-2">{{ $wishlistItem->product->brand }}</p>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-jade-green font-bold">₱{{ number_format($wishlistItem->product->price, 2) }}</span>
                                                    @if($wishlistItem->product->isInStock())
                                                        <form method="POST" action="{{ route('cart.add', $wishlistItem->product->id) }}" 
                                                              onclick="event.stopPropagation()">
                                                            @csrf
                                                            <input type="hidden" name="quantity" value="1">
                                                            <button type="submit" class="text-xs bg-jade-green text-white px-2 py-1 rounded hover:bg-opacity-90 transition">
                                                                Add to Cart
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-xs text-red-500">Out of Stock</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="flex-grow flex items-center justify-center">
                            <div class="text-center">
                                <div class="text-6xl mb-4 opacity-50">💕</div>
                                <p class="text-soft-brown opacity-75 text-lg">No items in wishlist</p>
                                <p class="text-soft-brown opacity-60 text-sm mb-6">Save your favorite products for later</p>
                                <a href="{{ route('products.index') }}" class="inline-block px-6 py-2 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                                    Explore Products
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Right Column - Sidebar -->
            {{-- This column's natural height is what the left column's Wishlist card aligns to --}}
            <div class="flex flex-col gap-8">
                
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

                    <button onclick="window.location.href='{{ route('profile.show') }}#loyalty'" class="w-full py-2 bg-white text-jade-green rounded-full font-semibold hover:bg-opacity-90 transition cursor-pointer">
                        Learn More
                    </button>
                </div>

                <!-- Recently Viewed -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-xl font-bold text-soft-brown font-playfair mb-6">Recently Viewed</h3>
                    
                    <div class="text-center py-8">
                        <p class="text-soft-brown opacity-75">No items viewed yet</p>
                        <a href="{{ route('products.index') }}" class="text-jade-green hover:text-soft-brown transition font-semibold text-sm mt-2 inline-block">
                            Browse Products
                        </a>
                    </div>
                </div>

            </div>

        </div>

        <!-- Add whitespace between main content and help section -->
        <div class="h-12"></div>

        <!-- Need Help? Section -->
        <div id="help" class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6">Need help?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('support.contact') }}" class="p-6 rounded-xl border-2 border-light-sage hover:border-jade-green hover:shadow-lg transition">
                    <p class="text-3xl mb-3">💬</p>
                    <h3 class="font-bold text-soft-brown mb-2">Contact Support</h3>
                    <p class="text-sm text-soft-brown opacity-75">Get help from our team</p>
                </a>

                <a href="{{ route('support.knowledge') }}" class="p-6 rounded-xl border-2 border-light-sage hover:border-jade-green hover:shadow-lg transition">
                    <p class="text-3xl mb-3">📚</p>
                    <h3 class="font-bold text-soft-brown mb-2">Knowledge Base</h3>
                    <p class="text-sm text-soft-brown opacity-75">Browse helpful articles</p>
                </a>

                <a href="{{ route('support.forum') }}" class="p-6 rounded-xl border-2 border-light-sage hover:border-jade-green hover:shadow-lg transition">
                    <p class="text-3xl mb-3">💬</p>
                    <h3 class="font-bold text-soft-brown mb-2">Forum</h3>
                    <p class="text-sm text-soft-brown opacity-75">Join community discussions</p>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection