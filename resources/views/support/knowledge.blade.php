@extends('layouts.app')

@section('title', 'Knowledge Base - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-soft-brown font-playfair mb-4">
                Knowledge Base
            </h1>
            <p class="text-lg text-soft-brown opacity-75">
                Find answers to common questions and learn how to make the most of GlowTrack.
            </p>
        </div>

        <!-- Search Bar -->
        <div class="mb-12">
            <div class="max-w-2xl mx-auto">
                <div class="relative">
                    <input type="text" 
                           placeholder="Search for answers..." 
                           class="w-full px-6 py-4 pr-12 border border-light-sage rounded-2xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition text-lg">
                    <button class="absolute right-4 top-1/2 transform -translate-y-1/2 text-jade-green hover:text-soft-brown transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- Getting Started -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition">
                <div class="text-center mb-6">
                    <p class="text-4xl mb-3">🚀</p>
                    <h3 class="text-xl font-bold text-soft-brown font-playfair">Getting Started</h3>
                </div>
                <ul class="space-y-3">
                    <li>
                        <a href="#getting-started" class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-jade-green hover:text-white transition group">
                            <span class="text-sm font-medium">Creating an Account</span>
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#getting-started" class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-jade-green hover:text-white transition group">
                            <span class="text-sm font-medium">Complete Your Profile</span>
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#getting-started" class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-jade-green hover:text-white transition group">
                            <span class="text-sm font-medium">First Purchase Guide</span>
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Orders & Shipping -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition">
                <div class="text-center mb-6">
                    <p class="text-4xl mb-3">📦</p>
                    <h3 class="text-xl font-bold text-soft-brown font-playfair">Orders & Shipping</h3>
                </div>
                <ul class="space-y-3">
                    <li>
                        <a href="#orders" class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-jade-green hover:text-white transition group">
                            <span class="text-sm font-medium">Track Your Order</span>
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#orders" class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-jade-green hover:text-white transition group">
                            <span class="text-sm font-medium">Shipping Information</span>
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#orders" class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-jade-green hover:text-white transition group">
                            <span class="text-sm font-medium">Returns & Refunds</span>
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#orders" class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-jade-green hover:text-white transition group">
                            <span class="text-sm font-medium">Cancel an Order</span>
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Account & Settings -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition">
                <div class="text-center mb-6">
                    <p class="text-4xl mb-3">⚙️</p>
                    <h3 class="text-xl font-bold text-soft-brown font-playfair">Account & Settings</h3>
                </div>
                <ul class="space-y-3">
                    <li>
                        <a href="#account" class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-jade-green hover:text-white transition group">
                            <span class="text-sm font-medium">Update Profile Information</span>
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#account" class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-jade-green hover:text-white transition group">
                            <span class="text-sm font-medium">Change Password</span>
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#account" class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-jade-green hover:text-white transition group">
                            <span class="text-sm font-medium">Manage Addresses</span>
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#account" class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-jade-green hover:text-white transition group">
                            <span class="text-sm font-medium">Privacy Settings</span>
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Popular Articles -->
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 mb-12">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-8">Popular Articles</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Article 1 -->
                <div class="border border-light-sage rounded-xl p-6 hover:border-jade-green hover:shadow-lg transition">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <p class="text-2xl">💳</p>
                        </div>
                        <div>
                            <h3 class="font-bold text-soft-brown mb-2">Payment Methods & Security</h3>
                            <p class="text-sm text-soft-brown opacity-75 mb-4">Learn about accepted payment methods and how we keep your information secure.</p>
                            <a href="#payment" class="text-jade-green hover:text-soft-brown font-semibold text-sm transition">
                                Read More →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Article 2 -->
                <div class="border border-light-sage rounded-xl p-6 hover:border-jade-green hover:shadow-lg transition">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <p class="text-2xl">⭐</p>
                        </div>
                        <div>
                            <h3 class="font-bold text-soft-brown mb-2">Loyalty Program Explained</h3>
                            <p class="text-sm text-soft-brown opacity-75 mb-4">Understand how to earn points and redeem rewards in our loyalty program.</p>
                            <a href="#loyalty" class="text-jade-green hover:text-soft-brown font-semibold text-sm transition">
                                Read More →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Article 3 -->
                <div class="border border-light-sage rounded-xl p-6 hover:border-jade-green hover:shadow-lg transition">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <p class="text-2xl">🛡️</p>
                        </div>
                        <div>
                            <h3 class="font-bold text-soft-brown mb-2">Product Quality & Authenticity</h3>
                            <p class="text-sm text-soft-brown opacity-75 mb-4">Information about our product quality standards and authenticity guarantees.</p>
                            <a href="#quality" class="text-jade-green hover:text-soft-brown font-semibold text-sm transition">
                                Read More →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Article 4 -->
                <div class="border border-light-sage rounded-xl p-6 hover:border-jade-green hover:shadow-lg transition">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <p class="text-2xl">🤝</p>
                        </div>
                        <div>
                            <h3 class="font-bold text-soft-brown mb-2">Become a Seller</h3>
                            <p class="text-sm text-soft-brown opacity-75 mb-4">Step-by-step guide to becoming a seller on GlowTrack and reaching more customers.</p>
                            <a href="#seller" class="text-jade-green hover:text-soft-brown font-semibold text-sm transition">
                                Read More →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Still Need Help -->
        <div class="text-center bg-white rounded-3xl shadow-xl p-8 md:p-12">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-4">Still Need Help?</h2>
            <p class="text-soft-brown opacity-75 mb-8">Can't find what you're looking for? Our support team is here to help!</p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('support.contact') }}" 
                   class="px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                    Contact Support
                </a>
                <a href="{{ route('dashboard') }}" 
                   class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
