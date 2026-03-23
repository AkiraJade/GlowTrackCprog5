@extends('layouts.app')

@section('title', 'Frequently Asked Questions - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-xl p-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-3">Frequently Asked Questions</h1>
                        <p class="text-lg text-soft-brown opacity-75">Find answers to common questions about GlowTrack</p>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('products.index') }}" class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                            ← Products
                        </a>
                        <a href="{{ route('support.contact') }}" class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-opacity-90 transition font-semibold">
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Categories -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Getting Started -->
            <div class="bg-white rounded-3xl shadow-xl p-6">
                <div class="text-center mb-4">
                    <div class="text-4xl mb-2">🚀</div>
                    <h3 class="text-xl font-bold text-soft-brown mb-2">Getting Started</h3>
                </div>
                <div class="space-y-3">
                    <a href="{{ route('knowledge.creating-account') }}" class="block p-3 rounded-xl hover:bg-mint-cream transition">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-soft-brown">Creating Account</span>
                            <span class="text-jade-green">→</span>
                        </div>
                    </a>
                    <a href="{{ route('knowledge.complete-profile') }}" class="block p-3 rounded-xl hover:bg-mint-cream transition">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-soft-brown">Complete Profile</span>
                            <span class="text-jade-green">→</span>
                        </div>
                    </a>
                    <a href="{{ route('knowledge.first-purchase') }}" class="block p-3 rounded-xl hover:bg-mint-cream transition">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-soft-brown">First Purchase</span>
                            <span class="text-jade-green">→</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Orders & Shipping -->
            <div class="bg-white rounded-3xl shadow-xl p-6">
                <div class="text-center mb-4">
                    <div class="text-4xl mb-2">📦</div>
                    <h3 class="text-xl font-bold text-soft-brown mb-2">Orders & Shipping</h3>
                </div>
                <div class="space-y-3">
                    <a href="{{ route('knowledge.track-order') }}" class="block p-3 rounded-xl hover:bg-mint-cream transition">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-soft-brown">Track Order</span>
                            <span class="text-jade-green">→</span>
                        </div>
                    </a>
                    <a href="{{ route('knowledge.shipping') }}" class="block p-3 rounded-xl hover:bg-mint-cream transition">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-soft-brown">Shipping Info</span>
                            <span class="text-jade-green">→</span>
                        </div>
                    </a>
                    <a href="{{ route('knowledge.returns') }}" class="block p-3 rounded-xl hover:bg-mint-cream transition">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-soft-brown">Returns & Refunds</span>
                            <span class="text-jade-green">→</span>
                        </div>
                    </a>
                    <a href="{{ route('knowledge.cancel-order') }}" class="block p-3 rounded-xl hover:bg-mint-cream transition">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-soft-brown">Cancel Order</span>
                            <span class="text-jade-green">→</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Account & Settings -->
            <div class="bg-white rounded-3xl shadow-xl p-6">
                <div class="text-center mb-4">
                    <div class="text-4xl mb-2">⚙️</div>
                    <h3 class="text-xl font-bold text-soft-brown mb-2">Account & Settings</h3>
                </div>
                <div class="space-y-3">
                    <a href="{{ route('knowledge.update-profile') }}" class="block p-3 rounded-xl hover:bg-mint-cream transition">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-soft-brown">Update Profile</span>
                            <span class="text-jade-green">→</span>
                        </div>
                    </a>
                    <a href="{{ route('knowledge.password') }}" class="block p-3 rounded-xl hover:bg-mint-cream transition">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-soft-brown">Password Reset</span>
                            <span class="text-jade-green">→</span>
                        </div>
                    </a>
                    <a href="{{ route('knowledge.addresses') }}" class="block p-3 rounded-xl hover:bg-mint-cream transition">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-soft-brown">Manage Addresses</span>
                            <span class="text-jade-green">→</span>
                        </div>
                    </a>
                    <a href="{{ route('knowledge.privacy') }}" class="block p-3 rounded-xl hover:bg-mint-cream transition">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-soft-brown">Privacy Settings</span>
                            <span class="text-jade-green">→</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Popular Articles -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-8">Popular Help Articles</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-soft-brown mb-4">Payment & Security</h3>
                    <div class="space-y-3">
                        <a href="{{ route('knowledge.payment-security') }}" class="block p-4 rounded-xl border-2 border-gray-200 hover:border-jade-green hover:bg-mint-cream transition">
                            <div class="flex items-center">
                                <div class="text-2xl mr-3">💳</div>
                                <div>
                                    <div class="font-medium text-soft-brown">Payment Security</div>
                                    <div class="text-sm text-soft-brown opacity-75">Learn about secure payments</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-soft-brown mb-4">Loyalty Program</h3>
                    <div class="space-y-3">
                        <a href="{{ route('knowledge.loyalty-program') }}" class="block p-4 rounded-xl border-2 border-gray-200 hover:border-jade-green hover:bg-mint-cream transition">
                            <div class="flex items-center">
                                <div class="text-2xl mr-3">⭐</div>
                                <div>
                                    <div class="font-medium text-soft-brown">Loyalty Points</div>
                                    <div class="text-sm text-soft-brown opacity-75">Earn rewards with every purchase</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-soft-brown mb-4">Product Quality</h3>
                    <div class="space-y-3">
                        <a href="{{ route('knowledge.product-quality') }}" class="block p-4 rounded-xl border-2 border-gray-200 hover:border-jade-green hover:bg-mint-cream transition">
                            <div class="flex items-center">
                                <div class="text-2xl mr-3">🧴</div>
                                <div>
                                    <div class="font-medium text-soft-brown">Product Quality</div>
                                    <div class="text-sm text-soft-brown opacity-75">Our quality guarantee</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-soft-brown mb-4">Become a Seller</h3>
                    <div class="space-y-3">
                        <a href="{{ route('knowledge.become-seller') }}" class="block p-4 rounded-xl border-2 border-gray-200 hover:border-jade-green hover:bg-mint-cream transition">
                            <div class="flex items-center">
                                <div class="text-2xl mr-3">🏪</div>
                                <div>
                                    <div class="font-medium text-soft-brown">Sell on GlowTrack</div>
                                    <div class="text-sm text-soft-brown opacity-75">Join our seller community</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="mt-8">
            <div class="bg-white rounded-3xl shadow-xl p-8">
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-soft-brown font-playfair mb-4">Still Need Help?</h3>
                    <p class="text-soft-brown opacity-75 mb-6">Can't find what you're looking for? Our support team is here to help!</p>
                    
                    <div class="flex flex-col md:flex-row gap-6 justify-center">
                        <a href="{{ route('support.contact') }}" class="px-8 py-3 bg-jade-green text-white rounded-full hover:bg-opacity-90 transition font-bold text-lg">
                            📧 Contact Support
                        </a>
                        <a href="{{ route('support.forum') }}" class="px-8 py-3 border-2 border-soft-brown text-soft-brown rounded-full hover:bg-soft-brown hover:text-white transition font-bold text-lg">
                            💬 Community Forum
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
