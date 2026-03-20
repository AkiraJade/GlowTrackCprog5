@extends('layouts.admin')

@section('title', 'Sales Report - Admin')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 font-playfair">Sales Report</h1>
                <p class="text-gray-600 mt-2">Detailed sales analytics and insights</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.reports') }}" class="px-6 py-2 border-2 border-admin-primary text-admin-primary rounded-full hover:bg-admin-primary hover:text-white transition font-semibold">
                    ← Back to Reports
                </a>
                <button onclick="window.print()" class="px-6 py-2 bg-admin-primary text-white rounded-full hover:bg-admin-primary/80 transition font-semibold">
                    🖨️ Print Report
                </button>
            </div>
        </div>

        <!-- Date Filter Form -->
        <form method="GET" action="{{ route('admin.reports.sales') }}" class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex flex-wrap gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-soft-brown mb-2">Start Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" 
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green">
                </div>
                <div>
                    <label class="block text-sm font-medium text-soft-brown mb-2">End Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" 
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green">
                </div>
                <button type="submit" class="px-6 py-2 bg-jade-green text-white rounded-lg hover:bg-jade-green-600 transition">
                    Generate Report
                </button>
            </div>
        </form>

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-jade-green rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-soft-brown ml-4">Total Revenue</h3>
                </div>
                <div class="text-3xl font-bold text-jade-green mb-2">
                    ${{ number_format($totalRevenue, 2) }}
                </div>
                <p class="text-sm text-soft-brown opacity-75">{{ $startDate }} to {{ $endDate }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-warm-peach rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-soft-brown ml-4">Total Orders</h3>
                </div>
                <div class="text-3xl font-bold text-jade-green mb-2">
                    {{ $totalOrders }}
                </div>
                <p class="text-sm text-soft-brown opacity-75">Completed orders</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-blush-pink rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-soft-brown ml-4">Average Order Value</h3>
                </div>
                <div class="text-3xl font-bold text-jade-green mb-2">
                    ${{ number_format($averageOrderValue, 2) }}
                </div>
                <p class="text-sm text-soft-brown opacity-75">Per order average</p>
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6">Top Selling Products</h2>
            
            @if($topProducts->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Units Sold</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seller</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($topProducts as $topProduct)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $topProduct->product->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $topProduct->product->brand }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $topProduct->total_sold }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($topProduct->total_revenue, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $topProduct->product->seller->name }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-soft-brown opacity-75">No sales data available for the selected period</p>
                </div>
            @endif
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6">Recent Orders</h2>
            
            @if($orders->count() > 0)
                <div class="space-y-4">
                    @foreach($orders->take(10) as $order)
                        <div class="border border-gray-200 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-semibold text-soft-brown">#{{ $order->order_id }}</span>
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-soft-brown opacity-75">{{ $order->user->name }}</span>
                                <span class="font-bold text-jade-green">${{ number_format($order->total_amount, 2) }}</span>
                            </div>
                            <div class="text-xs text-soft-brown opacity-60 mt-1">{{ $order->created_at->format('M d, Y H:i') }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-soft-brown opacity-75">No orders found for the selected period</p>
                </div>
            @endif
        </div>
</div>
@endsection
