@extends('layouts.admin')

@section('title', 'Skin Trends - GlowTrack Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 font-playfair">Skin Trends</h1>
                    <p class="text-gray-600 mt-2">Analyze skincare patterns and trends</p>
                </div>
            </div>
        </div>


        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Skin Type Distribution Chart -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Skin Type Distribution</h3>
                    <div class="text-2xl">📊</div>
                </div>
                <div class="h-80">
                    <canvas id="skinTypeChart"></canvas>
                </div>
            </div>

            <!-- Skin Concerns Trends Chart -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Top Skin Concerns</h3>
                    <div class="text-2xl">🎯</div>
                </div>
                <div class="h-80">
                    <canvas id="skinConcernsChart"></canvas>
                </div>
            </div>

            <!-- Popular Ingredients Chart -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Popular Ingredients</h3>
                    <div class="text-2xl">🌿</div>
                </div>
                <div class="h-80">
                    <canvas id="ingredientsChart"></canvas>
                </div>
            </div>


        </div>


            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <div class="card-header">
                    <h5 class="text-lg font-semibold text-gray-900">Overview</h5>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-blue-600">{{ $overview['total_users'] ?? 0 }}</p>
                            <p class="text-sm text-gray-600 mt-1">Total Users</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-green-600">{{ $overview['active_profiles'] ?? 0 }}</p>
                            <p class="text-sm text-gray-600 mt-1">Active Profiles</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-purple-600">{{ $overview['total_journals'] ?? 0 }}</p>
                            <p class="text-sm text-gray-600 mt-1">Total Journals</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-red-600">{{ number_format($overview['avg_skin_score'] ?? 0, 1) }}</p>
                            <p class="text-sm text-gray-600 mt-1">Avg Skin Score</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-yellow-600">{{ ucfirst($overview['most_common_concern'] ?? 'None') }}</p>
                            <p class="text-sm text-gray-600 mt-1">Top Concern</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-indigo-600">{{ ucfirst($overview['most_common_type'] ?? 'None') }}</p>
                            <p class="text-sm text-gray-600 mt-1">Top Skin Type</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
<script>
// Skin Trends Charts - Enhanced with Chart.js
document.addEventListener('DOMContentLoaded', function() {
    console.log('Skin Trends page loaded - Charts enabled');

    // Verify Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('❌ Chart.js not loaded!');
        return;
    }
    console.log('✅ Chart.js loaded successfully:', Chart.version);

    // Set default Chart.js options for better visuals
    Chart.defaults.font.family = "'Poppins', sans-serif";
    Chart.defaults.font.size = 12;
    Chart.defaults.plugins.legend.labels.usePointStyle = true;

    // Skin Type Distribution Chart
    const skinTypeCtx = document.getElementById('skinTypeChart');
    if (skinTypeCtx) {
        const skinTypeData = @json($skinTypeDistribution['chart_data'] ?? []);
        new Chart(skinTypeCtx, {
            type: 'doughnut',
            data: {
                labels: skinTypeData.map(item => item.label),
                datasets: [{
                    data: skinTypeData.map(item => item.value),
                    backgroundColor: [
                        '#7EC8B3', // jade-green
                        '#F1FAF7', // mint-cream
                        '#CDEDE3', // pastel-green
                        '#A8D5C2', // light-sage
                        '#F6C1CC', // blush-pink
                        '#FFD6A5', // warm-peach
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
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
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return `${label}: ${value} users (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Skin Concerns Chart
    const concernsCtx = document.getElementById('skinConcernsChart');
    if (concernsCtx) {
        const concernsData = @json($skinConcernsTrends['chart_data'] ?? []);
        new Chart(concernsCtx, {
            type: 'bar',
            data: {
                labels: concernsData.map(item => item.label),
                datasets: [{
                    label: 'Reports',
                    data: concernsData.map(item => item.value),
                    backgroundColor: '#7EC8B3',
                    borderColor: '#6B9B87',
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // Popular Ingredients Chart
    const ingredientsCtx = document.getElementById('ingredientsChart');
    if (ingredientsCtx) {
        const ingredientsData = @json($popularIngredients['chart_data'] ?? []);
        new Chart(ingredientsCtx, {
            type: 'bar',
            data: {
                labels: ingredientsData.map(item => item.label),
                datasets: [{
                    label: 'Usage Count',
                    data: ingredientsData.map(item => item.value),
                    backgroundColor: '#F6C1CC',
                    borderColor: '#E5A8B3',
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }




});
</script>
@endpush