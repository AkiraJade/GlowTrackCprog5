@extends('layouts.admin')

@section('title', 'Order Management - Admin')

@section('content')
<div style="display:flex;flex-direction:column;gap:1.5rem;">

    {{-- Page Header --}}
    <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div>
            <p class="page-label" style="margin-bottom:.3rem;">Order Management</p>
            <h1 class="page-title">All Orders</h1>
            <p style="color:rgba(107,79,79,.55);font-size:.825rem;margin-top:.25rem;">
                Track, update and manage customer orders
            </p>
        </div>
        <div class="glass-card" style="border-radius:.875rem;padding:.65rem 1.1rem;display:flex;align-items:center;gap:.5rem;">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#7EC8B3;flex-shrink:0;">
                <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <span style="font-size:.8rem;font-weight:600;color:#6B4F4F;">{{ $orders->total() }} Total Orders</span>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="glass-filter" style="border-radius:1.125rem;padding:1.1rem 1.5rem;">
        <div style="display:flex;flex-wrap:wrap;align-items:center;gap:.75rem;">
            {{-- Search --}}
            <div style="position:relative;flex:1;min-width:220px;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"
                     style="position:absolute;left:.75rem;top:50%;transform:translateY(-50%);color:rgba(107,79,79,.38);pointer-events:none;">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" id="searchInput"
                       placeholder="Search by order ID or customer name…"
                       class="glass-input"
                       style="width:100%;padding-left:2.25rem;">
            </div>

            {{-- Status Filter --}}
            <select id="statusFilter" class="glass-select" style="min-width:150px;">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="processing">Processing</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
            </select>

            {{-- Date Filter --}}
            <div style="position:relative;">
                <input type="date" id="dateFilter"
                       class="glass-input"
                       style="padding-left:.875rem;">
            </div>

            {{-- Clear Button --}}
            <button onclick="clearFilters()"
                    style="padding:.525rem 1rem;border-radius:.75rem;font-size:.8rem;font-weight:600;
                           color:rgba(107,79,79,.6);background:rgba(255,255,255,.5);
                           border:1px solid rgba(168,213,194,.35);cursor:pointer;
                           transition:all .2s ease;font-family:'Poppins',sans-serif;white-space:nowrap;"
                    onmouseover="this.style.background='rgba(255,255,255,.8)'"
                    onmouseout="this.style.background='rgba(255,255,255,.5)'">
                Clear Filters
            </button>
        </div>
    </div>

    {{-- Orders Table --}}
    <div class="glass-table">

        {{-- Table Header Bar --}}
        <div style="display:flex;align-items:center;justify-content:space-between;
                    padding:1.1rem 1.5rem;border-bottom:1px solid rgba(168,213,194,.35);
                    background:rgba(241,250,247,.75);">
            <div style="display:flex;align-items:center;gap:.625rem;">
                <div style="width:32px;height:32px;border-radius:.625rem;display:flex;align-items:center;justify-content:center;
                            background:rgba(126,200,179,.18);border:1px solid rgba(126,200,179,.3);">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#7EC8B3;">
                        <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h2 style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:#6B4F4F;">
                    Orders
                </h2>
            </div>
            <span class="badge badge-jade">{{ $orders->total() }} total</span>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        @php
                            $statusStyle = match($order->status) {
                                'pending'    => 'background:rgba(255,214,165,.3);color:#8B5E3C;border-color:rgba(255,180,100,.4);',
                                'confirmed'  => 'background:rgba(168,213,194,.28);color:#2D5A4A;border-color:rgba(126,200,179,.38);',
                                'processing' => 'background:rgba(168,213,194,.32);color:#205040;border-color:rgba(100,180,160,.42);',
                                'shipped'    => 'background:rgba(126,200,179,.22);color:#1D4A3A;border-color:rgba(100,180,160,.42);',
                                'delivered'  => 'background:rgba(126,200,179,.28);color:#2D6A5B;border-color:rgba(126,200,179,.48);',
                                'cancelled'  => 'background:rgba(246,193,204,.28);color:#8B3A4A;border-color:rgba(220,150,170,.38);',
                                default      => 'background:rgba(255,255,255,.5);color:#6B4F4F;border-color:rgba(168,213,194,.35);',
                            };
                        @endphp
                        <tr>
                            {{-- Order ID --}}
                            <td>
                                <span style="font-weight:700;color:#7EC8B3;font-size:.82rem;">
                                    #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            {{-- Customer --}}
                            <td>
                                <div style="display:flex;align-items:center;gap:.625rem;">
                                    <div class="avatar-jade"
                                         style="width:34px;height:34px;border-radius:.625rem;flex-shrink:0;font-size:.78rem;
                                                box-shadow:0 2px 8px rgba(126,200,179,.2);">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <div style="min-width:0;">
                                        <p style="font-size:.82rem;font-weight:600;color:#6B4F4F;white-space:nowrap;">
                                            {{ $order->user->name }}
                                        </p>
                                        <p style="font-size:.72rem;color:rgba(107,79,79,.5);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:160px;">
                                            {{ $order->user->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Items --}}
                            <td>
                                <p style="font-size:.82rem;font-weight:600;color:#6B4F4F;">
                                    {{ $order->orderItems->count() }} item{{ $order->orderItems->count() !== 1 ? 's' : '' }}
                                </p>
                                @foreach($order->orderItems->take(2) as $item)
                                    <p style="font-size:.72rem;color:rgba(107,79,79,.5);white-space:nowrap;">
                                        {{ Str::limit($item->product->name ?? 'N/A', 22) }} (×{{ $item->quantity }})
                                    </p>
                                @endforeach
                                @if($order->orderItems->count() > 2)
                                    <p style="font-size:.7rem;color:rgba(126,200,179,.8);font-weight:600;">
                                        +{{ $order->orderItems->count() - 2 }} more
                                    </p>
                                @endif
                            </td>

                            {{-- Total --}}
                            <td>
                                <span style="font-size:.875rem;font-weight:700;color:#7EC8B3;">
                                    ₱{{ number_format($order->total_amount, 2) }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td>
                                <select onchange="updateOrderStatus({{ $order->id }}, this.value)"
                                        style="font-size:.75rem;font-weight:700;border-radius:.625rem;padding:.3rem .65rem;cursor:pointer;outline:none;font-family:'Poppins',sans-serif;border:1px solid;{{ $statusStyle }}">
                                    <option value="pending"    {{ $order->status === 'pending'    ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed"  {{ $order->status === 'confirmed'  ? 'selected' : '' }}>Confirmed</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped"    {{ $order->status === 'shipped'    ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered"  {{ $order->status === 'delivered'  ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled"  {{ $order->status === 'cancelled'  ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </td>

                            {{-- Date --}}
                            <td style="color:rgba(107,79,79,.6);font-size:.8rem;white-space:nowrap;">
                                {{ $order->created_at->format('M d, Y') }}<br>
                                <span style="font-size:.72rem;color:rgba(107,79,79,.42);">{{ $order->created_at->format('H:i') }}</span>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div style="display:flex;align-items:center;gap:.4rem;flex-wrap:nowrap;">
                                    <a href="{{ route('orders.show', $order) }}"
                                       style="display:inline-flex;align-items:center;gap:.35rem;
                                              padding:.3rem .65rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                              text-decoration:none;color:#2D6A5B;background:rgba(126,200,179,.18);
                                              border:1px solid rgba(126,200,179,.32);transition:all .18s ease;white-space:nowrap;"
                                       onmouseover="this.style.background='rgba(126,200,179,.3)'"
                                       onmouseout="this.style.background='rgba(126,200,179,.18)'">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        View
                                    </a>

                                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" style="display:inline;"
                                          onsubmit="return confirm('Delete Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}? It will be moved to trash and can be restored later.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                style="display:inline-flex;align-items:center;gap:.35rem;
                                                       padding:.3rem .65rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                                       color:#8B3A4A;background:rgba(246,193,204,.18);
                                                       border:1px solid rgba(220,150,170,.32);cursor:pointer;
                                                       transition:all .18s ease;white-space:nowrap;font-family:'Poppins',sans-serif;"
                                                onmouseover="this.style.background='rgba(246,193,204,.35)'"
                                                onmouseout="this.style.background='rgba(246,193,204,.18)'">
                                            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:3.5rem 1.5rem;">
                                <div style="display:flex;flex-direction:column;align-items:center;gap:.75rem;">
                                    <div style="width:52px;height:52px;border-radius:1rem;display:flex;align-items:center;justify-content:center;
                                                background:rgba(126,200,179,.12);border:1px solid rgba(126,200,179,.22);">
                                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" style="color:rgba(126,200,179,.55);">
                                            <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                    </div>
                                    <p style="font-size:.875rem;color:rgba(107,79,79,.45);font-weight:500;">No orders found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="padding:1rem 1.5rem;border-top:1px solid rgba(205,237,227,.4);background:rgba(241,250,247,.5);">
            {{ $orders->links() }}
        </div>

    </div>

</div>

@push('scripts')
<script>
    /* ── Order status update ─────────────────────── */
    function updateOrderStatus(orderId, newStatus) {
        if (!confirm(`Update order status to "${newStatus}"?`)) {
            location.reload(); return;
        }
        fetch(`/admin/orders/${orderId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(r => r.json())
        .then(data => { if (data.success) location.reload(); else alert('Error updating order status'); })
        .catch(() => alert('Error updating order status'));
    }

    /* ── Client-side filters ─────────────────────── */
    function applyFilters() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const status = document.getElementById('statusFilter').value.toLowerCase();
        const date   = document.getElementById('dateFilter').value;
        document.querySelectorAll('tbody tr').forEach(row => {
            const orderId   = row.querySelector('td:nth-child(1)')?.textContent.trim().toLowerCase() ?? '';
            const customer  = row.querySelector('td:nth-child(2)')?.textContent.trim().toLowerCase() ?? '';
            const rowStatus = row.querySelector('td:nth-child(5) select')?.value ?? '';
            const rowDate   = row.querySelector('td:nth-child(6)')?.textContent.trim() ?? '';
            const matchSearch = !search || orderId.includes(search) || customer.includes(search);
            const matchStatus = !status || rowStatus === status;
            const matchDate   = !date   || rowDate.includes(date);
            row.style.display = (matchSearch && matchStatus && matchDate) ? '' : 'none';
        });
    }

    function clearFilters() {
        document.getElementById('searchInput').value  = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('dateFilter').value   = '';
        applyFilters();
    }

    document.getElementById('searchInput').addEventListener('input',  applyFilters);
    document.getElementById('statusFilter').addEventListener('change', applyFilters);
    document.getElementById('dateFilter').addEventListener('change',   applyFilters);
</script>
@endpush
@endsection
