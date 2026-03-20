@extends('layouts.admin')

@section('title', 'Create Delivery - GlowTrack Admin')

@section('content')
<!-- Create Delivery Container -->
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Create New Delivery</h1>
        <p class="text-gray-600">Assign delivery personnel and schedule delivery for processing orders</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-md p-8 border border-gray-200">
        <form method="POST" action="{{ route('admin.deliveries.store') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="order_id" class="block text-sm font-medium text-gray-700 mb-2">Select Order</label>
                    <select name="order_id" id="order_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
                        <option value="">Select an order...</option>
                        @foreach($orders as $order)
                            <option value="{{ $order->id }}" 
                                    {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                #{{ $order->id }} - {{ $order->user->name }} ({{ $order->total_amount }}) - {{ $order->status }}
                            </option>
                        @endforeach
                    </select>
                    @error('order_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="delivery_personnel_id" class="block text-sm font-medium text-gray-700 mb-2">Assign to Personnel</label>
                    <select name="delivery_personnel_id" id="delivery_personnel_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
                        <option value="">Select delivery personnel...</option>
                        @foreach($personnel as $person)
                            <option value="{{ $person->id }}" 
                                    {{ old('delivery_personnel_id') == $person->id ? 'selected' : '' }}>
                                {{ $person->name }} - {{ $person->phone }}
                            </option>
                        @endforeach
                    </select>
                    @error('delivery_personnel_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="expected_delivery_date" class="block text-sm font-medium text-gray-700 mb-2">Expected Delivery Date</label>
                    <input type="date" id="expected_delivery_date" name="expected_delivery_date" required
                           value="{{ old('expected_delivery_date') }}"
                           min="{{ now()->addDays(1)->format('Y-m-d') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
                    @error('expected_delivery_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="collection_point" class="block text-sm font-medium text-gray-700 mb-2">Collection Point (Optional)</label>
                    <input type="text" id="collection_point" name="collection_point"
                           value="{{ old('collection_point') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent"
                           placeholder="e.g., Warehouse, Store, etc.">
                    @error('collection_point')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="destination_address" class="block text-sm font-medium text-gray-700 mb-2">Delivery Address</label>
                <textarea id="destination_address" name="destination_address" rows="3" required
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent resize-none"
                          placeholder="Enter complete delivery address">{{ old('destination_address') }}</textarea>
                @error('destination_address')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
            </div>
            
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Delivery Notes (Optional)</label>
                <textarea id="notes" name="notes" rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent resize-none"
                          placeholder="Any special instructions or notes for this delivery">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
            </div>
            
            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.deliveries.index') }}" 
                   class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-full hover:bg-gray-100 transition font-semibold">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-semibold">
                    Create Delivery
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
