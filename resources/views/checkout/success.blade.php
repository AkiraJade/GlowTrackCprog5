@extends('layouts.app')

@section('title', 'Order Success - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Success Message -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-xl p-12 text-center">
                <div class="text-8xl mb-4">🎉</div>
                <h1 class="text-5xl font-bold text-soft-brown font-playfair mb-3">Order Confirmed!</h1>
                <p class="text-xl text-soft-brown opacity-75 mb-6">Thank you for your purchase. Your order has been successfully placed and is being processed.</p>
                
                <div class="bg-jade-green text-white rounded-2xl p-6 inline-block">
                    <div class="text-sm opacity-90">Order Number</div>
                    <div class="text-3xl font-bold">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6">Order Summary 📋</h2>
            
            <div class="bg-gradient-to-r from-mint-cream to-light-sage rounded-xl p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="text-sm text-soft-brown opacity-75 mb-1">Order Number</div>
                        <div class="text-lg font-bold text-soft-brown">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-soft-brown opacity-75 mb-1">Total Amount</div>
                        <div class="text-2xl font-bold text-jade-green">₱{{ number_format($order->total_amount, 2) }}</div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="text-sm text-soft-brown opacity-75 mb-1">Order Date</div>
                        <div class="text-lg font-semibold text-soft-brown">{{ $order->created_at->format('F d, Y, g:i A') }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-soft-brown opacity-75 mb-1">Status</div>
                        <div class="text-lg font-semibold text-soft-brown">{{ ucfirst($order->status) }}</div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="space-y-4">
                @foreach($order->orderItems as $item)
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-mint-cream to-light-sage rounded-xl">
                        <div class="flex items-center flex-1">
                            @if($item->product->photo)
                                <img src="{{ $item->product->photo_url }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="w-16 h-16 object-cover rounded-lg mr-4">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg mr-4 flex items-center justify-center">
                                    <span class="text-gray-400 text-xs">No img</span>
                                </div>
                            @endif
                            <div>
                                <div class="font-semibold text-soft-brown">{{ $item->product->name }}</div>
                                <div class="text-sm text-soft-brown opacity-75">{{ $item->product->brand }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-jade-green">₱{{ number_format($item->price * $item->quantity, 2) }}</div>
                            <div class="text-sm text-soft-brown opacity-75">Qty: {{ $item->quantity }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Loyalty Points Earned -->
        @isset($loyaltyPointsEarned)
            <div class="mb-8">
                <div class="bg-gradient-to-r from-jade-green to-light-sage text-white rounded-3xl shadow-xl p-8 text-center">
                    <div class="text-4xl mb-2">⭐</div>
                    <h3 class="text-2xl font-bold mb-2">Loyalty Points Earned!</h3>
                    <div class="text-4xl font-bold mb-2">+{{ $loyaltyPointsEarned }} Points</div>
                    <p class="text-lg opacity-90">You've earned {{ $loyaltyPointsEarned }} loyalty points from this order. 1 point per quantity purchased!</p>
                </div>
            </div>
        @endisset

        <!-- Next Steps -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6">What's Next? 🚀</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-4xl mb-3">📦</div>
                    <h3 class="text-xl font-bold text-soft-brown mb-2">Track Your Order</h3>
                    <p class="text-soft-brown opacity-75 mb-4">Monitor your order status and delivery progress</p>
                    <a href="{{ route('orders.show', $order) }}" class="inline-block px-6 py-3 bg-jade-green text-white rounded-full hover:bg-opacity-90 transition font-semibold">
                        Track Order
                    </a>
                </div>
                
                <div class="text-center">
                    <div class="text-4xl mb-3">🛍️</div>
                    <h3 class="text-xl font-bold text-soft-brown mb-2">Continue Shopping</h3>
                    <p class="text-soft-brown opacity-75 mb-4">Browse more amazing skincare products</p>
                    <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                        Continue Shopping
                    </a>
                </div>
                
                <div class="text-center">
                    <div class="text-4xl mb-3">📋</div>
                    <h3 class="text-xl font-bold text-soft-brown mb-2">View Orders</h3>
                    <p class="text-soft-brown opacity-75 mb-4">Check your order history and status</p>
                    <a href="{{ route('orders.index') }}" class="inline-block px-6 py-3 border-2 border-soft-brown text-soft-brown rounded-full hover:bg-soft-brown hover:text-white transition font-semibold">
                        View Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
