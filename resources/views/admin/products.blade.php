@extends('layouts.admin')

@section('title', 'Product Management - Admin')

@section('content')
<div style="display:flex;flex-direction:column;gap:1.5rem;">

    {{-- Page Header --}}
    <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div>
            <p class="page-label" style="margin-bottom:.3rem;">Product Management</p>
            <h1 class="page-title">All Products</h1>
            <p style="color:rgba(107,79,79,.55);font-size:.825rem;margin-top:.25rem;">
                Review, approve and manage product listings
            </p>
        </div>
        <div style="display:flex;align-items:center;gap:.75rem;">
            <div class="glass-card" style="border-radius:.875rem;padding:.65rem 1.1rem;display:flex;align-items:center;gap:.5rem;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#7EC8B3;flex-shrink:0;">
                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span style="font-size:.8rem;font-weight:600;color:#6B4F4F;">{{ $products->total() }} Products</span>
            </div>
            <a href="{{ route('admin.products.create') }}" class="btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Add Product
            </a>
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
                       placeholder="Search products or sellers…"
                       class="glass-input"
                       style="width:100%;padding-left:2.25rem;">
            </div>

            {{-- Status Filter --}}
            <select id="statusFilter" class="glass-select" style="min-width:140px;">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>

            {{-- Seller Filter --}}
            <select id="sellerFilter" class="glass-select" style="min-width:140px;">
                <option value="">All Sellers</option>
            </select>

            {{-- Clear --}}
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

    {{-- Products Table --}}
    <div class="glass-table">

        {{-- Table header bar --}}
        <div style="display:flex;align-items:center;justify-content:space-between;
                    padding:1.1rem 1.5rem;border-bottom:1px solid rgba(168,213,194,.35);
                    background:rgba(241,250,247,.75);">
            <div style="display:flex;align-items:center;gap:.625rem;">
                <div style="width:32px;height:32px;border-radius:.625rem;display:flex;align-items:center;justify-content:center;
                            background:rgba(126,200,179,.18);border:1px solid rgba(126,200,179,.3);">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#7EC8B3;">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h2 style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:#6B4F4F;">
                    Product Listings
                </h2>
            </div>
            <span class="badge badge-jade">{{ $products->total() }} total</span>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Seller</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            {{-- Product --}}
                            <td>
                                <div style="display:flex;align-items:center;gap:.75rem;">
                                    {{-- Thumbnail --}}
                                    <div style="width:42px;height:42px;border-radius:.75rem;overflow:hidden;flex-shrink:0;
                                                border:1px solid rgba(168,213,194,.35);background:rgba(241,250,247,.8);">
                                        @if($product->photo)
                                            <img src="{{ $product->photo_url }}"
                                                 alt="{{ $product->name }}"
                                                 style="width:100%;height:100%;object-fit:cover;"
                                                 onerror="this.onerror=null;this.src='{{ asset('images/default-product.jpg') }}';">
                                        @else
                                            <img src="{{ asset('images/default-product.jpg') }}"
                                                 alt="{{ $product->name }}"
                                                 style="width:100%;height:100%;object-fit:cover;">
                                        @endif
                                    </div>
                                    <div style="min-width:0;">
                                        <p style="font-size:.835rem;font-weight:600;color:#6B4F4F;
                                                  white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px;">
                                            {{ $product->name }}
                                        </p>
                                        <p style="font-size:.75rem;color:rgba(107,79,79,.5);margin-top:.1rem;">
                                            {{ $product->brand ?? '—' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Seller --}}
                            <td>
                                <div style="display:flex;align-items:center;gap:.5rem;">
                                    <div class="avatar-peach"
                                         style="width:30px;height:30px;border-radius:.5rem;flex-shrink:0;font-size:.72rem;">
                                        {{ strtoupper(substr($product->seller->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <div style="min-width:0;">
                                        <p style="font-size:.8rem;font-weight:600;color:#6B4F4F;
                                                  white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:130px;">
                                            {{ $product->seller->name ?? 'N/A' }}
                                        </p>
                                        <p style="font-size:.7rem;color:rgba(107,79,79,.48);
                                                  white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:130px;">
                                            {{ $product->seller->email ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Price --}}
                            <td>
                                <span style="font-size:.875rem;font-weight:700;color:#7EC8B3;">
                                    ₱{{ number_format($product->price, 2) }}
                                </span>
                            </td>

                            {{-- Stock --}}
                            <td>
                                @if($product->quantity <= 0)
                                    <span style="font-size:.82rem;font-weight:700;color:#8B3A4A;
                                                 background:rgba(246,193,204,.25);border:1px solid rgba(220,150,170,.35);
                                                 padding:.25rem .65rem;border-radius:.5rem;">
                                        Out of Stock
                                    </span>
                                @elseif($product->quantity <= 10)
                                    <span style="font-size:.82rem;font-weight:700;color:#8B5E3C;
                                                 background:rgba(255,214,165,.28);border:1px solid rgba(255,180,100,.35);
                                                 padding:.25rem .65rem;border-radius:.5rem;">
                                        {{ $product->quantity }} ⚠
                                    </span>
                                @else
                                    <span style="font-size:.82rem;font-weight:600;color:#6B4F4F;">
                                        {{ $product->quantity }}
                                    </span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td>
                                <span class="badge badge-{{ $product->status }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>

                            {{-- Created --}}
                            <td style="color:rgba(107,79,79,.6);font-size:.8rem;white-space:nowrap;">
                                {{ $product->created_at->format('M d, Y') }}
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div style="display:flex;align-items:center;gap:.4rem;flex-wrap:nowrap;">
                                    <a href="{{ route('products.show', $product) }}"
                                       style="padding:.3rem .6rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                              text-decoration:none;color:#2D6A5B;background:rgba(126,200,179,.18);
                                              border:1px solid rgba(126,200,179,.32);transition:all .18s ease;white-space:nowrap;"
                                       onmouseover="this.style.background='rgba(126,200,179,.3)'"
                                       onmouseout="this.style.background='rgba(126,200,179,.18)'">
                                        View
                                    </a>

                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       style="padding:.3rem .6rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                              text-decoration:none;color:#2D5A4A;background:rgba(168,213,194,.2);
                                              border:1px solid rgba(168,213,194,.35);transition:all .18s ease;white-space:nowrap;"
                                       onmouseover="this.style.background='rgba(168,213,194,.35)'"
                                       onmouseout="this.style.background='rgba(168,213,194,.2)'">
                                        Edit
                                    </a>

                                    <button onclick="showRestockForm({{ $product->id }}, {{ $product->quantity }}, '{{ addslashes($product->name) }}')"
                                            style="padding:.3rem .6rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                                   color:#2D5A4A;background:rgba(168,213,194,.18);
                                                   border:1px solid rgba(168,213,194,.32);cursor:pointer;
                                                   transition:all .18s ease;white-space:nowrap;font-family:'Poppins',sans-serif;"
                                            onmouseover="this.style.background='rgba(168,213,194,.32)'"
                                            onmouseout="this.style.background='rgba(168,213,194,.18)'">
                                        Restock
                                    </button>

                                    @if($product->status === 'pending')
                                        <form action="{{ route('admin.products.approve', $product) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit"
                                                    style="padding:.3rem .6rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                                           color:#2D6A5B;background:rgba(126,200,179,.2);
                                                           border:1px solid rgba(126,200,179,.38);cursor:pointer;
                                                           transition:all .18s ease;white-space:nowrap;font-family:'Poppins',sans-serif;"
                                                    onmouseover="this.style.background='rgba(126,200,179,.38)'"
                                                    onmouseout="this.style.background='rgba(126,200,179,.2)'">
                                                ✓ Approve
                                            </button>
                                        </form>

                                        <button onclick="showRejectForm({{ $product->id }})"
                                                style="padding:.3rem .6rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                                       color:#8B3A4A;background:rgba(246,193,204,.2);
                                                       border:1px solid rgba(220,150,170,.35);cursor:pointer;
                                                       transition:all .18s ease;white-space:nowrap;font-family:'Poppins',sans-serif;"
                                                onmouseover="this.style.background='rgba(246,193,204,.38)'"
                                                onmouseout="this.style.background='rgba(246,193,204,.2)'">
                                            ✕ Reject
                                        </button>
                                    @endif

                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;"
                                          onsubmit="return confirm('Delete {{ addslashes($product->name) }}? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                style="padding:.3rem .6rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                                       color:#8B3A4A;background:rgba(246,193,204,.18);
                                                       border:1px solid rgba(220,150,170,.28);cursor:pointer;
                                                       transition:all .18s ease;white-space:nowrap;font-family:'Poppins',sans-serif;"
                                                onmouseover="this.style.background='rgba(246,193,204,.35)'"
                                                onmouseout="this.style.background='rgba(246,193,204,.18)'">
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
                                            <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <p style="font-size:.875rem;color:rgba(107,79,79,.45);font-weight:500;">No products found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="padding:1rem 1.5rem;border-top:1px solid rgba(205,237,227,.4);background:rgba(241,250,247,.5);">
            {{ $products->links() }}
        </div>

    </div>

</div>

{{-- ══════════════════════════════════════════════
     REJECT MODAL
══════════════════════════════════════════════ --}}
<div id="rejectModal"
     style="display:none;position:fixed;inset:0;z-index:60;align-items:center;justify-content:center;padding:1.5rem;">
    <div class="modal-backdrop"
         style="position:absolute;inset:0;"
         onclick="hideRejectForm()"></div>
    <div class="glass-modal"
         style="position:relative;z-index:1;border-radius:1.25rem;padding:2rem;width:100%;max-width:440px;">

        <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;">
            <div style="width:40px;height:40px;border-radius:.875rem;display:flex;align-items:center;justify-content:center;
                        background:rgba(246,193,204,.22);border:1px solid rgba(220,150,170,.32);flex-shrink:0;">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#D98BA0;">
                    <path d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
            <div>
                <h3 style="font-family:'Playfair Display',serif;font-size:1.15rem;font-weight:700;color:#6B4F4F;line-height:1.2;">
                    Reject Product
                </h3>
                <p style="font-size:.78rem;color:rgba(107,79,79,.55);margin-top:.2rem;">
                    The seller will be notified with the reason.
                </p>
            </div>
        </div>

        <form id="rejectForm" action="" method="POST">
            @csrf
            <input type="hidden" name="product_id" id="rejectProductId">

            <div style="margin-bottom:1.1rem;">
                <label style="display:block;font-size:.8rem;font-weight:600;color:#6B4F4F;margin-bottom:.5rem;">
                    Reason for Rejection <span style="color:#D98BA0;">*</span>
                </label>
                <textarea name="rejection_reason" rows="3" required
                          class="glass-input"
                          style="width:100%;resize:vertical;"
                          placeholder="Provide a clear, helpful reason for the seller…"></textarea>
            </div>

            <div style="display:flex;gap:.625rem;">
                <button type="submit"
                        style="flex:1;padding:.625rem 1rem;border-radius:.75rem;font-size:.825rem;font-weight:600;
                               cursor:pointer;font-family:'Poppins',sans-serif;
                               background:rgba(246,193,204,.25);color:#8B3A4A;border:1px solid rgba(220,150,170,.4);
                               transition:all .2s ease;"
                        onmouseover="this.style.background='rgba(246,193,204,.45)'"
                        onmouseout="this.style.background='rgba(246,193,204,.25)'">
                    Reject Product
                </button>
                <button type="button" onclick="hideRejectForm()"
                        style="flex:1;padding:.625rem 1rem;border-radius:.75rem;font-size:.825rem;font-weight:600;
                               cursor:pointer;font-family:'Poppins',sans-serif;
                               background:rgba(255,255,255,.6);color:#6B4F4F;border:1px solid rgba(168,213,194,.4);
                               transition:all .2s ease;"
                        onmouseover="this.style.background='rgba(255,255,255,.88)'"
                        onmouseout="this.style.background='rgba(255,255,255,.6)'">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════════════
     RESTOCK MODAL
══════════════════════════════════════════════ --}}
<div id="restockModal"
     style="display:none;position:fixed;inset:0;z-index:60;align-items:center;justify-content:center;padding:1.5rem;">
    <div class="modal-backdrop"
         style="position:absolute;inset:0;"
         onclick="hideRestockForm()"></div>
    <div class="glass-modal"
         style="position:relative;z-index:1;border-radius:1.25rem;padding:2rem;width:100%;max-width:440px;">

        <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;">
            <div style="width:40px;height:40px;border-radius:.875rem;display:flex;align-items:center;justify-content:center;
                        background:rgba(168,213,194,.22);border:1px solid rgba(168,213,194,.32);flex-shrink:0;">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#5DAE99;">
                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div>
                <h3 style="font-family:'Playfair Display',serif;font-size:1.15rem;font-weight:700;color:#6B4F4F;line-height:1.2;">
                    Restock Product
                </h3>
                <p style="font-size:.78rem;color:rgba(107,79,79,.55);margin-top:.2rem;">
                    Add inventory to the product stock.
                </p>
            </div>
        </div>

        {{-- Product info strip --}}
        <div style="background:rgba(126,200,179,.1);border:1px solid rgba(126,200,179,.25);
                    border-radius:.875rem;padding:.875rem 1rem;margin-bottom:1.1rem;">
            <p style="font-size:.8rem;color:#6B4F4F;margin-bottom:.35rem;">
                Product: <strong id="restockProductName" style="color:#2D6A5B;"></strong>
            </p>
            <p style="font-size:.8rem;color:#6B4F4F;">
                Current Stock:
                <strong id="restockCurrentStock" style="color:#7EC8B3;"></strong>
                units
            </p>
        </div>

        <form id="restockForm" action="" method="POST">
            @csrf
            <input type="hidden" name="product_id" id="restockProductId">

            <div style="margin-bottom:.875rem;">
                <label style="display:block;font-size:.8rem;font-weight:600;color:#6B4F4F;margin-bottom:.5rem;">
                    Quantity to Add <span style="color:#D98BA0;">*</span>
                </label>
                <input type="number" name="add_quantity" min="1" max="9999" required
                       class="glass-input"
                       style="width:100%;"
                       placeholder="Enter quantity to add…">
            </div>

            <div style="margin-bottom:1.1rem;">
                <label style="display:block;font-size:.8rem;font-weight:600;color:#6B4F4F;margin-bottom:.5rem;">
                    Notes <span style="font-weight:400;color:rgba(107,79,79,.45);">(optional)</span>
                </label>
                <textarea name="restock_notes" rows="2"
                          class="glass-input"
                          style="width:100%;resize:vertical;"
                          placeholder="Add any restock notes…"></textarea>
            </div>

            <div style="display:flex;gap:.625rem;">
                <button type="submit"
                        style="flex:1;padding:.625rem 1rem;border-radius:.75rem;font-size:.825rem;font-weight:600;
                               cursor:pointer;font-family:'Poppins',sans-serif;
                               background:linear-gradient(135deg,#7EC8B3,#5DAE99);color:#fff;
                               border:1px solid rgba(255,255,255,.25);
                               box-shadow:0 4px 16px rgba(126,200,179,.38);
                               transition:all .2s ease;"
                        onmouseover="this.style.boxShadow='0 6px 22px rgba(126,200,179,.5)';this.style.transform='translateY(-1px)'"
                        onmouseout="this.style.boxShadow='0 4px 16px rgba(126,200,179,.38)';this.style.transform='none'">
                    Add Stock
                </button>
                <button type="button" onclick="hideRestockForm()"
                        style="flex:1;padding:.625rem 1rem;border-radius:.75rem;font-size:.825rem;font-weight:600;
                               cursor:pointer;font-family:'Poppins',sans-serif;
                               background:rgba(255,255,255,.6);color:#6B4F4F;border:1px solid rgba(168,213,194,.4);
                               transition:all .2s ease;"
                        onmouseover="this.style.background='rgba(255,255,255,.88)'"
                        onmouseout="this.style.background='rgba(255,255,255,.6)'">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    /* ── Reject modal ────────────────────────────── */
    function showRejectForm(productId) {
        document.getElementById('rejectProductId').value = productId;
        document.getElementById('rejectForm').action =
            "{{ route('admin.products.reject', ':id') }}".replace(':id', productId);
        document.getElementById('rejectModal').style.display = 'flex';
    }
    function hideRejectForm() {
        document.getElementById('rejectModal').style.display = 'none';
        document.getElementById('rejectForm').reset();
    }

    /* ── Restock modal ───────────────────────────── */
    function showRestockForm(productId, currentStock, productName) {
        document.getElementById('restockProductId').value  = productId;
        document.getElementById('restockProductName').textContent    = productName;
        document.getElementById('restockCurrentStock').textContent   = currentStock;
        document.getElementById('restockForm').action =
            "{{ route('admin.products.restock', ':id') }}".replace(':id', productId);
        document.getElementById('restockModal').style.display = 'flex';
    }
    function hideRestockForm() {
        document.getElementById('restockModal').style.display = 'none';
        document.getElementById('restockForm').reset();
    }

    /* ── Client-side filters ─────────────────────── */
    function applyFilters() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const status = document.getElementById('statusFilter').value.toLowerCase();
        const seller = document.getElementById('sellerFilter').value.toLowerCase();

        document.querySelectorAll('tbody tr').forEach(row => {
            const productName = row.querySelector('td:nth-child(1)')?.textContent.trim().toLowerCase() ?? '';
            const sellerName  = row.querySelector('td:nth-child(2)')?.textContent.trim().toLowerCase() ?? '';
            const statusText  = row.querySelector('td:nth-child(5) .badge')?.textContent.trim().toLowerCase() ?? '';

            const matchSearch = !search || productName.includes(search) || sellerName.includes(search);
            const matchStatus = !status || statusText.includes(status);
            const matchSeller = !seller || sellerName.includes(seller);

            row.style.display = (matchSearch && matchStatus && matchSeller) ? '' : 'none';
        });
    }

    function clearFilters() {
        document.getElementById('searchInput').value  = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('sellerFilter').value = '';
        applyFilters();
    }

    document.getElementById('searchInput').addEventListener('input',  applyFilters);
    document.getElementById('statusFilter').addEventListener('change', applyFilters);
    document.getElementById('sellerFilter').addEventListener('change', applyFilters);
</script>
@endpush
@endsection
