@extends('layouts.app')

@section('title', 'Terms of Service - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-4">Terms of Service</h1>
            <p class="text-lg text-soft-brown opacity-75">Last updated: {{ date('F d, Y') }}</p>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
            
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-soft-brown leading-relaxed mb-4">
                    Welcome to GlowTrack. These Terms of Service ("Terms") govern your use of our skincare e-commerce platform and services. By accessing or using GlowTrack, you agree to be bound by these Terms.
                </p>
                <p class="text-soft-brown leading-relaxed">
                    Please read these Terms carefully before using our services. If you do not agree to these Terms, you should not use GlowTrack.
                </p>
            </div>

            <!-- Table of Contents -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Table of Contents</h2>
                <div class="space-y-2">
                    <a href="#acceptance" class="block text-jade-green hover:text-soft-brown transition">1. Acceptance of Terms</a>
                    <a href="#services" class="block text-jade-green hover:text-soft-brown transition">2. Services Description</a>
                    <a href="#user-accounts" class="block text-jade-green hover:text-soft-brown transition">3. User Accounts</a>
                    <a href="#products" class="block text-jade-green hover:text-soft-brown transition">4. Products and Pricing</a>
                    <a href="#orders" class="block text-jade-green hover:text-soft-brown transition">5. Orders and Payment</a>
                    <a href="#shipping" class="block text-jade-green hover:text-soft-brown transition">6. Shipping and Delivery</a>
                    <a href="#returns" class="block text-jade-green hover:text-soft-brown transition">7. Returns and Refunds</a>
                    <a href="#intellectual-property" class="block text-jade-green hover:text-soft-brown transition">8. Intellectual Property</a>
                    <a href="#user-conduct" class="block text-jade-green hover:text-soft-brown transition">9. User Conduct</a>
                    <a href="#privacy" class="block text-jade-green hover:text-soft-brown transition">10. Privacy Policy</a>
                    <a href="#limitation" class="block text-jade-green hover:text-soft-brown transition">11. Limitation of Liability</a>
                    <a href="#termination" class="block text-jade-green hover:text-soft-brown transition">12. Account Termination</a>
                    <a href="#changes" class="block text-jade-green hover:text-soft-brown transition">13. Changes to Terms</a>
                    <a href="#contact" class="block text-jade-green hover:text-soft-brown transition">14. Contact Information</a>
                </div>
            </div>

            <!-- Sections -->
            <div class="space-y-8">
                <!-- Acceptance of Terms -->
                <section id="acceptance" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">1. Acceptance of Terms</h2>
                    <p class="text-soft-brown leading-relaxed">
                        By accessing and using GlowTrack, you accept and agree to be bound by the terms and provision of this agreement. Additionally, by using this website you represent and warrant that you are at least 18 years old and are legally able to enter into contracts.
                    </p>
                </section>

                <!-- Services Description -->
                <section id="services" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">2. Services Description</h2>
                    <p class="text-soft-brown leading-relaxed mb-4">
                        GlowTrack is a comprehensive skincare e-commerce platform that provides:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-soft-brown ml-4">
                        <li>Product discovery and browsing</li>
                        <li>Online purchasing of skincare products</li>
                        <li>Order tracking and management</li>
                        <li>Loyalty program and rewards</li>
                        <li>Customer reviews and ratings</li>
                        <li>Seller platform for skincare vendors</li>
                    </ul>
                </section>

                <!-- User Accounts -->
                <section id="user-accounts" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">3. User Accounts</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">3.1 Account Registration</h3>
                            <p class="text-soft-brown leading-relaxed">
                                To access certain features of GlowTrack, you must register for an account. You agree to provide accurate, current, and complete information as prompted by our registration form.
                            </p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">3.2 Account Security</h3>
                            <p class="text-soft-brown leading-relaxed">
                                You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.
                            </p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">3.3 Account Termination</h3>
                            <p class="text-soft-brown leading-relaxed">
                                GlowTrack reserves the right to terminate or suspend your account at any time for violation of these Terms or for any other reason.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Products and Pricing -->
                <section id="products" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">4. Products and Pricing</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">4.1 Product Information</h3>
                            <p class="text-soft-brown leading-relaxed">
                                We strive to be as accurate as possible in the descriptions of our products. However, we do not warrant that product descriptions, colors, information, or other content of any product are accurate, complete, reliable, current, or error-free.
                            </p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">4.2 Pricing</h3>
                            <p class="text-soft-brown leading-relaxed">
                                All prices are shown in Philippine Pesos (₱) and are subject to change without notice. Prices include applicable taxes unless otherwise specified.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Orders and Payment -->
                <section id="orders" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">5. Orders and Payment</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">5.1 Order Acceptance</h3>
                            <p class="text-soft-brown leading-relaxed">
                                Your receipt of an electronic or other form of order confirmation does not signify our acceptance of your order, nor does it constitute confirmation of our offer to sell.
                            </p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">5.2 Payment Methods</h3>
                            <p class="text-soft-brown leading-relaxed">
                                We accept various payment methods including credit/debit cards, digital wallets, and bank transfers. All payment information is encrypted and secure.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Shipping and Delivery -->
                <section id="shipping" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">6. Shipping and Delivery</h2>
                    <p class="text-soft-brown leading-relaxed mb-4">
                        We offer various shipping options within the Philippines. Delivery times vary based on location and shipping method selected. Estimated delivery times are provided for reference only.
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-soft-brown ml-4">
                        <li>Standard Shipping: 2-5 business days</li>
                        <li>Express Shipping: 1-2 business days (Metro Manila only)</li>
                        <li>Free shipping on orders over ₱1,000</li>
                    </ul>
                </section>

                <!-- Returns and Refunds -->
                <section id="returns" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">7. Returns and Refunds</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">7.1 Return Policy</h3>
                            <p class="text-soft-brown leading-relaxed">
                                We offer a 30-day return policy for unopened products in original packaging. Products must be returned in the same condition as received.
                            </p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">7.2 Refund Process</h3>
                            <p class="text-soft-brown leading-relaxed">
                                Refunds are processed within 5-7 business days after we receive the returned item. Refunds are issued to the original payment method.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Intellectual Property -->
                <section id="intellectual-property" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">8. Intellectual Property</h2>
                    <p class="text-soft-brown leading-relaxed">
                        All content included on this site, such as text, graphics, logos, images, and software, is the property of GlowTrack or its content suppliers and protected by international copyright laws.
                    </p>
                </section>

                <!-- User Conduct -->
                <section id="user-conduct" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">9. User Conduct</h2>
                    <p class="text-soft-brown leading-relaxed mb-4">
                        You agree not to use the service to:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-soft-brown ml-4">
                        <li>Violate any applicable laws or regulations</li>
                        <li>Infringe on intellectual property rights</li>
                        <li>Upload malicious code or viruses</li>
                        <li>Harass, abuse, or harm other users</li>
                        <li>Submit false or misleading information</li>
                        <li>Use the service for fraudulent purposes</li>
                    </ul>
                </section>

                <!-- Privacy Policy -->
                <section id="privacy" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">10. Privacy Policy</h2>
                    <p class="text-soft-brown leading-relaxed">
                        Your privacy is important to us. Please review our Privacy Policy, which also governs your use of our services, to understand our practices.
                    </p>
                </section>

                <!-- Limitation of Liability -->
                <section id="limitation" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">11. Limitation of Liability</h2>
                    <p class="text-soft-brown leading-relaxed">
                        In no event shall GlowTrack, its directors, employees, partners, agents, suppliers, or affiliates be liable for any indirect, incidental, special, consequential, or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses.
                    </p>
                </section>

                <!-- Account Termination -->
                <section id="termination" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">12. Account Termination</h2>
                    <p class="text-soft-brown leading-relaxed">
                        We may terminate or suspend your account and bar access to the service immediately, without prior notice or liability, under our sole discretion, for any reason whatsoever.
                    </p>
                </section>

                <!-- Changes to Terms -->
                <section id="changes" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">13. Changes to Terms</h2>
                    <p class="text-soft-brown leading-relaxed">
                        We reserve the right to modify these Terms at any time. If we make material changes, we will notify you by email or by posting a notice on our site prior to the effective date of the changes.
                    </p>
                </section>

                <!-- Contact Information -->
                <section id="contact" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">14. Contact Information</h2>
                    <p class="text-soft-brown leading-relaxed mb-4">
                        Questions about the Terms of Service should be sent to us at:
                    </p>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <p class="text-soft-brown">
                            <strong>Email:</strong> legal@glowtrack.com<br>
                            <strong>Phone:</strong> 1-800-GLOWTRACK<br>
                            <strong>Address:</strong> Manila, Philippines
                        </p>
                    </div>
                </section>
            </div>
        </div>

        <!-- Back to Top -->
        <div class="text-center mt-8">
            <a href="#top" class="inline-flex items-center px-6 py-3 bg-jade-green text-white rounded-full hover:bg-soft-brown transition font-semibold">
                Back to Top
            </a>
        </div>
    </div>
</div>
@endsection
