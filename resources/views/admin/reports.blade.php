@extends('layouts.admin')

@section('title', 'Reports & Analytics - Admin')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 font-playfair">Reports & Analytics</h1>
        <p class="text-gray-600 mt-2">Generate insights and reports for your business</p>
    </div>

        <!-- Report Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
            <!-- Sales Report -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition cursor-pointer" onclick="window.location.href='{{ route('admin.reports.sales') }}'">
                <div class="flex items-center mb-6">
                    <div class="p-3 bg-jade-green rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-soft-brown ml-4">Sales Report</h3>
                </div>
                <p class="text-soft-brown opacity-75 mb-4">Analyze sales performance, revenue trends, and top-selling products</p>
                <div class="flex items-center text-jade-green font-semibold">
                    <span>Generate Report</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Inventory Report -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition cursor-pointer" onclick="window.location.href='{{ route('admin.reports.inventory') }}'">
                <div class="flex items-center mb-6">
                    <div class="p-3 bg-warm-peach rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-soft-brown ml-4">Inventory Report</h3>
                </div>
                <p class="text-soft-brown opacity-75 mb-4">Monitor stock levels, low stock alerts, and inventory movements</p>
                <div class="flex items-center text-jade-green font-semibold">
                    <span>Generate Report</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Customer Report -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition cursor-pointer" onclick="window.location.href='{{ route('admin.skin-trends') }}'">
                <div class="flex items-center mb-6">
                    <div class="p-3 bg-blush-pink rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-soft-brown ml-4">Skin Trends Report</h3>
                </div>
                <p class="text-soft-brown opacity-75 mb-4">Platform-wide skin type distribution, concerns, and ingredient usage patterns</p>
                <div class="flex items-center text-jade-green font-semibold">
                    <span>View Trends</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Forum Review -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition cursor-pointer" onclick="window.location.href='{{ route('admin.forum-moderation') }}'">
                <div class="flex items-center mb-6">
                    <div class="p-3 bg-jade-green rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M9 16h6M7 8h10a2 2 0 012 2v8a2 2 0 01-2 2H7a2 2 0 01-2-2V10a2 2 0 012-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-soft-brown ml-4">Forum Review</h3>
                </div>
                <p class="text-soft-brown opacity-75 mb-4">Monitor forum discussions, remove inappropriate content, and warn users.</p>
                <div class="flex items-center text-jade-green font-semibold">
                    <span>Go to Forum Moderation</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Seller Performance -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition cursor-pointer" onclick="window.location.href='{{ route('admin.seller-performance') }}'">
                <div class="flex items-center mb-6">
                    <div class="p-3 bg-pastel-green rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-soft-brown ml-4">Seller Performance</h3>
                </div>
                <p class="text-soft-brown opacity-75 mb-4">Seller rankings, performance metrics, and compliance reports</p>
                <div class="flex items-center text-jade-green font-semibold">
                    <span>View Performance</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Skin Trends Insights -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition cursor-pointer" onclick="window.location.href='{{ route('admin.skin-trends') }}'">
                <div class="flex items-center mb-6">
                    <div class="p-3 bg-light-sage rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-soft-brown ml-4">Skin Trends</h3>
                </div>
                <p class="text-soft-brown opacity-75 mb-4">Skin type analysis, concern trends, and product preferences</p>
                <div class="flex items-center text-jade-green font-semibold">
                    <span>View Trends</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6">Quick Overview</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-jade-green mb-2">
                        {{ App\Models\Order::where('status', '!=', 'cancelled')->count() }}
                    </div>
                    <div class="text-sm text-soft-brown opacity-75">Total Orders</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-jade-green mb-2">
                        ₱{{ number_format(App\Models\Order::where('status', '!=', 'cancelled')->sum('total_amount'), 0) }}
                    </div>
                    <div class="text-sm text-soft-brown opacity-75">Total Revenue</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-jade-green mb-2">
                        {{ App\Models\User::count() }}
                    </div>
                    <div class="text-sm text-soft-brown opacity-75">Total Customers</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-jade-green mb-2">
                        {{ App\Models\Product::count() }}
                    </div>
                    <div class="text-sm text-soft-brown opacity-75">Total Products</div>
                </div>
            </div>
        </div>
</div>
@endsection
