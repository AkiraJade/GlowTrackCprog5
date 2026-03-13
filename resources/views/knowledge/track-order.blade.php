@extends('layouts.app')

@section('title', 'Track Your Order - GlowTrack Knowledge Base')

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
                            <span class="ml-1 text-soft-brown font-medium">Track Your Order</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Article Header -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center">
                    <span class="text-2xl">📦</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Track Your Order</h1>
                    <p class="text-soft-brown opacity-75">Monitor your order status and delivery progress</p>
                </div>
            </div>

            <!-- Article Meta -->
            <div class="flex items-center gap-6 text-sm text-soft-brown opacity-75 border-t border-b border-gray-200 py-4">
                <span>📅 Updated 1 day ago</span>
                <span>⏱️ 3 min read</span>
                <span>👁️ 856 views</span>
            </div>
        </div>

        <!-- Article Content -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-lg text-soft-brown leading-relaxed mb-6">
                    Once you've placed an order with GlowTrack, you can easily track its progress from processing to delivery. This guide shows you how to monitor your order status and what each stage means.
                </p>
            </div>

            <!-- Order Status Timeline -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Order Status Timeline</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-yellow-600">⏳</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Pending</h3>
                            <p class="text-sm text-soft-brown opacity-75">Order received and awaiting confirmation</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-blue-600">✓</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Confirmed</h3>
                            <p class="text-sm text-soft-brown opacity-75">Order confirmed and being processed</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-purple-600">📦</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Processing</h3>
                            <p class="text-sm text-soft-brown opacity-75">Products being packaged and prepared for shipment</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-indigo-600">🚚</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Shipped</h3>
                            <p class="text-sm text-soft-brown opacity-75">Order has been dispatched and is on its way</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-green-600">🎉</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Delivered</h3>
                            <p class="text-sm text-soft-brown opacity-75">Order has been successfully delivered</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How to Track -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">How to Track Your Order</h2>
                
                <div class="space-y-6">
                    <!-- Method 1 -->
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3">Method 1: Through Your Account</h3>
                        <ol class="space-y-2 text-soft-brown">
                            <li>1. Log in to your GlowTrack account</li>
                            <li>2. Go to "My Orders" from the dashboard</li>
                            <li>3. Click on the order you want to track</li>
                            <li>4. View the real-time status and tracking information</li>
                        </ol>
                    </div>

                    <!-- Method 2 -->
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3">Method 2: Order Confirmation Email</h3>
                        <ol class="space-y-2 text-soft-brown">
                            <li>1. Check your email for the order confirmation</li>
                            <li>2. Click the "Track Order" link in the email</li>
                            <li>3. View the order status and tracking details</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Tracking Information -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">What You'll See</h2>
                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-semibold text-soft-brown mb-2">Order Details:</h4>
                            <ul class="space-y-1 text-sm text-soft-brown">
                                <li>• Order number</li>
                                <li>• Order date and time</li>
                                <li>• Total amount paid</li>
                                <li>• Payment method</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-soft-brown mb-2">Tracking Information:</h4>
                            <ul class="space-y-1 text-sm text-soft-brown">
                                <li>• Current status</li>
                                <li>• Estimated delivery date</li>
                                <li>• Tracking number (when shipped)</li>
                                <li>• Delivery address</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Time Estimates -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Delivery Time Estimates</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">🏙️ Metro Manila</h3>
                        <p class="text-sm text-soft-brown opacity-75">2-3 business days</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">🌆 Provincial</h3>
                        <p class="text-sm text-soft-brown opacity-75">3-5 business days</p>
                    </div>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mt-4">
                    <p class="text-sm font-medium text-blue-800 mb-2">ℹ️ Note:</p>
                    <p class="text-sm text-blue-700">Delivery times may vary during holidays, promotions, or due to weather conditions.</p>
                </div>
            </div>

            <!-- Troubleshooting -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Common Tracking Issues</h2>
                <div class="space-y-4">
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Tracking number not working"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Tracking numbers are usually activated within 24 hours after shipment. Try again later or contact support.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Order status hasn't changed"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Some orders may take 24-48 hours to process. This is normal, especially during peak periods.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Delivery is delayed"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Check for weather alerts or holidays. Contact our support team if the delay exceeds the estimated time.</p>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Need Help with Your Order?</h2>
                <p class="text-soft-brown mb-4">If you have any questions or concerns about your order, our support team is here to help:</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4 text-center">
                        <p class="text-2xl mb-2">💬</p>
                        <h3 class="font-semibold text-soft-brown mb-1">Live Chat</h3>
                        <p class="text-sm text-soft-brown opacity-75">Available 9 AM - 6 PM</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4 text-center">
                        <p class="text-2xl mb-2">📧</p>
                        <h3 class="font-semibold text-soft-brown mb-1">Email Support</h3>
                        <p class="text-sm text-soft-brown opacity-75">support@glowtrack.com</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4 text-center">
                        <p class="text-2xl mb-2">📞</p>
                        <h3 class="font-semibold text-soft-brown mb-1">Phone Support</h3>
                        <p class="text-sm text-soft-brown opacity-75">1-800-GLOWTRACK</p>
                    </div>
                </div>
            </div>

            <!-- Related Articles -->
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-xl font-bold text-soft-brown mb-4">Related Articles</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('knowledge.shipping') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Shipping Information →
                    </a>
                    <a href="{{ route('knowledge.returns') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Returns & Refunds →
                    </a>
                    <a href="{{ route('knowledge.cancel-order') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Cancel an Order →
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
