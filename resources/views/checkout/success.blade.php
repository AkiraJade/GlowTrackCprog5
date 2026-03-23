@extends('layouts.app')

@section('title', 'Order Success - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Success Message -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-xl p-8 text-center">
                <div class="text-6xl mb-4">🎉</div>
                <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-3">Order Confirmed!</h1>
                <p class="text-lg text-soft-brown opacity-75 mb-6">Thank you for your purchase. Your order has been successfully placed.</p>
                
                <div class="bg-jade-green text-white rounded-2xl p-6 inline-block">
                    <div class="text-sm opacity-90">Order Number</div>
                    <div class="text-2xl font-bold">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>
            </div>
        </div>

        <!-- Loyalty Points Earned -->
        @isset($loyaltyPointsEarned)
            <div class="mb-8">
                <div class="bg-gradient-to-r from-jade-green to-light-sage text-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="text-2xl mb-2">⭐</div>
                    <h3 class="text-xl font-bold mb-2">Loyalty Points Earned!</h3>
                    <p class="text-3xl font-bold mb-2">+{{ $loyaltyPointsEarned }} Points</p>
                    <p class="text-sm opacity-90">You've earned {{ $loyaltyPointsEarned }} loyalty points from this order. 1 point per quantity purchased!</p>
                </div>
            </div>
        @endisset

        <!-- Order Details -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-soft-brown mb-6">Order Details</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Shipping Information -->
                <div>
                    <h3 class="font-semibold text-soft-brown mb-3">Shipping Information</h3>
                    <div class="space-y-2 text-sm">
                        <div><strong>Name:</strong> {{ auth()->user()->name }}</div>
                        <div><strong>Address:</strong> {{ $order->shipping_address }}</div>
                        <div><strong>City:</strong> {{ $order->city }}</div>
                        <div><strong>State:</strong> {{ $order->state }}</div>
                        <div><strong>Postal Code:</strong> {{ $order->postal_code }}</div>
                        <div><strong>Phone:</strong> {{ $order->phone }}</div>
                    </div>
                </div>

                <!-- Order Information -->
                <div>
                    <h3 class="font-semibold text-soft-brown mb-3">Order Information</h3>
                    <div class="space-y-2 text-sm">
                        <div><strong>Order Date:</strong> {{ $order->order_date->format('M d, Y') }}</div>
                        <div><strong>Status:</strong> 
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</div>
                        <div><strong>Total Amount:</strong> <span class="text-jade-green font-bold">₱{{ number_format($order->total_amount, 2) }}</span></div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div>
                <h3 class="font-semibold text-soft-brown mb-4">Items Ordered</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-soft-brown">Product</th>
                                <th class="text-left py-3 px-4 font-semibold text-soft-brown">Price</th>
                                <th class="text-left py-3 px-4 font-semibold text-soft-brown">Quantity</th>
                                <th class="text-right py-3 px-4 font-semibold text-soft-brown">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr class="border-b border-gray-100">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            @if($item->product->photo)
                                                <img src="{{ $item->product->photo_url }}" 
                                                     alt="{{ $item->product->name }}" 
                                                     class="w-12 h-12 object-cover rounded-lg mr-3">
                                            @else
                                                <div class="w-12 h-12 bg-gray-200 rounded-lg mr-3 flex items-center justify-center">
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
                                    <td class="py-4 px-4">{{ $item->quantity }}</td>
                                    <td class="py-4 px-4 text-right">
                                        <span class="font-semibold text-jade-green">₱{{ number_format($item->price * $item->quantity, 2) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products.index') }}" 
                   class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold text-center">
                    Continue Shopping
                </a>
                <a href="{{ route('orders.index') }}" 
                   class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green-600 transition font-semibold text-center">
                    View My Orders
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
