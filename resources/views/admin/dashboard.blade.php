@extends('layouts.admin')

@section('title', 'Admin Dashboard - GlowTrack')

@section('content')
<div style="display:flex;flex-direction:column;gap:1.5rem;">

    {{-- ══════════════════════════════════════════════
         PAGE HEADER
    ══════════════════════════════════════════════ --}}
    <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div>
            <p class="page-label" style="margin-bottom:.3rem;">Overview</p>
            <h1 class="page-title">GlowTrack Management</h1>
            <p style="color:rgba(107,79,79,.55);font-size:.825rem;margin-top:.25rem;">
                Welcome back, <span style="color:#7EC8B3;font-weight:600;">{{ auth()->user()->name }}</span>
            </p>
        </div>
        <div class="glass-card" style="border-radius:.875rem;padding:.75rem 1.25rem;display:flex;align-items:center;gap:.625rem;">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#7EC8B3;flex-shrink:0;">
                <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
            <div>
                <p style="font-size:.7rem;color:rgba(107,79,79,.5);font-weight:600;text-transform:uppercase;letter-spacing:.06em;">Last Updated</p>
                <p style="font-size:.8rem;font-weight:600;color:#6B4F4F;">{{ now()->format('M d, Y · H:i') }}</p>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════
         STAT CARDS
    ══════════════════════════════════════════════ --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;">

        {{-- Total Users --}}
        <a href="{{ route('admin.users') }}" class="glass-card glass-card-hover stat-jade"
           style="border-radius:1.125rem;padding:1.35rem 1.4rem;position:relative;overflow:hidden;text-decoration:none;display:block;">
            <div style="position:absolute;top:-28px;right:-18px;width:90px;height:90px;border-radius:50%;
                        background:radial-gradient(circle, rgba(126,200,179,.2), transparent);pointer-events:none;"></div>
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.75rem;">
                <div style="min-width:0;">
                    <p style="font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(107,79,79,.5);margin-bottom:.4rem;">
                        Total Users
                    </p>
                    <p style="font-size:2rem;font-weight:700;color:#6B4F4F;line-height:1;">{{ $stats['total_users'] }}</p>
                    <p style="font-size:.72rem;color:rgba(107,79,79,.45);margin-top:.4rem;">Registered platform users</p>
                </div>
                <div style="width:44px;height:44px;border-radius:.875rem;flex-shrink:0;display:flex;align-items:center;justify-content:center;
                            background:linear-gradient(135deg,rgba(126,200,179,.22),rgba(168,213,194,.3));
                            border:1px solid rgba(126,200,179,.32);">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#7EC8B3;">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                </div>
            </div>
        </a>

        {{-- Total Products --}}
        <a href="{{ route('admin.products') }}" class="glass-card glass-card-hover stat-peach"
           style="border-radius:1.125rem;padding:1.35rem 1.4rem;position:relative;overflow:hidden;text-decoration:none;display:block;">
            <div style="position:absolute;top:-28px;right:-18px;width:90px;height:90px;border-radius:50%;
                        background:radial-gradient(circle,rgba(255,214,165,.22),transparent);pointer-events:none;"></div>
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.75rem;">
                <div style="min-width:0;">
                    <p style="font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(107,79,79,.5);margin-bottom:.4rem;">
                        Products
                    </p>
                    <p style="font-size:2rem;font-weight:700;color:#6B4F4F;line-height:1;">{{ $stats['total_products'] }}</p>
                    @if($stats['pending_products'] > 0)
                        <p style="font-size:.72rem;color:#8B5E3C;margin-top:.4rem;font-weight:600;">
                            ⚠ {{ $stats['pending_products'] }} pending review
                        </p>
                    @else
                        <p style="font-size:.72rem;color:rgba(107,79,79,.45);margin-top:.4rem;">All listings</p>
                    @endif
                </div>
                <div style="width:44px;height:44px;border-radius:.875rem;flex-shrink:0;display:flex;align-items:center;justify-content:center;
                            background:linear-gradient(135deg,rgba(255,214,165,.28),rgba(246,193,204,.2));
                            border:1px solid rgba(255,180,100,.3);">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#D4935A;">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </a>

        {{-- Total Orders --}}
        <a href="{{ route('admin.orders') }}" class="glass-card glass-card-hover stat-pink"
           style="border-radius:1.125rem;padding:1.35rem 1.4rem;position:relative;overflow:hidden;text-decoration:none;display:block;">
            <div style="position:absolute;top:-28px;right:-18px;width:90px;height:90px;border-radius:50%;
                        background:radial-gradient(circle,rgba(246,193,204,.22),transparent);pointer-events:none;"></div>
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.75rem;">
                <div style="min-width:0;">
                    <p style="font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(107,79,79,.5);margin-bottom:.4rem;">
                        Orders
                    </p>
                    <p style="font-size:2rem;font-weight:700;color:#6B4F4F;line-height:1;">{{ $stats['total_orders'] }}</p>
                    @if($stats['pending_orders'] > 0)
                        <p style="font-size:.72rem;color:#8B3A4A;margin-top:.4rem;font-weight:600;">
                            ⚠ {{ $stats['pending_orders'] }} pending
                        </p>
                    @else
                        <p style="font-size:.72rem;color:rgba(107,79,79,.45);margin-top:.4rem;">Customer orders</p>
                    @endif
                </div>
                <div style="width:44px;height:44px;border-radius:.875rem;flex-shrink:0;display:flex;align-items:center;justify-content:center;
                            background:linear-gradient(135deg,rgba(246,193,204,.28),rgba(255,214,165,.18));
                            border:1px solid rgba(220,150,170,.3);">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#D98BA0;">
                        <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
        </a>

        {{-- Revenue --}}
        <a href="{{ route('admin.reports') }}" class="glass-card glass-card-hover stat-sage"
           style="border-radius:1.125rem;padding:1.35rem 1.4rem;position:relative;overflow:hidden;text-decoration:none;display:block;">
            <div style="position:absolute;top:-28px;right:-18px;width:90px;height:90px;border-radius:50%;
                        background:radial-gradient(circle,rgba(168,213,194,.25),transparent);pointer-events:none;"></div>
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.75rem;">
                <div style="min-width:0;">
                    <p style="font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(107,79,79,.5);margin-bottom:.4rem;">
                        Revenue
                    </p>
                    <p style="font-size:1.55rem;font-weight:700;color:#6B4F4F;line-height:1;word-break:break-all;">₱{{ number_format($stats['total_revenue'], 2) }}</p>
                    <p style="font-size:.72rem;color:rgba(107,79,79,.45);margin-top:.4rem;">Total platform revenue</p>
                </div>
                <div style="width:44px;height:44px;border-radius:.875rem;flex-shrink:0;display:flex;align-items:center;justify-content:center;
                            background:linear-gradient(135deg,rgba(168,213,194,.28),rgba(126,200,179,.2));
                            border:1px solid rgba(126,200,179,.32);">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#5DAE99;">
                        <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </a>

    </div>

    {{-- ══════════════════════════════════════════════
         RECENT ORDERS + QUICK ACTIONS
    ══════════════════════════════════════════════ --}}
    <div class="admin-grid-2col">

            {{-- Recent Orders --}}
            <div class="glass-card" style="border-radius:1.125rem;overflow:hidden;">
                <div style="display:flex;align-items:center;justify-content:space-between;
                            padding:1.1rem 1.5rem;border-bottom:1px solid rgba(205,237,227,.5);">
                    <div style="display:flex;align-items:center;gap:.625rem;">
                        <div style="width:32px;height:32px;border-radius:.625rem;display:flex;align-items:center;justify-content:center;
                                    background:rgba(126,200,179,.15);border:1px solid rgba(126,200,179,.28);">
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#7EC8B3;">
                                <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <h2 style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:#6B4F4F;">Recent Orders</h2>
                    </div>
                    <a href="{{ route('admin.orders') }}" class="link-jade">View All →</a>
                </div>

                @if($recentOrders->count() > 0)
                    <div>
                        @foreach($recentOrders as $order)
                            <div style="display:flex;align-items:center;justify-content:space-between;
                                        padding:.9rem 1.5rem;border-bottom:1px solid rgba(205,237,227,.35);
                                        transition:background .18s ease;"
                                 onmouseover="this.style.background='rgba(241,250,247,.55)'"
                                 onmouseout="this.style.background='transparent'">
                                <div style="display:flex;align-items:center;gap:.875rem;">
                                    <div style="width:38px;height:38px;border-radius:.75rem;display:flex;align-items:center;justify-content:center;
                                                background:rgba(126,200,179,.12);border:1px solid rgba(126,200,179,.22);
                                                font-size:.68rem;font-weight:700;color:#5DAE99;flex-shrink:0;font-family:'Poppins',sans-serif;">
                                        #{{ str_pad(substr($order->order_id, -3), 3, '0', STR_PAD_LEFT) }}
                                    </div>
                                    <div style="min-width:0;">
                                        <p style="font-size:.825rem;font-weight:600;color:#6B4F4F;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                            {{ $order->user->name }}
                                        </p>
                                        <p style="font-size:.72rem;color:rgba(107,79,79,.48);margin-top:.1rem;">
                                            {{ $order->created_at->format('M d, Y · H:i') }}
                                        </p>
                                    </div>
                                </div>
                                <div style="display:flex;align-items:center;gap:.875rem;flex-shrink:0;">
                                    <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                                    <span style="font-size:.85rem;font-weight:700;color:#7EC8B3;min-width:80px;text-align:right;">
                                        ₱{{ number_format($order->total_amount, 2) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:3rem 1.5rem;">
                        <div style="width:52px;height:52px;border-radius:1rem;display:flex;align-items:center;justify-content:center;
                                    background:rgba(126,200,179,.1);border:1px solid rgba(126,200,179,.22);margin-bottom:.875rem;">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" style="color:rgba(126,200,179,.55);">
                                <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <p style="font-size:.85rem;color:rgba(107,79,79,.45);">No orders yet</p>
                    </div>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="glass-card" style="border-radius:1.125rem;overflow:hidden;">
                <div style="padding:1.1rem 1.5rem;border-bottom:1px solid rgba(205,237,227,.5);display:flex;align-items:center;gap:.625rem;">
                    <div style="width:32px;height:32px;border-radius:.625rem;display:flex;align-items:center;justify-content:center;
                                background:rgba(255,214,165,.22);border:1px solid rgba(255,180,100,.28);">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#D4935A;">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h2 style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:#6B4F4F;">Quick Actions</h2>
                </div>
                <div style="padding:.875rem;display:flex;flex-direction:column;gap:.4rem;">

                    @php
                    $actions = [
                        ['href' => route('admin.products'),  'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',     'label' => 'Manage Products',    'sub' => 'Approve / reject listings',    'bg' => 'rgba(126,200,179,.15)', 'bc' => 'rgba(126,200,179,.28)', 'ic' => '#7EC8B3', 'hbg' => 'rgba(126,200,179,.1)', 'hbc' => 'rgba(126,200,179,.3)'],
                        ['href' => route('products.import'), 'icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12',        'label' => 'Import Products',    'sub' => 'Bulk import from Excel',       'bg' => 'rgba(168,213,194,.18)', 'bc' => 'rgba(168,213,194,.32)', 'ic' => '#5DAE99', 'hbg' => 'rgba(168,213,194,.1)', 'hbc' => 'rgba(168,213,194,.32)'],
                        ['href' => route('products.export'), 'icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4',        'label' => 'Export Products',    'sub' => 'Download Excel data',          'bg' => 'rgba(255,214,165,.2)',  'bc' => 'rgba(255,180,100,.28)', 'ic' => '#D4935A', 'hbg' => 'rgba(255,214,165,.12)', 'hbc' => 'rgba(255,180,100,.3)'],
                        ['href' => route('admin.orders'),    'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',                             'label' => 'Manage Orders',      'sub' => 'Update order statuses',        'bg' => 'rgba(126,200,179,.15)', 'bc' => 'rgba(126,200,179,.28)', 'ic' => '#7EC8B3', 'hbg' => 'rgba(126,200,179,.1)', 'hbc' => 'rgba(126,200,179,.3)'],
                        ['href' => route('admin.users'),     'icon' => 'M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75', 'label' => 'Manage Users', 'sub' => 'Roles & permissions', 'bg' => 'rgba(168,213,194,.18)', 'bc' => 'rgba(168,213,194,.32)', 'ic' => '#5DAE99', 'hbg' => 'rgba(168,213,194,.1)', 'hbc' => 'rgba(168,213,194,.3)'],
                        ['href' => route('admin.charts'),    'icon' => 'M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z', 'label' => 'Analytics', 'sub' => 'Charts & insights',           'bg' => 'rgba(246,193,204,.18)', 'bc' => 'rgba(220,150,170,.28)', 'ic' => '#D98BA0', 'hbg' => 'rgba(246,193,204,.1)', 'hbc' => 'rgba(220,150,170,.3)'],
                    ];
                    @endphp

                    @foreach($actions as $action)
                        <a href="{{ $action['href'] }}"
                           style="display:flex;align-items:center;gap:.75rem;padding:.65rem .75rem;border-radius:.75rem;
                                  text-decoration:none;border:1px solid transparent;transition:all .2s ease;"
                           onmouseover="this.style.background='{{ $action['hbg'] }}';this.style.borderColor='{{ $action['hbc'] }}';this.style.transform='translateX(2px)';"
                           onmouseout="this.style.background='transparent';this.style.borderColor='transparent';this.style.transform='none';">
                            <div style="width:34px;height:34px;border-radius:.625rem;flex-shrink:0;display:flex;align-items:center;justify-content:center;
                                        background:{{ $action['bg'] }};border:1px solid {{ $action['bc'] }};">
                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:{{ $action['ic'] }};">
                                    <path d="{{ $action['icon'] }}"/>
                                </svg>
                            </div>
                            <div style="min-width:0;">
                                <p style="font-size:.8rem;font-weight:600;color:#6B4F4F;line-height:1.2;">{{ $action['label'] }}</p>
                                <p style="font-size:.7rem;color:rgba(107,79,79,.5);margin-top:.1rem;">{{ $action['sub'] }}</p>
                            </div>
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"
                                 style="color:rgba(107,79,79,.3);margin-left:auto;flex-shrink:0;">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    @endforeach

                    {{-- Primary CTA --}}
                    <a href="{{ route('admin.reports') }}" class="btn-primary" style="margin-top:.25rem;justify-content:center;">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        View Full Reports
                    </a>

                    @if(($stats['pending_seller_applications'] ?? 0) > 0)
                        <a href="{{ route('admin.seller-applications') }}"
                           style="display:flex;align-items:center;gap:.75rem;padding:.65rem .75rem;border-radius:.75rem;
                                  text-decoration:none;background:rgba(255,214,165,.2);border:1px solid rgba(255,180,100,.32);transition:all .2s ease;"
                           onmouseover="this.style.background='rgba(255,214,165,.32)'"
                           onmouseout="this.style.background='rgba(255,214,165,.2)'">
                            <div style="width:34px;height:34px;border-radius:.625rem;flex-shrink:0;display:flex;align-items:center;justify-content:center;
                                        background:rgba(255,180,100,.2);border:1px solid rgba(255,150,80,.28);">
                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#D4935A;">
                                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div style="min-width:0;">
                                <p style="font-size:.8rem;font-weight:600;color:#6B4F4F;">Seller Applications</p>
                                <p style="font-size:.7rem;color:#8B5E3C;font-weight:600;">{{ $stats['pending_seller_applications'] }} awaiting review</p>
                            </div>
                        </a>
                    @endif

                </div>
            </div>

    </div>

    {{-- ══════════════════════════════════════════════
         PENDING PRODUCTS + RECENT USERS
    ══════════════════════════════════════════════ --}}
    <div class="{{ $pendingProducts->count() > 0 ? 'admin-grid-2equal' : 'admin-grid-1col' }}" style="gap:1.25rem;">

        {{-- Pending Products --}}
        @if($pendingProducts->count() > 0)
        <div class="glass-card" style="border-radius:1.125rem;overflow:hidden;">
            <div style="display:flex;align-items:center;justify-content:space-between;
                        padding:1.1rem 1.5rem;border-bottom:1px solid rgba(205,237,227,.5);">
                <div style="display:flex;align-items:center;gap:.625rem;">
                    <div style="width:32px;height:32px;border-radius:.625rem;display:flex;align-items:center;justify-content:center;
                                background:rgba(255,214,165,.22);border:1px solid rgba(255,180,100,.28);">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#D4935A;">
                            <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h2 style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:#6B4F4F;">Pending Products</h2>
                    <span class="badge badge-pending" style="font-size:.65rem;">{{ $pendingProducts->count() }}</span>
                </div>
                <a href="{{ route('admin.products') }}" class="link-jade">View All →</a>
            </div>
            <div style="padding:.875rem;display:flex;flex-direction:column;gap:.625rem;">
                @foreach($pendingProducts as $product)
                    <div style="background:rgba(255,214,165,.1);border:1px solid rgba(255,180,100,.22);
                                border-radius:.875rem;padding:1rem 1.125rem;transition:all .2s ease;"
                         onmouseover="this.style.background='rgba(255,214,165,.2)'"
                         onmouseout="this.style.background='rgba(255,214,165,.1)'">
                        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.5rem;margin-bottom:.625rem;">
                            <p style="font-size:.825rem;font-weight:600;color:#6B4F4F;line-height:1.3;">{{ $product->name }}</p>
                            <span class="badge badge-pending" style="flex-shrink:0;">Pending</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:1rem;margin-bottom:.75rem;">
                            <p style="font-size:.75rem;color:rgba(107,79,79,.6);">
                                Seller: <span style="font-weight:600;color:#6B4F4F;">{{ $product->seller->name }}</span>
                            </p>
                            <p style="font-size:.75rem;color:rgba(107,79,79,.6);">
                                Price: <span style="font-weight:700;color:#7EC8B3;">₱{{ number_format($product->price, 2) }}</span>
                            </p>
                        </div>
                        <div style="display:flex;gap:.5rem;">
                            <form action="{{ route('admin.products.approve', $product) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit"
                                        style="padding:.35rem .875rem;font-size:.75rem;font-weight:600;border-radius:.625rem;cursor:pointer;
                                               background:rgba(126,200,179,.2);color:#2D6A5B;border:1px solid rgba(126,200,179,.38);
                                               transition:all .2s ease;font-family:'Poppins',sans-serif;"
                                        onmouseover="this.style.background='rgba(126,200,179,.35)'"
                                        onmouseout="this.style.background='rgba(126,200,179,.2)'">
                                    ✓ Approve
                                </button>
                            </form>
                            <button onclick="dashboardShowRejectForm({{ $product->id }})"
                                    style="padding:.35rem .875rem;font-size:.75rem;font-weight:600;border-radius:.625rem;cursor:pointer;
                                           background:rgba(246,193,204,.2);color:#8B3A4A;border:1px solid rgba(220,150,170,.38);
                                           transition:all .2s ease;font-family:'Poppins',sans-serif;"
                                    onmouseover="this.style.background='rgba(246,193,204,.35)'"
                                    onmouseout="this.style.background='rgba(246,193,204,.2)'">
                                ✕ Reject
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Recent Users --}}
        <div class="glass-card" style="border-radius:1.125rem;overflow:hidden;">
            <div style="display:flex;align-items:center;justify-content:space-between;
                        padding:1.1rem 1.5rem;border-bottom:1px solid rgba(205,237,227,.5);">
                <div style="display:flex;align-items:center;gap:.625rem;">
                    <div style="width:32px;height:32px;border-radius:.625rem;display:flex;align-items:center;justify-content:center;
                                background:rgba(168,213,194,.2);border:1px solid rgba(168,213,194,.32);">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#5DAE99;">
                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                        </svg>
                    </div>
                    <h2 style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:#6B4F4F;">Recent Users</h2>
                </div>
                <a href="{{ route('admin.users') }}" class="link-jade">View All →</a>
            </div>
            <div>
                @foreach($recentUsers as $user)
                    <div style="display:flex;align-items:center;justify-content:space-between;
                                padding:.875rem 1.5rem;border-bottom:1px solid rgba(205,237,227,.32);
                                transition:background .18s ease;"
                         onmouseover="this.style.background='rgba(241,250,247,.55)'"
                         onmouseout="this.style.background='transparent'">
                        <div style="display:flex;align-items:center;gap:.75rem;">
                            <div class="avatar-jade"
                                 style="width:36px;height:36px;border-radius:.75rem;flex-shrink:0;
                                        box-shadow:0 2px 8px rgba(126,200,179,.22);">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div style="min-width:0;">
                                <p style="font-size:.825rem;font-weight:600;color:#6B4F4F;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $user->name }}
                                </p>
                                <p style="font-size:.72rem;color:rgba(107,79,79,.48);margin-top:.1rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $user->email }}
                                </p>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:.625rem;flex-shrink:0;">
                            <span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                            <a href="{{ route('admin.users.show', $user) }}" class="link-jade">View →</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>

{{-- ══════════════════════════════════════════════
     REJECT MODAL (dashboard quick reject)
══════════════════════════════════════════════ --}}
<div id="dashboardRejectModal"
     style="display:none;position:fixed;inset:0;z-index:60;align-items:center;justify-content:center;padding:1.5rem;">
    <div class="modal-backdrop"
         style="position:absolute;inset:0;"
         onclick="dashboardHideRejectForm()"></div>
    <div class="glass-modal"
         style="position:relative;z-index:1;border-radius:1.25rem;padding:2rem;width:100%;max-width:420px;">
        <h3 style="font-family:'Playfair Display',serif;font-size:1.2rem;font-weight:700;color:#6B4F4F;margin-bottom:1rem;">
            Reject Product
        </h3>
        <form id="dashboardRejectForm" action="" method="POST">
            @csrf
            <input type="hidden" name="product_id" id="dashboardRejectProductId">
            <div style="margin-bottom:1rem;">
                <label style="display:block;font-size:.8rem;font-weight:600;color:#6B4F4F;margin-bottom:.5rem;">
                    Reason for Rejection
                </label>
                <textarea name="rejection_reason" rows="3" required
                          class="glass-input"
                          style="width:100%;resize:vertical;"
                          placeholder="Provide a clear reason…"></textarea>
            </div>
            <div style="display:flex;gap:.625rem;">
                <button type="submit"
                        style="flex:1;padding:.6rem 1rem;border-radius:.75rem;font-size:.825rem;font-weight:600;
                               background:rgba(246,193,204,.25);color:#8B3A4A;border:1px solid rgba(220,150,170,.4);
                               cursor:pointer;transition:all .2s ease;font-family:'Poppins',sans-serif;"
                        onmouseover="this.style.background='rgba(246,193,204,.45)'"
                        onmouseout="this.style.background='rgba(246,193,204,.25)'">
                    Reject Product
                </button>
                <button type="button" onclick="dashboardHideRejectForm()"
                        style="flex:1;padding:.6rem 1rem;border-radius:.75rem;font-size:.825rem;font-weight:600;
                               background:rgba(255,255,255,.6);color:#6B4F4F;border:1px solid rgba(168,213,194,.4);
                               cursor:pointer;transition:all .2s ease;font-family:'Poppins',sans-serif;"
                        onmouseover="this.style.background='rgba(255,255,255,.85)'"
                        onmouseout="this.style.background='rgba(255,255,255,.6)'">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function dashboardShowRejectForm(productId) {
        document.getElementById('dashboardRejectProductId').value = productId;
        document.getElementById('dashboardRejectForm').action =
            "{{ route('admin.products.reject', ':id') }}".replace(':id', productId);
        const modal = document.getElementById('dashboardRejectModal');
        modal.style.display = 'flex';
    }
    function dashboardHideRejectForm() {
        document.getElementById('dashboardRejectModal').style.display = 'none';
        document.getElementById('dashboardRejectForm').reset();
    }
</script>
@endpush
@endsection
