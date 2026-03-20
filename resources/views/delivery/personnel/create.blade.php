@extends('layouts.admin')

@section('title', 'Add Delivery Personnel - GlowTrack Admin')

@section('content')
<!-- Add Personnel Container -->
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Add Delivery Personnel</h1>
        <p class="text-gray-600">Add a new delivery team member to the system</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-md p-8 border border-gray-200">
        <form method="POST" action="{{ route('admin.delivery-personnel.store') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" id="name" name="name" required
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent"
                           placeholder="Enter full name">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" required
                           value="{{ old('email') }}"
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
                           value="{{ old('phone') }}"
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
                                   {{ old('is_active') ? 'checked' : '' }}
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
            
            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.delivery-personnel.index') }}" 
                   class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-full hover:bg-gray-100 transition font-semibold">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-semibold">
                    Add Personnel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
