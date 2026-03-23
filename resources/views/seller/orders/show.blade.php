@extends('layouts.app')

@section('title', 'Order Details - Seller Dashboard - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-xl p-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-2">
                            Order Details 📋
                        </h1>
                        <p class="text-lg text-soft-brown opacity-75">
                            Order #{{ $order->order_id }}
                        </p>
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('seller.orders.index') }}" class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                            ← Back to Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Customer Information -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-soft-brown mb-6">Customer Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-soft-brown opacity-75 mb-2">Name</h3>
                            <p class="text-lg font-semibold text-soft-brown">{{ $order->user->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-soft-brown opacity-75 mb-2">Email</h3>
                            <p class="text-lg font-semibold text-soft-brown">{{ $order->user->email }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-soft-brown opacity-75 mb-2">Phone</h3>
                            <p class="text-lg font-semibold text-soft-brown">{{ $order->phone }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-soft-brown opacity-75 mb-2">Order Date</h3>
                            <p class="text-lg font-semibold text-soft-brown">{{ $order->order_date->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    
                    <!-- Shipping Address -->
                    <div class="mt-6 pt-6 border-t border-pastel-green">
                        <h3 class="text-sm font-medium text-soft-brown opacity-75 mb-2">Shipping Address</h3>
                        <p class="text-lg font-semibold text-soft-brown">
                            {{ $order->shipping_address }}, {{ $order->city }}, {{ $order->state }}, {{ $order->postal_code }}
                        </p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-soft-brown mb-6">Order Items</h2>
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                            <div class="flex items-center space-x-4 p-4 bg-mint-cream rounded-lg">
                                <div class="flex-shrink-0">
                                    @if($item->product->photo)
                                        <img src="{{ $item->product->photo_url }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="w-16 h-16 object-cover rounded-lg">
                                    @else
                                        <div class="w-16 h-16 bg-light-sage rounded-lg flex items-center justify-center">
                                            <span class="text-2xl">🧴</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-soft-brown">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-soft-brown opacity-75">{{ $item->product->brand }}</p>
                                    <p class="text-sm text-soft-brown opacity-75">Size: {{ $item->product->size_volume }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-soft-brown opacity-75">Qty: {{ $item->quantity }}</p>
                                    <p class="font-semibold text-jade-green">₱{{ number_format($item->price, 2) }}</p>
                                    <p class="text-sm font-semibold text-soft-brown">₱{{ number_format($item->total, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Order Total -->
                    <div class="mt-6 pt-6 border-t border-pastel-green">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-semibold text-soft-brown">Total Amount:</span>
                            <span class="text-2xl font-bold text-jade-green">₱{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                @if($order->notes)
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-soft-brown mb-4">Order Notes</h2>
                        <p class="text-soft-brown whitespace-pre-line">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Order Actions -->
            <div class="space-y-8">
                <!-- Order Status -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-soft-brown mb-6">Order Status</h2>
                    
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'confirmed' => 'bg-blue-100 text-blue-800',
                            'processing' => 'bg-purple-100 text-purple-800',
                            'shipped' => 'bg-indigo-100 text-indigo-800',
                            'delivered' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ];
                    @endphp
                    
                    <div class="text-center mb-6">
                        <span class="px-4 py-2 rounded-full text-lg font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <!-- Status Update Actions -->
                    @if(in_array($order->status, ['pending', 'confirmed', 'processing']))
                        <div class="space-y-3">
                            @if($order->status === 'pending')
                                <form method="POST" action="{{ route('seller.orders.update-status', $order) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="w-full px-4 py-3 bg-jade-green text-white rounded-lg hover:shadow-lg transition font-semibold">
                                        ✓ Confirm Order
                                    </button>
                                </form>
                            @endif

                            @if($order->status === 'confirmed')
                                <form method="POST" action="{{ route('seller.orders.prepare-shipment', $order) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium text-soft-brown mb-2">Tracking Number (Optional)</label>
                                            <input type="text" name="tracking_number" placeholder="Enter tracking number" class="w-full px-4 py-2 border border-jade-green rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-soft-brown mb-2">Shipping Notes (Optional)</label>
                                            <textarea name="shipping_notes" rows="3" placeholder="Add shipping notes..." class="w-full px-4 py-2 border border-jade-green rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent"></textarea>
                                        </div>
                                        <button type="submit" class="w-full px-4 py-3 bg-jade-green text-white rounded-lg hover:shadow-lg transition font-semibold">
                                            📦 Prepare for Shipment
                                        </button>
                                    </div>
                                </form>
                            @endif

                            @if($order->status === 'processing')
                                <form method="POST" action="{{ route('seller.orders.update-status', $order) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="shipped">
                                    <button type="submit" class="w-full px-4 py-3 bg-jade-green text-white rounded-lg hover:shadow-lg transition font-semibold">
                                        🚚 Mark as Shipped
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif

                    <!-- Status Timeline -->
                    <div class="mt-6 pt-6 border-t border-pastel-green">
                        <h3 class="text-sm font-medium text-soft-brown opacity-75 mb-4">Order Timeline</h3>
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span class="text-sm text-soft-brown">Order Placed - {{ $order->order_date->format('M d, h:i A') }}</span>
                            </div>
                            @if($order->status !== 'pending')
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                    <span class="text-sm text-soft-brown">Order Confirmed</span>
                                </div>
                            @endif
                            @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                    <span class="text-sm text-soft-brown">Processing</span>
                                </div>
                            @endif
                            @if(in_array($order->status, ['shipped', 'delivered']))
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-indigo-500 rounded-full"></div>
                                    <span class="text-sm text-soft-brown">Shipped</span>
                                </div>
                            @endif
                            @if($order->status === 'delivered')
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <span class="text-sm text-soft-brown">Delivered</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-soft-brown mb-6">Payment Information</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-soft-brown opacity-75 mb-2">Payment Method</h3>
                            <p class="text-lg font-semibold text-soft-brown">{{ ucfirst($order->payment_method) }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-soft-brown opacity-75 mb-2">Total Amount</h3>
                            <p class="text-2xl font-bold text-jade-green">₱{{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
