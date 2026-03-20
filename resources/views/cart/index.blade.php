@extends('layouts.app')

@section('title', 'Shopping Cart - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-xl p-8 flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-3">Shopping Cart 🛒</h1>
                    <p class="text-lg text-soft-brown opacity-75">Review your items before checkout</p>
                </div>
                <a href="{{ route('orders.index') }}" 
                   class="px-6 py-3 border-2 border-soft-brown text-soft-brown rounded-full hover:bg-soft-brown hover:text-white transition font-semibold">
                    📦 My Orders
                </a>
            </div>
        </div>

        <!-- Cart Items -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            @if($cartItems->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-soft-brown">Product</th>
                                <th class="text-left py-3 px-4 font-semibold text-soft-brown">Price</th>
                                <th class="text-left py-3 px-4 font-semibold text-soft-brown">Quantity</th>
                                <th class="text-left py-3 px-4 font-semibold text-soft-brown">Subtotal</th>
                                <th class="text-left py-3 px-4 font-semibold text-soft-brown">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr class="border-b border-gray-100">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            @if($item->product->photo)
                                                <img src="{{ asset('storage/' . $item->product->photo) }}" 
                                                     alt="{{ $item->product->name }}" 
                                                     class="w-16 h-16 object-cover object-center rounded-lg mr-3">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 rounded-lg mr-3 flex items-center justify-center">
                                                    <span class="text-gray-400 text-xs">No img</span>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-semibold text-soft-brown">{{ $item->product->name }}</div>
                                                <div class="text-sm text-soft-brown opacity-75">{{ $item->product->brand }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="font-semibold text-jade-green">₱{{ number_format($item->price, 2) }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                                   min="1" max="{{ $item->product->quantity }}"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded-lg text-center"
                                                   onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="font-semibold text-jade-green">
                                            ₱{{ number_format($item->price * $item->quantity, 2) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <form action="{{ route('cart.remove', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 font-semibold"
                                                    onclick="return confirm('Remove this item from cart?')">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Cart Summary -->
                <div class="mt-8 border-t border-gray-200 pt-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-2xl font-bold text-soft-brown">Total</h3>
                            <p class="text-sm text-soft-brown opacity-75">Including all items</p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-jade-green">
                                ₱{{ number_format($total, 2) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex flex-wrap gap-4 justify-center">
                    <a href="{{ route('products.index') }}" 
                       class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                        Continue Shopping
                    </a>
                    <button onclick="window.location.href='{{ route('checkout.index') }}'" 
                        class="px-8 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green-600 transition font-semibold">
                        Proceed to Checkout
                    </button>
                    <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-6 py-3 border-2 border-red-500 text-red-500 rounded-full hover:bg-red-500 hover:text-white transition font-semibold"
                                onclick="return confirm('Clear entire cart?')">
                            Clear Cart
                        </button>
                    </form>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="text-8xl mb-4 opacity-50">🛒</div>
                    <h3 class="text-2xl font-bold text-soft-brown mb-4">Your cart is empty</h3>
                    <p class="text-soft-brown opacity-75 mb-8">Start shopping to add some amazing skincare products!</p>
                    <a href="{{ route('products.index') }}" 
                       class="inline-block px-8 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green-600 transition font-semibold">
                        Browse Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
