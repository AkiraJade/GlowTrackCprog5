@extends('layouts.app')

@section('title', 'Profile Settings - GlowTrack')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Profile Settings</h1>
            <p class="text-gray-600 mt-2">Manage your account information and preferences</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Profile Information Form -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Profile Information</h2>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Profile Photo Section -->
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 mb-4">Profile Photo</label>
                        <div class="flex items-center space-x-6">
                            <div class="flex-shrink-0">
                                <img id="current-photo" src="{{ $user->photo_url }}" alt="{{ $user->name }}" 
                                     class="w-24 h-24 rounded-full object-cover border-4 border-gray-200">
                            </div>
                            <div class="flex-1">
                                <div>
                                    <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                           class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-jade-green file:text-white hover:file:bg-soft-brown">
                                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, JPEG, GIF or WebP (Max 2MB)</p>
                                    @error('photo')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <button type="button" id="remove-photo" class="text-sm text-red-600 hover:text-red-800 font-medium">
                                        Remove Current Photo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ $user->name }}" required
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <input type="text" id="username" name="username" value="{{ $user->username }}" required
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                            @error('username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ $user->email }}" required
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="{{ $user->phone }}"
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <textarea id="address" name="address" rows="3" 
                                      class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">{{ $user->address }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="px-6 py-2 bg-jade-green text-white rounded-md hover:bg-opacity-90 transition font-medium">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Password Change Form -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Change Password</h2>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('profile.password.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                            <input type="password" id="current_password" name="current_password" required
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <input type="password" id="password" name="password" required minlength="8"
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="px-6 py-2 bg-jade-green text-white rounded-md hover:bg-opacity-90 transition font-medium">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Account Information -->
        <div class="mt-8 bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Account Information</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Account Type</label>
                        <p class="text-gray-900 capitalize">{{ $user->role }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Member Since</label>
                        <p class="text-gray-900">{{ $user->created_at->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email Verification</label>
                        <p class="text-gray-900">{{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                        <p class="text-gray-900">{{ $user->updated_at->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seller Options -->
        @if(auth()->user()->isCustomer())
            <div class="mt-8 bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Seller Options</h2>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-4">Want to start selling your own skincare products on GlowTrack?</p>
                    <a href="{{ route('seller.application.create') }}" class="inline-flex items-center px-6 py-3 bg-jade-green text-white rounded-md hover:bg-opacity-90 transition font-medium">
                        <span class="mr-2">🛍️</span>
                        Become a Seller
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
// Photo preview functionality
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const currentPhoto = document.getElementById('current-photo');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            currentPhoto.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Remove photo functionality
document.getElementById('remove-photo').addEventListener('click', function() {
    if (confirm('Are you sure you want to remove your profile photo?')) {
        // Create a hidden input to indicate photo removal
        const form = document.querySelector('form[action="{{ route('profile.update') }}"]');
        const removeInput = document.createElement('input');
        removeInput.type = 'hidden';
        removeInput.name = 'remove_photo';
        removeInput.value = '1';
        form.appendChild(removeInput);
        
        // Reset the photo input and show default avatar
        document.getElementById('photo').value = '';
        document.getElementById('current-photo').src = "https://ui-avatars.com/api/?name={{ substr($user->name, 0, 2) }}&color=ffffff&background=4a7c59&size=200&bold=true";
        
        // Submit form to update profile
        form.submit();
    }
});
</script>
@endsection
