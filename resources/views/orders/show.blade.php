@extends('layouts.app')

@section('title', 'Order Details - GlowTrack')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('orders.index') }}" class="text-jade-green hover:text-jade-green-900 font-medium">
                ← Back to Orders
            </a>
<h1 class="text-3xl font-bold text-gray-900 mt-4">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h1>
        </div>

        <!-- Order Status Card -->
        <div class="bg-white rounded-lg shadow-lg mb-8">
            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <div class="flex items-center space-x-4 mb-2">
                            <h2 class="text-xl font-semibold text-gray-900">Order Status</h2>
                            <span class="px-4 py-2 text-sm font-medium rounded-full
                                @if($order->status === 'pending')
                                    bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'confirmed')
                                    bg-blue-100 text-blue-800
                                @elseif($order->status === 'processing')
                                    bg-purple-100 text-purple-800
                                @elseif($order->status === 'shipped')
                                    bg-indigo-100 text-indigo-800
                                @elseif($order->status === 'delivered')
                                    bg-green-100 text-green-800
                                @elseif($order->status === 'cancelled')
                                    bg-red-100 text-red-800
                                @else
                                    bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <p class="text-gray-600">
                            Placed on {{ $order->created_at->format('F d, Y \a\t g:i A') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                        <p class="text-sm text-gray-500">{{ $order->orderItems->count() }} items</p>
                    </div>
                </div>

                <!-- Order Timeline -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Timeline</h3>
                    <div class="space-y-4">
                        <!-- Order Placed -->
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 000-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Order Placed</p>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                        </div>

                        <!-- Order Confirmed -->
                        @if(in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered']))
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 000-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Order Confirmed</p>
                                    <p class="text-sm text-gray-500">Your order has been confirmed and is being prepared</p>
                                </div>
                            </div>
                        @endif

                        <!-- Order Processing -->
                        @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 000-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Processing</p>
                                    <p class="text-sm text-gray-500">Your order is being processed</p>
                                </div>
                            </div>
                        @endif

                        <!-- Order Shipped -->
                        @if(in_array($order->status, ['shipped', 'delivered']))
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 000-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Shipped</p>
                                    <p class="text-sm text-gray-500">Your order has been shipped</p>
                                </div>
                            </div>
                        @endif

                        <!-- Order Delivered -->
                        @if($order->status === 'delivered')
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 000-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Delivered</p>
                                    <p class="text-sm text-gray-500">Your order has been delivered</p>
                                </div>
                            </div>
                        @endif

                        <!-- Order Cancelled -->
                        @if($order->status === 'cancelled')
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Order Cancelled</p>
                                    <p class="text-sm text-gray-500">
                                        @if($order->notes)
                                            {{ $order->notes }}
                                        @else
                                            Order was cancelled
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-lg mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Order Items</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($order->orderItems as $item)
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                            <!-- Product Image -->
                            <div class="flex-shrink-0">
                                @if($item->product->photo)
                                    <img src="{{ asset('storage/' . $item->product->photo) }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="w-20 h-20 object-cover rounded-lg">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <span class="text-gray-400 text-sm">No Image</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-gray-900">
                                    <a href="{{ route('products.show', $item->product) }}" 
                                       class="hover:text-jade-green transition">
                                        {{ $item->product->name }}
                                    </a>
                                </h3>
                                <p class="text-gray-600">{{ $item->product->brand }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $item->product->classification }}</p>
                                <div class="flex items-center space-x-6 mt-2">
                                    <span class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</span>
                                    <span class="text-sm text-gray-600">Price: ${{ number_format($item->price, 2) }}</span>
                                    <span class="text-sm text-gray-600">Total: ${{ number_format($item->total, 2) }}</span>
                                </div>
                            </div>

                            <!-- Seller Info -->
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Sold by</p>
                                <p class="font-medium text-gray-900">{{ $item->product->seller->name }}</p>
                                @if($item->product->is_verified)
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 mt-1">
                                        ✓ Verified
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900">Total Amount</span>
                        <span class="text-2xl font-bold text-gray-900">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="bg-white rounded-lg shadow-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Shipping Information</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Shipping Address</h3>
                        <p class="text-gray-900">{{ $order->shipping_address }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Payment Method</h3>
                        <p class="text-gray-900">{{ ucfirst($order->payment_method) }}</p>
                    </div>
                </div>
                @if($order->notes)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Order Notes</h3>
                        <p class="text-gray-900">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
