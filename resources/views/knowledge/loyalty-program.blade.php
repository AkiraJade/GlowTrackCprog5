@extends('layouts.app')

@section('title', 'Loyalty Program Explained - GlowTrack Knowledge Base')

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
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-soft-brown mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-soft-brown font-medium">Loyalty Program Explained</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Article Header -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center">
                    <span class="text-2xl">⭐</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Loyalty Program Explained</h1>
                    <p class="text-soft-brown opacity-75">How to earn points and redeem rewards at GlowTrack</p>
                </div>
            </div>

            <!-- Article Meta -->
            <div class="flex items-center gap-6 text-sm text-soft-brown opacity-75 border-t border-b border-gray-200 py-4">
                <span>📅 Updated 3 days ago</span>
                <span>⏱️ 6 min read</span>
                <span>👁️ 2.3k views</span>
            </div>
        </div>

        <!-- Article Content -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-lg text-soft-brown leading-relaxed mb-6">
                    The GlowTrack Loyalty Program rewards our valued customers for their continued support. Earn points with every purchase and redeem them for exciting rewards, discounts, and exclusive benefits.
                </p>
            </div>

            <!-- How it Works -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">How It Works</h2>
                <div class="bg-gradient-to-r from-jade-green to-light-sage text-white rounded-xl p-6 mb-6">
                    <p class="text-center text-lg font-semibold mb-2">Simple Formula: Shop → Earn → Redeem</p>
                    <p class="text-center opacity-90">Every product quantity you purchase earns you 1 loyalty point</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-2xl">🛍️</span>
                        </div>
                        <h3 class="font-semibold text-soft-brown mb-2">Shop</h3>
                        <p class="text-sm text-soft-brown opacity-75">Purchase your favorite skincare products</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-2xl">⭐</span>
                        </div>
                        <h3 class="font-semibold text-soft-brown mb-2">Earn</h3>
                        <p class="text-sm text-soft-brown opacity-75">Get 1 point per product quantity</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-2xl">🎁</span>
                        </div>
                        <h3 class="font-semibold text-soft-brown mb-2">Redeem</h3>
                        <p class="text-sm text-soft-brown opacity-75">Exchange points for rewards</p>
                    </div>
                </div>
            </div>

            <!-- Membership Tiers -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Membership Tiers</h2>
                <div class="space-y-4">
                    <div class="border border-gray-300 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-soft-brown">🥉 Bronze Member</h3>
                            <span class="text-sm text-gray-500">0-99 points</span>
                        </div>
                        <p class="text-sm text-soft-brown opacity-75">Welcome tier with basic earning opportunities</p>
                    </div>
                    <div class="border border-gray-300 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-soft-brown">🥈 Silver Member</h3>
                            <span class="text-sm text-gray-500">100-499 points</span>
                        </div>
                        <p class="text-sm text-soft-brown opacity-75">Enhanced benefits and exclusive offers</p>
                    </div>
                    <div class="border border-gray-300 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-soft-brown">🥇 Gold Member</h3>
                            <span class="text-sm text-gray-500">500+ points</span>
                        </div>
                        <p class="text-sm text-soft-brown opacity-75">Premium tier with maximum benefits</p>
                    </div>
                </div>
            </div>

            <!-- Earning Opportunities -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Ways to Earn Points</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3 flex items-center gap-2">
                            <span>🛍️</span> Make Purchases
                        </h3>
                        <p class="text-sm text-soft-brown opacity-75 mb-2">1 point per product quantity</p>
                        <div class="text-xs text-soft-brown">
                            <p>Example: Buy 3 products = 3 points</p>
                            <p>Example: Buy 10 of same product = 10 points</p>
                        </div>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3 flex items-center gap-2">
                            <span>✍️</span> Write Reviews
                        </h3>
                        <p class="text-sm text-soft-brown opacity-75 mb-2">10 points per verified review</p>
                        <div class="text-xs text-soft-brown">
                            <p>Share your experience with purchased products</p>
                        </div>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3 flex items-center gap-2">
                            <span>🎂</span> Birthday Bonus
                        </h3>
                        <p class="text-sm text-soft-brown opacity-75 mb-2">25 points annually</p>
                        <div class="text-xs text-soft-brown">
                            <p>Special birthday treat from us</p>
                        </div>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3 flex items-center gap-2">
                            <span>👥</span> Refer Friends
                        </h3>
                        <p class="text-sm text-soft-brown opacity-75 mb-2">50 points per referral</p>
                        <div class="text-xs text-soft-brown">
                            <p>When your friend makes their first purchase</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Rewards -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Available Rewards</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">🎫 10% Discount</h3>
                        <p class="text-sm text-soft-brown opacity-75 mb-2">10% off your next order</p>
                        <p class="text-jade-green font-bold">100 points</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">🚚 Free Shipping</h3>
                        <p class="text-sm text-soft-brown opacity-75 mb-2">Free shipping on next order</p>
                        <p class="text-jade-green font-bold">50 points</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">💆 VIP Consultation</h3>
                        <p class="text-sm text-soft-brown opacity-75 mb-2">30-minute skincare consultation</p>
                        <p class="text-jade-green font-bold">300 points</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">🎁 15% Discount</h3>
                        <p class="text-sm text-soft-brown opacity-75 mb-2">15% off your next order</p>
                        <p class="text-jade-green font-bold">150 points</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">💋 Face Mask Set</h3>
                        <p class="text-sm text-soft-brown opacity-75 mb-2">Premium face mask bundle</p>
                        <p class="text-jade-green font-bold">200 points</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">🌟 Exclusive Access</h3>
                        <p class="text-sm text-soft-brown opacity-75 mb-2">Early access to new products</p>
                        <p class="text-jade-green font-bold">500 points</p>
                    </div>
                </div>
            </div>

            <!-- How to Redeem -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">How to Redeem Rewards</h2>
                <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                    <ol class="space-y-2 text-soft-brown">
                        <li>1. Go to your dashboard and click on "Loyalty Points"</li>
                        <li>2. Browse available rewards</li>
                        <li>3. Click "Redeem" on your chosen reward</li>
                        <li>4. Confirm the redemption</li>
                        <li>5. Check your email for reward details</li>
                    </ol>
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Terms & Conditions</h2>
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <ul class="space-y-2 text-sm text-yellow-800">
                        <li>• Points are earned per product quantity, not per order value</li>
                        <li>• Points are credited immediately after order confirmation</li>
                        <li>• Rewards are subject to availability</li>
                        <li>• Points cannot be transferred between accounts</li>
                        <li>• Points expire after 12 months of inactivity</li>
                        <li>• GlowTrack reserves the right to modify the program</li>
                    </ul>
                </div>
            </div>

            <!-- FAQ -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Frequently Asked Questions</h2>
                <div class="space-y-4">
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ How do I check my points balance?</h3>
                        <p class="text-sm text-soft-brown opacity-75">Log in to your account and visit the Loyalty Points section in your dashboard.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ Can I combine rewards with discounts?</h3>
                        <p class="text-sm text-soft-brown opacity-75">Most rewards can be combined with other promotions, but some exclusions apply.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ Do points expire?</h3>
                        <p class="text-sm text-soft-brown opacity-75">Points expire after 12 months of inactivity. Regular purchases keep your points active.</p>
                    </div>
                </div>
            </div>

            <!-- Related Articles -->
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-xl font-bold text-soft-brown mb-4">Related Articles</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('loyalty.points') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        View My Points →
                    </a>
                    <a href="{{ route('support.knowledge') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        All Rewards →
                    </a>
                    <a href="{{ route('support.knowledge') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Membership Benefits →
                    </a>
                </div>
            </div>

        </div>

        <!-- Help Section -->
        <div class="mt-8 text-center bg-white rounded-3xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-soft-brown mb-4">Questions About Loyalty?</h3>
            <p class="text-soft-brown opacity-75 mb-6">Our support team is happy to help with any loyalty program questions!</p>
            <a href="{{ route('support.contact') }}" 
               class="px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                Contact Support
            </a>
        </div>

    </div>
</div>
@endsection
