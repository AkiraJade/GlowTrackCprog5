<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GlowTrack - Your Premium Skincare E-commerce Platform">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

            .glass-card {
                background: rgba(255, 255, 255, 0.78);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(229, 231, 235, 0.7);
            }

            .badge-pill {
                padding: 0.15rem 0.65rem;
                border-radius: 9999px;
                font-size: 0.70rem;
                font-weight: 600;
                letter-spacing: 0.02em;
            }
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
<a href="{{ route('features') }}" class="text-soft-brown hover:text-jade-green transition">Features</a>
                    <a href="{{ route('products.index') }}" class="text-soft-brown hover:text-jade-green transition">Products</a>
                    <a href="{{ route('about') }}" class="text-soft-brown hover:text-jade-green transition">About</a>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Notification Button -->
                        <div class="relative group">
                            <button id="notification-btn"
                                    class="relative p-2 text-soft-brown hover:text-jade-green transition rounded-full hover:bg-gray-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                @if(($unreadCount ?? 0) > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold">{{ $unreadCount }}</span>
                                @endif
                            </button>
                            @include('partials.notifications')
                        </div>

                        @if(auth()->user()->isAdmin())
                            <div class="relative group">
                                <button class="text-soft-brown hover:text-jade-green transition font-medium flex items-center space-x-1">
                                    <span>Admin Panel</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-soft-brown hover:bg-jade-green hover:text-white transition">Dashboard</a>
                                    <a href="{{ route('admin.users') }}" class="block px-4 py-2 text-sm text-soft-brown hover:bg-jade-green hover:text-white transition">Users</a>
                                    <a href="{{ route('admin.products') }}" class="block px-4 py-2 text-sm text-soft-brown hover:bg-jade-green hover:text-white transition">Products</a>
                                    <a href="{{ route('admin.orders') }}" class="block px-4 py-2 text-sm text-soft-brown hover:bg-jade-green hover:text-white transition">Orders</a>
                                    <a href="{{ route('admin.reports.inventory') }}" class="block px-4 py-2 text-sm text-soft-brown hover:bg-jade-green hover:text-white transition">Reports</a>
                                    <div class="border-t border-gray-200"></div>
                                    <a href="{{ route('products.import') }}" class="block px-4 py-2 text-sm text-soft-brown hover:bg-jade-green hover:text-white transition">Import Products</a>
                                    <a href="{{ route('products.export') }}" class="block px-4 py-2 text-sm text-soft-brown hover:bg-jade-green hover:text-white transition">Export Products</a>
                                </div>
                            </div>
                        @endif
@if(auth()->user()->isCustomer())
                            <a href="{{ route('cart.index') }}" class="text-soft-brown hover:text-jade-green transition">Cart ({{ Auth::user()->cartItems()->count() }})</a>
                        @endif

                        @if(auth()->user()->isSeller())
                            <div class="relative group">
                                <button class="text-soft-brown hover:text-jade-green transition font-medium flex items-center space-x-1">
                                    <span>Seller Panel</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <a href="{{ route('seller.dashboard') }}" class="block px-4 py-2 text-sm text-soft-brown hover:bg-jade-green hover:text-white transition">Dashboard</a>
                                    <a href="{{ route('seller.products.index') }}" class="block px-4 py-2 text-sm text-soft-brown hover:bg-jade-green hover:text-white transition">My Products</a>
                                    <a href="{{ route('seller.orders.index') }}" class="block px-4 py-2 text-sm text-soft-brown hover:bg-jade-green hover:text-white transition">Orders</a>
                                    <div class="border-t border-gray-200"></div>
                                    <a href="{{ route('products.import') }}" class="block px-4 py-2 text-sm text-soft-brown hover:bg-jade-green hover:text-white transition">Import Products</a>
                                    <a href="{{ route('products.export') }}" class="block px-4 py-2 text-sm text-soft-brown hover:bg-jade-green hover:text-white transition">Export Products</a>
                                </div>
                            </div>
                        @endif

                        <a href="{{ route('dashboard') }}" class="text-soft-brown hover:text-jade-green transition">Dashboard</a>
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

    <!-- Notifications JavaScript -->
    @if(auth()->check())
        <script>
            // Auto-refresh notifications every 30 seconds
            setInterval(() => {
                fetch('{{ route("notifications.unread-count") }}')
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.querySelector('#notification-btn .bg-red-500');
                        if (badge) {
                            if (data.unread_count > 0) {
                                badge.textContent = data.unread_count;
                                badge.style.display = 'flex';
                            } else {
                                badge.style.display = 'none';
                            }
                        }
                    })
                    .catch(error => console.error('Error fetching notifications:', error));
            }, 30000);

            // Mark notification as read when clicked
            document.addEventListener('DOMContentLoaded', function() {
                const notificationLinks = document.querySelectorAll('[data-notification-id]');
                notificationLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        const notificationId = this.dataset.notificationId;
                        if (notificationId) {
                            fetch(`{{ route("notifications.mark-read", ":id") }}`.replace(':id', notificationId), {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Content-Type': 'application/json'
                                }
                            }).catch(error => console.error('Error marking notification as read:', error));
                        }
                    });
                });
            });
        </script>
    @endif

    @stack('scripts')
</body>
</html>
