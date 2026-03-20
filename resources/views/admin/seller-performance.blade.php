@extends('layouts.app')

@section('title', 'Seller Performance - GlowTrack Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 font-playfair">Seller Performance Reports</h1>
                    <p class="text-gray-600 mt-2">Comprehensive seller analytics and performance metrics for your marketplace</p>
                </div>
                <div class="flex space-x-3">
                    <button onclick="exportSellerPerformance()" class="px-4 py-2 bg-jade-green text-white rounded-lg hover:bg-jade-green/80 transition">
                        📊 Export CSV
                    </button>
                    <button onclick="refreshAllData()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        🔄 Refresh Data
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Filters</h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Time Period</label>
                    <select id="periodFilter" onchange="updateFilters()" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-jade-green focus:border-jade-green">
                        <option value="7days">Last 7 Days</option>
                        <option value="30days" selected>Last 30 Days</option>
                        <option value="90days">Last 90 Days</option>
                        <option value="1year">Last Year</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Seller Status</label>
                    <select id="sellerStatusFilter" onchange="updateFilters()" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-jade-green focus:border-jade-green">
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Min Revenue ($)</label>
                    <input type="number" id="minRevenueFilter" onchange="updateFilters()" min="0" step="1000" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-jade-green focus:border-jade-green">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Min Orders</label>
                    <input type="number" id="minOrdersFilter" onchange="updateFilters()" min="0" step="5" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-jade-green focus:border-jade-green">
                </div>
                <div class="flex items-end">
                    <button onclick="resetFilters()" class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Reset Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Overview Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-2.828 2H4.72a2 2 0 00-2.828-2H17z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11.37A4 4 0 10 6.63 6.62l-1.42-1.42v-.006a2 2 0 00-2.828 0H4.72a2 2 0 00-2.828 0H17z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-2 3m0 0l-3 2m0 0l-3 2"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Sellers</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($overview['total_sellers']) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3.667V5a2 2 0 00-2.828-2H4.72a2 2 0 00-2.828 0H17z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2m0 0l2 2"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2m0 0l2 2"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Active Sellers</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($overview['active_sellers']) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3.667V5a2 2 0 00-2.828-2H4.72a2 2 0 00-2.828 0H17z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11.37A4 4 0 10 6.63 6.62l-1.42-1.42v-.006a2 2 0 00-2.828 0H17z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2m0 0l2 2"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($overview['total_revenue'], 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2m-2 0l2 2m-2 0l2 2"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1v1h1m1 4h-1v-1h-1"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 10v2a8 8 0 00-8-8v-2m0 0a8 8 0 00-8 8H12a8 8 0 00-8 8H4a8 8 0 00-8 8H4"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v8m0 0l8 8m-8 8H4"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Avg Revenue/Seller</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($overview['avg_revenue_per_seller'], 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-orange-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.29 3.34L15.21 8.42L15.21 15.21L21 15.21L10.29 3.34m0 6.36L4.68 15.25L15.21 8.42L15.21 15.21L4.68 15.25L10.29 3.34m0 6.36L4.68 15.25L15.21 8.42L15.21 15.21L4.68 15.25L10.29 3.34"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8s2 2-2 2v-2m0 0l-2 2m0 0l-2 2m2 2v2m0 0l-2 2"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Avg Fulfillment Rate</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($overview['avg_fulfillment_rate'], 1) }}%</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-pink-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.316 18.374a.532.532 0 01-.512.068m0 0a.532.532 0 01-.512.068m0 0a.532.532 0 01-.512.068m0 0a.532.532 0 01-.512.068m0 0a.532.532 0 01-.512.068M9.978 18.374a.532.532 0 01-.512.068m0 0a.532.532 0 01-.512.068m0 0a.532.532 0 01-.512.068"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.978 18.374a.532.532 0 01-.512.068m0 0a.532.532 0 01-.512.068"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.978 18.374a.532.532 0 01-.512.068"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Avg Satisfaction Score</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($overview['avg_satisfaction_score'], 1) }}/5.0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Top Performers -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Performing Sellers</h3>
                <div id="topPerformersChart" class="h-80"></div>
                <div class="mt-4 overflow-y-auto max-h-96">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seller</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fulfillment</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                            </tr>
                        </thead>
                        <tbody id="topPerformersTable">
                            <!-- Rows will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Revenue Analysis -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Revenue Analysis</h3>
                <div id="revenueChart" class="h-64 mb-4"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Revenue Distribution</h4>
                        <div id="revenueRanges" class="space-y-2">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="revenue-metrics-header">Monthly Revenue Trend</h4>
                        <div class="revenue-metrics-data">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row of Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Fulfillment Metrics -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Fulfillment Metrics</h3>
                <div id="fulfillmentChart" class="h-64 mb-4"></div>
                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Fulfillment Rate Distribution</h4>
                        <div id="fulfillmentDistribution">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Order Status Breakdown</h4>
                        <div id="orderStatusBreakdown">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Satisfaction Scores -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text_t-lg font-semibold text-gray-900 mb-4">Customer Satisfaction</h3>
                <div id="satisfactionChart" class="h-64 mb-4"></div>
                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Score Distribution</h4>
                        <div id="scoreDistribution">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Rating Breakdown</h4>
                        <div id="ratingBreakdown">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Growth Trends -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Growth Trends</h3>
                <div id="growthChart" class="h-64 mb-4"></div>
                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Monthly New Sellers</h4>
                        <div id="newSellersTrend">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Revenue Growth</h4>
                        <div class="revenue-growth-data">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Performance -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Performance</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Top Products -->
                <div class="space-y-4">
                    <h4 class="text-md font-semibold text-gray-900">Top Performing Products</h4>
                    <div id="topProductsChart" class="h-64"></div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seller</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                </tr>
                            </thead>
                            <tbody id="topProductsTable">
                                <!-- Rows will be populated by JavaScript -->
                            </tbody>
                            </table>
                        </div>
                    </div>

                <!-- Category Performance -->
                <div class="space-y-4">
                    <h4 class="text-md font-semibold text-gray-900">Category Performance</h4>
                    <div id="categoryChart" class="h-64"></div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Revenue</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Orders</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Rating</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                                </tr>
                            </thead>
                            <tbody id="categoryTable">
                                <!-- Rows will be populated by JavaScript -->
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Phase 4 Charts DISABLED for performance -->
@if(false)
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script src="{{ asset('js/seller-performance-charts.js') }}"></script>
@endif
<script>
// Phase 4 Seller Performance - CHARTS DISABLED
// Charts have been disabled for better performance
// To re-enable: Change @if(false) to @if(true) above

document.addEventListener('DOMContentLoaded', function() {
    console.log('Phase 4 Seller Performance - Charts disabled for performance');
    
    // Show simple static data instead of charts
    const chartContainers = document.querySelectorAll('[id$="Chart"]');
    chartContainers.forEach(container => {
        container.innerHTML = '<div class="text-center text-gray-500 py-8">Charts disabled for performance</div>';
    });
});

// Simplified data refresh (no charts)
function refreshSellerData() {
    console.log('Data refresh - Charts disabled');
    showNotification('Data refreshed (charts disabled)', 'info');
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endsection
        if (data.download_url) {
            // Create download link
            const link = document.createElement('a');
            link.href = data.download_url;
            link.download = data.filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            // Show success message
            showNotification('Seller performance report exported successfully!', 'success');
        }
    })
    .catch(error => {
        console.error('Error exporting report:', error);
        showNotification('Error exporting report', 'error');
    });
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>

@php
function getSellerIcon($tier) {
    $icons = [
        'Platinum' => '👑',
        'Gold' => '🥇',
        'Silver' => '🥈',
        'Bronze' => '🥉',
        'Standard' => '⭐'
    ];
    
    return $icons[$tier] ?? '⭐';
}

function getPerformanceColor($score) {
    if ($score >= 90) return '#7EC8B3';
    if ($score >= 80) return '#F6C1CC';
    if ($score >= 70) return '#FFD6A5';
    if ($score >= 60) return '#A8D5C2';
    return '#6B4F4F';
}

function getFulfillmentColor($rate) {
    if ($rate >= 95) return '#10B981';
    if ($rate >= 90) return '#7EC8B3';
    if ($rate >= 85) return '#F6C1CC';
    if ($rate >= 80) return '#FFD6A5';
    if ($rate >= 75) return '#A8D5C2';
    return '#6B4F4F';
}
</script>
@endsection
