@extends('layouts.app')

@section('title', 'Seller Performance - GlowTrack Admin')
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 font-playfair">Seller Performance Reports</h1>
                    <p class="text-gray-600 mt-2">Comprehensive seller analytics and performance metrics for your marketplace</p>
                    <div class="mt-2 text-sm text-green-600 font-semibold">🎨 Enhanced Charts v2.0 - New Visual Design Active</div>
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
    
    // Add visual indicator that new version is loaded
    document.body.style.borderTop = '4px solid #10B981';
    
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
                                return 'Revenue: $' + context.parsed.y.toLocaleString();
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
                                return '$' + (value / 1000) + 'k';
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
                                return 'Revenue: $' + context.parsed.y.toLocaleString();
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
                                return '$' + (value / 1000) + 'k';
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
                                return 'Revenue: $' + context.parsed.x.toLocaleString();
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
                                return '$' + (value / 1000) + 'k';
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
                                    label + ': $' + value.toLocaleString(),
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
    if (charts.topPerformers) {
        charts.topPerformers.data.labels = ['Seller A', 'Seller B', 'Seller C', 'Seller D', 'Seller E'];
        charts.topPerformers.data.datasets[0].data = [15000, 12000, 8000, 6000, 4000];
        charts.topPerformers.update();
    }

    // Revenue Chart
    if (charts.revenue) {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        charts.revenue.data.labels = months;
        charts.revenue.data.datasets[0].data = [45000, 52000, 48000, 61000, 58000, 67000];
        charts.revenue.update();
    }

    // Fulfillment Chart
    if (charts.fulfillment) {
        charts.fulfillment.data.datasets[0].data = [75, 15, 7, 3];
        charts.fulfillment.update();
    }

    // Satisfaction Chart
    if (charts.satisfaction) {
        charts.satisfaction.data.datasets[0].data = [4.2, 4.5, 3.8, 4.1, 4.3];
        charts.satisfaction.update();
    }

    // Growth Chart
    if (charts.growth) {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        charts.growth.data.labels = months;
        charts.growth.data.datasets[0].data = [5, 8, 12, 7, 15, 10];
        charts.growth.update();
    }

    // Top Products
    if (charts.topProducts) {
        charts.topProducts.data.labels = ['Product A', 'Product B', 'Product C', 'Product D', 'Product E'];
        charts.topProducts.data.datasets[0].data = [8500, 7200, 5400, 3100, 2100];
        charts.topProducts.update();
    }

    // Category Chart
    if (charts.category) {
        charts.category.data.labels = ['Skincare', 'Makeup', 'Hair Care', 'Body Care', 'Fragrance', 'Tools'];
        charts.category.data.datasets[0].data = [35000, 28000, 22000, 18000, 12000, 8000];
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
