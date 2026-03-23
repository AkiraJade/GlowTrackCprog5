<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GlowTrack Admin Panel">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - GlowTrack')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'jade-green':   '#7EC8B3',
                            'mint-cream':   '#F1FAF7',
                            'pastel-green': '#CDEDE3',
                            'light-sage':   '#A8D5C2',
                            'blush-pink':   '#F6C1CC',
                            'warm-peach':   '#FFD6A5',
                            'soft-brown':   '#6B4F4F',
                        },
                        fontFamily: {
                            sans:     ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                            playfair: ['Playfair Display', 'serif'],
                            poppins:  ['Poppins', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
    @endif

    <style>
        /* ─── Reset & Base ──────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Poppins', sans-serif;
            background: #CDEDE3;
            background-image:
                radial-gradient(ellipse 80% 60% at 10% 0%,   rgba(126,200,179,.45) 0%, transparent 60%),
                radial-gradient(ellipse 70% 55% at 90% 100%, rgba(246,193,204,.35) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 50% 50%,  rgba(255,214,165,.20) 0%, transparent 70%),
                linear-gradient(150deg, #F1FAF7 0%, #CDEDE3 45%, #A8D5C2 100%);
            background-attachment: fixed;
            min-height: 100vh;
            overflow: hidden;
            color: #6B4F4F;
        }

        .font-playfair { font-family: 'Playfair Display', serif; }

        /* ─── Scrollbar ─────────────────────────────────────────── */
        ::-webkit-scrollbar          { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track    { background: transparent; }
        ::-webkit-scrollbar-thumb    { background: rgba(126,200,179,.45); border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(126,200,179,.7); }

        /* ─── Sidebar ───────────────────────────────────────────── */
        .glass-sidebar {
            background: linear-gradient(165deg,
                rgba(75, 55, 55, 0.97) 0%,
                rgba(42, 88, 74, 0.97) 60%,
                rgba(30, 70, 58, 0.98) 100%);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border-right: 1px solid rgba(255,255,255,.08);
            box-shadow: 4px 0 32px rgba(0,0,0,.18);
        }

        .sidebar-logo {
            background: rgba(255,255,255,.06);
            border-bottom: 1px solid rgba(255,255,255,.08);
        }



        /* nav item */
        .nav-item {
            display: flex;
            align-items: center;
            padding: .6rem .75rem;
            border-radius: .75rem;
            border: 1px solid transparent;
            font-size: .8125rem;
            font-weight: 500;
            color: rgba(255,255,255,.62);
            transition: all .22s cubic-bezier(.4,0,.2,1);
            text-decoration: none;
            gap: .625rem;
            position: relative;
            overflow: hidden;
        }
        .nav-item:hover {
            color: #ffffff;
            background: rgba(126,200,179,.18);
            border-color: rgba(126,200,179,.28);
            transform: translateX(3px);
            box-shadow: 0 4px 18px rgba(126,200,179,.15);
        }
        .nav-item.active {
            color: #7EC8B3;
            background: rgba(126,200,179,.18);
            border-color: rgba(126,200,179,.38);
            box-shadow: 0 4px 20px rgba(126,200,179,.18), inset 0 0 16px rgba(126,200,179,.06);
        }
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 20%; bottom: 20%;
            width: 3px;
            border-radius: 0 99px 99px 0;
            background: linear-gradient(to bottom, #7EC8B3, #A8D5C2);
        }
        .nav-item svg { flex-shrink: 0; }

        .nav-section-label {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(168,213,194,.5);
            padding: 0 .75rem;
            margin-bottom: .375rem;
        }

        /* logout */
        .sidebar-logout {
            display: flex;
            align-items: center;
            gap: .625rem;
            padding: .6rem .75rem;
            border-radius: .75rem;
            font-size: .8125rem;
            font-weight: 500;
            color: rgba(246,193,204,.7);
            width: 100%;
            background: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all .22s ease;
        }
        .sidebar-logout:hover {
            background: rgba(246,193,204,.12);
            border-color: rgba(246,193,204,.25);
            color: #F6C1CC;
        }

        /* ─── Top Header ────────────────────────────────────────── */
        .glass-header {
            background: rgba(241,250,247,.88);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid rgba(168,213,194,.35);
            box-shadow: 0 2px 20px rgba(107,79,79,.06);
        }

        .header-icon-btn {
            padding: .45rem;
            border-radius: .625rem;
            color: rgba(107,79,79,.7);
            transition: all .2s ease;
            border: 1px solid transparent;
            background: none;
            cursor: pointer;
        }
        .header-icon-btn:hover {
            background: rgba(126,200,179,.14);
            border-color: rgba(126,200,179,.25);
            color: #6B4F4F;
        }

        /* ─── Search ────────────────────────────────────────────── */
        .glass-search {
            background: rgba(255,255,255,.55);
            border: 1px solid rgba(168,213,194,.45);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: .75rem;
            padding: .45rem .85rem .45rem 2.25rem;
            font-size: .825rem;
            color: #6B4F4F;
            outline: none;
            width: 220px;
            transition: all .25s ease;
        }
        .glass-search::placeholder { color: rgba(107,79,79,.4); }
        .glass-search:focus {
            background: rgba(255,255,255,.82);
            border-color: #7EC8B3;
            box-shadow: 0 0 0 3px rgba(126,200,179,.18);
            width: 300px;
        }

        /* ─── Glass Card ────────────────────────────────────────── */
        .glass-card {
            background: rgba(255,255,255,.68);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255,255,255,.55);
            box-shadow: 0 8px 32px rgba(107,79,79,.08), 0 2px 8px rgba(107,79,79,.04);
        }
        .glass-card-hover {
            transition: all .28s cubic-bezier(.4,0,.2,1);
            cursor: pointer;
        }
        .glass-card-hover:hover {
            background: rgba(255,255,255,.82);
            box-shadow: 0 16px 48px rgba(107,79,79,.13), 0 4px 12px rgba(107,79,79,.06);
            transform: translateY(-2px);
        }

        /* stat card top accent bars */
        .stat-jade::before, .stat-peach::before, .stat-pink::before, .stat-sage::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0;
            height: 3px; border-radius: 1rem 1rem 0 0;
        }
        .stat-jade::before  { background: linear-gradient(90deg, #7EC8B3, #A8D5C2); }
        .stat-peach::before { background: linear-gradient(90deg, #FFD6A5, #F6C1CC); }
        .stat-pink::before  { background: linear-gradient(90deg, #F6C1CC, #FFD6A5); }
        .stat-sage::before  { background: linear-gradient(90deg, #A8D5C2, #7EC8B3); }

        /* ─── Glass Table ───────────────────────────────────────── */
        .glass-table {
            background: rgba(255,255,255,.65);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255,255,255,.5);
            border-radius: 1.125rem;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(107,79,79,.08);
        }
        .glass-table thead tr {
            background: rgba(241,250,247,.85);
            border-bottom: 1px solid rgba(168,213,194,.35);
        }
        .glass-table thead th {
            padding: .875rem 1.5rem;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: rgba(107,79,79,.65);
            text-align: left;
        }
        .glass-table tbody tr {
            border-bottom: 1px solid rgba(205,237,227,.4);
            transition: background .18s ease;
        }
        .glass-table tbody tr:last-child { border-bottom: none; }
        .glass-table tbody tr:hover { background: rgba(241,250,247,.6); }
        .glass-table tbody td {
            padding: .9rem 1.5rem;
            font-size: .8375rem;
            color: #6B4F4F;
            vertical-align: middle;
        }

        /* ─── Glass Filter Bar ──────────────────────────────────── */
        .glass-filter {
            background: rgba(255,255,255,.55);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,.48);
            box-shadow: 0 4px 16px rgba(107,79,79,.05);
        }

        /* ─── Glass Input ───────────────────────────────────────── */
        .glass-input {
            background: rgba(255,255,255,.6);
            border: 1px solid rgba(168,213,194,.45);
            border-radius: .75rem;
            padding: .525rem .875rem;
            font-size: .825rem;
            color: #6B4F4F;
            outline: none;
            transition: all .22s ease;
            font-family: 'Poppins', sans-serif;
        }
        .glass-input::placeholder { color: rgba(107,79,79,.38); }
        .glass-input:focus {
            background: rgba(255,255,255,.85);
            border-color: #7EC8B3;
            box-shadow: 0 0 0 3px rgba(126,200,179,.18);
        }

        /* ─── Glass Select ──────────────────────────────────────── */
        .glass-select {
            background: rgba(255,255,255,.6);
            border: 1px solid rgba(168,213,194,.45);
            border-radius: .75rem;
            padding: .525rem .875rem;
            font-size: .825rem;
            color: #6B4F4F;
            outline: none;
            cursor: pointer;
            transition: all .22s ease;
            font-family: 'Poppins', sans-serif;
        }
        .glass-select:focus {
            background: rgba(255,255,255,.85);
            border-color: #7EC8B3;
            box-shadow: 0 0 0 3px rgba(126,200,179,.18);
        }

        /* ─── Badges ────────────────────────────────────────────── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: .2rem .75rem;
            border-radius: 99px;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .04em;
            white-space: nowrap;
        }
        .badge-jade    { background: rgba(126,200,179,.22); color: #2D6A5B; border: 1px solid rgba(126,200,179,.38); }
        .badge-pink    { background: rgba(246,193,204,.28); color: #8B3A4A; border: 1px solid rgba(220,150,170,.35); }
        .badge-peach   { background: rgba(255,214,165,.32); color: #8B5E3C; border: 1px solid rgba(255,180,100,.35); }
        .badge-sage    { background: rgba(168,213,194,.28); color: #2D5A4A; border: 1px solid rgba(126,200,179,.35); }
        .badge-gray    { background: rgba(107,79,79,.1);   color: rgba(107,79,79,.7); border: 1px solid rgba(107,79,79,.18); }
        .badge-admin   { background: rgba(246,193,204,.25); color: #7A3040; border: 1px solid rgba(220,150,170,.3); }
        .badge-seller  { background: rgba(255,214,165,.28); color: #7A5030; border: 1px solid rgba(220,180,120,.3); }
        .badge-customer{ background: rgba(126,200,179,.18); color: #2D6A5B; border: 1px solid rgba(126,200,179,.28); }

        /* order status shorthands */
        .badge-pending    { background: rgba(255,214,165,.32); color: #8B5E3C; border: 1px solid rgba(255,180,100,.35); }
        .badge-confirmed  { background: rgba(168,213,194,.28); color: #2D5A4A; border: 1px solid rgba(126,200,179,.35); }
        .badge-processing { background: rgba(168,213,194,.32); color: #205040; border: 1px solid rgba(100,180,160,.4); }
        .badge-shipped    { background: rgba(126,200,179,.22); color: #1D4A3A; border: 1px solid rgba(100,180,160,.4); }
        .badge-delivered  { background: rgba(126,200,179,.28); color: #2D6A5B; border: 1px solid rgba(126,200,179,.45); }
        .badge-cancelled  { background: rgba(246,193,204,.28); color: #8B3A4A; border: 1px solid rgba(220,150,170,.35); }
        .badge-approved   { background: rgba(126,200,179,.22); color: #2D6A5B; border: 1px solid rgba(126,200,179,.38); }
        .badge-rejected   { background: rgba(246,193,204,.28); color: #8B3A4A; border: 1px solid rgba(220,150,170,.35); }
        .badge-active     { background: rgba(126,200,179,.22); color: #2D6A5B; border: 1px solid rgba(126,200,179,.38); }
        .badge-inactive   { background: rgba(246,193,204,.28); color: #8B3A4A; border: 1px solid rgba(220,150,170,.35); }

        /* ─── Buttons ───────────────────────────────────────────── */
        .btn-primary {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .525rem 1.1rem;
            border-radius: .75rem;
            font-size: .825rem; font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #7EC8B3 0%, #5DAE99 100%);
            border: 1px solid rgba(255,255,255,.25);
            box-shadow: 0 4px 16px rgba(126,200,179,.38);
            transition: all .22s ease;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #6CBCA6 0%, #4A9E89 100%);
            box-shadow: 0 6px 22px rgba(126,200,179,.48);
            transform: translateY(-1px);
            color: #fff;
        }

        .btn-secondary {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .525rem 1.1rem;
            border-radius: .75rem;
            font-size: .825rem; font-weight: 600;
            color: #6B4F4F;
            background: rgba(255,255,255,.55);
            border: 1px solid rgba(168,213,194,.4);
            box-shadow: 0 2px 8px rgba(107,79,79,.06);
            transition: all .22s ease;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,.8);
            border-color: rgba(126,200,179,.45);
            transform: translateY(-1px);
        }

        .btn-danger {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .525rem 1.1rem;
            border-radius: .75rem;
            font-size: .825rem; font-weight: 600;
            color: #8B3A4A;
            background: rgba(246,193,204,.22);
            border: 1px solid rgba(220,150,170,.38);
            transition: all .22s ease;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-danger:hover {
            background: rgba(246,193,204,.38);
            transform: translateY(-1px);
        }

        /* ─── Glass Modal ───────────────────────────────────────── */
        .glass-modal {
            background: rgba(255,255,255,.88);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,.6);
            box-shadow: 0 24px 64px rgba(107,79,79,.18);
        }
        .modal-backdrop {
            background: rgba(107,79,79,.3);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        }

        /* ─── Flash Messages ────────────────────────────────────── */
        .flash-success { background: rgba(126,200,179,.16); border: 1px solid rgba(126,200,179,.38); color: #2D6A5B; }
        .flash-error   { background: rgba(246,193,204,.18); border: 1px solid rgba(220,150,170,.38); color: #8B3A4A; }
        .flash-warning { background: rgba(255,214,165,.18); border: 1px solid rgba(255,180,100,.35); color: #8B5E3C; }

        /* ─── Page header ───────────────────────────────────────── */
        .page-label {
            font-size: .7rem; font-weight: 700;
            letter-spacing: .12em; text-transform: uppercase;
            color: rgba(107,79,79,.45);
        }
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem; font-weight: 700;
            color: #6B4F4F;
            line-height: 1.2;
        }

        /* ─── Avatar ────────────────────────────────────────────── */
        .avatar-jade {
            background: linear-gradient(135deg, #7EC8B3, #A8D5C2);
            color: #fff; font-weight: 700; font-size: .85rem;
            display: flex; align-items: center; justify-content: center;
        }
        .avatar-peach {
            background: linear-gradient(135deg, #F6C1CC, #FFD6A5);
            color: #6B4F4F; font-weight: 700; font-size: .85rem;
            display: flex; align-items: center; justify-content: center;
        }

        /* ─── Action link ───────────────────────────────────────── */
        .link-jade {
            color: #7EC8B3; font-size: .78rem; font-weight: 600;
            text-decoration: none; transition: color .18s ease;
            padding: .25rem .65rem; border-radius: .5rem;
            border: 1px solid rgba(126,200,179,.25);
            background: rgba(126,200,179,.08);
        }
        .link-jade:hover {
            background: rgba(126,200,179,.18);
            color: #5DAE99;
        }

        /* ─── Mobile ────────────────────────────────────────────── */
        @media (max-width: 768px) {
            .sidebar-mobile {
                position: fixed; top: 0; left: 0; bottom: 0;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform .3s cubic-bezier(.4,0,.2,1);
                width: 280px !important;
            }
            .sidebar-mobile.open { transform: translateX(0); }

            .sidebar-overlay {
                position: fixed; inset: 0;
                background: rgba(107,79,79,.35);
                backdrop-filter: blur(5px);
                -webkit-backdrop-filter: blur(5px);
                z-index: 40;
                display: none;
            }
            .sidebar-overlay.show { display: block; }

            .mobile-menu-btn { display: flex !important; }
        }
        @media (min-width: 769px) {
            .mobile-menu-btn  { display: none !important; }
            .sidebar-mobile   { position: static !important; transform: none !important; }
            .sidebar-overlay  { display: none !important; }
        }

        /* ─── Divider ───────────────────────────────────────────── */
        .glass-divider { background: rgba(168,213,194,.35); }

        /* ─── Responsive Grid Helpers ───────────────────────────── */
        .admin-grid-2col {
            display: grid;
            grid-template-columns: minmax(0,2fr) minmax(0,1fr);
            gap: 1.25rem;
        }
        .admin-grid-2equal {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }
        .admin-grid-1col {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }
        @media (max-width: 900px) {
            .admin-grid-2col,
            .admin-grid-2equal {
                grid-template-columns: 1fr;
            }
        }

        /* ─── Pagination Glassmorphism ───────────────────────────── */
        nav[role="navigation"] span,
        nav[role="navigation"] a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2rem;
            padding: .3rem .65rem;
            border-radius: .625rem;
            font-size: .78rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .18s ease;
            font-family: 'Poppins', sans-serif;
        }
        nav[role="navigation"] a {
            color: #6B4F4F;
            background: rgba(255,255,255,.55);
            border: 1px solid rgba(168,213,194,.38);
        }
        nav[role="navigation"] a:hover {
            background: rgba(126,200,179,.2);
            border-color: rgba(126,200,179,.45);
            color: #2D6A5B;
        }
        nav[role="navigation"] span[aria-current="page"] > span {
            background: linear-gradient(135deg, #7EC8B3, #5DAE99);
            color: #fff;
            border: 1px solid rgba(255,255,255,.2);
            box-shadow: 0 2px 10px rgba(126,200,179,.35);
        }
        nav[role="navigation"] span.cursor-default {
            color: rgba(107,79,79,.38);
            background: rgba(255,255,255,.3);
            border: 1px solid rgba(168,213,194,.2);
        }
        nav[role="navigation"] svg {
            width: 14px;
            height: 14px;
        }
    </style>
</head>

<body>
    <!-- Mobile overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <div style="display:flex; height:100vh; overflow:hidden; position:relative; z-index:1;">

        <!-- ══════════════════════════════════════════════════════
             SIDEBAR
        ══════════════════════════════════════════════════════ -->
        <aside class="sidebar-mobile glass-sidebar flex flex-col" style="width:272px; flex-shrink:0;">

            <!-- Logo -->
            <div class="sidebar-logo flex items-center gap-3 px-5 py-5 flex-shrink-0">
                <div class="avatar-jade rounded-xl flex-shrink-0" style="width:38px;height:38px;border-radius:.75rem;box-shadow:0 4px 14px rgba(126,200,179,.4);">
                    <span style="font-family:'Playfair Display',serif;font-size:1.1rem;">G</span>
                </div>
                <div>
                    <p class="font-playfair font-bold" style="color:#fff;font-size:1.05rem;line-height:1.2;">GlowTrack</p>
                    <p style="color:rgba(168,213,194,.75);font-size:.7rem;font-weight:500;letter-spacing:.04em;">Admin Portal</p>
                </div>
            </div>

            <!-- Nav -->
            <nav style="flex:1;overflow-y:auto;padding:1rem .75rem;" class="space-y-5">

                <!-- Main -->
                <div>
                    <p class="nav-section-label">Main</p>
                    <div class="space-y-0.5">
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                                <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                            </svg>
                            Dashboard
                        </a>
                    </div>
                </div>

                <!-- Products -->
                <div>
                    <p class="nav-section-label">Products</p>
                    <div class="space-y-0.5">
                        <a href="{{ route('admin.products') }}"
                           class="nav-item {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Products
                        </a>
                        <a href="{{ route('admin.reports.inventory') }}"
                           class="nav-item {{ request()->routeIs('admin.reports.inventory') ? 'active' : '' }}">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Inventory
                        </a>
                    </div>
                </div>

                <!-- Orders -->
                <div>
                    <p class="nav-section-label">Orders</p>
                    <div class="space-y-0.5">
                        <a href="{{ route('admin.orders') }}"
                           class="nav-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Orders
                        </a>
                    </div>
                </div>

                <!-- Users -->
                <div>
                    <p class="nav-section-label">Users</p>
                    <div class="space-y-0.5">
                        <a href="{{ route('admin.users') }}"
                           class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                            </svg>
                            Users
                        </a>
                        <a href="{{ route('admin.seller-applications') }}"
                           class="nav-item {{ request()->routeIs('admin.seller-applications*') ? 'active' : '' }}">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Verifications
                        </a>
                    </div>
                </div>

                <!-- Analytics -->
                <div>
                    <p class="nav-section-label">Analytics</p>
                    <div class="space-y-0.5">
                        <a href="{{ route('admin.reports') }}"
                           class="nav-item {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Reports
                        </a>
                    </div>
                </div>

                <!-- Delivery -->
                <div>
                    <p class="nav-section-label">Delivery</p>
                    <div class="space-y-0.5">
                        <a href="{{ route('admin.delivery-dashboard') }}"
                           class="nav-item {{ request()->routeIs('admin.delivery-dashboard') ? 'active' : '' }}">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 104 0m6 0a2 2 0 104 0m-4 0a2 2 0 104 0"/>
                            </svg>
                            Delivery Hub
                        </a>
                        <a href="{{ route('admin.deliveries.index') }}"
                           class="nav-item {{ request()->routeIs('admin.deliveries*') ? 'active' : '' }}">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            Manage Deliveries
                        </a>
                        <a href="{{ route('admin.delivery-personnel.index') }}"
                           class="nav-item {{ request()->routeIs('admin.delivery-personnel*') ? 'active' : '' }}">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Personnel
                        </a>
                    </div>
                </div>

                <!-- System -->
                <div>
                    <p class="nav-section-label">System</p>
                    <div class="space-y-0.5">
                        <a href="{{ route('admin.notifications') }}"
                           class="nav-item {{ request()->routeIs('admin.notifications') ? 'active' : '' }}">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            Notifications
                            @if(($unreadCount ?? 0) > 0)
                                <span class="ml-auto badge badge-pink" style="font-size:.62rem;padding:.1rem .5rem;">{{ $unreadCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.forum-moderation') }}"
                           class="nav-item {{ request()->routeIs('admin.forum-moderation') ? 'active' : '' }}">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            Forum Moderation
                        </a>
                        <a href="{{ route('admin.trash') }}"
                           class="nav-item {{ request()->routeIs('admin.trash*') ? 'active' : '' }}">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Trash
                        </a>
                    </div>
                </div>

            </nav>

            <!-- Logout -->
            <div style="padding:.75rem;flex-shrink:0;border-top:1px solid rgba(255,255,255,.07);background:rgba(0,0,0,.12);">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-logout">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- ══════════════════════════════════════════════════════
             MAIN CONTENT
        ══════════════════════════════════════════════════════ -->
        <div style="flex:1;display:flex;flex-direction:column;overflow:hidden;min-width:0;">

            <!-- Top Header -->
            <header class="glass-header flex-shrink-0">
                <div style="display:flex;align-items:center;justify-content:space-between;padding:.75rem 1.5rem;">

                    <!-- Left: hamburger + search -->
                    <div style="display:flex;align-items:center;gap:.75rem;">
                        <!-- Mobile toggle -->
                        <button onclick="toggleSidebar()" class="mobile-menu-btn header-icon-btn" style="display:none;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <!-- Search -->
                        <form id="admin-search-form" action="{{ route('admin.products') }}" method="GET" style="position:relative;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"
                                 style="position:absolute;left:.7rem;top:50%;transform:translateY(-50%);color:rgba(107,79,79,.38);pointer-events:none;">
                                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                            </svg>
                            <input type="search" name="search" value="{{ request('search') }}"
                                   placeholder="Search products, pages…"
                                   class="glass-search">
                        </form>
                    </div>

                    <!-- Right: actions + avatar -->
                    <div style="display:flex;align-items:center;gap:.375rem;">

                        <!-- Notifications -->
                        <a href="{{ route('admin.notifications') }}" class="header-icon-btn" style="position:relative;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:rgba(107,79,79,.7);">
                                <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @if(($unreadCount ?? 0) > 0)
                                <span style="position:absolute;top:6px;right:6px;width:7px;height:7px;border-radius:50%;background:#F6C1CC;border:1.5px solid rgba(241,250,247,.9);"></span>
                            @endif
                        </a>

                        <!-- Divider -->
                        <div style="width:1px;height:22px;background:rgba(168,213,194,.4);margin:0 .25rem;"></div>

                        <!-- Avatar + name -->
                        <div style="display:flex;align-items:center;gap:.625rem;">
                            <div class="avatar-jade" style="width:34px;height:34px;border-radius:.625rem;box-shadow:0 2px 10px rgba(126,200,179,.32);flex-shrink:0;">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="hidden md:block">
                                <p style="font-size:.8rem;font-weight:600;color:#6B4F4F;line-height:1.2;">{{ auth()->user()->name }}</p>
                                <p style="font-size:.68rem;color:rgba(107,79,79,.5);">Administrator</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if(session('success') || session('error') || session('warning'))
                <div style="padding:.75rem 1.5rem .25rem;">
                    @if(session('success'))
                        <div class="flash-success" style="display:flex;align-items:center;gap:.75rem;padding:.75rem 1rem;border-radius:.875rem;font-size:.825rem;font-weight:500;margin-bottom:.5rem;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="flash-error" style="display:flex;align-items:center;gap:.75rem;padding:.75rem 1rem;border-radius:.875rem;font-size:.825rem;font-weight:500;margin-bottom:.5rem;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;">
                                <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(session('warning'))
                        <div class="flash-warning" style="display:flex;align-items:center;gap:.75rem;padding:.75rem 1rem;border-radius:.875rem;font-size:.825rem;font-weight:500;margin-bottom:.5rem;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;">
                                <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            {{ session('warning') }}
                        </div>
                    @endif
                </div>
            @endif

            <!-- Page Content -->
            <main style="flex:1;overflow-y:auto;padding:1.5rem;">
                <div style="max-width:1600px;margin:0 auto;">
                    @yield('content')
                </div>
            </main>

        </div><!-- /main content -->
    </div><!-- /flex wrapper -->

    <!-- Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/js/app.js'])
    @else
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @endif

    <script>
        /* ── Sidebar toggle ─────────────────────────── */
        function toggleSidebar() {
            document.querySelector('.sidebar-mobile').classList.toggle('open');
            document.querySelector('.sidebar-overlay').classList.toggle('show');
        }

        document.addEventListener('click', function (e) {
            const sidebar = document.querySelector('.sidebar-mobile');
            const overlay = document.querySelector('.sidebar-overlay');
            const btn     = document.querySelector('.mobile-menu-btn');
            if (window.innerWidth <= 768 &&
                !sidebar.contains(e.target) &&
                btn && !btn.contains(e.target) &&
                sidebar.classList.contains('open')) {
                toggleSidebar();
            }
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 768) {
                document.querySelector('.sidebar-mobile').classList.remove('open');
                document.querySelector('.sidebar-overlay').classList.remove('show');
            }
        });

        /* ── Quick-nav search ───────────────────────── */
        const searchForm = document.getElementById('admin-search-form');
        if (searchForm) {
            searchForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const q = this.search.value.trim().toLowerCase();
                if (!q) { this.submit(); return; }
                const routes = {
                    'dashboard':          '{{ route('admin.dashboard') }}',
                    'products':           '{{ route('admin.products') }}',
                    'inventory':          '{{ route('admin.reports.inventory') }}',
                    'orders':             '{{ route('admin.orders') }}',
                    'users':              '{{ route('admin.users') }}',
                    'verification':       '{{ route('admin.seller-applications') }}',
                    'seller applications':'{{ route('admin.seller-applications') }}',
                    'reports':            '{{ route('admin.reports') }}',
                    'sales':              '{{ route('admin.reports.sales') }}',
                    'delivery':           '{{ route('admin.delivery-dashboard') }}',
                    'trash':              '{{ route('admin.trash') }}',
                    'notifications':      '{{ route('admin.notifications') }}',
                    'analytics':          '{{ route('admin.charts') }}',
                    'charts':             '{{ route('admin.charts') }}',
                };
                if (routes[q]) { window.location.href = routes[q]; return; }
                this.submit();
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
