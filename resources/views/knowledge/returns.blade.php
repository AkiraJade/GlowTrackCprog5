@extends('layouts.app')

@section('title', 'Returns & Refunds - GlowTrack Knowledge Base')

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
                            <span class="ml-1 text-soft-brown font-medium">Returns & Refunds</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Article Header -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center">
                    <span class="text-2xl">🔄</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Returns & Refunds</h1>
                    <p class="text-soft-brown opacity-75">Our hassle-free return policy and refund process</p>
                </div>
            </div>

            <!-- Article Meta -->
            <div class="flex items-center gap-6 text-sm text-soft-brown opacity-75 border-t border-b border-gray-200 py-4">
                <span>📅 Updated 1 week ago</span>
                <span>⏱️ 7 min read</span>
                <span>👁️ 3.4k views</span>
            </div>
        </div>

        <!-- Article Content -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-lg text-soft-brown leading-relaxed mb-6">
                    At GlowTrack, we want you to be completely satisfied with your purchase. If you're not happy with any product, we offer a straightforward return and refund policy. Here's everything you need to know about returning items and getting your money back.
                </p>
            </div>

            <!-- Return Policy Overview -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Return Policy Overview</h2>
                <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                    <h3 class="font-semibold text-green-800 mb-3">✅ Our Promise</h3>
                    <ul class="space-y-2 text-sm text-green-700">
                        <li>• <strong>30-day return window</strong> from date of delivery</li>
                        <li>• <strong>Full refund</strong> for unopened products</li>
                        <li>• <strong>Partial refund</strong> for opened products (case-by-case)</li>
                        <li>• <strong>Free return shipping</strong> for defective items</li>
                        <li>• <strong>No restocking fees</strong> on valid returns</li>
                    </ul>
                </div>
            </div>

            <!-- Eligible Returns -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">What Can Be Returned?</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3">✅ Eligible for Full Refund</h3>
                        <ul class="space-y-2 text-sm text-soft-brown">
                            <li>• Unopened products in original packaging</li>
                            <li>• Defective or damaged items</li>
                            <li>• Wrong product delivered</li>
                            <li>• Products that cause allergic reactions</li>
                            <li>• Expired products (within 30 days of delivery)</li>
                        </ul>
                    </div>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                        <h3 class="font-semibold text-yellow-800 mb-3">⚠️ May Qualify for Partial Refund</h3>
                        <ul class="space-y-2 text-sm text-yellow-700">
                            <li>• Opened but unused products</li>
                            <li>• Products with damaged packaging</li>
                            <li>• Wrong size/color ordered</li>
                            <li>• Customer changed mind (case-by-case)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Non-Returnable Items -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Non-Returnable Items</h2>
                <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                    <ul class="space-y-2 text-sm text-red-700">
                        <li>• Products returned after 30 days</li>
                        <li>• Heavily used or empty products</li>
                        <li>• Products damaged by customer</li>
                        <li>• Final sale items</li>
                        <li>• Promotional items (unless defective)</li>
                        <li>• Personalized or customized products</li>
                    </ul>
                </div>
            </div>

            <!-- Return Process -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">How to Return Items</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">1</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Initiate Return</h3>
                            <p class="text-sm text-soft-brown opacity-75">Log in to your account and go to "My Orders" → "Return Item"</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">2</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Select Items</h3>
                            <p class="text-sm text-soft-brown opacity-75">Choose which items to return and select the return reason</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">3</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Print Return Label</h3>
                            <p class="text-sm text-soft-brown opacity-75">Download and print the prepaid shipping label</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">4</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Package and Ship</h3>
                            <p class="text-sm text-soft-brown opacity-75">Pack items securely and drop off at designated courier</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">5</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Wait for Processing</h3>
                            <p class="text-sm text-soft-brown opacity-75">We'll inspect and process your return within 5-7 business days</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Refund Timeline -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Refund Timeline</h2>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-blue-800">Return Received</span>
                            <span class="text-sm text-blue-600">Day 0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-blue-800">Quality Inspection</span>
                            <span class="text-sm text-blue-600">Days 1-3</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-blue-800">Refund Approval</span>
                            <span class="text-sm text-blue-600">Day 4</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-blue-800">Refund Processed</span>
                            <span class="text-sm text-blue-600">Days 5-7</span>
                        </div>
                    </div>
                    <p class="text-xs text-blue-600 mt-3">Refund processing time may vary depending on your payment method.</p>
                </div>
            </div>

            <!-- Refund Methods -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Refund Methods</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">💳 Credit/Debit Card</h3>
                        <p class="text-sm text-soft-brown opacity-75">Refunded to original card (5-7 business days)</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">📱 Digital Wallets</h3>
                        <p class="text-sm text-soft-brown opacity-75">Refunded to original wallet (1-3 business days)</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">🏦 Bank Transfer</h3>
                        <p class="text-sm text-soft-brown opacity-75">Refunded to bank account (3-5 business days)</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">💰 Cash on Delivery</h3>
                        <p class="text-sm text-soft-brown opacity-75">Bank transfer or store credit available</p>
                    </div>
                </div>
            </div>

            <!-- Exchange Policy -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Exchange Policy</h2>
                <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                    <h3 class="font-semibold text-soft-brown mb-3">🔄 Exchanges Available</h3>
                    <ul class="space-y-2 text-sm text-soft-brown">
                        <li>• Exchange for different size/color of same product</li>
                        <li>• Exchange for different product of equal or lesser value</li>
                        <li>• Pay difference for higher-priced items</li>
                        <li>• Exchange process same as return process</li>
                        <li>• No additional shipping fees for exchanges</li>
                    </ul>
                </div>
            </div>

            <!-- Damaged Items -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Damaged or Defective Items</h2>
                <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                    <p class="text-sm text-red-700 mb-4">If you receive damaged or defective items:</p>
                    <ul class="space-y-2 text-sm text-red-700">
                        <li>• Contact us within 48 hours of delivery</li>
                        <li>• Provide photos of damage/defect</li>
                        <li>• We'll arrange immediate replacement or refund</li>
                        <li>• Free return shipping provided</li>
                        <li>• Priority processing for damaged items</li>
                    </ul>
                </div>
            </div>

            <!-- Common Questions -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Common Return Questions</h2>
                <div class="space-y-4">
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Do I need the original packaging?"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Original packaging is preferred but not required. Keep all product materials if possible.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Who pays for return shipping?"</h3>
                        <p class="text-sm text-soft-brown opacity-75">We provide prepaid return labels for all valid returns. No cost to you.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Can I return sale items?"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Final sale items cannot be returned unless defective.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "What if I lost the return label?"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Contact support and we'll email you a new return label.</p>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Need Help with Returns?</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">📧 Email Support</h3>
                        <p class="text-sm text-soft-brown opacity-75">returns@glowtrack.com</p>
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
                    <a href="{{ route('knowledge.track-order') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Track Your Order →
                    </a>
                    <a href="{{ route('knowledge.cancel-order') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Cancel an Order →
                    </a>
                    <a href="{{ route('knowledge.shipping') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Shipping Information →
                    </a>
                </div>
            </div>

        </div>

        <!-- Help Section -->
        <div class="mt-8 text-center bg-white rounded-3xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-soft-brown mb-4">Return Policy Questions?</h3>
            <p class="text-soft-brown opacity-75 mb-6">Our returns team is here to help make the process easy!</p>
            <a href="{{ route('support.contact') }}" 
               class="px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                Contact Returns Team
            </a>
        </div>

    </div>
</div>
@endsection
