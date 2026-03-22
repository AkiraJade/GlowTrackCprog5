@extends('layouts.admin')

@section('title', 'Admin Dashboard - GlowTrack')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 font-playfair">Dashboard</h1>
        <p class="text-gray-600 mt-2">Manage your GlowTrack skincare platform</p>
    </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition cursor-pointer border border-gray-200" onclick="window.location.href='{{ route('admin.users') }}'">
                <div class="flex items-center">
                    <div class="p-3 bg-jade-green rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition cursor-pointer border border-gray-200" onclick="window.location.href='{{ route('admin.products') }}'">
                <div class="flex items-center">
                    <div class="p-3 bg-warm-peach rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Products</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
                        @if($stats['pending_products'] > 0)
                            <p class="text-xs text-yellow-600">{{ $stats['pending_products'] }} pending</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition cursor-pointer border border-gray-200" onclick="window.location.href='{{ route('admin.orders') }}'">
                <div class="flex items-center">
                    <div class="p-3 bg-blush-pink rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Orders</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                        @if($stats['pending_orders'] > 0)
                            <p class="text-xs text-yellow-600">{{ $stats['pending_orders'] }} pending</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition cursor-pointer border border-gray-200" onclick="window.location.href='{{ route('admin.reports') }}'">
                <div class="flex items-center">
                    <div class="p-3 bg-jade-green rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Revenue</p>
                        <p class="text-2xl font-bold text-gray-900">₱{{ number_format($stats['total_revenue'], 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Overview Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            
            <!-- Recent Orders -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 font-playfair">Recent Orders</h2>
                    <a href="{{ route('admin.orders') }}" class="text-jade-green hover:text-jade-green/90 transition font-semibold text-sm">View All</a>
                </div>
                
                @if($recentOrders->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentOrders as $order)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-semibold text-gray-900">#{{ $order->order_id }}</span>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                           ($order->status === 'confirmed' ? 'bg-blue-100 text-blue-800' :
                                           ($order->status === 'processing' ? 'bg-purple-100 text-purple-800' :
                                           ($order->status === 'shipped' ? 'bg-indigo-100 text-indigo-800' :
                                           ($order->status === 'delivered' ? 'bg-green-100 text-green-800' :
                                           ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' :
                                           'bg-gray-100 text-gray-800'))))) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">{{ $order->user->name }}</span>
                                    <span class="font-bold text-jade-green">₱{{ number_format($order->total_amount, 2) }}</span>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ $order->created_at->format('M d, Y H:i') }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">No orders yet</p>
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <h2 class="text-xl font-bold text-gray-900 font-playfair mb-6">Quick Actions</h2>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.products') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 hover:bg-gray-100 hover:shadow-md transition border border-gray-200">
                        <span class="text-2xl">📦</span>
                        <div>
                            <p class="font-semibold text-gray-900">Manage Products</p>
                            <p class="text-xs text-gray-600">Approve/reject listings</p>
                        </div>
                    </a>

                    <a href="{{ route('products.import') }}" class="flex items-center gap-3 p-3 rounded-lg bg-blue-50 hover:bg-blue-100 hover:shadow-md transition border border-blue-200">
                        <span class="text-2xl">📥</span>
                        <div>
                            <p class="font-semibold text-gray-900">Import Products</p>
                            <p class="text-xs text-gray-600">Bulk import from Excel</p>
                        </div>
                    </a>

                    <a href="{{ route('products.export') }}" class="flex items-center gap-3 p-3 rounded-lg bg-purple-50 hover:bg-purple-100 hover:shadow-md transition border border-purple-200">
                        <span class="text-2xl">📤</span>
                        <div>
                            <p class="font-semibold text-gray-900">Export Products</p>
                            <p class="text-xs text-gray-600">Download Excel data</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.orders') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 hover:bg-gray-100 hover:shadow-md transition border border-gray-200">
                        <span class="text-2xl">🛒</span>
                        <div>
                            <p class="font-semibold text-gray-900">Manage Orders</p>
                            <p class="text-xs text-gray-600">Update order status</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.users') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 hover:bg-gray-100 hover:shadow-md transition border border-gray-200">
                        <span class="text-2xl">👥</span>
                        <div>
                            <p class="font-semibold text-gray-900">Manage Users</p>
                            <p class="text-xs text-gray-600">Roles & permissions</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 p-3 rounded-lg bg-jade-green hover:bg-jade-green/80 hover:shadow-md transition text-white">
                        <span class="text-2xl">📊</span>
                        <div>
                            <p class="font-semibold">View Reports</p>
                            <p class="text-xs opacity-80">Sales & analytics</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.charts') }}" class="flex items-center gap-3 p-3 rounded-lg bg-indigo-500 hover:bg-indigo-600 hover:shadow-md transition text-white">
                        <span class="text-2xl">📈</span>
                        <div>
                            <p class="font-semibold">Analytics & Charts</p>
                            <p class="text-xs opacity-80">View detailed analytics</p>
                        </div>
                    </a>

                    @if($stats['pending_seller_applications'] > 0)
                    <a href="{{ route('admin.seller-applications') }}" class="flex items-center gap-3 p-3 rounded-lg bg-yellow-500 hover:bg-yellow-600 hover:shadow-md transition text-white">
                        <span class="text-2xl">⚠️</span>
                        <div>
                            <p class="font-semibold">Seller Applications</p>
                            <p class="text-xs opacity-80">{{ $stats['pending_seller_applications'] }} pending</p>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pending Products & Recent Users -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Pending Products -->
            @if($pendingProducts->count() > 0)
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 font-playfair">Pending Products</h2>
                    <a href="{{ route('admin.products') }}" class="text-jade-green hover:text-jade-green/90 transition font-semibold text-sm">View All</a>
                </div>
                
                <div class="space-y-4">
                    @foreach($pendingProducts as $product)
                        <div class="border border-yellow-200 rounded-lg p-4 hover:shadow-md transition bg-yellow-50">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-semibold text-gray-900">{{ $product->name }}</span>
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                    Pending Review
                                </span>
                            </div>
                            <div class="text-sm text-gray-600">
                                Seller: {{ $product->seller->name }}
                            </div>
                            <div class="text-sm text-gray-600">
                                Price: ₱{{ number_format($product->price, 2) }}
                            </div>
                            <div class="mt-3 flex gap-2">
                                <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-green-500 text-white text-xs rounded-full hover:bg-green-600 transition">
                                        Approve
                                    </button>
                                </form>
                                <button onclick="showRejectForm({{ $product->id }})" class="px-3 py-1 bg-red-500 text-white text-xs rounded-full hover:bg-red-600 transition">
                                    Reject
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Recent Users -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 font-playfair">Recent Users</h2>
                    <a href="{{ route('admin.users') }}" class="text-jade-green hover:text-jade-green/90 transition font-semibold text-sm">View All</a>
                </div>
                
                <div class="space-y-4">
                    @foreach($recentUsers as $user)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-semibold text-gray-900">{{ $user->name }}</span>
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                                       ($user->role === 'seller' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-600">{{ $user->email }}</div>
                            <div class="text-xs text-gray-500 mt-1">Joined {{ $user->created_at->format('M d, Y') }}</div>
                            <div class="mt-3">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-jade-green hover:text-jade-green/90 transition font-semibold text-sm">
                                    View Details →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
