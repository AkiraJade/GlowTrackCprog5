@extends('layouts.app')

@section('title', 'Complete Your Profile - GlowTrack Knowledge Base')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <div class="mb-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('support.knowledge') }}" class="text-soft-brown hover:text-jade-green transition">
                            Knowledge Base
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-soft-brown mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="#" class="ml-1 text-soft-brown hover:text-jade-green transition">Getting Started</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-soft-brown mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-soft-brown font-medium">Complete Your Profile</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Article Header -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center">
                    <span class="text-2xl">👤</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Complete Your Profile</h1>
                    <p class="text-soft-brown opacity-75">Personalize your GlowTrack experience with a complete profile</p>
                </div>
            </div>

            <!-- Article Meta -->
            <div class="flex items-center gap-6 text-sm text-soft-brown opacity-75 border-t border-b border-gray-200 py-4">
                <span>📅 Updated 1 day ago</span>
                <span>⏱️ 4 min read</span>
                <span>👁️ 892 views</span>
            </div>
        </div>

        <!-- Article Content -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-lg text-soft-brown leading-relaxed mb-6">
                    A complete profile helps us provide you with personalized product recommendations, faster checkout, and a better overall shopping experience. Follow this guide to fill out all the important sections of your GlowTrack profile.
                </p>
            </div>

            <!-- Profile Sections -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Profile Sections to Complete</h2>
                
                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3 flex items-center gap-2">
                            <span>📝</span> Basic Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Full Name</p>
                                <p class="text-sm text-soft-brown opacity-75">Your legal name for order processing</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Username</p>
                                <p class="text-sm text-soft-brown opacity-75">Unique identifier for your account</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Email Address</p>
                                <p class="text-sm text-soft-brown opacity-75">Primary communication channel</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Phone Number</p>
                                <p class="text-sm text-soft-brown opacity-75">For order notifications and delivery</p>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Details -->
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3 flex items-center gap-2">
                            <span>🎂</span> Personal Details
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Birth Date</p>
                                <p class="text-sm text-soft-brown opacity-75">For birthday rewards and age-appropriate products</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Gender</p>
                                <p class="text-sm text-soft-brown opacity-75">Helps with product recommendations</p>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3 flex items-center gap-2">
                            <span>🏠</span> Address Information
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Shipping Address</p>
                                <p class="text-sm text-soft-brown opacity-75">Where your orders will be delivered</p>
                                <div class="bg-white rounded-lg p-3 mt-2">
                                    <p class="text-xs text-gray-600">Street Address, City, Province, Postal Code</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Billing Address</p>
                                <p class="text-sm text-soft-brown opacity-75">Same as shipping address (can be different)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Preferences -->
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3 flex items-center gap-2">
                            <span>⚙️</span> Preferences
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Skin Type</p>
                                <p class="text-sm text-soft-brown opacity-75">Oily, Dry, Combination, Sensitive, Normal</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Skin Concerns</p>
                                <p class="text-sm text-soft-brown opacity-75">Acne, Aging, Dark Spots, Sensitivity, etc.</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Product Preferences</p>
                                <p class="text-sm text-soft-brown opacity-75">Organic, Vegan, Cruelty-free, etc.</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Budget Range</p>
                                <p class="text-sm text-soft-brown opacity-75">Helps us recommend suitable products</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How to Update Profile -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">How to Update Your Profile</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">1</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Log In to Your Account</h3>
                            <p class="text-sm text-soft-brown opacity-75">Access your GlowTrack account using your credentials</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">2</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Go to Profile Settings</h3>
                            <p class="text-sm text-soft-brown opacity-75">Click on your profile icon and select "Profile Settings"</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">3</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Update Information</h3>
                            <p class="text-sm text-soft-brown opacity-75">Fill in or update each section with accurate information</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">4</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Save Changes</h3>
                            <p class="text-sm text-soft-brown opacity-75">Click "Save" to update your profile information</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Benefits -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Benefits of a Complete Profile</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                        <h3 class="font-semibold text-green-800 mb-2">🎯 Personalized Recommendations</h3>
                        <p class="text-sm text-green-700">Get product suggestions based on your skin type and preferences</p>
                    </div>
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <h3 class="font-semibold text-blue-800 mb-2">⚡ Faster Checkout</h3>
                        <p class="text-sm text-blue-700">Auto-fill shipping and billing information during checkout</p>
                    </div>
                    <div class="bg-purple-50 border border-purple-200 rounded-xl p-4">
                        <h3 class="font-semibold text-purple-800 mb-2">🎁 Birthday Rewards</h3>
                        <p class="text-sm text-purple-700">Receive special birthday treats and loyalty points</p>
                    </div>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                        <h3 class="font-semibold text-yellow-800 mb-2">📧 Better Communication</h3>
                        <p class="text-sm text-yellow-700">Receive relevant updates and offers based on your preferences</p>
                    </div>
                </div>
            </div>

            <!-- Privacy Settings -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Privacy Settings</h2>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <p class="text-sm text-blue-700 mb-4">Control how your information is used:</p>
                    <ul class="space-y-2 text-sm text-blue-700">
                        <li>• Profile visibility to other users</li>
                        <li>• Email marketing preferences</li>
                        <li>• Order status notifications</li>
                        <li>• Personalized advertising</li>
                        <li>• Data sharing with partners</li>
                    </ul>
                </div>
            </div>

            <!-- Troubleshooting -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Common Issues</h2>
                <div class="space-y-4">
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Can't save profile changes"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Ensure all required fields are filled out and check your internet connection.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Address not found"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Double-check the address format and postal code for accuracy.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Phone number already in use"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Each phone number can only be used by one account. Contact support if needed.</p>
                    </div>
                </div>
            </div>

            <!-- Related Articles -->
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-xl font-bold text-soft-brown mb-4">Related Articles</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('knowledge.creating-account') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Creating an Account →
                    </a>
                    <a href="{{ route('knowledge.password') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Change Password →
                    </a>
                    <a href="{{ route('knowledge.addresses') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Manage Addresses →
                    </a>
                </div>
            </div>

        </div>

        <!-- Help Section -->
        <div class="mt-8 text-center bg-white rounded-3xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-soft-brown mb-4">Need Help with Your Profile?</h3>
            <p class="text-soft-brown opacity-75 mb-6">Our support team is here to help you complete your profile!</p>
            <a href="{{ route('support.contact') }}" 
               class="px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                Contact Support
            </a>
        </div>

    </div>
</div>
@endsection
