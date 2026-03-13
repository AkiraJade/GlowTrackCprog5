@extends('layouts.app')

@section('title', 'Update Profile Information - GlowTrack Knowledge Base')

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
                            <a href="#" class="ml-1 text-soft-brown hover:text-jade-green transition">Account & Settings</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-soft-brown mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-soft-brown font-medium">Update Profile Information</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Article Header -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center">
                    <span class="text-2xl">📝</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Update Profile Information</h1>
                    <p class="text-soft-brown opacity-75">Keep your account information current and accurate</p>
                </div>
            </div>

            <!-- Article Meta -->
            <div class="flex items-center gap-6 text-sm text-soft-brown opacity-75 border-t border-b border-gray-200 py-4">
                <span>📅 Updated 3 days ago</span>
                <span>⏱️ 5 min read</span>
                <span>👁️ 756 views</span>
            </div>
        </div>

        <!-- Article Content -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-lg text-soft-brown leading-relaxed mb-6">
                    Keeping your profile information up-to-date ensures smooth order processing, accurate delivery, and personalized recommendations. Learn how to update your account details quickly and easily.
                </p>
            </div>

            <!-- Profile Sections -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Profile Information You Can Update</h2>
                
                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3 flex items-center gap-2">
                            <span>👤</span> Basic Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Full Name</p>
                                <p class="text-sm text-soft-brown opacity-75">Your legal name for orders</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Username</p>
                                <p class="text-sm text-soft-brown opacity-75">Unique account identifier</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Email Address</p>
                                <p class="text-sm text-soft-brown opacity-75">Primary communication channel</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Phone Number</p>
                                <p class="text-sm text-soft-brown opacity-75">For delivery notifications</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Details -->
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3 flex items-center gap-2">
                            <span>📱</span> Contact Details
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Address</p>
                                <p class="text-sm text-soft-brown opacity-75">Shipping and billing address</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">City/Province</p>
                                <p class="text-sm text-soft-brown opacity-75">Location for shipping</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Postal Code</p>
                                <p class="text-sm text-soft-brown opacity-75">For accurate delivery</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Country</p>
                                <p class="text-sm text-soft-brown opacity-75">Philippines</p>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Preferences -->
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3 flex items-center gap-2">
                            <span>⚙️</span> Personal Preferences
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Skin Type</p>
                                <p class="text-sm text-soft-brown opacity-75">For product recommendations</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Skin Concerns</p>
                                <p class="text-sm text-soft-brown opacity-75">Targeted product suggestions</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Birth Date</p>
                                <p class="text-sm text-soft-brown opacity-75">For birthday rewards</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-1">Gender</p>
                                <p class="text-sm text-soft-brown opacity-75">Optional demographic info</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How to Update -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">How to Update Your Profile</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">1</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Log In to Your Account</h3>
                            <p class="text-sm text-soft-brown opacity-75">Access your GlowTrack account with your email and password</p>
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
                            <h3 class="font-semibold text-soft-brown mb-1">Edit Information</h3>
                            <p class="text-sm text-soft-brown opacity-75">Click the "Edit" button in any section to update details</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">4</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Save Changes</h3>
                            <p class="text-sm text-soft-brown opacity-75">Click "Update Profile" to save your changes</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Benefits -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Benefits of Keeping Profile Updated</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                        <h3 class="font-semibold text-green-800 mb-2">🎯 Better Recommendations</h3>
                        <p class="text-sm text-green-700">Personalized product suggestions based on your preferences</p>
                    </div>
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <h3 class="font-semibold text-blue-800 mb-2">⚡ Faster Checkout</h3>
                        <p class="text-sm text-blue-700">Auto-fill information during checkout process</p>
                    </div>
                    <div class="bg-purple-50 border border-purple-200 rounded-xl p-4">
                        <h3 class="font-semibold text-purple-800 mb-2">🎁 Birthday Rewards</h3>
                        <p class="text-sm text-purple-700">Receive special birthday treats and offers</p>
                    </div>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                        <h3 class="font-semibold text-yellow-800 mb-2">📧 Important Updates</h3>
                        <p class="text-sm text-yellow-700">Receive relevant notifications about your orders</p>
                    </div>
                </div>
            </div>

            <!-- Privacy Settings -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Privacy and Security</h2>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <p class="text-sm text-blue-700 mb-4">Your profile information is secure and private:</p>
                    <ul class="space-y-2 text-sm text-blue-700">
                        <li>• We use industry-standard encryption to protect your data</li>
                        <li>• Your information is never shared with third parties without consent</li>
                        <li>• You can control what information is visible to other users</li>
                        <li>• You can opt out of marketing communications anytime</li>
                        <li>• You can request deletion of your account and data</li>
                    </ul>
                </div>
            </div>

            <!-- Common Issues -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Common Profile Issues</h2>
                <div class="space-y-4">
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Can't update my email address"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Email addresses cannot be changed for security reasons. Contact support for assistance.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Address not recognized"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Double-check the address format and ensure all required fields are filled.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Changes not saving"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Ensure all required fields are filled and click the update button.</p>
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
                    <a href="{{ route('knowledge.complete-profile') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Complete Your Profile →
                    </a>
                    <a href="{{ route('knowledge.password') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Change Password →
                    </a>
                </div>
            </div>

        </div>

        <!-- Help Section -->
        <div class="mt-8 text-center bg-white rounded-3xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-soft-brown mb-4">Profile Help Needed?</h3>
            <p class="text-soft-brown opacity-75 mb-6">Our support team can help you update your profile information!</p>
            <a href="{{ route('support.contact') }}" 
               class="px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                Contact Support
            </a>
        </div>

    </div>
</div>
@endsection
