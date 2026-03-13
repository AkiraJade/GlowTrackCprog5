@extends('layouts.app')

@section('title', 'Product Quality & Authenticity - GlowTrack Knowledge Base')

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
                            <span class="ml-1 text-soft-brown font-medium">Product Quality & Authenticity</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Article Header -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center">
                    <span class="text-2xl">🛡️</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Product Quality & Authenticity</h1>
                    <p class="text-soft-brown opacity-75">Our commitment to quality and authentic skincare products</p>
                </div>
            </div>

            <!-- Article Meta -->
            <div class="flex items-center gap-6 text-sm text-soft-brown opacity-75 border-t border-b border-gray-200 py-4">
                <span>📅 Updated 1 week ago</span>
                <span>⏱️ 6 min read</span>
                <span>👁️ 2.8k views</span>
            </div>
        </div>

        <!-- Article Content -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-lg text-soft-brown leading-relaxed mb-6">
                    At GlowTrack, we're committed to providing only the highest quality, authentic skincare products. Learn about our quality standards, authenticity guarantees, and how we ensure every product meets our strict criteria.
                </p>
            </div>

            <!-- Quality Standards -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Our Quality Standards</h2>
                <div class="space-y-6">
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3">🔬 FDA/BFAD Compliance</h3>
                        <ul class="space-y-2 text-sm text-soft-brown">
                            <li>• All products registered with FDA/BFAD</li>
                            <li>• Compliance with Philippine FDA regulations</li>
                            <li>• Regular safety testing and certification</li>
                            <li>• Proper ingredient labeling and documentation</li>
                        </ul>
                    </div>
                    
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3">🧪 Ingredient Sourcing</h3>
                        <ul class="space-y-2 text-sm text-pack-brown">
                            <li>• Premium ingredients from certified suppliers</li>
                            <li>• Ethical and sustainable sourcing practices</li>
                            <li>• Full ingredient traceability</li>
                            <li>• No harmful chemicals or toxins</li>
                        </ul>
                    </div>
                    
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="form-semibold text-soft-brown mb-3">🏭 Manufacturing Standards</h3>
                        <ul class="space-y-2 text-sm text-soft-brown">
                            <li>• GMP-compliant manufacturing facilities</li>
                            <li>• Strict quality control processes</li>
                            <li>• Regular facility inspections</li>
                            <li>• Hygienic production environment</li>
                        </ul>
                    </div>
                    
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                        <h3 class="font-semibold text-soft-brown mb-3">🧪 Testing & Validation</h3>
                        <li class="space-y-2 text-sm text-soft-brown">
                            <li>• Microbial testing for safety</li>
                            <li>• Stability and shelf-life testing</li>
                            <li>• Efficacy testing for claimed benefits</li>
                            <li>• Third-party lab verification</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Authenticity Guarantees -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Authenticity Guarantees</h2>
                <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                    <h3 class="font-semibold text-green-800 mb-3">🔒 Our Authenticity Promise</h3>
                    <ul class="space-y-2 text-sm text-green-700">
                        <li>• 100% genuine products</li>
                        <li>• Direct from authorized distributors</li>
                        <li>• No counterfeit or imitation products</li>
                        <li>• Verified authenticity certificates</li>
                        <li>• Money-back guarantee on authenticity</li>
                    </ul>
                </div>
                
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mt-4">
                    <h3 class="font-semibold text-blue-800 mb-3">📋 How We Verify Authenticity</h3>
                    <ul class="space-y-2 text-sm text-blue-700">
                        <li>• Direct partnerships with brands</li>
                        <li>• Supply chain verification</li>
                        <li>• Batch tracking and serialization</li>
                        <li>• Regular authenticity audits</li>
                        <li>• Customer feedback monitoring</li>
                    </ul>
                </div>
            </div>

            <!-- Quality Control Process -->
            <div class="mb-8">
                <h2 class="text-2xl font-ourl-bold text-soft-brown mb-4">Our Quality Control Process</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">1</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Supplier Vetting</h3>
                            <p class="text-sm text-soft-brown opacity-75">Rigorous supplier evaluation and certification process</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">2</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Incoming Inspection</h3>
                            <p class="text quality inspection and verification upon arrival</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">3</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Quality Testing</h3>
                            <p class="text-sm text-soft-brown opacity-75">Laboratory testing for safety and efficacy</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">4</div>
                        <div>
                            <h3 class="final inspection before shipping</h3>
                            <p class="text quality inspection and final approval before distribution</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seller Verification -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Seller Verification Program</h2>
                <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
                    <h3 class="font-semibold text-purple-800 mb-3">✅ Verified Sellers</h3>
                    <ul class="space-y-2 text-sm text-purple-700">
                        <li>• Business license verification</li>
                        <li>• Product quality assessment</li>
                        <li>• Customer satisfaction monitoring</li>
                        <li>• Regular compliance checks</li>
                        <li>• Verified badge on product listings</li>
                    </ul>
                </div>
                
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mt-4">
                    <h3 class="font-semibold text-yellow-800 mb-3">🔍 Verification Criteria</h3>
                    <ul class="space-y-2 text-sm text-yellow-700">
                        <li>• Valid business registration</li>
                        <li>• Quality product offerings</li>
                        <li>Positive customer feedback</li>
                        <li>Compliance with regulations</li>
                        <li>Responsive customer service</li>
                    </ul>
                </div>
            </div>

            <!-- Customer Protection -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Customer Protection</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">🛡️ Money-Back Guarantee</h3>
                        <p class="text-sm text-soft-brown opacity-75">30-day money-back guarantee on all products</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">📞 Customer Support</h3>
                        <p class="text-sm text-soft-brown opacity-75">Dedicated support for quality concerns</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">📝 Product Reviews</h3>
                        <p class="text-sm text-soft-brown opacity-75">Honest customer reviews and ratings</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3>🔍 Easy Returns</h3>
                        <p class="text-sm text-soft-brown opacity-75">Hassle-free return process</p>
                    </div>
                </div>
            </div>

            <!-- Quality Issues -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Quality Issues & Resolution</h2>
                <div class="space-y-4">
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "What if I receive a defective product?"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Contact us immediately and we'll arrange for replacement or refund.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "How do I report quality concerns?"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Use our contact form or call our support team to report issues.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "What if I suspect counterfeit products?"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Report it immediately and we'll investigate thoroughly.</p>
                    </div>
                </div>
            </div>

            <!-- Continuous Improvement -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-ourl-bold text-soft-brown mb-4">Continuous Improvement</h2>
                <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                    <h3 class="font-semibold text-soft-brown mb-3">📈 Quality Metrics</h3>
                    <ul class="space-y-2 text-sm text-soft-brown">
                        <li>• Customer satisfaction ratings</li>
                        <li>• Product return rates</li>
                        <li>• Quality complaint reports</li>
                        <li>• Seller performance metrics</li>
                        <li>• Regular quality audits</li>
                    </ul>
                </div>
                
                <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                    <h3 class="font-semibold text-soft-brown mb-3">📊 Customer Feedback</h3>
                    <ul class="space-y-2 text-sm text-soft-brown">
                        <li>• Product reviews and ratings</li>
                        <li>• Customer satisfaction surveys</li>
                        <li>• Quality feedback forms</li>
                        <li>• Social media monitoring</li>
                        <li>• Direct customer communications</li>
                    </ul>
                </div>
            </div>

            <!-- Related Articles -->
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-xl font-bold text-soft-brown mb-4">Related Articles</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('knowledge.become-seller') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Become a Seller →
                    </a>
                    <a href="{{ route('support.knowledge') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        All Articles →
                    </a>
                </div>
            </div>

        </div>

        <!-- Help Section -->
        <div class="mt-8 text-center bg-white rounded-3xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-soft-brown mb-4">Quality Questions?</h3>
            <p class="text-soft-brown opacity-75 mb-6">Our quality team is here to address any concerns!</p>
            <a href="{{ route('support.contact') }}" 
               class="px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                Contact Quality Team
            </a>
        </div>

    </div>
</div>
@endsection
