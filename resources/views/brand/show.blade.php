@extends('layouts.app')

@section('title', $seller->name . ' - Brand Page - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage">
    
    <!-- Brand Hero Section -->
    <div class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                    <!-- Brand Info -->
                    <div class="md:col-span-2">
                        <div class="flex items-center space-x-4 mb-6">
                            @if($seller->photo)
                                <img src="{{ asset('storage/user_photos/' . $seller->photo) }}" 
                                     alt="{{ $seller->name }}" 
                                     class="w-20 h-20 rounded-full object-cover border-4 border-jade-green">
                            @else
                                <div class="w-20 h-20 bg-jade-green rounded-full flex items-center justify-center">
                                    <span class="text-3xl text-white font-bold">{{ substr($seller->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <div class="flex items-center space-x-2 mb-2">
                                    <h1 class="text-3xl font-bold text-soft-brown font-playfair">{{ $seller->name }}</h1>
                                    <div class="flex items-center space-x-1">
                                        <span class="text-2xl">✨</span>
                                        <span class="px-2 py-1 bg-jade-green text-white text-xs rounded-full font-semibold">Verified</span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-1">
                                        <span class="text-yellow-500">⭐</span>
                                        <span class="font-semibold text-soft-brown">{{ number_format($stats['average_rating'], 1) }}</span>
                                        <span class="text-sm text-soft-brown opacity-75">({{ $stats['total_reviews'] }} reviews)</span>
                                    </div>
                                    <div class="text-sm text-soft-brown opacity-75">
                                        📦 {{ $stats['total_products'] }} products
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if($seller->sellerApplication && $seller->sellerApplication->brand_description)
                            <p class="text-lg text-soft-brown opacity-80 mb-6 leading-relaxed">
                                {{ $seller->sellerApplication->brand_description }}
                            </p>
                        @endif
                        
                        <!-- Brand Stats -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                            <div class="bg-mint-cream rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-jade-green">{{ $stats['total_products'] }}</div>
                                <div class="text-sm text-soft-brown opacity-75">Products</div>
                            </div>
                            <div class="bg-mint-cream rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-jade-green">{{ $stats['total_reviews'] }}</div>
                                <div class="text-sm text-soft-brown opacity-75">Reviews</div>
                            </div>
                            <div class="bg-mint-cream rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-jade-green">{{ number_format($stats['average_rating'], 1) }}</div>
                                <div class="text-sm text-soft-brown opacity-75">Avg Rating</div>
                            </div>
                            <div class="bg-mint-cream rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-jade-green">₱{{ number_format($stats['total_sales'], 0) }}</div>
                                <div class="text-sm text-soft-brown opacity-75">Total Sales</div>
                            </div>
                        </div>
                        
                        <!-- Contact Info -->
                        @if($seller->sellerApplication)
                            <div class="flex flex-wrap gap-4">
                                @if($seller->sellerApplication->business_email)
                                    <div class="flex items-center space-x-2 text-soft-brown">
                                        <span>📧</span>
                                        <span>{{ $seller->sellerApplication->business_email }}</span>
                                    </div>
                                @endif
                                @if($seller->sellerApplication->business_phone)
                                    <div class="flex items-center space-x-2 text-soft-brown">
                                        <span>📱</span>
                                        <span>{{ $seller->sellerApplication->business_phone }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                    
                    <!-- Brand Visual -->
                    <div class="text-center">
                        <div class="text-8xl mb-4 opacity-50">🏪</div>
                        @if($seller->sellerApplication && $seller->sellerApplication->business_name)
                            <h3 class="text-xl font-semibold text-soft-brown mb-2">{{ $seller->sellerApplication->business_name }}</h3>
                        @endif
                        <p class="text-soft-brown opacity-75">Official Brand Partner</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Featured Products -->
        @if($featuredProducts->count() > 0)
            <div class="mb-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Featured Products ⭐</h2>
                    <p class="text-lg text-soft-brown opacity-75">Highest rated products from {{ $seller->name }}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($featuredProducts as $product)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="relative">
                                @if($product->photo)
                                    <img src="{{ $product->photo_url }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-48 object-cover object-center">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-jade-green to-light-sage flex items-center justify-center">
                                        <span class="text-4xl">🧴</span>
                                    </div>
                                @endif
                                @if($product->is_verified)
                                    <div class="absolute top-2 right-2 bg-jade-green text-white px-2 py-1 rounded-full text-xs font-semibold">
                                        Verified
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-soft-brown mb-2">{{ $product->name }}</h3>
                                <p class="text-soft-brown opacity-75 mb-4">{{ $product->brand }}</p>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl font-bold text-jade-green">₱{{ number_format($product->price, 2) }}</span>
                                    <div class="flex items-center space-x-1">
                                        <span class="text-yellow-500">⭐</span>
                                        <span class="text-sm font-semibold">{{ number_format($product->average_rating, 1) }}</span>
                                        <span class="text-sm text-soft-brown opacity-75">({{ $product->review_count }})</span>
                                    </div>
                                </div>
                                <a href="{{ route('products.show', $product) }}" class="block w-full text-center px-4 py-2 bg-jade-green text-white rounded-lg hover:bg-jade-green/80 transition font-semibold">
                                    View Product
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- All Products Section -->
        <div>
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-soft-brown font-playfair mb-2">All Products 🛍️</h2>
                <p class="text-lg text-soft-brown opacity-75">Complete product catalog from {{ $seller->name }}</p>
            </div>
            
            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="relative">
                                @if($product->photo)
                                    <img src="{{ $product->photo_url }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-40 object-cover object-center">
                                @else
                                    <div class="w-full h-40 bg-gradient-to-br from-jade-green to-light-sage flex items-center justify-center">
                                        <span class="text-3xl">🧴</span>
                                    </div>
                                @endif
                                @if($product->is_verified)
                                    <div class="absolute top-2 right-2 bg-jade-green text-white px-2 py-1 rounded-full text-xs font-semibold">
                                        Verified
                                    </div>
                                @endif
                                <div class="absolute bottom-2 left-2">
                                    <span class="px-2 py-1 bg-white/90 text-soft-brown text-xs rounded-full font-semibold">
                                        {{ $product->classification }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-bold text-soft-brown mb-1 truncate">{{ $product->name }}</h3>
                                <p class="text-sm text-soft-brown opacity-75 mb-2">{{ $product->brand }}</p>
                                <p class="text-xs text-soft-brown opacity-60 mb-3">{{ $product->size_volume }}</p>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xl font-bold text-jade-green">₱{{ number_format($product->price, 2) }}</span>
                                    <div class="flex items-center space-x-1">
                                        <span class="text-yellow-500 text-xs">⭐</span>
                                        <span class="text-xs font-semibold">{{ number_format($product->average_rating, 1) }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs {{ $product->getStockStatusColor() }} font-semibold">
                                        {{ $product->getStockStatusLabel() }}
                                    </span>
                                    <span class="text-xs text-soft-brown opacity-75">
                                        {{ $product->quantity }} left
                                    </span>
                                </div>
                                <a href="{{ route('products.show', $product) }}" class="block w-full text-center px-3 py-2 bg-jade-green text-white rounded-lg hover:bg-jade-green/80 transition text-sm font-semibold">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">📦</div>
                    <h3 class="text-xl font-semibold text-soft-brown mb-2">No products available</h3>
                    <p class="text-soft-brown opacity-75">{{ $seller->name }} hasn't added any products yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
