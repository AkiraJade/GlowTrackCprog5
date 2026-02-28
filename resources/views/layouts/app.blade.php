<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GlowTrack - Your Premium Skincare E-commerce Platform">
    <title>@yield('title', 'GlowTrack - Premium Skincare')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback Tailwind CSS from CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'jade-green': '#7EC8B3',
                            'mint-cream': '#F1FAF7',
                            'pastel-green': '#CDEDE3',
                            'light-sage': '#A8D5C2',
                            'blush-pink': '#F6C1CC',
                            'warm-peach': '#FFD6A5',
                            'soft-brown': '#6B4F4F',
                        },
                        fontFamily: {
                            sans: ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                            playfair: ['Playfair Display', 'serif'],
                            poppins: ['Poppins', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
        <style>
            html { scroll-behavior: smooth; }
            .font-playfair { font-family: 'Playfair Display', serif; }
            a { transition: all 0.2s ease; }
        </style>
    @endif
</head>
<body class="bg-mint-cream text-soft-brown font-poppins">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('index') }}" class="flex items-center space-x-2">
                        <span class="text-2xl font-bold text-jade-green">✨</span>
                        <span class="text-2xl font-bold text-jade-green font-playfair">GlowTrack</span>
                    </a>
                </div>
                
                <!-- Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-soft-brown hover:text-jade-green transition">Features</a>
                    <a href="{{ route('products.index') }}" class="text-soft-brown hover:text-jade-green transition">Products</a>
                    <a href="{{ route('about') }}" class="text-soft-brown hover:text-jade-green transition">About</a>
                </div>
                
                <!-- Auth Links -->
                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-soft-brown hover:text-jade-green transition font-medium">Admin Panel</a>
                        @endif
                        @if(auth()->user()->isCustomer())
                            <a href="{{ route('seller.application.create') }}" class="text-soft-brown hover:text-jade-green transition">Become a Seller</a>
                            <a href="{{ route('orders.index') }}" class="text-soft-brown hover:text-jade-green transition">My Orders</a>
                        @endif
                        @if(auth()->user()->isSeller())
                            <a href="{{ route('products.my') }}" class="text-soft-brown hover:text-jade-green transition">My Products</a>
                            <a href="{{ route('orders.index') }}" class="text-soft-brown hover:text-jade-green transition">My Orders</a>
                        @endif
                        <a href="{{ route('profile.show') }}" class="text-soft-brown hover:text-jade-green transition">Profile</a>
                        <a href="{{ url('/dashboard') }}" class="text-soft-brown hover:text-jade-green transition">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-soft-brown hover:text-jade-green transition font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-soft-brown hover:text-jade-green transition font-medium">Login</a>
                        <a href="{{ route('register') }}" class="px-6 py-2 bg-jade-green text-white rounded-full hover:bg-opacity-90 transition font-medium">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-soft-brown text-white mt-20 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">GlowTrack</h3>
                    <p class="text-gray-200">Your trusted platform for premium skincare products.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Shop</h4>
                    <ul class="space-y-2 text-gray-200">
                        <li><a href="#" class="hover:text-jade-green transition">New Arrivals</a></li>
                        <li><a href="#" class="hover:text-jade-green transition">Best Sellers</a></li>
                        <li><a href="#" class="hover:text-jade-green transition">Collections</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-200">
                        <li><a href="#" class="hover:text-jade-green transition">Contact Us</a></li>
                        <li><a href="#" class="hover:text-jade-green transition">FAQs</a></li>
                        <li><a href="#" class="hover:text-jade-green transition">Shipping Info</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2 text-gray-200">
                        <li><a href="#" class="hover:text-jade-green transition">Privacy</a></li>
                        <li><a href="#" class="hover:text-jade-green transition">Terms</a></li>
                        <li><a href="#" class="hover:text-jade-green transition">Returns</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center text-gray-200">
                <p>&copy; 2024 GlowTrack. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Smooth scroll -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>
