@extends('layouts.admin')

@section('title', 'User Details - GlowTrack')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 font-playfair">User Details</h1>
                <p class="text-gray-600 mt-2">View and manage user information</p>
            </div>
            <a href="{{ route('admin.users') }}" class="text-admin-primary hover:text-admin-primary/80 font-medium">← Back to Users</a>
        </div>
    </div>

        <!-- User Info Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">User Information</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Profile Section -->
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 h-20 w-20">
                            <div class="h-20 w-20 rounded-full bg-jade-green flex items-center justify-center">
                                <span class="text-white text-2xl font-medium">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-gray-500">{{ $user->username }}</p>
                            <span class="inline-flex mt-2 px-3 py-1 text-sm leading-5 font-semibold rounded-full 
                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                                   ($user->role === 'seller' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email Address</label>
                            <p class="text-gray-900">{{ $user->email }}</p>
                        </div>
                        @if($user->phone)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <p class="text-gray-900">{{ $user->phone }}</p>
                            </div>
                        @endif
                        @if($user->address)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Address</label>
                                <p class="text-gray-900">{{ $user->address }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Account Status -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Account Status</label>
                            <p class="text-gray-900">{{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Member Since</label>
                            <p class="text-gray-900">{{ $user->created_at->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                            <p class="text-gray-900">{{ $user->updated_at->format('F d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                @if(auth()->user()->id !== $user->id)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex space-x-4">
                            <!-- Update Role Form -->
                            <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="flex-1">
                                @csrf
                                @method('PUT')
                                <div class="flex items-end space-x-2">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Update Role</label>
                                        <select name="role" class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="seller" {{ $user->role === 'seller' ? 'selected' : '' }}>Seller</option>
                                            <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="px-4 py-2 bg-jade-green text-white rounded-md hover:bg-opacity-90 transition">
                                        Update Role
                                    </button>
                                </div>
                            </form>

                            <!-- Delete Button -->
                            <form method="POST" action="{{ route('admin.users.delete', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                    Delete User
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-500">You cannot modify your own account from this page.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Additional Information (placeholder for future features) -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Activity Summary</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-jade-green">0</div>
                        <div class="text-sm text-gray-600 mt-1">Orders Placed</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-jade-green">0</div>
                        <div class="text-sm text-gray-600 mt-1">Products Listed</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-jade-green">0</div>
                        <div class="text-sm text-gray-600 mt-1">Reviews Written</div>
                    </div>
                </div>
                <p class="text-center text-gray-500 mt-6 text-sm">Detailed activity tracking will be available in future updates.</p>
            </div>
        </div>
</div>
@endsection
