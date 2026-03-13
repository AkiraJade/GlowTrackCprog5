@extends('layouts.app')

@section('title', 'Register - GlowTrack')

@section('content')
<section class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-block mb-4">
                    <span class="text-5xl">💫</span>
                </div>
                <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-2">Join GlowTrack</h1>
                <p class="text-soft-brown opacity-75">Start your skincare journey today</p>
            </div>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Full Name Field -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-semibold text-soft-brown">
                        Full Name
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition @error('name') border-red-500 @enderror bg-mint-cream"
                        placeholder="Your full name"
                    >
                    @error('name')
                        <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username Field -->
                <div class="space-y-2">
                    <label for="username" class="block text-sm font-semibold text-soft-brown">
                        Username
                    </label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        required
                        class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition @error('username') border-red-500 @enderror bg-mint-cream"
                        placeholder="Choose your username"
                    >
                    @error('username')
                        <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number Field -->
                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-semibold text-soft-brown">
                        Phone Number
                    </label>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                        required
                        class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition @error('phone') border-red-500 @enderror bg-mint-cream"
                        placeholder="Your phone number"
                    >
                    @error('phone')
                        <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address Field -->
                <div class="space-y-2">
                    <label for="address" class="block text-sm font-semibold text-soft-brown">
                        Address
                    </label>
                    <input
                        type="text"
                        id="address"
                        name="address"
                        value="{{ old('address') }}"
                        required
                        class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition @error('address') border-red-500 @enderror bg-mint-cream"
                        placeholder="Your address"
                    >
                    @error('address')
                        <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-soft-brown">
                        Email Address
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition @error('email') border-red-500 @enderror bg-mint-cream"
                        placeholder="your@email.com"
                    >
                    @error('email')
                        <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-soft-brown">
                        Password
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition @error('password') border-red-500 @enderror bg-mint-cream"
                        placeholder="••••••••"
                    >
                    <p class="text-xs text-soft-brown opacity-60 mt-1">At least 8 characters with uppercase, lowercase, and numbers</p>
                    @error('password')
                        <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-semibold text-soft-brown">
                        Confirm Password
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition bg-mint-cream"
                        placeholder="••••••••"
                    >
                </div>

                <!-- Profile Photo Field -->
                <div class="space-y-2">
                    <label for="photo" class="block text-sm font-semibold text-soft-brown">
                        Profile Photo (Optional)
                    </label>
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div id="photo-preview" class="w-20 h-20 rounded-full bg-light-sage flex items-center justify-center overflow-hidden">
                                <img id="preview-image" src="" alt="" class="w-full h-full object-cover hidden">
                                <span id="placeholder-icon" class="text-3xl text-soft-brown opacity-50">👤</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <input
                                type="file"
                                id="photo"
                                name="photo"
                                accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                class="w-full px-4 py-3 rounded-xl border-2 border-light-sage focus:border-jade-green focus:outline-none transition bg-mint-cream file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-jade-green file:text-white hover:file:bg-soft-brown"
                            >
                            <p class="text-xs text-soft-brown opacity-60 mt-1">JPG, PNG, JPEG, GIF or WebP (Max 2MB)</p>
                            @error('photo')
                                <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start space-x-2">
                    <input
                        type="checkbox"
                        id="agree"
                        name="agree"
                        required
                        class="w-4 h-4 rounded accent-jade-green cursor-pointer mt-1"
                    >
                    <label for="agree" class="text-sm text-soft-brown cursor-pointer">
                        I agree to the
                        <button type="button" onclick="showTermsModal()" class="text-jade-green hover:underline font-semibold">Terms of Service</button>
                        and
                        <button type="button" onclick="showPrivacyModal()" class="text-jade-green hover:underline font-semibold">Privacy Policy</button>
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full py-3 px-4 bg-gradient-to-r from-jade-green to-light-sage text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition transform duration-200 mt-6"
                    onclick="return validateAndSubmit(event)"
                >
                    Create Account
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 pt-6 border-t border-light-sage text-center">
                <p class="text-soft-brown text-sm">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-jade-green hover:text-soft-brown transition font-semibold">
                        Sign in here
                    </a>
                </p>
            </div>
        </div>

        <!-- Benefits -->
        <div class="mt-8 grid grid-cols-3 gap-3 text-center">
            <div class="text-sm">
                <p class="text-2xl mb-2">🎁</p>
                <p class="font-semibold text-soft-brown">Welcome Bonus</p>
            </div>
            <div class="text-sm">
                <p class="text-2xl mb-2">🚚</p>
                <p class="font-semibold text-soft-brown">Free Shipping</p>
            </div>
            <div class="text-sm">
                <p class="text-2xl mb-2">⭐</p>
                <p class="font-semibold text-soft-brown">Loyalty Points</p>
            </div>
        </div>
    </div>
</section>

<!-- Terms of Service Modal -->
<div id="termsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-3xl p-8 max-w-4xl mx-4 max-h-[80vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair">Terms of Service</h2>
            <button onclick="closeTermsModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="space-y-6 text-sm text-soft-brown">
            <div>
                <h3 class="font-semibold text-soft-brown mb-2">1. Acceptance of Terms</h3>
                <p>By accessing and using GlowTrack, you accept and agree to be bound by the terms and provision of this agreement.</p>
            </div>
            
            <div>
                <h3 class="font-semibold text-soft-brown mb-2">2. Services Description</h3>
                <p>GlowTrack is a comprehensive skincare e-commerce platform that provides product discovery, online purchasing, order tracking, loyalty programs, and more.</p>
            </div>
            
            <div>
                <h3 class="font-semibold text-soft-brown mb-2">3. User Accounts</h3>
                <p>You must provide accurate information to register for an account. You are responsible for maintaining the confidentiality of your account credentials.</p>
            </div>
            
            <div>
                <h3 class="font-semibold text-soft-brown mb-2">4. Products and Pricing</h3>
                <p>All prices are shown in Philippine Pesos (₱) and are subject to change without notice. We strive for accuracy but do not warrant that product descriptions are error-free.</p>
            </div>
            
            <div>
                <h3 class="font-semibold text-soft-brown mb-2">5. Orders and Payment</h3>
                <p>We accept various payment methods including credit/debit cards, digital wallets, and bank transfers. All payment information is encrypted and secure.</p>
            </div>
            
            <div>
                <h3 class="font-semibold text-soft-brown mb-2">6. Returns and Refunds</h3>
                <p>We offer a 30-day return policy for unopened products in original packaging. Refunds are processed within 5-7 business days.</p>
            </div>
            
            <div>
                <h3 class="font-semibold text-soft-brown mb-2">7. Privacy Policy</h3>
                <p>Your privacy is important to us. Please review our Privacy Policy to understand how we collect, use, and protect your information.</p>
            </div>
        </div>
        
        <div class="mt-6 text-center">
            <button onclick="closeTermsModal()" class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-soft-brown transition font-semibold">
                I Understand
            </button>
        </div>
    </div>
</div>

<!-- Privacy Policy Modal -->
<div id="privacyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-3xl p-8 max-w-4xl mx-4 max-h-[80vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair">Privacy Policy</h2>
            <button onclick="closePrivacyModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="space-y-6 text-sm text-soft-brown">
            <div>
                <h3 class="font-semibold text-soft-brown mb-2">Information We Collect</h3>
                <p>We collect personal information you provide directly (name, email, address) and automatically (IP address, browser type, usage data).</p>
            </div>
            
            <div>
                <h3 class="font-semibold text-soft-brown mb-2">How We Use Your Information</h3>
                <p>We use your information to provide services, personalize your experience, communicate with you, and improve our platform.</p>
            </div>
            
            <div>
                <h3 class="font-semibold text-soft-brown mb-2">Data Security</h3>
                <p>We implement SSL encryption, secure servers, firewalls, and regular security audits to protect your personal information.</p>
            </div>
            
            <div>
                <h3 class="font-semibold text-soft-brown mb-2">Cookies and Tracking</h3>
                <p>We use cookies to enhance your experience, remember preferences, and analyze website traffic. You can control cookies through browser settings.</p>
            </div>
            
            <div>
                <h3 class="font-semibold text-soft-brown mb-2">Your Rights</h3>
                <p>You have the right to access, correct, delete, and transfer your personal information. Contact us to exercise these rights.</p>
            </div>
            
            <div>
                <h3 class="font-semibold text-soft-brown mb-2">Data Retention</h3>
                <p>We retain your information only as long as necessary to fulfill the purposes for which it was collected.</p>
            </div>
        </div>
        
        <div class="mt-6 text-center">
            <button onclick="closePrivacyModal()" class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-soft-brown transition font-semibold">
                I Understand
            </button>
        </div>
    </div>
</div>

<script>
// Modal functions
function showTermsModal() {
    document.getElementById('termsModal').classList.remove('hidden');
    document.getElementById('termsModal').classList.add('flex');
}

function closeTermsModal() {
    document.getElementById('termsModal').classList.add('hidden');
    document.getElementById('termsModal').classList.remove('flex');
}

function showPrivacyModal() {
    document.getElementById('privacyModal').classList.remove('hidden');
    document.getElementById('privacyModal').classList.add('flex');
}

function closePrivacyModal() {
    document.getElementById('privacyModal').classList.add('hidden');
    document.getElementById('privacyModal').classList.remove('flex');
}

// Close modals when clicking outside
window.onclick = function(event) {
    const termsModal = document.getElementById('termsModal');
    const privacyModal = document.getElementById('privacyModal');
    
    if (event.target == termsModal) {
        closeTermsModal();
    }
    if (event.target == privacyModal) {
        closePrivacyModal();
    }
}

// Form validation and submission
function validateAndSubmit(event) {
    event.preventDefault();
    
    const form = event.target.closest('form');
    const formData = new FormData(form);
    
    console.log('Form submission started');
    console.log('FormData contents:');
    for (let [key, value] of formData.entries()) {
        console.log(key + ':', value);
    }
    
    // Check if photo field has value
    const photoInput = document.getElementById('photo');
    console.log('Photo input:', photoInput);
    console.log('Photo files:', photoInput.files);
    
    // Validate form
    const agreeCheckbox = document.getElementById('agree');
    if (!agreeCheckbox.checked) {
        alert('Please agree to the Terms of Service and Privacy Policy');
        return false;
    }
    
    // Submit form normally
    console.log('Submitting form...');
    form.submit();
}

// Photo preview functionality
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('preview-image');
    const placeholder = document.getElementById('placeholder-icon');
    
    console.log('File selected:', file);
    console.log('File type:', file ? file.type : 'No file');
    console.log('File size:', file ? file.size : 'No file');
    
    if (file) {
        // Check if it's an image
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file (JPEG, PNG, JPG, GIF, or WebP)');
            this.value = '';
            return;
        }
        
        // Check file size (2MB limit)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            this.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = '';
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
    }
});
</script>
@endsection
