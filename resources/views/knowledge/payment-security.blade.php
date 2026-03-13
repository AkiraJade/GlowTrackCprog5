@extends('layouts.app')

@section('title', 'Payment Methods & Security - GlowTrack Knowledge Base')

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
                            <span class="ml-1 text-soft-brown font-medium">Payment Methods & Security</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Article Header -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center">
                    <span class="text-2xl">💳</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Payment Methods & Security</h1>
                    <p class="text-soft-brown opacity-75">Safe and secure payment options for your GlowTrack purchases</p>
                </div>
            </div>

            <!-- Article Meta -->
            <div class="flex items-center gap-6 text-sm text-soft-brown opacity-75 border-t border-b border-gray-200 py-4">
                <span>📅 Updated 1 week ago</span>
                <span>⏱️ 4 min read</span>
                <span>👁️ 3.1k views</span>
            </div>
        </div>

        <!-- Article Content -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-lg text-soft-brown leading-relaxed mb-6">
                    At GlowTrack, we prioritize your security and convenience. We offer multiple payment methods and use industry-standard security measures to protect your financial information.
                </p>
            </div>

            <!-- Accepted Payment Methods -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Accepted Payment Methods</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3">💳 Credit/Debit Cards</h3>
                        <ul class="space-y-2 text-sm text-soft-brown">
                            <li>• Visa</li>
                            <li>• Mastercard</li>
                            <li>• American Express</li>
                            <li>• Discover</li>
                        </ul>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3">📱 Digital Wallets</h3>
                        <ul class="space-y-2 text-sm text-soft-brown">
                            <li>• PayPal</li>
                            <li>• GCash</li>
                            <li>• Maya</li>
                            <li>• GrabPay</li>
                        </ul>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3">💰 Bank Transfer</h3>
                        <ul class="space-y-2 text-sm text-soft-brown">
                            <li>• BPI</li>
                            <li>• BDO</li>
                            <li>• Metrobank</li>
                            <li>• UnionBank</li>
                        </ul>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3">🏦 Cash on Delivery</h3>
                        <p class="text-sm text-soft-brown opacity-75">Pay when you receive your order</p>
                    </div>
                </div>
            </div>

            <!-- Security Features -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Security Features</h2>
                <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start gap-3">
                            <span class="text-green-600">🔒</span>
                            <div>
                                <h3 class="font-semibold text-soft-brown mb-1">SSL Encryption</h3>
                                <p class="text-sm text-green-700">256-bit SSL encryption protects all data transmission</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-green-600">🛡️</span>
                            <div>
                                <h3 class="font-semibold text-soft-brown mb-1">PCI DSS Compliance</h3>
                                <p class="text-sm text-green-700">Payment Card Industry Data Security Standard</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-green-600">🔐</span>
                            <div>
                                <h3 class="font-semibold text-soft-brown mb-1">Secure Tokenization</h3>
                                <p class="text-sm text-green-700">Card details are never stored on our servers</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-green-600">👁️</span>
                            <div>
                                <h3 class="font-semibold text-soft-brown mb-1">Fraud Detection</h3>
                                <p class="text-sm text-green-700">Advanced fraud monitoring and prevention</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Process -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">How Payment Works</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">1</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Checkout</h3>
                            <p class="text-sm text-soft-brown opacity-75">Add items to cart and proceed to checkout</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">2</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Enter Details</h3>
                            <p class="text-sm text-soft-brown opacity-75">Fill in shipping and payment information</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">3</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Secure Processing</h3>
                            <p class="text-sm text-soft-brown opacity-75">Payment is processed securely through our payment gateway</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">4</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Confirmation</h3>
                            <p class="text-sm text-soft-brown opacity-75">Receive instant confirmation and order details</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Troubleshooting -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Common Payment Issues</h2>
                <div class="space-y-4">
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Payment declined"</h3>
                        <p class="text-sm text-soft-brown opacity-75 mb-2">Check your card details, available balance, and ensure your card is enabled for online purchases.</p>
                        <ul class="text-sm text-soft-brown opacity-75 ml-4">
                            <li>• Verify card number, expiry date, and CVV</li>
                            <li>• Check if your card has sufficient funds</li>
                            <li>• Contact your bank if the issue persists</li>
                        </ul>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Payment page not loading"</h3>
                        <p class="text-sm text-soft-brown opacity-75 mb-2">Try refreshing the page, clearing browser cache, or using a different browser.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Double charge"</h3>
                        <p class="text-sm text-soft-brown opacity-75 mb-2">If you see a duplicate charge, contact our support team immediately for assistance.</p>
                    </div>
                </div>
            </div>

            <!-- Refund Policy -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Refund Policy</h2>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <p class="text-sm text-blue-700 mb-4">We offer a 30-day money-back guarantee on all products:</p>
                    <ul class="space-y-2 text-sm text-blue-700">
                        <li>• Full refund for unopened products returned within 30 days</li>
                        <li>• Partial refund for opened products (case-by-case basis)</li>
                        <li>• Refunds processed within 5-7 business days</li>
                        <li>• Shipping costs are non-refundable</li>
                    </ul>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Payment Support</h2>
                <p class="text-soft-brown mb-4">If you encounter any payment-related issues, our support team is ready to help:</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">📧 Email Support</h3>
                        <p class="text-sm text-soft-brown opacity-75">payments@glowtrack.com</p>
                        <p class="text-xs text-soft-brown">Response within 24 hours</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">📞 Phone Support</h3>
                        <p class="text-sm text-soft-brown opacity-75">1-800-GLOWTRACK</p>
                        <p class="text-xs text-soft-brown">Mon-Fri, 9 AM - 6 PM</p>
                    </div>
                </div>
            </div>

            <!-- Related Articles -->
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-xl font-bold text-soft-brown mb-4">Related Articles</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('knowledge.returns') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Refunds & Returns →
                    </a>
                    <a href="{{ route('knowledge.returns') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Return Policy →
                    </a>
                    <a href="{{ route('support.knowledge') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Cash on Delivery →
                    </a>
                </div>
            </div>

        </div>

        <!-- Help Section -->
        <div class="mt-8 text-center bg-white rounded-3xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-soft-brown mb-4">Payment Questions?</h3>
            <p class="text-soft-brown opacity-75 mb-6">Our payment support team is here to help!</p>
            <a href="{{ route('support.contact') }}" 
               class="px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                Contact Support
            </a>
        </div>

    </div>
</div>
@endsection
