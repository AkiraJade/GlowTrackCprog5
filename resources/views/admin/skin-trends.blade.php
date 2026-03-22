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

        <!-- Charts Disabled Message -->
        <div class="bg-yellow-50 border border border-yellow-200 rounded-lg p-6 mb-8">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2a2 2 0 002-2h2a2 2 0 002 2v2a2 2 0 002 2m0 0V9a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h2a2 2 0 012 2z"></path>
                </svg>
                <div>
                    <h3 class="text-lg font-semibold text-yellow-800">Charts Disabled for Performance</h3>
                    <p class="text-yellow-700 mt-2">The skin trends charts have been temporarily disabled to improve page performance. You can re-enable them by changing <code>@if(false)</code> to <code>@if(true)</code> in the view file.</p>
                </div>
            </div>
        </div>

        <!-- Overview Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <div class="card-header">
                    <h5 class="text-lg font-semibold text-gray-900">Overview</h5>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-blue-600">{{ $overview['total_profiles'] ?? 0 }}</p>
                            <p class="text-sm text-gray-600">Total Profiles</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-green-600">{{ $overview['active_users'] ?? 0 }}</p>
                            <p class="text-sm text-gray-600">Active Users</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-purple-600">{{ $overview['total_concerns'] ?? 0 }}</p>
                            <p class="text-sm text-gray-600">Total Concerns</p>
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
<script>
// Skin Trends - Charts disabled for performance
document.addEventListener('DOMContentLoaded', function() {
    console.log('Skin Trends page loaded - Charts disabled');
});
</script>
@endpush
