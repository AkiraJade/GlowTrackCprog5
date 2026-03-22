<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <!-- Email Icon -->
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-envelope-open-text text-3xl text-green-600"></i>
            </div>

            <h1 class="text-2xl font-bold text-gray-800 mb-4">
                Verify Your Email
            </h1>

            <p class="text-gray-600 mb-6">
                We've sent a verification link to<br>
                <strong class="text-gray-800">{{ $email ?? 'your email address' }}</strong>
            </p>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                    <div class="text-left text-sm text-blue-700">
                        <p class="mb-2">Please check your inbox and click the verification link to complete your registration.</p>
                        <p>The link will expire in <strong>60 minutes</strong>.</p>
                    </div>
                </div>
            </div>

            <!-- Resend Button -->
            <form action="{{ route('verification.send') }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden" name="email" value="{{ $email ?? '' }}">
                <button type="submit" class="w-full bg-green-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-green-700 transition duration-200">
                    <i class="fas fa-redo mr-2"></i>
                    Resend Verification Email
                </button>
            </form>

            <p class="text-sm text-gray-500 mb-6">
                Didn't receive the email? Check your spam folder or click above to resend.
            </p>

            <div class="border-t pt-6">
                <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Login
                </a>
            </div>
        </div>

        <p class="text-center text-gray-500 text-sm mt-6">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>
</body>
</html>
