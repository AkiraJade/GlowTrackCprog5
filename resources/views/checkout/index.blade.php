@extends('layouts.app')

@section('title', 'Checkout - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-xl p-8">
                <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-3">Checkout 🛍️</h1>
                <p class="text-lg text-soft-brown opacity-75">Complete your order details</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-soft-brown mb-4">Order Summary</h2>
                    
                    @foreach($cartItems as $item)
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
                            <div class="flex items-center flex-1">
                                @if($item->product->photo)
                                    <img src="{{ asset('storage/' . $item->product->photo) }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="w-12 h-12 object-cover rounded-lg mr-3">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg mr-3 flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">No img</span>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <div class="font-semibold text-soft-brown text-sm">{{ $item->product->name }}</div>
                                    <div class="text-xs text-soft-brown opacity-75">Qty: {{ $item->quantity }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold text-jade-green">₱{{ number_format($item->price * $item->quantity, 2) }}</div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Price Breakdown -->
                    <div class="mt-6 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-soft-brown">Subtotal</span>
                            <span class="font-semibold">₱{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-soft-brown">Shipping</span>
                            <span class="font-semibold">₱{{ number_format($shipping, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-soft-brown">Tax (8%)</span>
                            <span class="font-semibold">₱{{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-soft-brown pt-3 border-t border-gray-200">
                            <span>Total</span>
                            <span class="text-jade-green">₱{{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="lg:col-span-2">
                <form action="{{ route('checkout.process') }}" method="POST" class="bg-white rounded-2xl shadow-lg p-8">
                    @csrf
                    
                    <!-- Shipping Information -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-soft-brown mb-6">Shipping Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-soft-brown mb-2">Street Address</label>
                                <input type="text" name="shipping_address" 
                                       value="{{ auth()->user()->address ?? '' }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green" 
                                       required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-soft-brown mb-2">City</label>
                                <input type="text" name="city" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green" 
                                       required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-soft-brown mb-2">State</label>
                                <input type="text" name="state" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green" 
                                       required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-soft-brown mb-2">Postal Code</label>
                                <input type="text" name="postal_code" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green" 
                                       required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-soft-brown mb-2">Phone Number</label>
                                <input type="tel" name="phone" 
                                       value="{{ auth()->user()->phone ?? '' }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green" 
                                       required>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-soft-brown mb-6">Payment Method</h2>
                        
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                <input type="radio" name="payment_method" value="cod" class="mr-3" checked>
                                <div>
                                    <div class="font-semibold text-soft-brown">Cash on Delivery</div>
                                    <div class="text-sm text-soft-brown opacity-75">Pay when you receive your order</div>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                <input type="radio" name="payment_method" value="card" class="mr-3">
                                <div>
                                    <div class="font-semibold text-soft-brown">Credit/Debit Card</div>
                                    <div class="text-sm text-soft-brown opacity-75">Secure online payment</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4">
                        <a href="{{ route('cart.index') }}" 
                           class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                            Back to Cart
                        </a>
                        <button type="submit" 
                                class="flex-1 px-8 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green-600 transition font-semibold">
                            Place Order - ${{ number_format($total, 2) }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
