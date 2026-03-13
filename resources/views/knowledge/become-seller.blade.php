@extends('layouts.app')

@section('title', 'Become a Seller - GlowTrack Knowledge Base')

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
                            <span class="ml-1 text-soft-brown font-medium">Become a Seller</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Article Header -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center">
                    <span class="text-2xl">🤝</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Become a Seller</h1>
                    <p class="text-soft-brown opacity-75">Step-by-step guide to selling your skincare products on GlowTrack</p>
                </div>
            </div>

            <!-- Article Meta -->
            <div class="flex items-center gap-6 text-sm text-soft-brown opacity-75 border-t border-b border-gray-200 py-4">
                <span>📅 Updated 2 days ago</span>
                <span>⏱️ 8 min read</span>
                <span>👁️ 1.8k views</span>
            </div>
        </div>

        <!-- Article Content -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-lg text-soft-brown leading-relaxed mb-6">
                    Join thousands of successful sellers on GlowTrack and reach customers who are passionate about quality skincare products. Our platform makes it easy to list, manage, and sell your products to a growing community of skincare enthusiasts.
                </p>
            </div>

            <!-- Why Sell on GlowTrack -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Why Sell on GlowTrack?</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-2">🎯 Targeted Audience</h3>
                        <p class="text-sm text-soft-brown opacity-75">Reach skincare enthusiasts actively looking for quality products</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-2">💰 Low Fees</h3>
                        <p class="text-sm text-soft-brown opacity-75">Competitive commission rates with no hidden charges</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-2">📈 Marketing Support</h3>
                        <p class="text-sm text-soft-brown opacity-75">Benefit from our marketing campaigns and promotions</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-2">🛡️ Seller Protection</h3>
                        <p class="text-sm text-soft-brown opacity-75">Secure payment processing and fraud protection</p>
                    </div>
                </div>
            </div>

            <!-- Requirements -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Seller Requirements</h2>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <h3 class="font-semibold text-blue-800 mb-3">To become a seller, you'll need:</h3>
                    <ul class="space-y-2 text-sm text-blue-700">
                        <li>• Valid business registration or DTI permit</li>
                        <li>• Business bank account for payments</li>
                        <li>• Product inventory and storage capability</li>
                        <li>• Commitment to quality customer service</li>
                        <li>• Compliance with FDA/BFAD regulations for cosmetics</li>
                    </ul>
                </div>
            </div>

            <!-- Application Process -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Application Process</h2>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">1</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">Submit Application</h3>
                            <p class="text-sm text-soft-brown opacity-75">Fill out the seller application form with your business details</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">2</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">Document Verification</h3>
                            <p class="text-sm text-soft-brown opacity-75">Upload required business documents for verification</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">3</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">Review Process</h3>
                            <p class="text-sm text-soft-brown opacity-75">Our team reviews your application (3-5 business days)</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">4</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">Approval & Setup</h3>
                            <p class="text-sm text-soft-brown opacity-75">Get approved and set up your seller account</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Getting Started -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Getting Started as a Seller</h2>
                <div class="space-y-6">
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3">📝 Create Your Seller Profile</h3>
                        <ul class="space-y-2 text-sm text-soft-brown">
                            <li>• Add your business information and logo</li>
                            <li>• Write a compelling seller description</li>
                            <li>• Set up your payment preferences</li>
                        </ul>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3">📦 List Your Products</h3>
                        <ul class="space-y-2 text-sm text-soft-brown">
                            <li>• Take high-quality product photos</li>
                            <li>• Write detailed product descriptions</li>
                            <li>• Set competitive prices</li>
                            <li>• Manage inventory levels</li>
                        </ul>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3">🚀 Launch Your Store</h3>
                        <ul class="space-y-2 text-sm text-soft-brown">
                            <li>• Review your store settings</li>
                            <li>• Set up shipping options</li>
                            <li>• Configure tax settings</li>
                            <li>• Publish your first products</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Seller Dashboard Features -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Seller Dashboard Features</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">📊 Sales Analytics</h3>
                        <p class="text-sm text-soft-brown opacity-75">Track sales, revenue, and performance metrics</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">📦 Inventory Management</h3>
                        <p class="text-sm text-soft-brown opacity-75">Manage stock levels and product listings</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">📋 Order Management</h3>
                        <p class="text-sm text-soft-brown opacity-75">Process orders and track shipments</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">💬 Customer Communication</h3>
                        <p class="text-sm text-soft-brown opacity-75">Respond to customer inquiries and reviews</p>
                    </div>
                </div>
            </div>

            <!-- Success Tips -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Tips for Success</h2>
                <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                    <ul class="space-y-2 text-sm text-green-700">
                        <li>• <strong>Quality Photos:</strong> Use clear, well-lit product images from multiple angles</li>
                        <li>• <strong>Detailed Descriptions:</strong> Include ingredients, benefits, and usage instructions</li>
                        <li>• <strong>Competitive Pricing:</strong> Research market rates and price competitively</li>
                        <li>• <strong>Excellent Service:</strong> Respond quickly to inquiries and resolve issues promptly</li>
                        <li>• <strong>Build Reviews:</strong> Encourage customer reviews to build trust</li>
                        <li>• <strong>Stay Active:</strong> Regularly update inventory and add new products</li>
                    </ul>
                </div>
            </div>

            <!-- Fees and Commission -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Fees and Commission</h2>
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                    <h3 class="font-semibold text-yellow-800 mb-3">Transparent Fee Structure:</h3>
                    <ul class="space-y-2 text-sm text-yellow-700">
                        <li>• <strong>Commission:</strong> 10% on successful sales</li>
                        <li>• <strong>Listing Fees:</strong> No fees to list products</li>
                        <li>• <strong>Payment Processing:</strong> 2.9% + ₱15 per transaction</li>
                        <li>• <strong>Monthly Fees:</strong> None - pay only when you sell</li>
                    </ul>
                    <p class="text-xs text-yellow-600 mt-3">*Fees are subject to change. Current rates apply.</p>
                </div>
            </div>

            <!-- Apply Now -->
            <div class="mb-8">
                <div class="text-center bg-gradient-to-r from-jade-green to-light-sage text-white rounded-3xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold mb-4">Ready to Start Selling?</h2>
                    <p class="mb-6 opacity-90">Join our community of successful skincare sellers today!</p>
                    <a href="{{ route('seller.application.create') }}" 
                       class="inline-block px-8 py-3 bg-white text-jade-green rounded-full hover:shadow-lg transition font-semibold">
                        Apply to Become a Seller
                    </a>
                </div>
            </div>

            <!-- Support -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Seller Support</h2>
                <p class="text-soft-brown mb-4">Our seller support team is here to help you succeed:</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4 text-center">
                        <p class="text-2xl mb-2">📧</p>
                        <h3 class="font-semibold text-soft-brown mb-1">Email Support</h3>
                        <p class="text-sm text-soft-brown opacity-75">sellers@glowtrack.com</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4 text-center">
                        <p class="text-2xl mb-2">💬</p>
                        <h3 class="font-semibold text-soft-brown mb-1">Live Chat</h3>
                        <p class="text-sm text-soft-brown opacity-75">Mon-Fri, 9 AM - 6 PM</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4 text-center">
                        <p class="text-2xl mb-2">📚</p>
                        <h3 class="font-semibold text-soft-brown mb-1">Seller Resources</h3>
                        <p class="text-sm text-soft-brown opacity-75">Guides and tutorials</p>
                    </div>
                </div>
            </div>

            <!-- Related Articles -->
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-xl font-bold text-soft-brown mb-4">Related Articles</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('support.knowledge') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Seller Fees →
                    </a>
                    <a href="{{ route('support.knowledge') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Product Listing Guide →
                    </a>
                    <a href="{{ route('support.knowledge') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Shipping for Sellers →
                    </a>
                </div>
            </div>

        </div>

        <!-- Help Section -->
        <div class="mt-8 text-center bg-white rounded-3xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-soft-brown mb-4">Questions About Selling?</h3>
            <p class="text-soft-brown opacity-75 mb-6">Our seller support team is ready to help you get started!</p>
            <a href="{{ route('support.contact') }}" 
               class="px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                Contact Seller Support
            </a>
        </div>

    </div>
</div>
@endsection
