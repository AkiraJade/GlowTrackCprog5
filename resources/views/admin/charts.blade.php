@extends('layouts.admin')

@section('title', 'Analytics & Charts - GlowTrack Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 font-playfair">Analytics & Charts</h1>
                    <p class="text-gray-600 mt-2">Comprehensive analytics and data visualization for your marketplace</p>
                    <div class="mt-2 text-sm text-green-600 font-semibold">🎨 Enhanced Charts v2.0 - Modern Visual Design</div>
                </div>
                <div class="flex space-x-3">
                    <button onclick="refreshAllCharts()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        🔄 Refresh All
                    </button>
                </div>
            </div>
        </div>

        <!-- Chart Navigation Tabs -->
        <div class="bg-white rounded-lg shadow-sm mb-8">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <button onclick="switchTab('overview')" id="overview-tab" class="tab-button active py-4 px-1 border-b-2 border-jade-green font-medium text-sm text-jade-green">
                        📊 Overview
                    </button>
                    <button onclick="switchTab('sales')" id="sales-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        📈 Sales Analytics
                    </button>
                    <button onclick="switchTab('products')" id="products-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        📦 Products
                    </button>
                    <button onclick="switchTab('users')" id="users-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        👥 Users
                    </button>
                </nav>
            </div>
        </div>

        <!-- Overview Tab -->
        <div id="overview-panel" class="tab-panel">
            <!-- Dashboard Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Revenue</p>
                            <p class="text-3xl font-bold mt-2">₱{{ number_format($stats['total_revenue'], 2) }}</p>
                            <p class="text-blue-100 text-sm mt-2">Monthly: ₱{{ number_format($stats['monthly_revenue'], 2) }}</p>
                        </div>
                        <div class="bg-blue-400 bg-opacity-50 rounded-full p-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Total Orders</p>
                            <p class="text-3xl font-bold mt-2">{{ $stats['total_orders'] }}</p>
                            <p class="text-green-100 text-sm mt-2">Completed: {{ $stats['completed_orders'] }}</p>
                        </div>
                        <div class="bg-green-400 bg-opacity-50 rounded-full p-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Total Users</p>
                            <p class="text-3xl font-bold mt-2">{{ $stats['total_users'] }}</p>
                            <p class="text-purple-100 text-sm mt-2">Active sellers: {{ App\Models\User::where('role', 'seller')->count() }}</p>
                        </div>
                        <div class="bg-purple-400 bg-opacity-50 rounded-full p-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">Total Products</p>
                            <p class="text-3xl font-bold mt-2">{{ $stats['total_products'] }}</p>
                            <p class="text-orange-100 text-sm mt-2">Approved: {{ App\Models\Product::where('status', 'approved')->count() }}</p>
                        </div>
                        <div class="bg-orange-400 bg-opacity-50 rounded-full p-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Yearly Sales Chart -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Yearly Sales Overview</h3>
                    <select id="yearSelector" onchange="loadCharts()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-jade-green">
                        @for($year = 2023; $year <= date('Y'); $year++)
                            <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="h-96">
                    <canvas id="yearlySalesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Sales Analytics Tab -->
        <div id="sales-panel" class="tab-panel hidden">
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Sales by Date Range</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                            <input type="date" id="startDate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-jade-green">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                            <input type="date" id="endDate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-jade-green">
                        </div>
                        <div class="flex items-end">
                            <button onclick="updateDateRange()" class="w-full px-4 py-2 bg-jade-green text-white rounded-lg hover:bg-jade-green/80 transition">
                                Update Chart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="h-96">
                    <canvas id="dateRangeSalesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Products Tab -->
        <div id="products-panel" class="tab-panel hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Product Sales Pie Chart -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">🥧 Top Products by Sales</h3>
                    <div class="h-80">
                        <canvas id="productSalesPieChart"></canvas>
                    </div>
                </div>

                <!-- Category Distribution Doughnut Chart -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">🍩 Category Distribution</h3>
                    <div class="h-80">
                        <canvas id="categorySalesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Tab -->
        <div id="users-panel" class="tab-panel hidden">
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">User Registration Trends</h3>
                    <select id="periodSelector" onchange="loadCharts()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-jade-green">
                        <option value="daily">Last 30 Days</option>
                        <option value="weekly">Last 12 Weeks</option>
                        <option value="monthly" selected>Last 12 Months</option>
                    </select>
                </div>
                <div class="h-96">
                    <canvas id="userRegistrationChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
<script>
console.log('🎨 ENHANCED CHARTS v2.0 - Modern Visual Design Loaded');

// Enhanced Chart.js configuration
Chart.defaults.font.family = "'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
Chart.defaults.color = '#374151';
Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(0, 0, 0, 0.8)';
Chart.defaults.plugins.tooltip.titleFont = { size: 14, weight: 'bold' };
Chart.defaults.plugins.tooltip.bodyFont = { size: 12 };
Chart.defaults.plugins.tooltip.padding = 12;
Chart.defaults.plugins.tooltip.cornerRadius = 8;
Chart.defaults.plugins.legend.labels.usePointStyle = true;
Chart.defaults.plugins.legend.labels.padding = 20;

// Tab switching functionality
function switchTab(tabName) {
    // Hide all panels
    document.querySelectorAll('.tab-panel').forEach(panel => {
        panel.classList.add('hidden');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(tab => {
        tab.classList.remove('active', 'border-jade-green', 'text-jade-green');
        tab.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected panel
    document.getElementById(tabName + '-panel').classList.remove('hidden');
    
    // Add active class to selected tab
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.add('active', 'border-jade-green', 'text-jade-green');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
    
    console.log(`🔄 Switched to ${tabName} tab`);
}

// Yearly Sales Chart - Enhanced Design
const yearlySalesCtx = document.getElementById('yearlySalesChart');
const yearlySalesChart = new Chart(yearlySalesCtx, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [{
            label: 'Revenue (₱)',
            data: [],
            backgroundColor: [
                'rgba(16, 185, 129, 0.9)',
                'rgba(59, 130, 246, 0.9)',
                'rgba(251, 146, 60, 0.9)',
                'rgba(244, 63, 94, 0.9)',
                'rgba(147, 51, 234, 0.9)',
                'rgba(251, 191, 36, 0.9)',
                'rgba(236, 72, 153, 0.9)',
                'rgba(34, 197, 94, 0.9)',
                'rgba(168, 85, 247, 0.9)',
                'rgba(251, 146, 60, 0.9)',
                'rgba(244, 63, 94, 0.9)'
            ],
            borderColor: [
                'rgb(16, 185, 129)',
                'rgb(59, 130, 246)',
                'rgb(251, 146, 60)',
                'rgb(244, 63, 94)',
                'rgb(147, 51, 234)',
                'rgb(251, 191, 36)',
                'rgb(236, 72, 153)',
                'rgb(34, 197, 94)',
                'rgb(168, 85, 247)',
                'rgb(251, 146, 60)',
                'rgb(244, 63, 94)'
            ],
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
        }, {
            label: 'Orders',
            data: [],
            type: 'line',
            borderColor: 'rgb(251, 146, 60)',
            backgroundColor: 'rgba(251, 146, 60, 0.1)',
            borderWidth: 3,
            pointBackgroundColor: 'rgb(251, 146, 60)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 8,
            tension: 0.4,
            fill: true,
            yAxisID: 'y1'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 20,
                    font: {
                        size: 12,
                        weight: '500'
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || '';
                        if (label) {
                            label += ': ';
                        }
                        if (context.parsed.y !== null) {
                            if (context.dataset.yAxisID === 'y1') {
                                label += context.parsed.y + ' orders';
                            } else {
                                label += '₱' + context.parsed.y.toLocaleString();
                            }
                        }
                        return label;
                    }
                }
            }
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                title: {
                    display: true,
                    text: 'Revenue (₱)',
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                },
                grid: {
                    color: 'rgba(156, 163, 175, 0.1)',
                    drawBorder: false
                },
                ticks: {
                    callback: function(value) {
                        return '₱' + (value / 1000) + 'k';
                    }
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                title: {
                    display: true,
                    text: 'Number of Orders',
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                },
                grid: {
                    drawOnChartArea: false,
                },
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString();
                    }
                }
            },
            x: {
                grid: {
                    display: false,
                    drawBorder: false
                }
            }
        },
        animation: {
            duration: 1500,
            easing: 'easeInOutQuart'
        }
    }
});

// Date Range Sales Chart - Enhanced Design
const dateRangeSalesCtx = document.getElementById('dateRangeSalesChart');
const dateRangeSalesChart = new Chart(dateRangeSalesCtx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Revenue (₱)',
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
                title: {
                    display: true,
                    text: 'Revenue (₱)',
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                },
                grid: {
                    color: 'rgba(156, 163, 175, 0.1)',
                    drawBorder: false
                },
                ticks: {
                    callback: function(value) {
                        return '₱' + (value / 1000) + 'k';
                    }
                }
            },
            x: {
                grid: {
                    display: false,
                    drawBorder: false
                }
            }
        },
        animation: {
            duration: 1200,
            easing: 'easeInOutQuart'
        }
    }
});

// Product Sales Pie Chart - ENHANCED VISUAL DESIGN 🥧
const productSalesPieCtx = document.getElementById('productSalesPieChart');
const productSalesPieChart = new Chart(productSalesPieCtx, {
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
                'rgb(251, 191, 36)',
                'rgb(236, 72, 153)',
                'rgb(34, 197, 94)',
                'rgb(168, 85, 247)',
                'rgb(251, 146, 60)'
            ],
            borderColor: '#fff',
            borderWidth: 3,
            hoverOffset: 15,
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
                            `${label}: ₱${value.toLocaleString()}`,
                            `Share: ${percentage}%`
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

// Category Sales Doughnut Chart - ENHANCED VISUAL DESIGN 🍩
const categorySalesCtx = document.getElementById('categorySalesChart');
const categorySalesChart = new Chart(categorySalesCtx, {
    type: 'doughnut',
    data: {
        labels: [],
        datasets: [{
            data: [],
            backgroundColor: [
                'rgb(59, 130, 246)',
                'rgb(251, 146, 60)',
                'rgb(244, 63, 94)',
                'rgb(147, 51, 234)',
                'rgb(251, 191, 36)',
                'rgb(236, 72, 153)',
                'rgb(34, 197, 94)',
                'rgb(168, 85, 247)',
                'rgb(16, 185, 129)'
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
        cutout: '60%',
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
                            `${label}: ₱${value.toLocaleString()}`,
                            `Share: ${percentage}%`
                        ];
                    }
                }
            }
        },
        animation: {
            animateRotate: true,
            animateScale: true,
            duration: 1400,
            easing: 'easeInOutQuart'
        }
    }
});

// User Registration Chart - Enhanced Design
const userRegistrationCtx = document.getElementById('userRegistrationChart');
const userRegistrationChart = new Chart(userRegistrationCtx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'New Users',
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
                title: {
                    display: true,
                    text: 'Number of Users',
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                },
                grid: {
                    color: 'rgba(156, 163, 175, 0.1)',
                    drawBorder: false
                },
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString();
                    }
                }
            },
            x: {
                grid: {
                    display: false,
                    drawBorder: false
                }
            }
        },
        animation: {
            duration: 1300,
            easing: 'easeInOutQuart'
        }
    }
});

// Load initial data
function loadCharts() {
    console.log('🔄 Loading enhanced charts data...');
    
    // Load yearly sales
    const year = document.getElementById('yearSelector').value;
    fetch(`/admin/charts/yearly-sales?year=${year}`)
        .then(response => response.json())
        .then(data => {
            yearlySalesChart.data.labels = data.labels;
            yearlySalesChart.data.datasets[0].data = data.totals;
            yearlySalesChart.data.datasets[1].data = data.counts;
            yearlySalesChart.update();
            console.log('✅ Yearly sales chart updated');
        })
        .catch(error => console.error('❌ Error loading yearly sales:', error));

    // Load product sales percentage - ENHANCED PIE CHART
    fetch('/admin/charts/product-sales-percentage')
        .then(response => response.json())
        .then(data => {
            productSalesPieChart.data.labels = data.data.map(item => item.name);
            productSalesPieChart.data.datasets[0].data = data.data.map(item => item.sales);
            productSalesPieChart.data.datasets[0].percentage = data.data.map(item => item.percentage);
            productSalesPieChart.update();
            console.log('🥧 Product sales pie chart updated with enhanced design');
        })
        .catch(error => console.error('❌ Error loading product sales:', error));

    // Load category distribution - ENHANCED DOUGHNUT CHART
    fetch('/admin/charts/category-sales-distribution')
        .then(response => response.json())
        .then(data => {
            categorySalesChart.data.labels = data.data.map(item => item.category);
            categorySalesChart.data.datasets[0].data = data.data.map(item => item.sales);
            categorySalesChart.update();
            console.log('🍩 Category distribution doughnut chart updated with enhanced design');
        })
        .catch(error => console.error('❌ Error loading category distribution:', error));

    // Load user registration trends
    const period = document.getElementById('periodSelector').value;
    fetch(`/admin/charts/user-registration-trends?period=${period}`)
        .then(response => response.json())
        .then(data => {
            userRegistrationChart.data.labels = data.labels;
            userRegistrationChart.data.datasets[0].data = data.data;
            userRegistrationChart.update();
            console.log('👥 User registration chart updated');
        })
        .catch(error => console.error('❌ Error loading user registration:', error));
}

// Update date range function
function updateDateRange() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    if (startDate && endDate) {
        console.log(`📅 Updating date range: ${startDate} to ${endDate}`);
        fetch(`/admin/charts/date-range-sales?start_date=${startDate}&end_date=${endDate}`)
            .then(response => response.json())
            .then(data => {
                dateRangeSalesChart.data.labels = data.labels;
                dateRangeSalesChart.data.datasets[0].data = data.totals;
                dateRangeSalesChart.update();
                console.log('✅ Date range sales chart updated');
            })
            .catch(error => console.error('❌ Error updating date range:', error));
    }
}

// Refresh all charts
function refreshAllCharts() {
    console.log('🔄 Refreshing all charts...');
    loadCharts();
    
    // Visual feedback
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '⏳ Refreshing...';
    button.disabled = true;
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
        console.log('✅ All charts refreshed successfully');
    }, 2000);
}

// Set default date ranges (last 30 days)
const today = new Date();
const thirtyDaysAgo = new Date(today.getTime() - (30 * 24 * 60 * 60 * 1000));
document.getElementById('startDate').value = thirtyDaysAgo.toISOString().split('T')[0];
document.getElementById('endDate').value = today.toISOString().split('T')[0];

// Load charts on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Enhanced Charts v2.0 - Initializing...');
    loadCharts();
});
</script>
</script>
@endsection
