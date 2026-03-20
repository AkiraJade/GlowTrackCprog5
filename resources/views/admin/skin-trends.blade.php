@extends('layouts.app')

@section('title', 'Skin Trends - GlowTrack Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Customer Skin Trends</h1>
                    <p class="text-gray-600 mt-2">Platform-wide insights on skin types, concerns, and ingredient usage patterns</p>
                </div>
                <div class="flex space-x-3">
                    <button onclick="exportSkinTrends()" class="px-4 py-2 bg-jade-green text-white rounded-lg hover:bg-jade-green/80 transition">
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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Skin Type</label>
                    <select id="skinTypeFilter" onchange="updateFilters()" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-jade-green focus:border-jade-green">
                        <option value="all">All Types</option>
                        <option value="Oily">Oily</option>
                        <option value="Dry">Dry</option>
                        <option value="Combination">Combination</option>
                        <option value="Sensitive">Sensitive</option>
                        <option value="Normal">Normal</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Skin Concern</label>
                    <select id="concernFilter" onchange="updateFilters()" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-jade-green focus:border-jade-green">
                        <option value="all">All Concerns</option>
                        <option value="Acne">Acne</option>
                        <option value="Hyperpigmentation">Hyperpigmentation</option>
                        <option value="Aging">Aging</option>
                        <option value="Dryness">Dryness</option>
                        <option value="Oily Skin">Oily Skin</option>
                        <option value="Sensitive Skin">Sensitive Skin</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button onclick="resetFilters()" class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Reset Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Overview Stats -->
        <div class="grid grid-cols-1 md:grid-cols-6 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($overview['total_users']) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Active Profiles</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($overview['active_profiles']) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Journals</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($overview['total_journals']) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Avg Skin Score</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($overview['avg_skin_score'], 1) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Top Concern</p>
                        <p class="text-lg font-bold text-gray-900 truncate">{{ $overview['most_common_concern'] }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Common Type</p>
                        <p class="text-lg font-bold text-gray-900">{{ $overview['most_common_type'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Skin Type Distribution -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Skin Type Distribution</h3>
                <div id="skinTypeChart" class="h-64"></div>
                <div class="mt-4 space-y-2">
                    @foreach($skinTypeDistribution['chart_data'] as $type)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ $type['label'] }}</span>
                        <div class="flex items-center space-x-2">
                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                <div class="bg-jade-green h-2 rounded-full" style="width: {{ $type['percentage'] }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 w-12 text-right">{{ $type['percentage'] }}%</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Skin Concerns -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Skin Concerns</h3>
                <div id="concernsChart" class="h-64"></div>
                <div class="mt-4 space-y-2">
                    @foreach($skinConcernsTrends['top_concerns'] as $concern => $count)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ ucfirst($concern) }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $count }} users</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Popular Ingredients -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Popular Ingredients</h3>
            <div id="ingredientsChart" class="h-64 mb-4"></div>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @foreach($popularIngredients['top_ingredients'] as $ingredient => $count)
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <div class="text-2xl mb-1">{{ getIngredientIcon($ingredient) }}</div>
                    <div class="text-sm font-medium text-gray-900">{{ ucfirst($ingredient) }}</div>
                    <div class="text-xs text-gray-500">{{ $count }} uses</div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Demographics and Trends -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Age Demographics -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Age Demographics</h3>
                <div id="ageChart" class="h-48"></div>
                <div class="mt-4 space-y-2">
                    @foreach($ageDemographics['chart_data'] as $age)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ $age['label'] }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $age['value'] }} ({{ $age['percentage'] }}%)</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Seasonal Trends -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Seasonal Trends</h3>
                <div id="seasonalChart" class="h-48"></div>
                <div class="mt-4 space-y-2">
                    @foreach($seasonalTrends['chart_data'] as $season)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ $season['label'] }}</span>
                        <div class="text-right">
                            <div class="text-sm font-medium text-gray-900">Score: {{ $season['avg_score'] }}</div>
                            <div class="text-xs text-gray-500">{{ $season['top_concern'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Regional Data -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Regional Trends</h3>
                <div id="regionalChart" class="h-48"></div>
                <div class="mt-4 space-y-2 max-h-48 overflow-y-auto">
                    @foreach($regionalData['chart_data'] as $region)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">{{ $region['region'] }}</span>
                        <div class="text-right">
                            <div class="font-medium text-gray-900">{{ $region['users'] }}</div>
                            <div class="text-xs text-gray-500">{{ $region['dominant_skin_type'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Phase 3 Charts DISABLED for performance -->
@if(false)
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script src="{{ asset('js/skin-trend-charts.js') }}"></script>
@endif
<script>
// Phase 3 Skin Trends - CHARTS DISABLED
// Charts have been disabled for better performance
// To re-enable: Change @if(false) to @if(true) above

document.addEventListener('DOMContentLoaded', function() {
    console.log('Phase 3 Skin Trends - Charts disabled for performance');
    
    // Show simple static data instead of charts
    const chartContainers = document.querySelectorAll('[id$="Chart"]');
    chartContainers.forEach(container => {
        container.innerHTML = '<div class="text-center text-gray-500 py-8">Charts disabled for performance</div>';
    });
});
</script>
@endsection
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Skin Concerns Chart
    const concernsCtx = document.getElementById('concernsChart').getContext('2d');
    charts.concerns = new Chart(concernsCtx, {
        type: 'bar',
        data: {
            labels: @json(array_keys($skinConcernsTrends['top_concerns'])),
            datasets: [{
                label: 'Users',
                data: @json(array_values($skinConcernsTrends['top_concerns'])),
                backgroundColor: '#7EC8B3',
                borderColor: '#7EC8B3',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Popular Ingredients Chart
    const ingredientsCtx = document.getElementById('ingredientsChart').getContext('2d');
    charts.ingredients = new Chart(ingredientsCtx, {
        type: 'horizontalBar',
        data: {
            labels: @json($popularIngredients['chart_data']->pluck('label')),
            datasets: [{
                label: 'Usage Count',
                data: @json($popularIngredients['chart_data']->pluck('value')),
                backgroundColor: '#F6C1CC',
                borderColor: '#F6C1CC',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Age Demographics Chart
    const ageCtx = document.getElementById('ageChart').getContext('2d');
    charts.age = new Chart(ageCtx, {
        type: 'pie',
        data: {
            labels: @json($ageDemographics['chart_data']->pluck('label')),
            datasets: [{
                data: @json($ageDemographics['chart_data']->pluck('value')),
                backgroundColor: [
                    '#7EC8B3', '#F6C1CC', '#FFD6A5', '#A8D5C2', '#6B4F4F'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12,
                        padding: 10
                    }
                }
            }
        }
    });

    // Seasonal Trends Chart
    const seasonalCtx = document.getElementById('seasonalChart').getContext('2d');
    charts.seasonal = new Chart(seasonalCtx, {
        type: 'line',
        data: {
            labels: @json($seasonalTrends['chart_data']->pluck('label')),
            datasets: [{
                label: 'Average Skin Score',
                data: @json($seasonalTrends['chart_data']->pluck('avg_score')),
                borderColor: '#7EC8B3',
                backgroundColor: 'rgba(126, 200, 179, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Regional Chart
    const regionalCtx = document.getElementById('regionalChart').getContext('2d');
    charts.regional = new Chart(regionalCtx, {
        type: 'polarArea',
        data: {
            labels: @json($regionalData['chart_data']->pluck('region')),
            datasets: [{
                data: @json($regionalData['chart_data']->pluck('users')),
                backgroundColor: [
                    'rgba(126, 200, 179, 0.7)',
                    'rgba(246, 193, 204, 0.7)',
                    'rgba(255, 214, 165, 0.7)',
                    'rgba(168, 213, 194, 0.7)',
                    'rgba(107, 79, 79, 0.7)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 10
                    }
                }
            }
        }
    });
}

function updateFilters() {
    const period = document.getElementById('periodFilter').value;
    const skinType = document.getElementById('skinTypeFilter').value;
    const concern = document.getElementById('concernFilter').value;

    // Update URL and reload page with new filters
    const url = new URL(window.location);
    url.searchParams.set('period', period);
    url.searchParams.set('skin_type', skinType);
    url.searchParams.set('concern', concern);
    
    window.location.href = url.toString();
}

function resetFilters() {
    document.getElementById('periodFilter').value = '30days';
    document.getElementById('skinTypeFilter').value = 'all';
    document.getElementById('concernFilter').value = 'all';
    
    window.location.href = '{{ route("admin.skin-trends") }}';
}

function refreshAllData() {
    // Show loading state
    const charts = document.querySelectorAll('canvas');
    charts.forEach(chart => {
        chart.style.opacity = '0.5';
    });

    // Reload page data
    fetch(window.location.href, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        // Extract and update the data sections
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        
        // Update overview stats
        updateOverviewStats(doc);
        
        // Update charts with new data
        updateChartsData(doc);
        
        // Restore chart opacity
        charts.forEach(chart => {
            chart.style.opacity = '1';
        });
    })
    .catch(error => {
        console.error('Error refreshing data:', error);
        charts.forEach(chart => {
            chart.style.opacity = '1';
        });
    });
}

function updateOverviewStats(doc) {
    // Update overview statistics
    const stats = ['total_users', 'active_profiles', 'total_journals', 'avg_skin_score'];
    stats.forEach(stat => {
        const element = document.querySelector(`[data-stat="${stat}"]`);
        if (element) {
            const newValue = doc.querySelector(`[data-stat="${stat}"]`);
            if (newValue) {
                element.textContent = newValue.textContent;
            }
        }
    });
}

function updateChartsData(doc) {
    // This would need server-side AJAX endpoints for real-time updates
    // For now, we'll just reload the page
    window.location.reload();
}

function exportSkinTrends() {
    fetch('{{ route("admin.skin-trends.export") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            period: document.getElementById('periodFilter').value,
            skin_type: document.getElementById('skinTypeFilter').value,
            concern: document.getElementById('concernFilter').value
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
            showNotification('Skin trends report exported successfully!', 'success');
        }
    })
    .catch(error => {
        console.error('Error exporting:', error);
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
function getIngredientIcon($ingredient) {
    $icons = [
        'retinol' => '🔄',
        'vitamin c' => '🍊',
        'hyaluronic acid' => '💧',
        'niacinamide' => '✨',
        'salicylic acid' => '🌿',
        'aha' => '🍋',
        'bha' => '🌱',
        'ceramides' => '🛡️',
        'peptides' => '🧬',
        'zinc' => '⚡'
    ];
    
    return $icons[strtolower($ingredient)] ?? '🌿';
}
@endphp
@endsection
