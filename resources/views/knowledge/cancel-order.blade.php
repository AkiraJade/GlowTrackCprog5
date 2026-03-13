@extends('layouts.app')

@section('title', 'Cancel an Order - GlowTrack Knowledge Base')

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
                            <a href="#" class="ml-1 text-soft-brown hover:text-jade-green transition">Orders & Shipping</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-soft-brown mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-soft-brown font-medium">Cancel an Order</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Article Header -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center">
                    <span class="text-2xl">❌</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Cancel an Order</h1>
                    <p class="text-soft-brown opacity-75">How to cancel your GlowTrack order and get a refund</p>
                </div>
            </div>

            <!-- Article Meta -->
            <div class="flex items-center gap-6 text-sm text-soft-brown opacity-75 border-t border-b border-gray-200 py-4">
                <span>📅 Updated 2 days ago</span>
                <span>⏱️ 4 min read</span>
                <span>👁️ 987 views</span>
            </div>
        </div>

        <!-- Article Content -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-lg text-soft-brown leading-relaxed mb-6">
                    Changed your mind? No problem! You can cancel your GlowTrack order as long as it hasn't been processed for shipping. Learn how to cancel orders and understand our cancellation policy.
                </p>
            </div>

            <!-- Cancellation Policy -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Cancellation Policy</h2>
                <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                    <h3 class="font-semibold text-green-800 mb-3">✅ When You Can Cancel:</h3>
                    <ul class="space-y-2 text-sm text-green-700">
                        <li>• Within 1 hour of placing the order</li>
                        <li>• Order status is "Pending" or "Confirmed"</li>
                        <li>• Order hasn't been processed for shipping</li>
                        <li>• Items haven't been packaged yet</li>
                    </ul>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-xl p-6 mt-4">
                    <h3 class="font-semibold text-red-800 mb-3">❌ When You Cannot Cancel:</h3>
                    <ul class="space-y-2 text-sm text-red-700">
                        <li>• Order status is "Processing" or "Shipped"</li>
                        <li>• More than 1 hour has passed since order placement</li>
                        <li>• Order has been handed to courier</li>
                        <li>• Express shipping orders (processed faster)</li>
                    </ul>
                </div>
            </div>

            <!-- How to Cancel -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">How to Cancel Your Order</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">1</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Log In to Your Account</h3>
                            <p class="text-sm text-soft-brown opacity-75">Sign in to your GlowTrack account</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">2</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Go to My Orders</h3>
                            <p class="text-sm text-soft-brown opacity-75">Click on your profile and select "My Orders"</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">3</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Find Your Order</h3>
                            <p class="text-sm text-soft-brown opacity-75">Locate the order you want to cancel</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">4</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Click Cancel Order</h3>
                            <p class="text-sm text-soft-brown opacity-75">Look for the "Cancel Order" button and click it</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">5</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Confirm Cancellation</h3>
                            <p class="text-sm text-soft-brown opacity-75">Confirm you want to cancel and provide a reason</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Refund Process -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Refund Process</h2>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <h3 class="font-semibold text-blue-800 mb-3">💰 Refund Timeline</h3>
                    <ul class="space-y-2 text-sm text-blue-700">
                        <li>• <strong>Immediate:</strong> Refund initiated upon cancellation</li>
                        <li>• <strong>3-5 business days:</strong> Refund processed to original payment method</li>
                        <li>• <strong>5-7 business days:</strong> Amount appears in your account (for credit cards)</li>
                        <li>• <strong>1-3 business days:</strong> Amount appears in digital wallets</li>
                    </ul>
                </div>
            </div>

            <!-- Alternative Options -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">If You Can't Cancel</h2>
                <div class="space-y-4">
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">📦 Return After Delivery</h3>
                        <p class="text-sm text-soft-brown opacity-75">If the order has already shipped, wait for delivery and then return the items using our 30-day return policy.</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">📞 Contact Support</h3>
                        <p class="text-sm text-soft-brown opacity-75">For urgent cancellations, contact our support team immediately for assistance.</p>
                    </div>
                </div>
            </div>

            <!-- Common Questions -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Common Cancellation Questions</h2>
                <div class="space-y-4">
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Can I cancel part of my order?"</h3>
                        <p class="text-sm text-soft-brown opacity-75">No, cancellations apply to the entire order. You can return individual items after delivery.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Will I get a full refund?"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Yes, you'll receive a full refund including shipping costs if cancelled within the allowed timeframe.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Can I re-order after cancelling?"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Yes, you can place a new order at any time after cancellation.</p>
                    </div>
                </div>
            </div>

            <!-- Related Articles -->
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-xl font-bold text-soft-brown mb-4">Related Articles</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('knowledge.track-order') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Track Your Order →
                    </a>
                    <a href="{{ route('knowledge.returns') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Returns & Refunds →
                    </a>
                    <a href="{{ route('knowledge.shipping') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Shipping Information →
                    </a>
                </div>
            </div>

        </div>

        <!-- Help Section -->
        <div class="mt-8 text-center bg-white rounded-3xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-soft-brown mb-4">Need Help with Cancellation?</h3>
            <p class="text-soft-brown opacity-75 mb-6">Our support team is here to help with urgent cancellations!</p>
            <a href="{{ route('support.contact') }}" 
               class="px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                Contact Support
            </a>
        </div>

    </div>
</div>
@endsection
