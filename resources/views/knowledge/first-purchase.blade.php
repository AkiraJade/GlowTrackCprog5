@extends('layouts.app')

@section('title', 'First Purchase Guide - GlowTrack Knowledge Base')

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
                            <span class="ml-1 text-soft-brown font-medium">First Purchase Guide</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Article Header -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center">
                    <span class="text-2xl">🛍️</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">First Purchase Guide</h1>
                    <p class="text-soft-brown opacity-75">Complete walkthrough of your first GlowTrack purchase</p>
                </div>
            </div>

            <!-- Article Meta -->
            <div class="flex items-center gap-6 text-sm text-soft-brown opacity-75 border-t border-b border-gray-200 py-4">
                <span>📅 Updated 3 days ago</span>
                <span>⏱️ 6 min read</span>
                <span>👁️ 1.5k views</span>
            </div>
        </div>

        <!-- Article Content -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-lg text-soft-brown leading-relaxed mb-6">
                    Welcome to your first GlowTrack purchase! This guide will walk you through every step of finding the perfect skincare products, adding them to cart, and completing your first order. Let's get started on your skincare journey!
                </p>
            </div>

            <!-- Step-by-Step Guide -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Step-by-Step Purchase Guide</h2>
                
                <div class="space-y-6">
                    <!-- Step 1 -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">1</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">Browse Products</h3>
                            <p class="text-sm text-soft-brown opacity-75 mb-3">Explore our wide range of skincare products:</p>
                            <ul class="space-y-2 text-sm text-soft-brown">
                                <li>• Use the search bar to find specific products</li>
                                <li>• Filter by skin type, concerns, or product category</li>
                                <li>• Sort by price, popularity, or newest arrivals</li>
                                <li>• Read product descriptions and customer reviews</li>
                            </ul>
                            <div class="bg-light-sage bg-opacity-50 rounded-xl p-4 mt-3">
                                <p class="text-sm font-medium text-jade-green mb-1">💡 Pro Tip:</p>
                                <p class="text-sm text-soft-brown">Start with products that match your skin type and primary concerns.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">2</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">Add to Cart</h3>
                            <p class="text-sm text-soft-brown opacity-75 mb-3">Once you've found products you love:</p>
                            <ul class="space-y-2 text-sm text-soft-brown">
                                <li>• Select the quantity you want to purchase</li>
                                <li>• Click "Add to Cart" on each product</li>
                                <li>• View your cart by clicking the cart icon</li>
                                <li>• Adjust quantities or remove items if needed</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">3</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">Proceed to Checkout</h3>
                            <p class="text-sm text-soft-brown opacity-75 mb-3">Review your order and proceed:</p>
                            <ul class="space-y-2 text-sm text-soft-brown">
                                <li>• Click "Proceed to Checkout" from your cart</li>
                                <li>• Review your order summary and total amount</li>
                                <li>• Apply any discount codes or loyalty points</li>
                                <li>• Confirm everything looks correct</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">4</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">Enter Shipping Information</h3>
                            <p class="text-sm text-soft-brown opacity-75 mb-3">Provide delivery details:</p>
                            <ul class="space-y-2 text-sm text-soft-brown">
                                <li>• Enter your complete shipping address</li>
                                <li>• Include contact phone number for delivery updates</li>
                                <li>• Choose your preferred delivery method</li>
                                <li>• Add special delivery instructions if needed</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">5</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">Select Payment Method</h3>
                            <p class="text-sm text-soft-brown opacity-75 mb-3">Choose your preferred payment option:</p>
                            <ul class="space-y-2 text-sm text-soft-brown">
                                <li>• Credit/Debit Card (Visa, Mastercard, Amex)</li>
                                <li>• Digital Wallets (GCash, Maya, PayPal)</li>
                                <li>• Bank Transfer</li>
                                <li>• Cash on Delivery (available in select areas)</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Step 6 -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">6</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">Complete Purchase</h3>
                            <p class="text-sm text-soft-brown opacity-75 mb-3">Finalize your order:</p>
                            <ul class="space-y-2 text-sm text-soft-brown">
                                <li>• Review all order details one last time</li>
                                <li>• Click "Place Order" to complete the purchase</li>
                                <li>• Wait for order confirmation page</li>
                                <li>• Check your email for order confirmation</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Available Payment Methods</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">💳 Digital Payments</h3>
                        <ul class="space-y-1 text-sm text-soft-brown">
                            <li>• Credit & Debit Cards</li>
                            <li>• GCash</li>
                            <li>• Maya</li>
                            <li>• PayPal</li>
                        </ul>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">🏦 Traditional Methods</h3>
                        <ul class="space-y-1 text-sm text-soft-brown">
                            <li>• Bank Transfer</li>
                            <li>• Cash on Delivery</li>
                            <li>• Over-the-counter payments</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Delivery Options -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Delivery Options</h2>
                <div class="space-y-4">
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">🚚 Standard Delivery</h3>
                        <p class="text-sm text-soft-brown opacity-75 mb-2">3-5 business days within Metro Manila</p>
                        <p class="text-sm text-soft-brown opacity-75">5-7 business days for provincial areas</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">⚡ Express Delivery</h3>
                        <p class="text-sm text-soft-brown opacity-75 mb-2">1-2 business days (Metro Manila only)</p>
                        <p class="text-sm text-soft-brown opacity-75">Additional fees may apply</p>
                    </div>
                </div>
            </div>

            <!-- First Purchase Tips -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">First Purchase Tips</h2>
                <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                    <ul class="space-y-2 text-sm text-green-700">
                        <li>• <strong>Start Small:</strong> Begin with 2-3 essential products rather than buying everything at once</li>
                        <li>• <strong>Read Reviews:</strong> Check customer reviews and ratings before purchasing</li>
                        <li>• <strong>Check Expiry Dates:</strong> Ensure products have sufficient shelf life</li>
                        <li>• <strong>Look for Promotions:</strong> Take advantage of first-time buyer discounts</li>
                        <li>• <strong>Save for Later:</strong> Use the wishlist feature to save products for future purchases</li>
                        <li>• <strong>Track Your Order:</strong> Monitor your order status through your account</li>
                    </ul>
                </div>
            </div>

            <!-- After Purchase -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">After Your Purchase</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0">✓</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Order Confirmation</h3>
                            <p class="text-sm text-soft-brown opacity-75">You'll receive an email with your order details and tracking information</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0">✓</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Earn Loyalty Points</h3>
                            <p class="text-sm text-soft-brown opacity-75">Automatically earn points based on quantity purchased</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0">✓</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Track Delivery</h3>
                            <p class="text-sm text-soft-brown opacity-75">Monitor your package journey from our warehouse to your doorstep</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0">✓</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Leave a Review</h3>
                            <p class="text-sm text-soft-brown opacity-75">Share your experience to help other customers and earn bonus points</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Common Questions -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Common First-Time Buyer Questions</h2>
                <div class="space-y-4">
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Can I change my order after placing it?"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Orders can be modified or cancelled within 1 hour of placement. After that, contact our support team.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "What if I receive the wrong product?"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Contact us immediately and we'll arrange for the correct product to be sent.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "How do I return a product?"</h3>
                        <p class="text-sm text-soft-brown opacity-75">We offer a 30-day return policy for unopened products. Check our return policy for details.</p>
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
                    <a href="{{ route('knowledge.track-order') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Track Your Order →
                    </a>
                    <a href="{{ route('knowledge.returns') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Returns & Refunds →
                    </a>
                </div>
            </div>

        </div>

        <!-- Help Section -->
        <div class="mt-8 text-center bg-white rounded-3xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-soft-brown mb-4">Need Help with Your First Purchase?</h3>
            <p class="text-soft-brown opacity-75 mb-6">Our customer support team is here to guide you through the process!</p>
            <a href="{{ route('support.contact') }}" 
               class="px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                Contact Support
            </a>
        </div>

    </div>
</div>
@endsection
