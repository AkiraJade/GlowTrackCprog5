@extends('layouts.app')

@section('title', 'Creating an Account - GlowTrack Knowledge Base')

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
                            <span class="ml-1 text-soft-brown font-medium">Creating an Account</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Article Header -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center">
                    <span class="text-2xl">🚀</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Creating an Account</h1>
                    <p class="text-soft-brown opacity-75">Step-by-step guide to setting up your GlowTrack account</p>
                </div>
            </div>

            <!-- Article Meta -->
            <div class="flex items-center gap-6 text-sm text-soft-brown opacity-75 border-t border-b border-gray-200 py-4">
                <span>📅 Updated 2 days ago</span>
                <span>⏱️ 5 min read</span>
                <span>👁️ 1.2k views</span>
            </div>
        </div>

        <!-- Article Content -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-lg text-soft-brown leading-relaxed mb-6">
                    Welcome to GlowTrack! Creating an account is the first step to accessing our premium skincare products, earning loyalty points, and enjoying personalized recommendations. This guide will walk you through the simple registration process.
                </p>
            </div>

            <!-- Step 1 -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center font-bold">1</span>
                    Visit the Registration Page
                </h2>
                <p class="text-soft-brown mb-4">
                    Navigate to the GlowTrack homepage and click the "Register" button in the top navigation bar, or visit the registration page directly.
                </p>
                <div class="bg-light-sage bg-opacity-50 rounded-xl p-4 border border-jade-green">
                    <p class="text-sm font-medium text-jade-green mb-2">💡 Pro Tip:</p>
                    <p class="text-sm text-soft-brown">You can also register directly from the checkout process when making your first purchase.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center font-bold">2</span>
                    Fill in Your Information
                </h2>
                <p class="text-soft-brown mb-4">
                    Complete the registration form with your personal information:
                </p>
                <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="text-jade-green">✓</span>
                        <span><strong>Full Name:</strong> Your legal name as it appears on identification</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-jade-green">✓</span>
                        <span><strong>Username:</strong> A unique identifier for your account (3-20 characters)</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-jade-green">✓</span>
                        <span><strong>Email Address:</strong> Must be a valid email you have access to</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-jade-green">✓</span>
                        <span><strong>Password:</strong> Minimum 8 characters with mixed letters and numbers</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-jade-green">✓</span>
                        <span><strong>Phone Number:</strong> For order notifications and delivery updates</span>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center font-bold">3</span>
                    Verify Your Email
                </h2>
                <p class="text-soft-brown mb-4">
                    After submitting the form, you'll receive a verification email. Click the verification link to activate your account.
                </p>
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <p class="text-sm font-medium text-yellow-800 mb-2">⚠️ Important:</p>
                    <p class="text-sm text-yellow-700">Check your spam folder if you don't see the verification email within 5 minutes.</p>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center font-bold">4</span>
                    Complete Your Profile
                </h2>
                <p class="text-soft-brown mb-4">
                    Once verified, log in and complete your profile to get personalized recommendations:
                </p>
                <ul class="space-y-2 text-soft-brown">
                    <li class="flex items-start gap-2">
                        <span class="text-jade-green mt-1">•</span>
                        <span>Add your shipping address for faster checkout</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-jade-green mt-1">•</span>
                        <span>Set your skin type for product recommendations</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-jade-green mt-1">•</span>
                        <span>Upload a profile photo (optional)</span>
                    </li>
                </ul>
            </div>

            <!-- Benefits -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Account Benefits</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">🎁 Loyalty Points</h3>
                        <p class="text-sm text-soft-brown opacity-75">Earn points with every purchase and redeem rewards</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">💝 Wishlist</h3>
                        <p class="text-sm text-soft-brown opacity-75">Save your favorite products for later</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">📦 Order Tracking</h3>
                        <p class="text-sm text-soft-brown opacity-75">Track your orders and view purchase history</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">🎯 Personalized Recommendations</h3>
                        <p class="text-sm text-soft-brown opacity-75">Get product suggestions based on your preferences</p>
                    </div>
                </div>
            </div>

            <!-- Troubleshooting -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Common Issues</h2>
                <div class="space-y-4">
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "I didn't receive the verification email"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Check your spam folder, ensure the email address is correct, and try resending the verification email.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Username is already taken"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Try adding numbers or using a different variation of your preferred username.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Password is too weak"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Use a mix of uppercase, lowercase, numbers, and special characters for a strong password.</p>
                    </div>
                </div>
            </div>

            <!-- Related Articles -->
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-xl font-bold text-soft-brown mb-4">Related Articles</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('knowledge.update-profile') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Complete Your Profile →
                    </a>
                    <a href="{{ route('knowledge.first-purchase') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        First Purchase Guide →
                    </a>
                    <a href="{{ route('knowledge.password') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Change Password →
                    </a>
                </div>
            </div>

        </div>

        <!-- Help Section -->
        <div class="mt-8 text-center bg-white rounded-3xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-soft-brown mb-4">Still Need Help?</h3>
            <p class="text-soft-brown opacity-75 mb-6">Can't find what you're looking for? Our support team is here to help!</p>
            <a href="{{ route('support.contact') }}" 
               class="px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                Contact Support
            </a>
        </div>

    </div>
</div>
@endsection
