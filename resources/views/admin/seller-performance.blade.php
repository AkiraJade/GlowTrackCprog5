@extends('layouts.admin')

@section('title', 'Seller Performance - GlowTrack Admin')

@section('content')
<div class="py-6 sm:py-8">
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
                        <option value="all" selected>All Time</option>
                        <option value="7days">Last 7 Days</option>
                        <option value="30days">Last 30 Days</option>
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
            <!-- Card 1 -->
            <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100 flex flex-col gap-3 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-purple-50 rounded-lg text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">Total Sellers</p>
                </div>
                <p class="text-2xl font-bold text-gray-900 truncate">{{ number_format($overview['total_sellers']) }}</p>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100 flex flex-col gap-3 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-green-50 rounded-lg text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">Active Sellers</p>
                </div>
                <p class="text-2xl font-bold text-gray-900 truncate">{{ number_format($overview['active_sellers']) }}</p>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100 flex flex-col gap-3 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">Total Revenue</p>
                </div>
                <p class="text-2xl font-bold text-gray-900 truncate" title="₱{{ number_format($overview['total_revenue'], 2) }}">₱{{ number_format($overview['total_revenue'], 2) }}</p>
            </div>

            <!-- Card 4 -->
            <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100 flex flex-col gap-3 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-yellow-50 rounded-lg text-yellow-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">Avg Rev/Seller</p>
                </div>
                <p class="text-2xl font-bold text-gray-900 truncate" title="₱{{ number_format($overview['avg_revenue_per_seller'], 2) }}">₱{{ number_format($overview['avg_revenue_per_seller'], 2) }}</p>
            </div>

            <!-- Card 5 -->
            <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100 flex flex-col gap-3 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-orange-50 rounded-lg text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">Avg Fulfill Rate</p>
                </div>
                <p class="text-2xl font-bold text-gray-900 truncate">{{ number_format($overview['avg_fulfillment_rate'], 1) }}%</p>
            </div>

            <!-- Card 6 -->
            <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100 flex flex-col gap-3 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-pink-50 rounded-lg text-pink-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">Avg Score</p>
                </div>
                <p class="text-2xl font-bold text-gray-900 truncate">{{ number_format($overview['avg_satisfaction_score'], 1) }}/5.0</p>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Top Performers -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Performing Sellers</h3>
                <div class="h-80 relative w-full"><canvas id="topPerformersChart"></canvas></div>
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
                                @foreach($topPerformers as $performer)
                                <tr class="border-b border-gray-100">
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $performer['seller']->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">₱{{ number_format($performer['revenue'], 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $performer['orders'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ number_format($performer['fulfillment_rate'], 1) }}%</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ number_format($performer['satisfaction_score'], 1) }} ★</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-jade-green">{{ number_format($performer['performance_score'], 1) }}</td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Revenue Analysis -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Revenue Analysis</h3>
                <div class="h-64 mb-4 relative w-full"><canvas id="revenueChart"></canvas></div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Revenue Distribution</h4>
                        <div id="revenueRanges" class="space-y-2">
                        @foreach($revenueAnalysis['revenue_ranges'] as $range => $count)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">₱{{ str_replace('-', ' - ₱', $range) }}</span>
                                <span class="font-medium text-gray-900">{{ $count }} sellers</span>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Monthly Revenue Trend</h4>
                        <div class="space-y-2 overflow-y-auto max-h-48 pr-2">
                        @foreach($revenueAnalysis['monthly_trends'] as $month => $revenue)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ \Carbon\Carbon::parse($month)->format('M Y') }}</span>
                                <span class="font-medium text-gray-900">₱{{ number_format($revenue, 2) }}</span>
                            </div>
                        @endforeach
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
                <div class="h-64 mb-4 relative w-full"><canvas id="fulfillmentChart"></canvas></div>
                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Fulfillment Rate Distribution</h4>
                        <div id="fulfillmentDistribution" class="space-y-2">
                            @foreach($fulfillmentMetrics['fulfillment_distribution'] as $range => $count)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">{{ $range }}%</span>
                                    <span class="font-medium text-gray-900">{{ $count }} sellers</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Order Status Breakdown</h4>
                        <div id="orderStatusBreakdown" class="space-y-2">
                        @foreach($fulfillmentMetrics['order_status_breakdown'] as $status => $count)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $status) }}</span>
                                <span class="font-medium text-gray-900">{{ $count }}</span>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Satisfaction Scores -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Satisfaction</h3>
                <div class="h-64 mb-4 relative w-full"><canvas id="satisfactionChart"></canvas></div>
                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Score Distribution</h4>
                        <div id="scoreDistribution" class="space-y-2">
                        @foreach($satisfactionScores['score_distribution'] as $range => $count)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ $range }} Stars</span>
                                <span class="font-medium text-gray-900">{{ $count }} sellers</span>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Rating Breakdown</h4>
                        <div id="ratingBreakdown" class="space-y-2">
                        @foreach($satisfactionScores['rating_breakdown'] as $rating => $count)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ $rating }} Stars</span>
                                <span class="font-medium text-gray-900">{{ $count }} reviews</span>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Growth Trends -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Growth Trends</h3>
                <div class="h-64 mb-4 relative w-full"><canvas id="growthChart"></canvas></div>
                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Monthly New Sellers</h4>
                        <div id="newSellersTrend" class="space-y-2 overflow-y-auto max-h-48 pr-2">
                        @foreach($growthTrends['new_sellers_trend'] as $month => $count)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ \Carbon\Carbon::parse($month)->format('M Y') }}</span>
                                <span class="font-medium text-gray-900">{{ $count }}</span>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Revenue Growth</h4>
                        <div class="revenue-growth-data space-y-2 overflow-y-auto max-h-48 pr-2">
                        @foreach($growthTrends['revenue_growth_trend'] as $month => $revenue)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ \Carbon\Carbon::parse($month)->format('M Y') }}</span>
                                <span class="font-medium text-gray-900">₱{{ number_format($revenue, 2) }}</span>
                            </div>
                        @endforeach
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
                    <div class="h-64 relative w-full"><canvas id="topProductsChart"></canvas></div>
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
                                @foreach($productPerformance['top_products'] as $item)
                                <tr class="border-b border-gray-100">
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $item['product']->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $item['seller']->name }}</td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">₱{{ number_format($item['revenue'], 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $item['orders'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ number_format($item['rating'], 1) }} ★</td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                    </div>

                <!-- Category Performance -->
                <div class="space-y-4">
                    <h4 class="text-md font-semibold text-gray-900">Category Performance</h4>
                    <div class="h-64 relative w-full"><canvas id="categoryChart"></canvas></div>
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
                                @foreach(collect($productPerformance['category_performance'])->sortByDesc('revenue') as $category => $data)
                                <tr class="border-b border-gray-100">
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $category }}</td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">₱{{ number_format($data['revenue'] / max(1, $data['products']), 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ number_format($data['orders'] / max(1, $data['products']), 1) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">-</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $loop->iteration }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Phase 4 Charts ENABLED -->
@if(true)
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
@endif
<script>
// Phase 4 Seller Performance - Charts Implementation v2.0

console.log('🎨 NEW CHART VERSION LOADED - Enhanced Visual Design v2.0');

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Phase 4 Seller Performance - Initializing enhanced charts v2.0');
    

    
    // Initialize all charts
    initializeCharts();
    
    // Load initial data
    loadChartData();
});

let charts = {};

function initializeCharts() {
    console.log('🎨 Initializing enhanced charts with new visual design...');
    
    // Verify Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('❌ Chart.js not loaded!');
        return;
    }
    
    console.log('✅ Chart.js loaded successfully:', Chart.version);
    
    // Set default Chart.js options for better visuals
    Chart.defaults.font.family = "'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
    Chart.defaults.color = '#374151';
    Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(0, 0, 0, 0.8)';
    Chart.defaults.plugins.tooltip.titleFont = { size: 14, weight: 'bold' };
    Chart.defaults.plugins.tooltip.bodyFont = { size: 12 };
    Chart.defaults.plugins.tooltip.padding = 12;
    Chart.defaults.plugins.tooltip.cornerRadius = 8;
    Chart.defaults.plugins.legend.labels.usePointStyle = true;
    Chart.defaults.plugins.legend.labels.padding = 20;

    // Top Performers Chart (Bar Chart)
    const topPerformersCtx = document.getElementById('topPerformersChart');
    if (topPerformersCtx) {
        charts.topPerformers = new Chart(topPerformersCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Revenue ($)',
                    data: [],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.9)',
                        'rgba(59, 130, 246, 0.9)',
                        'rgba(251, 146, 60, 0.9)',
                        'rgba(244, 63, 94, 0.9)',
                        'rgba(147, 51, 234, 0.9)'
                    ],
                    borderColor: [
                        'rgb(16, 185, 129)',
                        'rgb(59, 130, 246)',
                        'rgb(251, 146, 60)',
                        'rgb(244, 63, 94)',
                        'rgb(147, 51, 234)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Revenue: ₱' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(156, 163, 175, 0.1)',
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value) {
                                return '₱' + (value / 1000) + 'k';
                            },
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11,
                                weight: '500'
                            }
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }

    // Revenue Chart (Line Chart)
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        charts.revenue = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Monthly Revenue',
                    data: [],
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(16, 185, 129)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Revenue: ₱' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(156, 163, 175, 0.1)',
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value) {
                                return '₱' + (value / 1000) + 'k';
                            },
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11,
                                weight: '500'
                            }
                        }
                    }
                },
                animation: {
                    duration: 1500,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }

    // Fulfillment Chart (Doughnut Chart)
    const fulfillmentCtx = document.getElementById('fulfillmentChart');
    if (fulfillmentCtx) {
        charts.fulfillment = new Chart(fulfillmentCtx, {
            type: 'doughnut',
            data: {
                labels: ['Delivered', 'Processing', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [0, 0, 0, 0],
                    backgroundColor: [
                        'rgb(16, 185, 129)',
                        'rgb(59, 130, 246)',
                        'rgb(251, 191, 36)',
                        'rgb(239, 68, 68)'
                    ],
                    borderColor: '#fff',
                    borderWidth: 3,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + percentage + '%';
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1200,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }

    // Satisfaction Chart (Radar Chart)
    const satisfactionCtx = document.getElementById('satisfactionChart');
    if (satisfactionCtx) {
        charts.satisfaction = new Chart(satisfactionCtx, {
            type: 'radar',
            data: {
                labels: ['Quality', 'Communication', 'Shipping', 'Value', 'Overall'],
                datasets: [{
                    label: 'Average Rating',
                    data: [0, 0, 0, 0, 0],
                    borderColor: 'rgb(251, 146, 60)',
                    backgroundColor: 'rgba(251, 146, 60, 0.2)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgb(251, 146, 60)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 5,
                        min: 0,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 10
                            }
                        },
                        grid: {
                            color: 'rgba(156, 163, 175, 0.1)'
                        },
                        pointLabels: {
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    }
                },
                animation: {
                    duration: 1400,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }

    // Growth Chart (Area Chart)
    const growthCtx = document.getElementById('growthChart');
    if (growthCtx) {
        charts.growth = new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'New Sellers',
                    data: [],
                    borderColor: 'rgb(147, 51, 234)',
                    backgroundColor: 'rgba(147, 51, 234, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(147, 51, 234)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(156, 163, 175, 0.1)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11,
                                weight: '500'
                            }
                        }
                    }
                },
                animation: {
                    duration: 1300,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }

    // Top Products Chart (Horizontal Bar)
    const topProductsCtx = document.getElementById('topProductsChart');
    if (topProductsCtx) {
        charts.topProducts = new Chart(topProductsCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Revenue ($)',
                    data: [],
                    backgroundColor: [
                        'rgba(244, 63, 94, 0.9)',
                        'rgba(236, 72, 153, 0.9)',
                        'rgba(219, 39, 119, 0.9)',
                        'rgba(190, 24, 93, 0.9)',
                        'rgba(157, 23, 77, 0.9)'
                    ],
                    borderColor: [
                        'rgb(244, 63, 94)',
                        'rgb(236, 72, 153)',
                        'rgb(219, 39, 119)',
                        'rgb(190, 24, 93)',
                        'rgb(157, 23, 77)'
                    ],
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Revenue: ₱' + context.parsed.x.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(156, 163, 175, 0.1)',
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value) {
                                return '₱' + (value / 1000) + 'k';
                            },
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11,
                                weight: '500'
                            }
                        }
                    }
                },
                animation: {
                    duration: 1100,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }

    // Category Chart (Pie Chart) - ENHANCED VISUAL DESIGN
    const categoryCtx = document.getElementById('categoryChart');
    if (categoryCtx) {
        charts.category = new Chart(categoryCtx, {
            type: 'pie',
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: [
                        'rgb(16, 185, 129)',
                        'rgb(59, 130, 246)',
                        'rgb(251, 146, 60)',
                        'rgb(244, 63, 94)',
                        'rgb(147, 51, 234)',
                        'rgb(251, 191, 36)'
                    ],
                    borderColor: '#fff',
                    borderWidth: 3,
                    hoverOffset: 12,
                    hoverBorderWidth: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.9)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#fff',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return [
                                    label + ': ₱' + value.toLocaleString(),
                                    'Share: ' + percentage + '%'
                                ];
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1500,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }
}

function loadChartData() {
    // Load sample data for demonstration
    updateChartsWithSampleData();
}

function updateChartsWithSampleData() {
    // Top Performers
    const topPerformers = {!! \Illuminate\Support\Js::from(collect($topPerformers)->map(fn($p) => ['name' => $p['seller']->name, 'revenue' => $p['revenue']])->values()) !!};
    if (charts.topPerformers) {
        charts.topPerformers.data.labels = topPerformers.map(p => p.name);
        charts.topPerformers.data.datasets[0].data = topPerformers.map(p => p.revenue);
        charts.topPerformers.update();
    }

    // Revenue Chart
    const revenueTrends = {!! \Illuminate\Support\Js::from($revenueAnalysis['monthly_trends']) !!};
    if (charts.revenue) {
        charts.revenue.data.labels = Object.keys(revenueTrends).map(m => {
            const date = new Date(m);
            return date.toLocaleDateString('en-US', {month: 'short', year: 'numeric'});
        });
        charts.revenue.data.datasets[0].data = Object.values(revenueTrends);
        charts.revenue.update();
    }

    // Fulfillment Chart
    const fulfillmentStatuses = {!! \Illuminate\Support\Js::from($fulfillmentMetrics['order_status_breakdown']) !!};
    if (charts.fulfillment) {
        charts.fulfillment.data.datasets[0].data = [
            fulfillmentStatuses.delivered || 0,
            fulfillmentStatuses.processing || 0,
            fulfillmentStatuses.pending || 0,
            fulfillmentStatuses.cancelled || 0
        ];
        charts.fulfillment.update();
    }

    // Satisfaction Chart
    const scores = {!! \Illuminate\Support\Js::from($overview) !!};
    if (charts.satisfaction) {
        charts.satisfaction.data.datasets[0].data = [
            scores.avg_satisfaction_score || 0,
            scores.avg_satisfaction_score || 0,
            scores.avg_satisfaction_score || 0,
            scores.avg_satisfaction_score || 0,
            scores.avg_satisfaction_score || 0
        ];
        charts.satisfaction.update();
    }

    // Growth Chart
    const growthTrends = {!! \Illuminate\Support\Js::from($growthTrends['new_sellers_trend']) !!};
    if (charts.growth) {
        charts.growth.data.labels = Object.keys(growthTrends).map(m => {
            const date = new Date(m);
            return date.toLocaleDateString('en-US', {month: 'short', year: 'numeric'});
        });
        charts.growth.data.datasets[0].data = Object.values(growthTrends);
        charts.growth.update();
    }

    // Top Products
    const topProducts = {!! \Illuminate\Support\Js::from(collect($productPerformance['top_products'])->map(fn($p) => ['name' => \Illuminate\Support\Str::limit($p['product']->name, 15), 'revenue' => $p['revenue']])->values()) !!};
    if (charts.topProducts) {
        charts.topProducts.data.labels = topProducts.map(p => p.name);
        charts.topProducts.data.datasets[0].data = topProducts.map(p => p.revenue);
        charts.topProducts.update();
    }

    // Category Chart
    const categoryPerf = {!! \Illuminate\Support\Js::from(collect($productPerformance['category_performance'])->map(fn($c, $k) => ['name' => $k, 'revenue' => $c['revenue']])->values()) !!};
    if (charts.category) {
        charts.category.data.labels = categoryPerf.map(c => c.name);
        charts.category.data.datasets[0].data = categoryPerf.map(c => c.revenue);
        charts.category.update();
    }
}

function updateFilters() {
    console.log('Updating filters and refreshing charts');
    loadChartData();
    showNotification('Charts updated with new filters', 'success');
}

function resetFilters() {
    document.getElementById('periodFilter').value = '30days';
    document.getElementById('sellerStatusFilter').value = 'all';
    document.getElementById('minRevenueFilter').value = '';
    document.getElementById('minOrdersFilter').value = '';
    updateFilters();
}

function refreshAllData() {
    console.log('Refreshing all chart data');
    loadChartData();
    showNotification('All charts refreshed successfully', 'success');
}

function refreshSellerData() {
    loadChartData();
    showNotification('Seller performance data refreshed', 'success');
}

function exportSellerPerformance() {
    fetch('/admin/seller-performance/export-csv', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            period: document.getElementById('periodFilter').value,
            seller_status: document.getElementById('sellerStatusFilter').value,
            min_revenue: document.getElementById('minRevenueFilter').value || 0,
            min_orders: document.getElementById('minOrdersFilter').value || 0
        })
    })
    .then(response => response.json())
    .then(data => {
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
@endpush

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
@endphp
