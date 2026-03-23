@extends('layouts.admin')

@section('title', 'Trash Management - Admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Trash Management</h1>
            <p class="text-gray-600 mt-2">Manage soft-deleted items and restore if needed</p>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Tabs -->
        <div class="bg-white rounded-lg shadow mb-6 border-b border-gray-200">
            <div class="flex flex-wrap">
                @php
                    $tabs = [
                        'users' => 'Users',
                        'products' => 'Products',
                        'orders' => 'Orders',
                        'carts' => 'Carts',
                        'reviews' => 'Reviews',
                    ];
                @endphp
                @foreach($tabs as $tabType => $tabLabel)
                    <a href="{{ route('admin.trash', ['type' => $tabType]) }}" 
                       class="px-6 py-4 font-medium border-b-2 transition-colors
                           {{ $type === $tabType 
                               ? 'border-jade-green text-jade-green' 
                               : 'border-transparent text-gray-600 hover:text-gray-900' }}">
                        {{ $tabLabel }}
                        <span class="ml-2 inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-sm">
                            {{ $trashedCounts[$tabType] }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Empty State -->
        @if($trashedItems->count() === 0)
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
                <p class="mt-4 text-xl text-gray-600">No deleted items in {{ ucfirst($type) }} trash</p>
            </div>
        @else
            <!-- Items Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ ucfirst($type === 'carts' || $type === 'reviews' ? substr($type, 0, -1) : $type) }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Deleted At
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Details
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($trashedItems as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($type === 'users')
                                        <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->email }}</div>
                                    @elseif($type === 'products')
                                        <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->brand }}</div>
                                    @elseif($type === 'orders')
                                        <div class="text-sm font-medium text-gray-900">Order #{{ $item->order_id }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->user->name }}</div>
                                    @elseif($type === 'carts')
                                        <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                        <div class="text-sm text-gray-500">User: {{ $item->user->name }}</div>
                                    @elseif($type === 'reviews')
                                        <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                        <div class="text-sm text-gray-500">By: {{ $item->user->name }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $item->deleted_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @if($type === 'users')
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            {{ $item->role === 'admin' ? 'bg-red-100 text-red-800' : 
                                               ($item->role === 'seller' ? 'bg-blue-100 text-blue-800' : 
                                               'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($item->role) }}
                                        </span>
                                    @elseif($type === 'products')
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-jade-green/10 text-jade-green">
                                            ₱{{ number_format($item->price, 2) }}
                                        </span>
                                    @elseif($type === 'orders')
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            {{ $item->status === 'delivered' ? 'bg-green-100 text-green-800' : 
                                               ($item->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    @elseif($type === 'reviews')
                                        <div class="flex items-center">
                                            @for($i = 0; $i < $item->rating; $i++)
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                            <span class="text-sm text-gray-600 ml-1">({{ $item->rating }})</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <!-- Restore Button -->
                                    <form action="{{ route('admin.trash.restore') }}" method="POST" class="inline-block">
                                        @csrf
                                        <input type="hidden" name="type" value="{{ $type === 'reviews' || $type === 'carts' ? substr($type, 0, -1) : $type }}">
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 15L3 9m0 0l6-6m-6 6h12a6 6 0 010 12h-3"/>
                                            </svg>
                                            Restore
                                        </button>
                                    </form>

                                    <!-- Permanent Delete Button -->
                                    <form action="{{ route('admin.trash.force-delete') }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="type" value="{{ $type === 'reviews' || $type === 'carts' ? substr($type, 0, -1) : $type }}">
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $trashedItems->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
