@extends('layouts.admin')

@section('title', 'Seller Application Details - GlowTrack')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 font-playfair">Seller Application Details</h1>
                <p class="text-gray-600 mt-2">Review application from {{ $application->user->name }}</p>
            </div>
            <a href="{{ route('admin.seller-applications') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                ← Back to Applications
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Application Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Application Status -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-900">Application Status</h2>
                    @if($application->status === 'pending')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Pending Review
                        </span>
                    @elseif($application->status === 'approved')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            Approved
                        </span>
                    @else
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                            Rejected
                        </span>
                    @endif
                </div>

                @if($application->status === 'pending')
                    <div class="flex space-x-4">
                        <form method="POST" action="{{ route('admin.seller-applications.approve', $application) }}" class="flex-1">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes (Optional)</label>
                                <textarea name="admin_notes" id="admin_notes" rows="3" class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green" placeholder="Add any notes about this approval..."></textarea>
                            </div>
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium" onclick="return confirm('Are you sure you want to approve this seller application?')">
                                ✅ Approve Application
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.seller-applications.reject', $application) }}" class="flex-1">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="admin_notes_reject" class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason (Required)</label>
                                <textarea name="admin_notes" id="admin_notes_reject" rows="3" class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green" placeholder="Please provide a reason for rejection..." required></textarea>
                            </div>
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium" onclick="return confirm('Are you sure you want to reject this seller application?')">
                                ❌ Reject Application
                            </button>
                        </form>
                    </div>
                @else
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">
                                    <strong>Reviewed by:</strong> {{ $application->reviewer ? $application->reviewer->name : 'System' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <strong>Reviewed on:</strong> {{ $application->reviewed_at ? $application->reviewed_at->format('M d, Y H:i') : 'N/A' }}
                                </p>
                            </div>
                            @if($application->admin_notes)
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">Admin Notes:</p>
                                    <p class="text-sm text-gray-600">{{ $application->admin_notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Business Information -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Business Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Brand Name</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $application->brand_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contact Person</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $application->contact_person }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contact Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $application->contact_email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contact Phone</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $application->contact_phone }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Business Address</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $application->business_address }}</p>
                    </div>
                    @if($application->website_url)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Website</label>
                            <p class="mt-1 text-sm text-gray-900">
                                <a href="{{ $application->website_url }}" target="_blank" class="text-jade-green hover:text-jade-green-900">{{ $application->website_url }}</a>
                            </p>
                        </div>
                    @endif
                    @if($application->business_license)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Business License</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $application->business_license }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Business Description -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Business Description</h2>
                <p class="text-gray-700 leading-relaxed">{{ $application->business_description }}</p>
            </div>

            <!-- Product Categories -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Product Categories</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($application->product_categories as $category)
                        <span class="px-3 py-1 bg-jade-green text-white text-sm rounded-full">
                            {{ $category }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Applicant Information -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Applicant Information</h2>
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 h-12 w-12">
                        <div class="h-12 w-12 rounded-full bg-jade-green flex items-center justify-center">
                            <span class="text-white font-medium text-lg">{{ strtoupper(substr($application->user->name, 0, 1)) }}</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $application->user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $application->user->email }}</p>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <p><strong>Username:</strong> {{ $application->user->username }}</p>
                    <p><strong>Joined:</strong> {{ $application->user->created_at->format('M d, Y') }}</p>
                    <p><strong>Phone:</strong> {{ $application->user->phone ?? 'Not provided' }}</p>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.users.show', $application->user) }}" class="text-jade-green hover:text-jade-green-900 text-sm font-medium">
                        View Full Profile →
                    </a>
                </div>
            </div>

            <!-- Application Timeline -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Application Timeline</h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Application Submitted</p>
                            <p class="text-sm text-gray-500">{{ $application->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>

                    @if($application->status !== 'pending')
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 {{ $application->status === 'approved' ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center">
                                @if($application->status === 'approved')
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">
                                    Application {{ ucfirst($application->status) }}
                                </p>
                                <p class="text-sm text-gray-500">{{ $application->reviewed_at ? $application->reviewed_at->format('M d, Y H:i') : 'N/A' }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection