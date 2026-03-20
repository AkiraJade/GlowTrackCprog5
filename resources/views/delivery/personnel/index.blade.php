@extends('layouts.admin')

@section('title', 'Delivery Personnel - GlowTrack Admin')

@section('content')
<!-- Delivery Personnel Container -->
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Delivery Personnel</h1>
                <p class="text-gray-600">Manage delivery team members and their assignments</p>
            </div>
            <a href="{{ route('admin.delivery-personnel.create') }}" 
               class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-semibold shadow-lg">
                + Add Personnel
            </a>
        </div>
    </div>

    <!-- Personnel Table -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200">
        @if($personnel->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Deliveries</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completion Rate</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($personnel as $person)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-jade-green rounded-full flex items-center justify-center mr-3">
                                            <span class="text-white text-sm font-bold">{{ substr($person->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $person->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $person->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $person->phone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {!! $person->getStatusBadge() !!}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $person->deliveries()->count() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $stats = $person->getDeliveryStats();
                                    @endphp
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900">{{ $stats['completion_rate'] }}%</span>
                                        <div class="ml-2 w-16 bg-gray-200 rounded-full h-2">
                                            <div class="bg-jade-green h-2 rounded-full" style="width: {{ $stats['completion_rate'] }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.delivery-personnel.edit', $person) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    <form method="POST" action="{{ route('admin.delivery-personnel.destroy', $person) }}" 
                                          onsubmit="return confirm('Are you sure you want to remove this delivery personnel?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $personnel->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-500 mb-4">No delivery personnel found.</div>
                <a href="{{ route('admin.delivery-personnel.create') }}" 
                   class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-semibold shadow-lg">
                    + Add First Personnel Member
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
