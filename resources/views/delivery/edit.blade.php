@extends('layouts.admin')

@section('title', 'Edit Delivery - GlowTrack')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 font-playfair">Edit Delivery</h1>
                <p class="text-gray-600 mt-2">Update delivery information and status</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.deliveries.show', $delivery) }}" class="px-6 py-2 border-2 border-admin-primary text-admin-primary rounded-full hover:bg-admin-primary hover:text-white transition font-semibold">
                    ← Back to Details
                </a>
                <a href="{{ route('admin.deliveries.index') }}" class="px-6 py-2 bg-gray-600 text-white rounded-full hover:bg-gray-700 transition font-semibold">
                    All Deliveries
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Edit Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <form method="POST" action="{{ route('admin.deliveries.update', $delivery) }}" id="deliveryEditForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Information -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Basic Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Status</label>
                                <select name="status" required
                                        class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                    <option value="Assigned" {{ $delivery->status === 'Assigned' ? 'selected' : '' }}>Assigned</option>
                                    <option value="Picked Up" {{ $delivery->status === 'Picked Up' ? 'selected' : '' }}>Picked Up</option>
                                    <option value="In Transit" {{ $delivery->status === 'In Transit' ? 'selected' : '' }}>In Transit</option>
                                    <option value="Delivered" {{ $delivery->status === 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="Failed" {{ $delivery->status === 'Failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="Returned" {{ $delivery->status === 'Returned' ? 'selected' : '' }}>Returned</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Expected Delivery Date</label>
                                <input type="date" name="expected_delivery_date" value="{{ $delivery->expected_delivery_date->format('Y-m-d') }}" required
                                       class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                @error('expected_delivery_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Actual Delivery Date</label>
                                <input type="date" name="actual_delivery_date" 
                                       value="{{ $delivery->actual_delivery_date?->format('Y-m-d') ?? '' }}"
                                       class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                <p class="mt-1 text-xs text-gray-500">Leave empty if not yet delivered</p>
                                @error('actual_delivery_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Personnel</label>
                                <select name="delivery_personnel_id"
                                        class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                    <option value="">Select Personnel</option>
                                    @foreach($personnel as $person)
                                    <option value="{{ $person->id }}" 
                                            {{ $delivery->deliveryPersonnel?->id === $person->id ? 'selected' : '' }}>
                                        {{ $person->name }} - {{ $person->phone }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('delivery_personnel_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Location Information -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Location Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Collection Point</label>
                                <input type="text" name="collection_point" value="{{ $delivery->collection_point ?? '' }}"
                                       placeholder="e.g., Warehouse, Store Location"
                                       class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                @error('collection_point')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Destination Address</label>
                                <textarea name="destination_address" rows="3" required
                                          class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">{{ $delivery->destination_address }}</textarea>
                                @error('destination_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Additional Information</h2>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Notes</label>
                            <textarea name="notes" rows="4" placeholder="Any special instructions or notes about this delivery"
                                      class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">{{ $delivery->notes ?? '' }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Include special delivery instructions, customer preferences, etc.</p>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('admin.deliveries.show', $delivery) }}" 
                           class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-jade-green text-white rounded-md hover:bg-green-600 transition">
                            Update Delivery
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Order Summary -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h2>
                
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-center mb-3">
                        <div>
                            <p class="text-sm text-gray-500">Order #{{ $delivery->order->id }}</p>
                            <p class="font-semibold text-lg">₱{{ number_format($delivery->order->total_amount, 2) }}</p>
                        </div>
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $delivery->order->status === 'delivered' ? 'bg-green-100 text-green-800' : 
                               ($delivery->order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                               'bg-blue-100 text-blue-800') }}">
                            {{ ucfirst($delivery->order->status) }}
                        </span>
                    </div>
                    
                    <div class="text-sm text-gray-600">
                        <p><strong>Customer:</strong> {{ $delivery->order->user->name }}</p>
                        <p><strong>Email:</strong> {{ $delivery->order->user->email }}</p>
                        <p><strong>Items:</strong> {{ $delivery->order->orderItems->count() }}</p>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('orders.show', $delivery->order) }}" 
                       class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        View Full Order Details
                    </a>
                </div>
            </div>

            <!-- Status Guide -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Status Guide</h2>
                
                <div class="space-y-3">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">Assigned</p>
                            <p class="text-sm text-gray-600">Delivery personnel assigned</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">Picked Up</p>
                            <p class="text-sm text-gray-600">Package collected from sender</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-2 h-2 bg-purple-500 rounded-full mt-2"></div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">In Transit</p>
                            <p class="text-sm text-gray-600">Package is on the way</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">Delivered</p>
                            <p class="text-sm text-gray-600">Package successfully delivered</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-2 h-2 bg-red-500 rounded-full mt-2"></div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">Failed/Returned</p>
                            <p class="text-sm text-gray-600">Delivery failed or package returned</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
                
                <div class="space-y-3">
                    <button onclick="updateStatus('Delivered')" 
                            class="block w-full text-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        Mark as Delivered
                    </button>
                    
                    <button onclick="updateStatus('Failed')" 
                            class="block w-full text-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Mark as Failed
                    </button>
                    
                    <a href="{{ route('admin.users.show', $delivery->order->user) }}" 
                       class="block w-full text-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        View Customer Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateStatus(status) {
    const form = document.getElementById('deliveryEditForm');
    const statusSelect = form.querySelector('select[name="status"]');
    const actualDeliveryDate = form.querySelector('input[name="actual_delivery_date"]');
    
    statusSelect.value = status;
    
    if (status === 'Delivered' && !actualDeliveryDate.value) {
        actualDeliveryDate.value = new Date().toISOString().split('T')[0];
    }
    
    if (confirm(`Are you sure you want to mark this delivery as ${status}?`)) {
        form.submit();
    }
}
</script>
@endsection
