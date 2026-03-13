@extends('layouts.app')

@section('title', 'Privacy Policy - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-4">Privacy Policy</h1>
            <p class="text-lg text-soft-brown opacity-75">Last updated: {{ date('F d, Y') }}</p>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
            
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-soft-brown leading-relaxed mb-4">
                    GlowTrack ("we," "us," or "our") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website glowtrack.com and use our services.
                </p>
                <p class="text-soft-brown leading-relaxed">
                    By using GlowTrack, you consent to the data practices described in this policy. If you do not agree with the terms of this privacy policy, please do not access or use our website.
                </p>
            </div>

            <!-- Table of Contents -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Table of Contents</h2>
                <div class="space-y-2">
                    <a href="#information-collection" class="block text-jade-green hover:text-soft-brown transition">1. Information We Collect</a>
                    <a href="#information-use" class="block text-jade-green hover:text-soft-brown transition">2. How We Use Your Information</a>
                    <a href="#information-sharing" class="block text-jade-green hover:text-soft-brown transition">3. Information Sharing</a>
                    <a href="#data-security" class="block text-jade-green hover:text-soft-brown transition">4. Data Security</a>
                    <a href="#cookies" class="block text-jade-green hover:text-soft-brown transition">5. Cookies and Tracking</a>
                    <a href="#user-rights" class="block text-jade-green hover:text-soft-brown transition">6. Your Rights</a>
                    <a href="#data-retention" class="block text-jade-green hover:text-soft-brown transition">7. Data Retention</a>
                    <a href="#children-privacy" class="block text-jade-green hover:text-soft-brown transition">8. Children's Privacy</a>
                    <a href="#international-transfer" class="block text-jade-green hover:text-soft-brown transition">9. International Data Transfers</a>
                    <a href="#policy-changes" class="block text-jade-green hover:text-soft-brown transition">10. Changes to This Policy</a>
                    <a href="#contact-privacy" class="block text-jade-green hover:text-soft-brown transition">11. Contact Information</a>
                </div>
            </div>

            <!-- Sections -->
            <div class="space-y-8">
                <!-- Information We Collect -->
                <section id="information-collection" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">1. Information We Collect</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">1.1 Personal Information</h3>
                            <p class="text-soft-brown leading-relaxed mb-2">We collect information you provide directly to us:</p>
                            <ul class="list-disc list-inside space-y-1 text-soft-brown ml-4">
                                <li>Name, username, and email address</li>
                                <li>Phone number and address</li>
                                <li>Profile photo (if uploaded)</li>
                                <li>Payment information</li>
                                <li>Account credentials</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">1.2 Automatically Collected Information</h3>
                            <p class="text-soft-brown leading-relaxed mb-2">We automatically collect certain information when you visit our website:</p>
                            <ul class="list-disc list-inside space-y-1 text-soft-brown ml-4">
                                <li>IP address and browser type</li>
                                <li>Device information and operating system</li>
                                <li>Pages visited and time spent</li>
                                <li>Referring website addresses</li>
                                <li>Clickstream data</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">1.3 Transaction Information</h3>
                            <p class="text-soft-brown leading-relaxed">
                                When you make purchases, we collect order details, payment information, and shipping preferences.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- How We Use Your Information -->
                <section id="information-use" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">2. How We Use Your Information</h2>
                    <p class="text-soft-brown leading-relaxed mb-4">We use your information for various purposes:</p>
                    <ul class="list-disc list-inside space-y-2 text-soft-brown ml-4">
                        <li><strong>Service Provision:</strong> To process orders, manage accounts, and provide customer support</li>
                        <li><strong>Personalization:</strong> To personalize your experience and recommend products</li>
                        <li><strong>Communication:</strong> To send order confirmations, shipping updates, and marketing communications</li>
                        <li><strong>Improvement:</strong> To analyze usage patterns and improve our services</li>
                        <li><strong>Security:</strong> To detect fraud and maintain security of our platform</li>
                        <li><strong>Legal Compliance:</strong> To comply with legal obligations</li>
                    </ul>
                </section>

                <!-- Information Sharing -->
                <section id="information-sharing" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">3. Information Sharing</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">3.1 Service Providers</h3>
                            <p class="text-soft-brown leading-relaxed">
                                We share information with third-party service providers who perform services on our behalf, such as payment processing, shipping, and data analytics.
                            </p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">3.2 Sellers</h3>
                            <p class="text-soft-brown leading-relaxed">
                                We share necessary order information with sellers to fulfill your orders and provide customer service.
                            </p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">3.3 Legal Requirements</h3>
                            <p class="text-soft-brown leading-relaxed">
                                We may disclose your information if required by law or in good faith belief that such disclosure is necessary to comply with legal obligations.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Data Security -->
                <section id="data-security" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">4. Data Security</h2>
                    <p class="text-soft-brown leading-relaxed mb-4">
                        We implement appropriate technical and organizational measures to protect your personal information:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-soft-brown ml-4">
                        <li>SSL encryption for data transmission</li>
                        <li>Secure servers and firewalls</li>
                        <li>Regular security audits and updates</li>
                        <li>Employee training on data protection</li>
                        <li>Access controls and authentication</li>
                    </ul>
                    <p class="text-soft-brown leading-relaxed">
                        However, no method of transmission over the internet or method of electronic storage is 100% secure.
                    </p>
                </section>

                <!-- Cookies and Tracking -->
                <section id="cookies" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">5. Cookies and Tracking</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">5.1 Cookies</h3>
                            <p class="text-soft-brown leading-relaxed">
                                We use cookies and similar tracking technologies to enhance your experience, remember your preferences, and analyze website traffic.
                            </p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">5.2 Cookie Types</h3>
                            <ul class="list-disc list-inside space-y-1 text-soft-brown ml-4">
                                <li>Essential cookies for website functionality</li>
                                <li>Performance cookies for analytics</li>
                                <li>Functionality cookies for personalization</li>
                                <li>Marketing cookies for advertising</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-2">5.3 Cookie Management</h3>
                            <p class="text-soft-brown leading-relaxed">
                                You can control cookies through your browser settings. Disabling cookies may affect your experience on our website.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Your Rights -->
                <section id="user-rights" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">6. Your Rights</h2>
                    <p class="text-soft-brown leading-relaxed mb-4">You have the following rights regarding your personal information:</p>
                    <ul class="list-disc list-inside space-y-2 text-soft-brown ml-4">
                        <li><strong>Access:</strong> Request access to your personal information</li>
                        <li><strong>Correction:</strong> Request correction of inaccurate information</li>
                        <li><strong>Deletion:</strong> Request deletion of your personal information</li>
                        <li><strong>Portability:</strong> Request transfer of your data to another service</li>
                        <li><strong>Objection:</strong> Object to processing of your information</li>
                        <li><strong>Restriction:</strong> Restrict processing of your information</li>
                    </ul>
                    <p class="text-soft-brown leading-relaxed">
                        To exercise these rights, please contact us using the information provided below.
                    </p>
                </section>

                <!-- Data Retention -->
                <section id="data-retention" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">7. Data Retention</h2>
                    <p class="text-soft-brown leading-relaxed">
                        We retain your personal information only as long as necessary to fulfill the purposes for which it was collected, unless a longer retention period is required or permitted by law.
                    </p>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4 mt-4">
                        <p class="text-soft-brown">
                            <strong>Typical retention periods:</strong><br>
                            • Account information: While account is active<br>
                            • Order information: 7 years for tax and legal purposes<br>
                            • Marketing data: Until you opt out<br>
                            • Analytics data: Aggregated and anonymized after 2 years
                        </p>
                    </div>
                </section>

                <!-- Children's Privacy -->
                <section id="children-privacy" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">8. Children's Privacy</h2>
                    <p class="text-soft-brown leading-relaxed">
                        Our services are not intended for individuals under the age of 18. We do not knowingly collect personal information from children under 18. If we become aware that we have collected personal information from a child under 18, we will take steps to delete such information immediately.
                    </p>
                </section>

                <!-- International Data Transfers -->
                <section id="international-transfer" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">9. International Data Transfers</h2>
                    <p class="text-soft-brown leading-relaxed">
                        Your information may be transferred to and processed in countries other than the Philippines. We ensure appropriate safeguards are in place to protect your information in accordance with applicable data protection laws.
                    </p>
                </section>

                <!-- Policy Changes -->
                <section id="policy-changes" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">10. Changes to This Policy</h2>
                    <p class="text-soft-brown leading-relaxed">
                        We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date at the top.
                    </p>
                    <p class="text-soft-brown leading-relaxed">
                        You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.
                    </p>
                </section>

                <!-- Contact Information -->
                <section id="contact-privacy" class="scroll-mt-8">
                    <h2 class="text-2xl font-bold text-soft-brown mb-4">11. Contact Information</h2>
                    <p class="text-soft-brown leading-relaxed mb-4">
                        If you have any questions about this Privacy Policy, please contact us:
                    </p>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <p class="text-soft-brown">
                            <strong>Email:</strong> privacy@glowtrack.com<br>
                            <strong>Phone:</strong> 1-800-GLOWTRACK<br>
                            <strong>Address:</strong> Manila, Philippines<br>
                            <strong>Data Protection Officer:</strong> dpo@glowtrack.com
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
