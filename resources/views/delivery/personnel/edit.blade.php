@extends('layouts.admin')

@section('title', 'Edit Delivery Personnel - GlowTrack Admin')

@section('content')
<!-- Edit Personnel Container -->
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Edit Delivery Personnel</h1>
        <p class="text-gray-600">Update information for {{ $deliveryPersonnel->name }}</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-md p-8 border border-gray-200">
        <form method="POST" action="{{ route('admin.delivery-personnel.update', $deliveryPersonnel) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" id="name" name="name" required
                           value="{{ old('name', $deliveryPersonnel->name) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent"
                           placeholder="Enter full name">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" required
                           value="{{ old('email', $deliveryPersonnel->email) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent"
                           placeholder="Enter email address">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" id="phone" name="phone" required
                           value="{{ old('phone', $deliveryPersonnel->phone) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent"
                           placeholder="Enter phone number">
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <div class="mt-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" 
                                   {{ old('is_active', $deliveryPersonnel->is_active) ? 'checked' : '' }}
                                   class="form-checkbox h-5 w-5 text-jade-green rounded focus:ring-jade-green">
                            <span class="ml-3 text-gray-700">Active</span>
                            <span class="ml-2 text-sm text-gray-500">(Can receive delivery assignments)</span>
                        </label>
                    </div>
                    @error('is_active')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Personnel Stats -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-soft-brown mb-4">Delivery Statistics</h3>
                @php
                    $stats = $deliveryPersonnel->getDeliveryStats();
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-jade-green">{{ $stats['total'] }}</div>
                        <div class="text-sm text-gray-600">Total Deliveries</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $stats['active'] }}</div>
                        <div class="text-sm text-gray-600">Active Deliveries</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</div>
                        <div class="text-sm text-gray-600">Completed</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $stats['completion_rate'] }}%</div>
                        <div class="text-sm text-gray-600">Completion Rate</div>
                    </div>
                </div>
            </div>
            
            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.delivery-personnel.index') }}" 
                   class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-full hover:bg-gray-100 transition font-semibold">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-semibold">
                    Update Personnel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
