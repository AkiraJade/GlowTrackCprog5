@extends('layouts.admin')

@section('title', 'Seller Applications - GlowTrack')

@section('content')
<div style="display:flex;flex-direction:column;gap:1.5rem;">

    {{-- Page Header --}}
    <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div>
            <p class="page-label" style="margin-bottom:.3rem;">User Management</p>
            <h1 class="page-title">Seller Applications</h1>
            <p style="color:rgba(107,79,79,.55);font-size:.825rem;margin-top:.25rem;">
                Review, approve and manage seller verification requests
            </p>
        </div>
        <div class="glass-card" style="border-radius:.875rem;padding:.65rem 1.1rem;display:flex;align-items:center;gap:.5rem;">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#7EC8B3;flex-shrink:0;">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span style="font-size:.8rem;font-weight:600;color:#6B4F4F;">{{ $applications->total() }} Total Applications</span>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="glass-card" style="border-radius:1.125rem;padding:.5rem;">
        <div style="display:flex;gap:.375rem;flex-wrap:wrap;">
            @php
                $tabs = [
                    ['label' => 'All',      'value' => null,       'count' => $applications->total()],
                    ['label' => 'Pending',  'value' => 'pending',  'count' => null],
                    ['label' => 'Approved', 'value' => 'approved', 'count' => null],
                    ['label' => 'Rejected', 'value' => 'rejected', 'count' => null],
                ];
            @endphp
            @foreach($tabs as $tab)
                @php $isActive = request('status') === $tab['value']; @endphp
                <a href="{{ route('admin.seller-applications', $tab['value'] ? ['status' => $tab['value']] : []) }}"
                   style="padding:.5rem 1.1rem;border-radius:.75rem;font-size:.8rem;font-weight:600;
                          text-decoration:none;transition:all .2s ease;
                          {{ $isActive
                              ? 'background:linear-gradient(135deg,#7EC8B3,#5DAE99);color:#fff;box-shadow:0 4px 14px rgba(126,200,179,.38);border:1px solid rgba(255,255,255,.25);'
                              : 'color:rgba(107,79,79,.65);background:transparent;border:1px solid transparent;' }}"
                   onmouseover="{{ $isActive ? '' : "this.style.background='rgba(126,200,179,.12)';this.style.borderColor='rgba(126,200,179,.28)';this.style.color='#6B4F4F';" }}"
                   onmouseout="{{ $isActive ? '' : "this.style.background='transparent';this.style.borderColor='transparent';this.style.color='rgba(107,79,79,.65)';" }}">
                    {{ $tab['label'] }}
                    @if($tab['count'] !== null)
                        <span style="margin-left:.35rem;font-size:.68rem;opacity:.75;">({{ $tab['count'] }})</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>

    {{-- Applications Table --}}
    <div class="glass-table">

        {{-- Table Header Bar --}}
        <div style="display:flex;align-items:center;justify-content:space-between;
                    padding:1.1rem 1.5rem;border-bottom:1px solid rgba(168,213,194,.35);
                    background:rgba(241,250,247,.75);">
            <div style="display:flex;align-items:center;gap:.625rem;">
                <div style="width:32px;height:32px;border-radius:.625rem;display:flex;align-items:center;justify-content:center;
                            background:rgba(126,200,179,.18);border:1px solid rgba(126,200,179,.3);">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#7EC8B3;">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:#6B4F4F;">
                    @if(request('status') === 'pending')   Pending Applications
                    @elseif(request('status') === 'approved') Approved Applications
                    @elseif(request('status') === 'rejected') Rejected Applications
                    @else All Applications
                    @endif
                </h2>
            </div>
            <span class="badge badge-jade">{{ $applications->total() }} total</span>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th>Applicant</th>
                        <th>Business</th>
                        <th>Categories</th>
                        <th>Status</th>
                        <th>Applied</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $application)
                        <tr>
                            {{-- Applicant --}}
                            <td>
                                <div style="display:flex;align-items:center;gap:.75rem;">
                                    <div class="avatar-jade"
                                         style="width:38px;height:38px;border-radius:.75rem;flex-shrink:0;
                                                box-shadow:0 2px 8px rgba(126,200,179,.22);">
                                        {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                    </div>
                                    <div style="min-width:0;">
                                        <p style="font-size:.835rem;font-weight:600;color:#6B4F4F;
                                                  white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:160px;">
                                            {{ $application->user->name }}
                                        </p>
                                        <p style="font-size:.75rem;color:rgba(107,79,79,.5);margin-top:.1rem;
                                                  white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:160px;">
                                            {{ $application->user->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Business --}}
                            <td>
                                <p style="font-size:.835rem;font-weight:600;color:#6B4F4F;
                                          white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:180px;">
                                    {{ $application->brand_name }}
                                </p>
                                <p style="font-size:.75rem;color:rgba(107,79,79,.5);margin-top:.1rem;
                                          white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:180px;">
                                    {{ Str::limit($application->business_description, 40) }}
                                </p>
                            </td>

                            {{-- Categories --}}
                            <td>
                                <div style="display:flex;flex-wrap:wrap;gap:.25rem;max-width:200px;">
                                    @foreach(array_slice((array)$application->product_categories, 0, 3) as $cat)
                                        <span class="badge badge-sage" style="font-size:.62rem;">{{ $cat }}</span>
                                    @endforeach
                                    @if(count((array)$application->product_categories) > 3)
                                        <span class="badge badge-gray" style="font-size:.62rem;">
                                            +{{ count((array)$application->product_categories) - 3 }} more
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Status --}}
                            <td>
                                @if($application->status === 'pending')
                                    <span class="badge badge-pending">Pending</span>
                                @elseif($application->status === 'approved')
                                    <span class="badge badge-approved">Approved</span>
                                @else
                                    <span class="badge badge-rejected">Rejected</span>
                                @endif
                            </td>

                            {{-- Applied --}}
                            <td style="color:rgba(107,79,79,.6);font-size:.8rem;white-space:nowrap;">
                                {{ $application->created_at->format('M d, Y') }}
                                @if($application->reviewed_at)
                                    <br>
                                    <span style="font-size:.7rem;color:rgba(107,79,79,.4);">
                                        Reviewed {{ $application->reviewed_at->format('M d, Y') }}
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div style="display:flex;align-items:center;gap:.4rem;flex-wrap:nowrap;">

                                    {{-- View --}}
                                    <a href="{{ route('admin.seller-applications.show', $application) }}"
                                       style="padding:.3rem .65rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                              text-decoration:none;color:#2D6A5B;background:rgba(126,200,179,.18);
                                              border:1px solid rgba(126,200,179,.32);transition:all .18s ease;white-space:nowrap;"
                                       onmouseover="this.style.background='rgba(126,200,179,.3)'"
                                       onmouseout="this.style.background='rgba(126,200,179,.18)'">
                                        View
                                    </a>

                                    {{-- Approve (pending only) --}}
                                    @if($application->status === 'pending')
                                        <form method="POST" action="{{ route('admin.seller-applications.approve', $application) }}"
                                              style="display:inline;"
                                              onsubmit="return confirm('Approve seller application for {{ addslashes($application->brand_name) }}?')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                    style="padding:.3rem .65rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                                           color:#2D6A5B;background:rgba(126,200,179,.2);
                                                           border:1px solid rgba(126,200,179,.38);cursor:pointer;
                                                           transition:all .18s ease;white-space:nowrap;font-family:'Poppins',sans-serif;"
                                                    onmouseover="this.style.background='rgba(126,200,179,.38)'"
                                                    onmouseout="this.style.background='rgba(126,200,179,.2)'">
                                                ✓ Approve
                                            </button>
                                        </form>

                                        {{-- Reject (pending only) --}}
                                        <button onclick="openRejectModal({{ $application->id }}, '{{ addslashes($application->brand_name) }}')"
                                                style="padding:.3rem .65rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                                       color:#8B5E3C;background:rgba(255,214,165,.2);
                                                       border:1px solid rgba(255,180,100,.32);cursor:pointer;
                                                       transition:all .18s ease;white-space:nowrap;font-family:'Poppins',sans-serif;"
                                                onmouseover="this.style.background='rgba(255,214,165,.38)'"
                                                onmouseout="this.style.background='rgba(255,214,165,.2)'">
                                            ✕ Reject
                                        </button>
                                    @endif

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.seller-applications.destroy', $application) }}"
                                          method="POST" style="display:inline;"
                                          onsubmit="return confirm('Permanently delete the application for {{ addslashes($application->brand_name) }}? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                style="padding:.3rem .65rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
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
                            <td colspan="6" style="text-align:center;padding:3.5rem 1.5rem;">
                                <div style="display:flex;flex-direction:column;align-items:center;gap:.75rem;">
                                    <div style="width:52px;height:52px;border-radius:1rem;display:flex;align-items:center;justify-content:center;
                                                background:rgba(126,200,179,.12);border:1px solid rgba(126,200,179,.22);">
                                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" style="color:rgba(126,200,179,.55);">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <p style="font-size:.875rem;color:rgba(107,79,79,.45);font-weight:500;">
                                        @if(request('status'))
                                            No {{ request('status') }} applications found
                                        @else
                                            No seller applications found
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($applications->hasPages())
            <div style="padding:1rem 1.5rem;border-top:1px solid rgba(205,237,227,.4);background:rgba(241,250,247,.5);">
                {{ $applications->links() }}
            </div>
        @endif

    </div>

</div>

{{-- ══════════════════════════════════════════════
     REJECT MODAL
══════════════════════════════════════════════ --}}
<div id="rejectModal"
     style="display:none;position:fixed;inset:0;z-index:60;align-items:center;justify-content:center;padding:1.5rem;">
    <div class="modal-backdrop"
         style="position:absolute;inset:0;"
         onclick="closeRejectModal()"></div>
    <div class="glass-modal"
         style="position:relative;z-index:1;border-radius:1.25rem;padding:2rem;width:100%;max-width:440px;">

        <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;">
            <div style="width:40px;height:40px;border-radius:.875rem;display:flex;align-items:center;justify-content:center;
                        background:rgba(255,214,165,.22);border:1px solid rgba(255,180,100,.32);flex-shrink:0;">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#D4935A;">
                    <path d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
            <div>
                <h3 style="font-family:'Playfair Display',serif;font-size:1.15rem;font-weight:700;color:#6B4F4F;line-height:1.2;">
                    Reject Application
                </h3>
                <p style="font-size:.78rem;color:rgba(107,79,79,.55);margin-top:.2rem;">
                    Rejecting: <strong id="rejectBrandName" style="color:#8B5E3C;"></strong>
                </p>
            </div>
        </div>

        <form id="rejectForm" method="POST" action="">
            @csrf
            @method('PUT')
            <div style="margin-bottom:1.1rem;">
                <label style="display:block;font-size:.8rem;font-weight:600;color:#6B4F4F;margin-bottom:.5rem;">
                    Reason for Rejection <span style="color:#D98BA0;">*</span>
                </label>
                <textarea name="admin_notes" rows="3" required
                          class="glass-input"
                          style="width:100%;resize:vertical;"
                          placeholder="Provide a clear reason for the applicant…"></textarea>
            </div>
            <div style="display:flex;gap:.625rem;">
                <button type="submit"
                        style="flex:1;padding:.625rem 1rem;border-radius:.75rem;font-size:.825rem;font-weight:600;
                               cursor:pointer;font-family:'Poppins',sans-serif;
                               background:rgba(255,214,165,.25);color:#8B5E3C;border:1px solid rgba(255,180,100,.4);
                               transition:all .2s ease;"
                        onmouseover="this.style.background='rgba(255,214,165,.45)'"
                        onmouseout="this.style.background='rgba(255,214,165,.25)'">
                    Reject Application
                </button>
                <button type="button" onclick="closeRejectModal()"
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
    function openRejectModal(applicationId, brandName) {
        document.getElementById('rejectBrandName').textContent = brandName;
        document.getElementById('rejectForm').action =
            "{{ route('admin.seller-applications.reject', ':id') }}".replace(':id', applicationId);
        document.getElementById('rejectModal').style.display = 'flex';
    }
    function closeRejectModal() {
        document.getElementById('rejectModal').style.display = 'none';
        document.getElementById('rejectForm').reset();
    }
</script>
@endpush
@endsection
