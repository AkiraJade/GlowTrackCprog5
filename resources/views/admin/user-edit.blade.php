@extends('layouts.admin')

@section('title', 'Edit User - GlowTrack')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 font-playfair">Edit User</h1>
                <p class="text-gray-600 mt-2">Update user information and role</p>
            </div>
            <a href="{{ route('admin.users.show', $user) }}" class="px-6 py-2 border-2 border-admin-primary text-admin-primary rounded-full hover:bg-admin-primary hover:text-white transition font-semibold">
                ← Back to User Details
            </a>
        </div>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')
                
                <!-- User Profile Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">User Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ $user->name }}" required
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                            <input type="text" name="username" value="{{ $user->username }}" required
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                            @error('username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ $user->email }}" required
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" name="phone" value="{{ $user->phone }}"
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <textarea name="address" rows="3" 
                                  class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">{{ $user->address }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Role Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Role & Permissions</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">User Role</label>
                            <select name="role" required
                                    class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="seller" {{ $user->role === 'seller' ? 'selected' : '' }}>Seller</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                @switch($user->role)
                                    @case('admin')
                                        Full administrative access to all platform features
                                        @break
                                    @case('seller')
                                        Can manage products, view orders, and access seller dashboard
                                        @break
                                    @case('customer')
                                        Can browse products, place orders, and manage account
                                        @break
                                @endswitch
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Account Status</label>
                            <div class="mt-2">
                                @if($user->active)
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        ✅ Active
                                    </span>
                                    <p class="mt-1 text-xs text-gray-500">User can access the platform</p>
                                @else
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        🚫 Inactive
                                    </span>
                                    <p class="mt-1 text-xs text-gray-500">User cannot access the platform</p>
                                    @if($user->deactivation_reason)
                                        <p class="mt-1 text-xs text-red-600">Reason: {{ $user->deactivation_reason }}</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Account Metadata -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Account Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">User ID</p>
                            <p class="font-semibold">#{{ $user->id }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Member Since</p>
                            <p class="font-semibold">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Last Seen</p>
                            <p class="font-semibold">{{ $user->last_seen_at ? $user->last_seen_at->diffForHumans() : 'Never' }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Loyalty Points</p>
                            <p class="font-semibold">{{ number_format($user->loyalty_points) }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.users.show', $user) }}" 
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-jade-green text-white rounded-md hover:bg-green-600 transition">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
