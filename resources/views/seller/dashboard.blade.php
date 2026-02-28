@extends('layouts.app')

@section('title', 'Seller Dashboard - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
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
                            Your seller dashboard
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('seller.products.index') }}" class="px-6 py-2 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                                My Products
                            </a>
                            <a href="{{ route('seller.products.create') }}" class="px-6 py-2 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                                Add New Product
                            </a>
                        </div>
                    </div>
                    <div class="text-8xl opacity-50">🛍️</div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition cursor-pointer" onclick="window.location.href='{{ route('seller.products.index') }}'">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-soft-brown">Total Products</h3>
                    <span class="text-4xl">📦</span>
                </div>
                <p class="text-4xl font-bold text-jade-green mb-2">{{ App\Models\Product::where('seller_id', Auth::id())->count() }}</p>
                <p class="text-sm text-soft-brown opacity-75">View all products</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition cursor-pointer" onclick="window.location.href='{{ route('orders.index') }}'">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-soft-brown">Total Orders</h3>
                    <span class="text-4xl">🛒</span>
                </div>
                <p class="text-4xl font-bold text-jade-green mb-2">{{ App\Models\Order::whereHas('orderItems.product', function($query) { $query->where('seller_id', Auth::id()); })->count() }}</p>
                <p class="text-sm text-soft-brown opacity-75">View all orders</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-soft-brown">Revenue</h3>
                    <span class="text-4xl">💰</span>
                </div>
                <p class="text-4xl font-bold text-jade-green mb-2">${{ number_format(App\Models\Order::whereHas('orderItems.product', function($query) { $query->where('seller_id', Auth::id()); })->where('status', '!=', 'cancelled')->sum('total_amount'), 2) }}</p>
                <p class="text-sm text-soft-brown opacity-75">Total earnings</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-soft-brown">Profile</h3>
                    <span class="text-4xl">👤</span>
                </div>
                <p class="text-4xl font-bold text-jade-green mb-2">{{ Auth::user()->name }}</p>
                <p class="text-sm text-soft-brown opacity-75">Manage account settings</p>
            </div>
        </div>

        <!-- Recent Products -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-soft-brown font-playfair">Recent Products</h2>
                <a href="{{ route('seller.products.index') }}" class="text-jade-green hover:text-soft-brown transition font-semibold text-sm">View All</a>
            </div>
            
            @php
                $recentProducts = App\Models\Product::where('seller_id', Auth::id())
                    ->withCount('reviews')
                    ->latest()
                    ->take(5)
                    ->get();
            @endphp
            
            @if($recentProducts->count() > 0)
                <div class="space-y-4">
                    @foreach($recentProducts as $product)
                        <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-semibold text-soft-brown">{{ $product->name }}</span>
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $product->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($product->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-soft-brown opacity-75">{{ $product->created_at->format('M d, Y') }}</span>
                                <span class="font-bold text-jade-green">${{ number_format($product->price, 2) }}</span>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('seller.products.edit', $product) }}" class="text-jade-green hover:text-soft-brown transition font-semibold text-sm mr-4">
                                    Edit →
                                </a>
                                <a href="{{ route('products.show', $product) }}" class="text-jade-green hover:text-soft-brown transition font-semibold text-sm">
                                    View Details →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4 opacity-50">📭</div>
                    <p class="text-soft-brown opacity-75 text-lg">No products yet</p>
                    <p class="text-soft-brown opacity-60 text-sm mb-6">Start adding your skincare products today!</p>
                    <a href="{{ route('seller.products.create') }}" class="inline-block px-6 py-2 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                        Add Your First Product
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
