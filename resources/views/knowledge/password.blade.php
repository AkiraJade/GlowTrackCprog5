@extends('layouts.app')

@section('title', 'Change Password - GlowTrack Knowledge Base')

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
                            <a href="#" class="ml-1 text-soft-brown hover:text-jade-green transition">Account & Settings</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-soft-brown mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-soft-brown font-medium">Change Password</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Article Header -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center">
                    <span class="text-2xl">🔐</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Change Password</h1>
                    <p class="text-soft-brown opacity-75">Secure your account with a strong password</p>
                </div>
            </div>

            <!-- Article Meta -->
            <div class="flex items-center gap-6 text-sm text-soft-brown opacity-75 border-t border-b border-gray-200 py-4">
                <span>📅 Updated 4 days ago</span>
                <span>⏱️ 3 min read</span>
                <span>👁️ 1.1k views</span>
            </div>
        </div>

        <!-- Article Content -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-lg text-soft-brown leading-relaxed mb-6">
                    Keeping your GlowTrack account secure is important. Learn how to change your password, create strong passwords, and protect your account from unauthorized access.
                </p>
            </div>

            <!-- How to Change Password -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">How to Change Your Password</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">1</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Log In to Your Account</h3>
                            <p class="text-sm text-soft-brown opacity-75">Sign in with your current email and password</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">2</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Go to Profile Settings</h3>
                            <p class="text-sm text-soft-brown opacity-75">Click your profile icon and select "Profile Settings"</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">3</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Click "Change Password"</h3>
                            <p class="text-sm text-soft-brown opacity-75">Find the password section and click the change button</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">4</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Enter Password Information</h3>
                            <p class="text-sm text-soft-brown opacity-75">Fill in current password, new password, and confirmation</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-jade-green text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">5</div>
                        <div>
                            <h3 class="font-semibold text-soft-brown mb-1">Save Changes</h3>
                            <p class="text-sm text-soft-brown opacity-75">Click "Update Password" to save your new password</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Requirements -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Password Requirements</h2>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <h3 class="font-semibold text-blue-800 mb-3">🔒 Your password must contain:</h3>
                    <ul class="space-y-2 text-sm text-blue-700">
                        <li>• Minimum 8 characters</li>
                        <li>• At least one uppercase letter (A-Z)</li>
                        <li>• At least one lowercase letter (a-z)</li>
                        <li>• At least one number (0-9)</li>
                        <li>• At least one special character (!@#$%^&*)</li>
                        <li>• Cannot be the same as your email or username</li>
                    </ul>
                </div>
            </div>

            <!-- Strong Password Tips -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Tips for Strong Passwords</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                        <h3 class="font-semibold text-green-800 mb-2">✅ Good Practices</h3>
                        <ul class="space-y-1 text-sm text-green-700">
                            <li>• Use unique phrases or sentences</li>
                            <li>• Mix different character types</li>
                            <li>• Avoid personal information</li>
                            <li>• Use different passwords for different sites</li>
                            <li>• Consider using a password manager</li>
                        </ul>
                    </div>
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                        <h3 class="font-semibold text-red-800 mb-2">❌ Avoid These</h3>
                        <ul class="space-y-1 text-sm text-red-700">
                            <li>• Common words (password, 123456)</li>
                            <li>• Personal information (birthdate, name)</li>
                            <li>• Sequential characters (abc123)</li>
                            <li>• Reusing old passwords</li>
                            <li>• Sharing your password with others</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Forgot Password -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Forgot Your Password?</h2>
                <div class="bg-light-sage bg-opacity-50 rounded-xl p-6">
                    <h3 class="font-semibold text-soft-brown mb-3">🔄 Password Reset Process</h3>
                    <ol class="space-y-2 text-sm text-soft-brown">
                        <li>1. Click "Forgot Password" on the login page</li>
                        <li>2. Enter your registered email address</li>
                        <li>3. Check your email for reset link (check spam folder)</li>
                        <li>4. Click the reset link within 24 hours</li>
                        <li>5. Create a new password</li>
                        <li>6. Log in with your new password</li>
                    </ol>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mt-4">
                        <p class="text-sm text-yellow-700 mb-2">⚠️ Important:</p>
                        <p class="text-sm text-yellow-700">Reset links expire after 24 hours for security reasons.</p>
                    </div>
                </div>
            </div>

            <!-- Security Best Practices -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Account Security Best Practices</h2>
                <div class="space-y-4">
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">🔐 Two-Factor Authentication</h3>
                        <p class="text-sm text-soft-brown opacity-75">Enable 2FA for an extra layer of security on your account.</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">📧 Email Security</h3>
                        <p class="text-sm text-soft-brown opacity-75">Keep your email account secure as it's used for password resets.</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">🔍 Regular Updates</h3>
                        <p class="text-sm text-soft-brown opacity-75">Change your password every 3-6 months for better security.</p>
                    </div>
                    <div class="bg-light-sage bg-opacity-50 rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">📱 Device Security</h3>
                        <p class="text-sm text-soft-brown opacity-75">Log out from shared devices and avoid saving passwords on public computers.</p>
                    </div>
                </div>
            </div>

            <!-- Common Issues -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-soft-brown mb-4">Common Password Issues</h2>
                <div class="space-y-4">
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Password not accepted"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Ensure your password meets all requirements and check for typos.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Current password incorrect"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Try the password you used to log in, or use the forgot password option.</p>
                    </div>
                    <div class="border border-light-sage rounded-xl p-4">
                        <h3 class="font-semibold text-soft-brown mb-2">❓ "Didn't receive reset email"</h3>
                        <p class="text-sm text-soft-brown opacity-75">Check spam folder, verify email address, and try again.</p>
                    </div>
                </div>
            </div>

            <!-- Related Articles -->
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-xl font-bold text-soft-brown mb-4">Related Articles</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('knowledge.creating-account') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Creating an Account →
                    </a>
                    <a href="{{ route('knowledge.update-profile') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Update Profile Information →
                    </a>
                    <a href="{{ route('knowledge.privacy') }}" class="text-jade-green hover:text-soft-brown transition font-medium">
                        Privacy Settings →
                    </a>
                </div>
            </div>

        </div>

        <!-- Help Section -->
        <div class="mt-8 text-center bg-white rounded-3xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-soft-brown mb-4">Password Help Needed?</h3>
            <p class="text-soft-brown opacity-75 mb-6">Our support team can help you secure your account!</p>
            <a href="{{ route('support.contact') }}" 
               class="px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                Contact Support
            </a>
        </div>

    </div>
</div>
@endsection
