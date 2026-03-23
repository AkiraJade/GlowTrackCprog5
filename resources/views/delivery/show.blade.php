@extends('layouts.admin')

@section('title', 'Delivery Details - GlowTrack')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 font-playfair">Delivery Details</h1>
                <p class="text-gray-600 mt-2">View and manage delivery information</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.deliveries.index') }}" class="px-6 py-2 border-2 border-admin-primary text-admin-primary rounded-full hover:bg-admin-primary hover:text-white transition font-semibold">
                    ← Back to Deliveries
                </a>
                <a href="{{ route('admin.deliveries.edit', $delivery) }}" class="px-6 py-2 bg-admin-primary text-white rounded-full hover:bg-admin-primary/80 transition font-semibold">
                    Edit Delivery
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Delivery Information -->
        <div class="lg:col-span-2">
            <!-- Delivery Status Card -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-900">Delivery Status</h2>
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $delivery->status === 'Delivered' ? 'bg-green-100 text-green-800' : 
                           ($delivery->status === 'Failed' || $delivery->status === 'Returned' ? 'bg-red-100 text-red-800' : 
                           'bg-blue-100 text-blue-800') }}">
                        {{ $delivery->status }}
                    </span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Delivery ID</p>
                        <p class="font-semibold">#{{ $delivery->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Expected Delivery</p>
                        <p class="font-semibold">{{ $delivery->expected_delivery_date->format('M d, Y') }}</p>
                    </div>
                    @if($delivery->actual_delivery_date)
                    <div>
                        <p class="text-sm text-gray-500">Actual Delivery</p>
                        <p class="font-semibold">{{ $delivery->actual_delivery_date->format('M d, Y') }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-sm text-gray-500">Created</p>
                        <p class="font-semibold">{{ $delivery->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Information -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Information</h2>
                
                <div class="border border-gray-200 rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="text-sm text-gray-500">Order #{{ $delivery->order->id }}</p>
                            <p class="font-semibold text-lg">₱{{ number_format($delivery->order->total_amount, 2) }}</p>
                        </div>
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $delivery->order->status === 'delivered' ? 'bg-green-100 text-green-800' : 
                               ($delivery->order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                               'bg-blue-100 text-blue-800') }}">
                            {{ ucfirst($delivery->order->status) }}
                        </span>
                    </div>
                    
                    <div class="text-sm text-gray-600 mb-2">
                        <p><strong>Customer:</strong> {{ $delivery->order->user->name }}</p>
                        <p><strong>Email:</strong> {{ $delivery->order->user->email }}</p>
                        <p><strong>Phone:</strong> {{ $delivery->order->user->phone ?? 'Not provided' }}</p>
                    </div>
                </div>

                <!-- Order Items -->
                <h3 class="text-lg font-medium text-gray-900 mb-3">Order Items</h3>
                <div class="space-y-3">
                    @foreach($delivery->order->orderItems as $item)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            @if($item->product->photo_url)
                                <img src="{{ $item->product->photo_url }}" alt="{{ $item->product->name }}" 
                                     class="w-12 h-12 rounded-lg object-cover mr-3">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded-lg mr-3 flex items-center justify-center">
                                    <span class="text-gray-400 text-xs">No img</span>
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-500">{{ $item->product->brand }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium">₱{{ number_format($item->price, 2) }}</p>
                            <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Delivery Details -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Delivery Details</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Pickup Information</h3>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-gray-500">Collection Point</p>
                                <p class="font-medium">{{ $delivery->collection_point ?: 'Not specified' }}</p>
                            </div>
                            @if($delivery->deliveryPersonnel)
                            <div>
                                <p class="text-sm text-gray-500">Delivery Personnel</p>
                                <p class="font-medium">{{ $delivery->deliveryPersonnel->name }}</p>
                                <p class="text-sm text-gray-600">{{ $delivery->deliveryPersonnel->phone }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Destination</h3>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-gray-500">Delivery Address</p>
                                <p class="font-medium">{{ $delivery->destination_address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($delivery->notes)
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Notes</h3>
                    <p class="text-gray-600 bg-gray-50 p-3 rounded-lg">{{ $delivery->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Timeline -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Delivery Timeline</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-green-600 text-xs">✓</span>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">Order Created</p>
                            <p class="text-sm text-gray-500">{{ $delivery->order->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 {{ $delivery->status !== 'Assigned' ? 'bg-green-100' : 'bg-gray-100' }} rounded-full flex items-center justify-center">
                            <span class="{{ $delivery->status !== 'Assigned' ? 'text-green-600' : 'text-gray-400' }} text-xs">✓</span>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">Delivery Assigned</p>
                            <p class="text-sm text-gray-500">{{ $delivery->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    
                    @if($delivery->status === 'Delivered')
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-green-600 text-xs">✓</span>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">Delivered</p>
                            <p class="text-sm text-gray-500">{{ $delivery->actual_delivery_date->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
                
                <div class="space-y-3">
                    <a href="{{ route('orders.show', $delivery->order) }}" 
                       class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        View Order Details
                    </a>
                    
                    @if($delivery->order->user)
                    <a href="{{ route('admin.users.show', $delivery->order->user) }}" 
                       class="block w-full text-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        View Customer Profile
                    </a>
                    @endif
                    
                    <button onclick="window.print()" 
                            class="block w-full text-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Print Delivery Details
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
