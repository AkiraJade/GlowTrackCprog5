<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GlowTrack Admin Panel">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - GlowTrack')</title>
    
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
                            'admin-primary': '#7EC8B3',
                            'admin-sidebar': '#6B4F4F',
                            'admin-hover': '#8B6F6F',
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
            .sidebar-gradient {
                background: linear-gradient(135deg, #7EC8B3 0%, #F1FAF7 100%);
            }
            .sidebar-menu-item {
                transition: all 0.2s ease;
            }
            .sidebar-menu-item:hover {
                background-color: #8B6F6F;
                transform: translateX(4px);
            }
            .sidebar-menu-item.active {
                background-color: #7EC8B3;
            }
            
            /* Mobile responsiveness */
            @media (max-width: 768px) {
                .sidebar-mobile {
                    position: fixed;
                    inset: 0;
                    z-index: 50;
                    transform: translateX(-100%);
                    transition: transform 0.3s ease-in-out;
                }
                
                .sidebar-mobile.open {
                    transform: translateX(0);
                }
                
                .sidebar-overlay {
                    position: fixed;
                    inset: 0;
                    background: rgba(0, 0, 0, 0.5);
                    z-index: 40;
                    display: none;
                }
                
                .sidebar-overlay.show {
                    display: block;
                }
                
                .mobile-menu-btn {
                    display: flex;
                }
                
                .desktop-only {
                    display: none;
                }
            }
            
            @media (min-width: 769px) {
                .mobile-menu-btn {
                    display: none;
                }
                
                .sidebar-mobile {
                    position: static;
                    transform: none;
                    transition: none;
                }
                
                .sidebar-overlay {
                    display: none !important;
                }
            }
        </style>
    @endif
</head>
<body class="bg-gray-50 text-gray-800 font-poppins">
    <!-- Mobile Menu Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile Menu Button -->
        <button onclick="toggleSidebar()" class="mobile-menu-btn lg:hidden fixed top-4 left-4 z-30 p-2 bg-jade-green text-white rounded-lg shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        
        <!-- Sidebar -->
        <aside class="w-64 flex-shrink-0">
            <div class="h-full flex flex-col">
                <!-- Sidebar Header -->
                <div class="sidebar-gradient p-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                            <span class="text-jade-green font-bold text-xl">GT</span>
                        </div>
                        <div>
                            <h2 class="text-soft-brown font-bold text-lg font-playfair">GlowTrack</h2>
                            <p class="text-soft-brown opacity-90">Admin Portal</p>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar Navigation -->
                <nav class="flex-1 bg-admin-sidebar overflow-y-auto">
                    <!-- Main Menu -->
                    <div class="p-4">
                        <h3 class="text-xs font-semibold text-gray-300 uppercase tracking-wider mb-3">Main Menu</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'hover:text-white' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l-2-2m4 4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Product Management -->
                    <div class="p-4">
                        <h3 class="text-xs font-semibold text-gray-300 uppercase tracking-wider mb-3">Product Management</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('admin.products') }}" class="sidebar-menu-item {{ request()->routeIs('admin.products') ? 'active' : '' }} flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('admin.products') ? 'text-white' : 'hover:text-white' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-4-4m0 0l8 4v14m-8-4h-4l-4 4v6m0 0v-6m0 0h6l4-4"></path>
                                    </svg>
                                    Products
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.reports.inventory') }}" class="sidebar-menu-item {{ request()->routeIs('admin.reports.inventory') ? 'active' : '' }} flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('admin.reports.inventory') ? 'text-white' : 'hover:text-white' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012 2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Inventory
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Order Management -->
                    <div class="p-4">
                        <h3 class="text-xs font-semibold text-gray-300 uppercase tracking-wider mb-3">Order Management</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('admin.orders') }}" class="sidebar-menu-item {{ request()->routeIs('admin.orders') ? 'active' : '' }} flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('admin.orders') ? 'text-white' : 'hover:text-white' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Orders
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- User Management -->
                    <div class="p-4">
                        <h3 class="text-xs font-semibold text-gray-300 uppercase tracking-wider mb-3">User Management</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('admin.users') }}" class="sidebar-menu-item {{ request()->routeIs('admin.users*') ? 'active' : '' }} flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('admin.users*') ? 'text-white' : 'hover:text-white' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    Users
                                </a>
                            </li>
                            <li>
                                <a href="#" class="sidebar-menu-item flex items-center px-4 py-3 text-gray-300 rounded-lg hover:text-white">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Verification
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Reports & Analytics -->
                    <div class="p-4">
                        <h3 class="text-xs font-semibold text-gray-300 uppercase tracking-wider mb-3">Reports & Analytics</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('admin.reports') }}" class="sidebar-menu-item {{ request()->routeIs('admin.reports') ? 'active' : '' }} flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('admin.reports') ? 'text-white' : 'hover:text-white' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Reports
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.reports.sales') }}" class="sidebar-menu-item {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }} flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('admin.reports.sales') ? 'text-white' : 'hover:text-white' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Sales Report
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Delivery Management -->
                    <div class="p-4">
                        <h3 class="text-xs font-semibold text-gray-300 uppercase tracking-wider mb-3">Delivery Management</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('admin.delivery-dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('admin.delivery-dashboard') ? 'active' : '' }} flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('admin.delivery-dashboard') ? 'text-white' : 'hover:text-white' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Delivery Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.deliveries.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.deliveries*') ? 'active' : '' }} flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('admin.deliveries*') ? 'text-white' : 'hover:text-white' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 104 0m6 0a2 2 0 104 0m-4 0a2 2 0 104 0"></path>
                                    </svg>
                                    Manage Deliveries
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.delivery-personnel.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.delivery-personnel*') ? 'active' : '' }} flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('admin.delivery-personnel*') ? 'text-white' : 'hover:text-white' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    Delivery Personnel
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Settings -->
                    <div class="p-4">
                        <h3 class="text-xs font-semibold text-gray-300 uppercase tracking-wider mb-3">Settings</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="#" class="sidebar-menu-item flex items-center px-4 py-3 text-gray-300 rounded-lg hover:text-white">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-1.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-2.572 1.065c-.94 1.543.826 3.31 2.37 2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Settings
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                
                <!-- Sidebar Footer -->
                <div class="p-4 border-t border-gray-700">
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-red-600 hover:text-white transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4 lg:px-6">
                    <!-- Search Bar -->
                    <div class="flex-1 max-w-lg mx-4 lg:mx-0">
                        <div class="relative">
                            <input type="text" placeholder="Search..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-admin-primary focus:border-transparent">
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Right Side Icons -->
                    <div class="flex items-center space-x-2 lg:space-x-4 ml-2 lg:ml-6">
                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-600 hover:text-gray-900 transition-colors">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        
                        <!-- Messages -->
                        <button class="relative p-2 text-gray-600 hover:text-gray-900 transition-colors">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                        
                        <!-- User Avatar -->
                        <div class="flex items-center space-x-2 lg:space-x-3">
                            <div class="w-8 h-8 bg-admin-primary rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name, 0, 1) ?? 'A' }}</span>
                            </div>
                            <div class="hidden md:block">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/js/app.js'])
    @else
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @endif
    
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar-mobile');
            const overlay = document.querySelector('.sidebar-overlay');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar-mobile');
            const overlay = document.querySelector('.sidebar-overlay');
            const menuButton = document.querySelector('.mobile-menu-btn');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !menuButton.contains(event.target) &&
                sidebar.classList.contains('open')) {
                toggleSidebar();
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                const sidebar = document.querySelector('.sidebar-mobile');
                const overlay = document.querySelector('.sidebar-overlay');
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
