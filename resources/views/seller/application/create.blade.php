@extends('layouts.app')

@section('title', 'Become a Seller - GlowTrack')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Become a GlowTrack Seller</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Join our marketplace and reach thousands of skincare enthusiasts looking for quality products.
            </p>
        </div>

        <!-- Reapplication Notice -->
        @if($isReapplication)
            <div class="mb-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Resubmitting Your Application</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>We appreciate you addressing our feedback! Please review and update your application information below.</p>
                            @if($rejectedApplication && $rejectedApplication->admin_notes)
                                <p class="mt-2 p-2 bg-blue-100 rounded"><strong>Previous Feedback:</strong> {{ $rejectedApplication->admin_notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Benefits -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="glass-card p-6 rounded-lg shadow text-center border border-gray-200">
                <div class="text-3xl mb-4">🎯</div>
                <h3 class="font-semibold text-gray-900 mb-2">Targeted Audience</h3>
                <p class="text-gray-600">Access customers actively searching for skincare solutions</p>
            </div>
            <div class="glass-card p-6 rounded-lg shadow text-center border border-gray-200">
                <div class="text-3xl mb-4">📈</div>
                <h3 class="font-semibold text-gray-900 mb-2">Growth Tools</h3>
                <p class="text-gray-600">Analytics and insights to grow your skincare business</p>
            </div>
            <div class="glass-card p-6 rounded-lg shadow text-center border border-gray-200">
                <div class="text-3xl mb-4">🤝</div>
                <h3 class="font-semibold text-gray-900 mb-2">Seller Support</h3>
                <p class="text-gray-600">Dedicated support and resources for your success</p>
            </div>
        </div>

        <!-- Application Form -->
        <div class="glass-card rounded-lg shadow-lg border border-gray-200">
            <div class="px-8 py-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Seller Application</h2>
                <p class="text-gray-600 mt-2">Please provide your business information to apply for a seller account.</p>
            </div>

            <form method="POST" action="{{ route('seller.application.store') }}" class="p-8">
                @csrf

                <!-- Business Information -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Business Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Brand Name -->
                        <div>
                            <label for="brand_name" class="block text-sm font-medium text-gray-700 mb-1">Brand Name *</label>
                            <input type="text" id="brand_name" name="brand_name" required
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
                                   placeholder="Your brand name"
                                   value="{{ old('brand_name', $isReapplication && $rejectedApplication ? $rejectedApplication->brand_name : '') }}">
                            @error('brand_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Business License -->
                        <div>
                            <label for="business_license" class="block text-sm font-medium text-gray-700 mb-1">Business License Number</label>
                            <input type="text" id="business_license" name="business_license"
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
                                   placeholder="License number (if applicable)"
                                   value="{{ old('business_license', $isReapplication && $rejectedApplication ? $rejectedApplication->business_license : '') }}">
                            @error('business_license')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Business Description -->
                        <div class="md:col-span-2">
                            <label for="business_description" class="block text-sm font-medium text-gray-700 mb-1">Business Description *</label>
                            <textarea id="business_description" name="business_description" rows="4" required
                                      class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
                                      placeholder="Tell us about your business, your products, and what makes you unique...">{{ old('business_description', $isReapplication && $rejectedApplication ? $rejectedApplication->business_description : '') }}</textarea>
                            @error('business_description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Website URL -->
                        <div class="md:col-span-2">
                            <label for="website_url" class="block text-sm font-medium text-gray-700 mb-1">Website URL</label>
                            <input type="url" id="website_url" name="website_url"
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
                                   placeholder="https://yourwebsite.com"
                                   value="{{ old('website_url', $isReapplication && $rejectedApplication ? $rejectedApplication->website_url : '') }}">
                            @error('website_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Contact Person -->
                        <div>
                            <label for="contact_person" class="block text-sm font-medium text-gray-700 mb-1">Contact Person *</label>
                            <input type="text" id="contact_person" name="contact_person" required
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
                                   placeholder="Full name of primary contact"
                                   value="{{ old('contact_person', $isReapplication && $rejectedApplication ? $rejectedApplication->contact_person : '') }}">
                            @error('contact_person')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contact Email -->
                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Contact Email *</label>
                            <input type="email" id="contact_email" name="contact_email" required
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
                                   placeholder="business@example.com"
                                   value="{{ old('contact_email', $isReapplication && $rejectedApplication ? $rejectedApplication->contact_email : '') }}">
                            @error('contact_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contact Phone -->
                        <div>
                            <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">Contact Phone *</label>
                            <input type="tel" id="contact_phone" name="contact_phone" required
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
                                   placeholder="+1 (555) 123-4567"
                                   value="{{ old('contact_phone', $isReapplication && $rejectedApplication ? $rejectedApplication->contact_phone : '') }}">
                            @error('contact_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Business Address -->
                        <div>
                            <label for="business_address" class="block text-sm font-medium text-gray-700 mb-1">Business Address *</label>
                            <input type="text" id="business_address" name="business_address" required
                                   class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green"
                                   placeholder="123 Business St, City, State 12345"
                                   value="{{ old('business_address', $isReapplication && $rejectedApplication ? $rejectedApplication->business_address : '') }}">
                            @error('business_address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Product Categories -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Categories *</h3>
                    <p class="text-gray-600 mb-4">Select all product categories you plan to sell on GlowTrack:</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($categories as $category)
                            <label class="flex items-center">
                                <input type="checkbox" name="product_categories[]" value="{{ $category }}"
                                       class="mr-2 border-gray-300 rounded text-jade-green focus:ring-jade-green"
                                       @if($isReapplication && $rejectedApplication && in_array($category, $rejectedApplication->product_categories)) checked @endif>
                                <span class="text-sm text-gray-700">{{ $category }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('product_categories')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms and Conditions -->
                <div class="mb-8">
                    <label class="flex items-start">
                        <input type="checkbox" name="terms" required
                               class="w-4 h-4 border-gray-300 rounded text-jade-green focus:ring-jade-green mt-1">
                        <span class="ml-2 text-sm text-gray-700">
                            I agree to the GlowTrack Seller Terms of Service and understand that my application will be reviewed by the GlowTrack team.
                        </span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="px-8 py-3 bg-jade-green text-white font-semibold rounded-lg hover:bg-opacity-90 transition">
                        Submit Application
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Application Process</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>Once submitted, your application will be reviewed within 2-3 business days. We'll contact you at the email address provided with any questions or updates.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
