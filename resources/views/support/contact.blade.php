@extends('layouts.app')

@section('title', 'Contact Support - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-soft-brown font-playfair mb-4">
                Contact Support
            </h1>
            <p class="text-lg text-soft-brown opacity-75">
                We're here to help! Send us your concerns and we'll get back to you within 24 hours.
            </p>
        </div>

        <!-- Contact Form -->
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
            <form method="POST" action="{{ route('support.submit') }}">
                @csrf
                
                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-soft-brown mb-2">Your Name</label>
                    <input type="text" id="name" name="name" required
                           value="{{ Auth::user()->name ?? Auth::user()->username }}"
                           class="w-full px-4 py-3 border border-light-sage rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition">
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-soft-brown mb-2">Email Address</label>
                    <input type="email" id="email" name="email" required
                           value="{{ Auth::user()->email }}"
                           class="w-full px-4 py-3 border border-light-sage rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition">
                </div>

                <!-- Subject -->
                <div class="mb-6">
                    <label for="subject" class="block text-sm font-medium text-soft-brown mb-2">Subject</label>
                    <select id="subject" name="subject" required
                            class="w-full px-4 py-3 border border-light-sage rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition">
                        <option value="">Select a topic</option>
                        <option value="order">Order Issue</option>
                        <option value="product">Product Question</option>
                        <option value="account">Account Problem</option>
                        <option value="payment">Payment Issue</option>
                        <option value="shipping">Shipping & Delivery</option>
                        <option value="return">Return & Refund</option>
                        <option value="technical">Technical Problem</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <!-- Order ID (Optional) -->
                <div class="mb-6">
                    <label for="order_id" class="block text-sm font-medium text-soft-brown mb-2">Order ID (if applicable)</label>
                    <input type="text" id="order_id" name="order_id"
                           placeholder="e.g., ORD-123456789"
                           class="w-full px-4 py-3 border border-light-sage rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition">
                </div>

                <!-- Message -->
                <div class="mb-8">
                    <label for="message" class="block text-sm font-medium text-soft-brown mb-2">Message</label>
                    <textarea id="message" name="message" rows="6" required
                              placeholder="Please describe your concern in detail..."
                              class="w-full px-4 py-3 border border-light-sage rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition resize-none"></textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                        Send Message
                    </button>
                    <a href="{{ route('dashboard') }}" 
                       class="flex-1 px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold text-center">
                        Back to Dashboard
                    </a>
                </div>
            </form>
        </div>

        <!-- Alternative Contact Methods -->
        <div class="mt-12 bg-white rounded-3xl shadow-xl p-8 md:p-12">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6">Other Ways to Reach Us</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Phone -->
                <div class="text-center p-6 rounded-xl bg-gradient-to-br from-blush-pink to-warm-peach">
                    <p class="text-3xl mb-3">📞</p>
                    <h3 class="font-bold text-soft-brown mb-2">Phone Support</h3>
                    <p class="text-sm text-soft-brown opacity-75 mb-3">Mon-Fri, 9 AM - 6 PM</p>
                    <p class="text-jade-green font-bold">1-800-GLOWTRACK</p>
                </div>

                <!-- FAQ -->
                <div class="text-center p-6 rounded-xl bg-gradient-to-br from-pastel-green to-light-sage">
                    <p class="text-3xl mb-3">📚</p>
                    <h3 class="font-bold text-soft-brown mb-2">Knowledge Base</h3>
                    <p class="text-sm text-soft-brown opacity-75 mb-3">Find instant answers</p>
                    <a href="{{ route('support.knowledge') }}" 
                       class="inline-block px-4 py-2 border-2 border-jade-green text-jade-green rounded-full text-sm font-semibold hover:bg-jade-green hover:text-white transition">
                        Browse FAQs
                    </a>
                </div>
            </div>
        </div>

        <!-- Response Time Info -->
        <div class="mt-8 text-center">
            <div class="bg-white bg-opacity-80 rounded-2xl p-6">
                <p class="text-soft-brown font-medium mb-2">🕐 Response Times</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-soft-brown opacity-75">
                    <div>
                        <strong>Email:</strong> Within 24 hours
                    </div>
                    <div>
                        <strong>Phone:</strong> Immediate during business hours
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
