@extends('layouts.app')

@section('title', 'Application Status - GlowTrack')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Seller Application Status</h1>
            <p class="text-gray-600 mt-2">Track the progress of your seller application</p>
        </div>

        <!-- Application Status Card -->
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-8">
                <!-- Status Badge -->
                <div class="mb-6">
                    @if($application->isPending())
                        <div class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-semibold">Under Review</span>
                        </div>
                    @elseif($application->isApproved())
                        <div class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-semibold">Approved</span>
                        </div>
                    @else
                        <div class="inline-flex items-center px-4 py-2 bg-red-100 text-red-800 rounded-full">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-semibold">Rejected</span>
                        </div>
                    @endif
                </div>

                <!-- Application Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Brand Name</h3>
                        <p class="text-gray-900 font-semibold">{{ $application->brand_name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Submitted On</h3>
                        <p class="text-gray-900">{{ $application->created_at->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Contact Person</h3>
                        <p class="text-gray-900">{{ $application->contact_person }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Contact Email</h3>
                        <p class="text-gray-900">{{ $application->contact_email }}</p>
                    </div>
                </div>

                <!-- Status Messages -->
                <div class="border-t border-gray-200 pt-6">
                    @if($application->isPending())
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Application Under Review</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>Your application is currently being reviewed by our team. This process typically takes 2-3 business days.</p>
                                        <p class="mt-1">We'll contact you at {{ $application->contact_email }} with any questions or updates.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($application->isApproved())
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800">Application Approved!</h3>
                                    <div class="mt-2 text-sm text-green-700">
                                        <p>Congratulations! Your seller application has been approved.</p>
                                        <p class="mt-1">You can now start listing your products on GlowTrack.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="mt-4">
                            <a href="{{ route('products.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-jade-green text-white font-medium rounded-md hover:bg-opacity-90 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                List Your First Product
                            </a>
                        </div>
                    @else
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h3 class="text-sm font-medium text-red-800">Application Not Approved</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p>We're sorry, but your application could not be approved at this time.</p>
                                        @if($application->admin_notes)
                                            <p class="mt-2 p-3 bg-red-100 rounded"><strong>Feedback:</strong> {{ $application->admin_notes }}</p>
                                        @endif
                                        <p class="mt-2">You can submit a new application after addressing the feedback provided.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reapply Button -->
                        <div class="mt-4">
                            <a href="{{ route('seller.application.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Submit New Application
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Admin Review Information -->
                @if($application->reviewed_at)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Review Information</h3>
                        <div class="text-sm text-gray-600">
                            <p>Reviewed on: {{ $application->reviewed_at->format('F d, Y \a\t g:i A') }}</p>
                            @if($application->reviewer)
                                <p>Reviewed by: {{ $application->reviewer->name }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Business Information Summary -->
        <div class="mt-8 bg-white rounded-lg shadow">
            <div class="px-8 py-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Business Information</h2>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Business Description</h3>
                        <p class="text-gray-900">{{ $application->business_description }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Business Address</h3>
                        <p class="text-gray-900">{{ $application->business_address }}</p>
                    </div>
                    @if($application->website_url)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Website</h3>
                            <a href="{{ $application->website_url }}" target="_blank" class="text-jade-green hover:underline">
                                {{ $application->website_url }}
                            </a>
                        </div>
                    @endif
                    @if($application->business_license)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Business License</h3>
                            <p class="text-gray-900">{{ $application->business_license }}</p>
                        </div>
                    @endif
                </div>

                @if($application->product_categories)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Product Categories</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($application->product_categories as $category)
                                <span class="px-3 py-1 bg-jade-green text-white rounded-full text-sm">
                                    {{ $category }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
