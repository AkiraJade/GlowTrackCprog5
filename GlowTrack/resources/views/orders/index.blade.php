@extends('layouts.app')

@section('title', 'My Orders - GlowTrack')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
            <p class="text-gray-600 mt-2">Track your orders and view purchase history</p>
        </div>

        @if($orders->count() > 0)
            <!-- Orders List -->
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <!-- Order Header -->
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <div class="flex items-center space-x-4 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            Order {{ $order->order_id }}
                                        </h3>
                                        <span class="px-3 py-1 text-sm font-medium rounded-full
                                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                               ($order->status === 'confirmed' ? 'bg-blue-100 text-blue-800' :
                                               ($order->status === 'processing' ? 'bg-purple-100 text-purple-800' :
                                               ($order->status === 'shipped' ? 'bg-indigo-100 text-indigo-800' :
                                               ($order->status === 'delivered' ? 'bg-green-100 text-green-800' :
                                               ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' :
                                               'bg-gray-100 text-gray-800')))) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600">
                                        Placed on {{ $order->created_at->format('F d, Y \a\t g:i A') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->orderItems->count() }} items</p>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="space-y-3 mb-4">
                                @foreach($order->orderItems as $item)
                                    <div class="flex items-center space-x-4 p-3 bg-gray-50 rounded-lg">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            @if($item->product->photo)
                                                <img src="{{ asset('storage/' . $item->product->photo) }}" 
                                                     alt="{{ $item->product->name }}" 
                                                     class="w-16 h-16 object-cover rounded-lg">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <span class="text-gray-400 text-xs">No Image</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Info -->
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-gray-900">
                                                <a href="{{ route('products.show', $item->product) }}" 
                                                   class="hover:text-jade-green transition">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h4>
                                            <p class="text-sm text-gray-500">{{ $item->product->brand }}</p>
                                            <div class="flex items-center space-x-4 mt-1">
                                                <span class="text-sm text-gray-600">Qty: {{ $item->quantity }}</span>
                                                <span class="text-sm text-gray-600">${{ number_format($item->price, 2) }} each</span>
                                            </div>
                                        </div>

                                        <!-- Seller Info -->
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500">Sold by</p>
                                            <p class="text-sm font-medium text-gray-900">{{ $item->product->seller->name }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Order Actions -->
                            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                                <div>
                                    <a href="{{ route('orders.show', $order) }}" 
                                       class="text-jade-green hover:text-jade-green-900 font-medium text-sm">
                                        View Details
                                    </a>
                                </div>
                                @if(in_array($order->status, ['pending', 'confirmed']))
                                    <form method="POST" action="{{ route('orders.cancel', $order) }}" 
                                          onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="reason" value="Customer cancellation">
                                        <button type="submit" 
                                                class="px-4 py-2 text-sm bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                            Cancel Order
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <svg class="mx-auto h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1.5 7.5L10 11l-3.5 5.5L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No orders yet</h3>
                <p class="text-gray-500 mb-6">You haven't placed any orders yet. Start shopping to see your order history here.</p>
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-jade-green text-white font-medium rounded-md hover:bg-opacity-90 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.419 2.122l2.844 2.844a1.5 1.5 0 001.42 0l2.844-2.844a1.5 1.5 0 00.419-2.122L7.707 13.707a1.5 1.5 0 00-2.122 0L3 11.586V7z"></path>
                    </svg>
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
