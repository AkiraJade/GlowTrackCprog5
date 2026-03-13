@extends('layouts.app')

@section('title', 'Shipping Information - GlowTrack Knowledge Base')

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
                            <span class="ml-1 text-soft-brown font-medium">Shipping Information</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Article Header -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center">
                    <span class="text-2xl">🚚</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Shipping Information</h1>
                    <p class="text-soft-brown opacity-75">Complete guide to GlowTrack shipping options and delivery</p>
                </div>
            </div>

            <!-- Article Meta -->
            <div class="flex items-center gap-6 text-sm text-soft-brown opacity-75 border-t border-b border-gray-200 py-4">
                <span>📅 Updated 2 days ago</span>
                <span>⏱️ 5 min read</span>
                <span>👁️ 2.1k views</span>
            </div>
        </div>

        <!-- Article Content -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-lg text-soft-brown leading-relaxed mb-6">
                    We offer reliable and affordable shipping options to get your GlowTrack products to you safely and quickly. Learn about our delivery methods, timeframes, and shipping policies.
                </p>
            </div>

            <!-- Shipping Options -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Shipping Options</h2>
                <div class="space-y-4">
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3">📦 Standard Shipping</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-2">Delivery Time:</p>
                                <ul class="text-sm text-soft-brown opacity-75">
                                    <li>• Metro Manila: 2-3 business days</li>
                                    <li>• Provincial: 3-5 business days</li>
                                </ul>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-2">Cost:</p>
                                <ul class="text-sm text-soft-brown opacity-75">
                                    <li>• Metro Manila: ₱50</li>
                                    <li>• Provincial: ₱80-120</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3">⚡ Express Shipping</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-2">Delivery Time:</p>
                                <ul class="text-sm text-soft-brown opacity-75">
                                    <li>• Metro Manila: 1-2 business days</li>
                                    <li>• Provincial: Not available</li>
                                </ul>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-soft-brown mb-2">Cost:</p>
                                <ul class="text-sm text-soft-brown opacity-75">
                                    <li>• Metro Manila: ₱120</li>
                                    <li>• Provincial: N/A</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3">💰 Free Shipping</h3>
                        <div class="text-sm text-soft-brown opacity-75">
                            <p class="mb-2">Get free shipping on orders over ₱1,000 within Metro Manila and ₱1,500 for provincial areas.</p>
                            <p>Free shipping automatically applies at checkout when minimum order value is met.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Areas -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Delivery Areas</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                        <h3 class="font-semibold text-blue-800 mb-3">🏙️ Metro Manila</h3>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Manila</li>
                            <li>• Quezon City</li>
                            <li>• Makati</li>
                            <li>• Pasig</li>
                            <li>• Mandaluyong</li>
                            <li>• San Juan</li>
                            <li>• Taguig</li>
                            <li>• Parañaque</li>
                            <li>• Las Piñas</li>
                            <li>• Muntinlupa</li>
                            <li>• Marikina</li>
                            <li>• Navotas</li>
                            <li>• Malabon</li>
                            <li>• Caloocan</li>
                            <li>• Valenzuela</li>
                            <li>• Pateros</li>
                        </ul>
                    </div>
                    <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                        <h3 class="font-semibold text-green-800 mb-3">🌆 Provincial Areas</h3>
                        <p class="text-sm text-green-700 mb-3">We deliver to most major cities and municipalities in:</p>
                        <ul class="text-sm text-green-700 space-y-1">
                            <li>• Luzon (North, South, Central)</li>
                            <li>• Visayas (Major islands)</li>
                            <li>• Mindanao (Select cities)</li>
                        </ul>
                        <p class="text-xs text-green-600 mt-3">Contact support to confirm delivery to your specific area.</p>
                    </div>
                </div>
            </div>

            <!-- Order Processing -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Order Processing Time</h2>
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                    <p class="text-sm text-yellow-700 mb-4">Timeline from order to delivery:</p>
                    <div class="space-y-2 text-sm text-yellow-700">
                        <p>• <strong>Order Confirmation:</strong> Immediate (within minutes)</p>
                        <p>• <strong>Order Processing:</strong> 1-2 business days</p>
                        <p>• <strong>Packaging:</strong> 1 business day</p>
                        <p>• <strong>Handover to Courier:</strong> 1 business day</p>
                        <p>• <strong>Transit Time:</strong> Based on chosen shipping option</p>
                    </div>
                    <p class="text-xs text-yellow-600 mt-3">Orders placed before 2 PM are processed the same day.</p>
                </div>
            </div>

            <!-- Packaging -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Packaging & Handling</h2>
                <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                    <h3 class="font-semibold text-soft-brown mb-3">📦 Secure Packaging</h3>
                    <ul class="space-y-2 text-sm text-soft-brown">
                        <li>• All products are carefully packaged to prevent damage</li>
                        <li>• Fragile items are wrapped with bubble wrap and cushioning</li>
                        <li>• Temperature-sensitive products are shipped in insulated packaging</li>
                        <li>• Discreet packaging to protect your privacy</li>
                        <li>• Eco-friendly materials used where possible</li>
                    </ul>
                </div>
            </div>

            <!-- Tracking -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Order Tracking</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0">1</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Order Confirmation</h3>
                            <p class="text-sm text-soft-brown opacity-75">Receive email confirmation with order number</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0">2</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Shipment Notification</h3>
                            <p class="text-sm text-soft-brown opacity-75">Get tracking number when order ships</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0">3</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Real-time Tracking</h3>
                            <p class="text-sm text-soft-brown opacity-75">Monitor package journey through courier's website</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0">4</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Delivery Updates</h3>
                            <p class="text-sm text-soft-brown opacity-75">Receive SMS/email updates on delivery status</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Instructions -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Delivery Instructions</h2>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <p class="text-sm text-blue-700 mb-4">You can provide special delivery instructions:</p>
                    <ul class="space-y-2 text-sm text-blue-700">
                        <li>• Leave package with building security/guard</li>
                        <li>• Call upon arrival</li>
                        <li>• Deliver to specific person/department</li>
                        <li>• Preferred delivery time window</li>
                        <li>• Access instructions for gated communities</li>
                    </ul>
                    <p class="text-xs text-blue-600 mt-3">Instructions can be added during checkout or by contacting support.</p>
                </div>
            </div>

            <!-- Failed Deliveries -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Failed Deliveries</h2>
                <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                    <p class="text-sm text-red-700 mb-4">If delivery fails:</p>
                    <ul class="space-y-2 text-sm text-red-700">
                        <li>• Courier will attempt redelivery the next business day</li>
                        <li>• Maximum of 3 delivery attempts</li>
                        <li>• After 3 failed attempts, package returns to our warehouse</li>
                        <li>• Additional fees may apply for redelivery</li>
                        <li>• Customer can arrange pickup from courier branch</li>
                    </ul>
                </div>
            </div>

            <!-- International Shipping -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">International Shipping</h2>
                <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
                    <p class="text-sm text-purple-700 mb-4">Currently, we only ship within the Philippines. However:</p>
                    <ul class="space-y-2 text-sm text-purple-700">
                        <li>• International shipping is under development</li>
                        <li>• Join our newsletter for international launch updates</li>
                        <li>• Contact support for special international requests</li>
                        <li>• Forwarding services available through third-party partners</li>
                    </ul>
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
                    <a href="{{ route('knowledge.cancel-order') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Cancel an Order →
                    </a>
                </div>
            </div>

        </div>

        <!-- Help Section -->
        <div class="mt-8 text-center bg-white rounded-3xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-soft-brown mb-4">Shipping Questions?</h3>
            <p class="text-soft-brown opacity-75 mb-6">Our support team can help with any shipping inquiries!</p>
            <a href="{{ route('support.contact') }}" 
               class="px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                Contact Support
            </a>
        </div>

    </div>
</div>
@endsection
