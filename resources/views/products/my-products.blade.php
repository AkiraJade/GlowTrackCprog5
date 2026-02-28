@extends('layouts.app')

@section('title', 'My Products - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold text-soft-brown font-playfair">My Products</h1>
                <p class="text-soft-brown opacity-75 mt-2">Manage your skincare product listings</p>
            </div>
            <a href="{{ route('seller.products.create') }}" class="px-6 py-2 bg-jade-green text-white rounded-full hover:bg-jade-green-600 transition font-semibold">
                + Add New Product
            </a>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition">
                        <!-- Product Image -->
                        @if($product->image)
                            <div class="h-48 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $product->image) }}')"></div>
                        @else
                            <div class="h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400 text-6xl">🧴</span>
                            </div>
                        @endif
                        
                        <!-- Product Info -->
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h3 class="text-lg font-bold text-soft-brown mb-1">{{ $product->name }}</h3>
                                    <p class="text-sm text-soft-brown opacity-75">{{ $product->brand }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-2xl font-bold text-jade-green">${{ number_format($product->price, 2) }}</span>
                                    <p class="text-xs text-soft-brown opacity-75">{{ $product->size_volume }}</p>
                                </div>
                            </div>
                            
                            <!-- Product Details -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-soft-brown opacity-75">Stock:</span>
                                    <span class="font-semibold {{ $product->quantity <= 10 ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ $product->quantity }} units
                                    </span>
                                </div>
                                
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-soft-brown opacity-75">Status:</span>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        {{ $product->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                           ($product->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-soft-brown opacity-75">Reviews:</span>
                                    <span class="font-semibold text-gray-900">{{ $product->reviews_count ?? 0 }}</span>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex gap-2">
                                <a href="{{ route('products.show', $product) }}" class="flex-1 px-4 py-2 bg-jade-green text-white rounded-lg hover:bg-jade-green-600 transition text-center font-semibold">
                                    View
                                </a>
                                <a href="{{ route('seller.products.edit', $product) }}" class="flex-1 px-4 py-2 border-2 border-jade-green text-jade-green rounded-lg hover:bg-jade-green hover:text-white transition text-center font-semibold">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="flex justify-center mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="bg-white rounded-2xl shadow-lg p-12 max-w-md mx-auto">
                    <div class="text-8xl mb-6 opacity-50">📦</div>
                    <h3 class="text-2xl font-bold text-soft-brown mb-4">No Products Yet</h3>
                    <p class="text-soft-brown opacity-75 mb-8">Start adding your skincare products to the marketplace!</p>
                    <a href="{{ route('seller.products.create') }}" class="inline-block px-8 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green-600 transition font-semibold">
                        Add Your First Product
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
