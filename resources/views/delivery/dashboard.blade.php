@extends('layouts.admin')

@section('title', 'Delivery Dashboard - GlowTrack Admin')

@section('content')
<!-- Delivery Dashboard Container -->
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Delivery Management Dashboard</h1>
        <p class="text-gray-600">Monitor and manage all delivery operations</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition cursor-pointer border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 bg-jade-green rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Deliveries</p>
                    <p class="text-2xl font-bold text-soft-brown">{{ $stats['total_deliveries'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition cursor-pointer border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-500 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Pending Deliveries</p>
                    <p class="text-2xl font-bold text-soft-brown">{{ $stats['pending_deliveries'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition cursor-pointer border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 bg-purple-500 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 104 0m6 0a2 2 0 104 0m-4 0a2 2 0 104 0"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">In Transit</p>
                    <p class="text-2xl font-bold text-soft-brown">{{ $stats['in_transit'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition cursor-pointer border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 bg-green-500 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Delivered Today</p>
                    <p class="text-2xl font-bold text-soft-brown">{{ $stats['delivered_today'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition cursor-pointer border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 bg-warm-peach rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Active Personnel</p>
                    <p class="text-2xl font-bold text-soft-brown">{{ $stats['active_personnel'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Deliveries -->
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900 font-playfair">Recent Deliveries</h2>
            <a href="{{ route('admin.deliveries.index') }}" class="text-jade-green hover:text-jade-green/90 transition font-semibold text-sm">View All</a>
        </div>

        @if($recentDeliveries->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delivery Personnel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expected Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentDeliveries as $delivery)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900">#{{ $delivery->order->id }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $delivery->order->user->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $delivery->deliveryPersonnel ? $delivery->deliveryPersonnel->name : 'Not Assigned' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $delivery->getStatusBadgeColor() }}">
                                        {{ $delivery->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $delivery->expected_delivery_date ? $delivery->expected_delivery_date->format('M d, Y') : 'Not Set' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div style="display:flex;align-items:center;gap:.4rem;flex-wrap:nowrap;">
                                        <a href="{{ route('admin.deliveries.show', $delivery) }}"
                                           style="padding:.3rem .65rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                                  text-decoration:none;color:#2D6A5B;background:rgba(126,200,179,.18);
                                                  border:1px solid rgba(126,200,179,.32);transition:all .18s ease;white-space:nowrap;"
                                           onmouseover="this.style.background='rgba(126,200,179,.3)'"
                                           onmouseout="this.style.background='rgba(126,200,179,.18)'">
                                            View
                                        </a>
                                        <a href="{{ route('admin.deliveries.edit', $delivery) }}"
                                           style="padding:.3rem .65rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                                  text-decoration:none;color:#2D5A4A;background:rgba(168,213,194,.2);
                                                  border:1px solid rgba(168,213,194,.35);transition:all .18s ease;white-space:nowrap;"
                                           onmouseover="this.style.background='rgba(168,213,194,.35)'"
                                           onmouseout="this.style.background='rgba(168,213,194,.2)'">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.deliveries.destroy', $delivery) }}" method="POST" style="display:inline;"
                                              onsubmit="return confirm('Delete delivery #{{ $delivery->id }} for Order #{{ $delivery->order->id }}? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    style="padding:.3rem .65rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                                           color:#8B3A4A;background:rgba(246,193,204,.18);
                                                           border:1px solid rgba(220,150,170,.28);cursor:pointer;
                                                           transition:all .18s ease;white-space:nowrap;font-family:'Poppins',sans-serif;"
                                                    onmouseover="this.style.background='rgba(246,193,204,.35)'"
                                                    onmouseout="this.style.background='rgba(246,193,204,.18)'">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-gray-500">No recent deliveries found.</div>
            </div>
        @endif
    </div>
</div>
@endsection
