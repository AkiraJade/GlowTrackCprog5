@extends('layouts.app')

@section('title', 'My Orders - Seller Dashboard - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="glass-card rounded-3xl shadow-lg p-8 border border-gray-200">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-2">
                            My Orders 🛍️
                        </h1>
                        <p class="text-lg text-soft-brown opacity-75">
                            Manage orders for your products
                        </p>
                    </div>
                    <a href="{{ route('seller.dashboard') }}" class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="glass-card rounded-2xl shadow-lg p-6 mb-8 border border-gray-200">
            <form method="GET" action="{{ route('seller.orders.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-soft-brown mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-jade-green rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-soft-brown mb-2">Date From</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 border border-jade-green rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-soft-brown mb-2">Date To</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-2 border border-jade-green rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full px-6 py-2 bg-jade-green text-white rounded-lg hover:shadow-lg transition font-semibold">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Orders List -->
        <div class="glass-card rounded-2xl shadow-lg overflow-hidden border border-gray-200">
            @if($orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-light-sage">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-medium text-soft-brown">Order ID</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-soft-brown">Customer</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-soft-brown">Date</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-soft-brown">Total</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-soft-brown">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-soft-brown">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-pastel-green">
                            @foreach($orders as $order)
                                <tr class="hover:bg-mint-cream transition">
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-jade-green">{{ $order->order_id }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="font-medium text-soft-brown">{{ $order->user->name }}</div>
                                            <div class="text-sm text-soft-brown opacity-75">{{ $order->user->email }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-soft-brown">{{ $order->order_date->format('M d, Y') }}</div>
                                        <div class="text-sm text-soft-brown opacity-75">{{ $order->order_date->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-jade-green">₱{{ number_format($order->total_amount, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4">
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
                                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('seller.orders.show', $order) }}" class="text-jade-green hover:text-jade-green/80 font-medium">
                                                View
                                            </a>
                                            @if(in_array($order->status, ['pending', 'confirmed', 'processing']))
                                                <form method="POST" action="{{ route('seller.orders.update-status', $order) }}" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="{{ $order->status === 'pending' ? 'confirmed' : ($order->status === 'confirmed' ? 'processing' : 'shipped') }}">
                                                    <button type="submit" class="text-jade-green hover:text-jade-green/80 font-medium" onclick="return confirm('Update order status?')">
                                                        {{ $order->status === 'pending' ? 'Confirm' : ($order->status === 'confirmed' ? 'Process' : 'Ship') }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-light-sage border-t border-pastel-green">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">📦</div>
                    <h3 class="text-xl font-semibold text-soft-brown mb-2">No orders found</h3>
                    <p class="text-soft-brown opacity-75">You don't have any orders matching your criteria.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
