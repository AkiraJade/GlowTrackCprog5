@extends('layouts.admin')

@section('title', 'Users Management - GlowTrack')

@section('content')
<div style="display:flex;flex-direction:column;gap:1.5rem;">

    {{-- Page Header --}}
    <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div>
            <p class="page-label" style="margin-bottom:.3rem;">User Management</p>
            <h1 class="page-title">All Users</h1>
            <p style="color:rgba(107,79,79,.55);font-size:.825rem;margin-top:.25rem;">
                Manage roles, statuses and user accounts
            </p>
        </div>
        <div class="glass-card" style="border-radius:.875rem;padding:.65rem 1.1rem;display:flex;align-items:center;gap:.5rem;">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#7EC8B3;flex-shrink:0;">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
            </svg>
            <span style="font-size:.8rem;font-weight:600;color:#6B4F4F;">{{ $users->total() }} Total Users</span>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="glass-table">

        {{-- Table Header Bar --}}
        <div style="display:flex;align-items:center;justify-content:space-between;
                    padding:1.1rem 1.5rem;border-bottom:1px solid rgba(168,213,194,.35);
                    background:rgba(241,250,247,.75);">
            <div style="display:flex;align-items:center;gap:.625rem;">
                <div style="width:32px;height:32px;border-radius:.625rem;display:flex;align-items:center;justify-content:center;
                            background:rgba(126,200,179,.18);border:1px solid rgba(126,200,179,.3);">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#7EC8B3;">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                </div>
                <h2 style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:#6B4F4F;">
                    Registered Users
                </h2>
            </div>
            <span class="badge badge-jade">{{ $users->total() }} total</span>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Contact</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            {{-- User --}}
                            <td>
                                <div style="display:flex;align-items:center;gap:.75rem;">
                                    <div class="avatar-jade"
                                         style="width:38px;height:38px;border-radius:.75rem;flex-shrink:0;
                                                box-shadow:0 2px 8px rgba(126,200,179,.22);">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div style="min-width:0;">
                                        <p style="font-weight:600;color:#6B4F4F;font-size:.835rem;white-space:nowrap;">
                                            {{ $user->name }}
                                        </p>
                                        <p style="color:rgba(107,79,79,.5);font-size:.75rem;">
                                            {{ $user->username }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Contact --}}
                            <td>
                                <p style="font-size:.82rem;color:#6B4F4F;">{{ $user->email }}</p>
                                @if($user->phone)
                                    <p style="font-size:.75rem;color:rgba(107,79,79,.5);margin-top:.15rem;">{{ $user->phone }}</p>
                                @endif
                            </td>

                            {{-- Role --}}
                            <td>
                                @if(auth()->user()->id !== $user->id)
                                    <form method="POST" action="{{ route('admin.users.update-role', $user) }}" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" onchange="this.form.submit()"
                                                style="font-size:.78rem;font-weight:600;border-radius:.625rem;
                                                       background:rgba(255,255,255,.6);border:1px solid rgba(168,213,194,.45);
                                                       color:#6B4F4F;padding:.3rem .6rem;cursor:pointer;
                                                       font-family:'Poppins',sans-serif;outline:none;">
                                            <option value="admin"    {{ $user->role === 'admin'    ? 'selected' : '' }}>Admin</option>
                                            <option value="seller"   {{ $user->role === 'seller'   ? 'selected' : '' }}>Seller</option>
                                            <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                        </select>
                                    </form>
                                @else
                                    <span class="badge badge-{{ $user->role }}">
                                        {{ ucfirst($user->role) }} (You)
                                    </span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td>
                                @if($user->active)
                                    <span class="badge badge-active">Active</span>
                                @else
                                    <span class="badge badge-inactive">Inactive</span>
                                @endif
                            </td>

                            {{-- Joined --}}
                            <td style="color:rgba(107,79,79,.6);font-size:.8rem;white-space:nowrap;">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div style="display:flex;align-items:center;gap:.4rem;flex-wrap:nowrap;">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                       style="padding:.3rem .65rem;font-size:.75rem;font-weight:600;border-radius:.5rem;
                                              text-decoration:none;color:#2D6A5B;background:rgba(126,200,179,.18);
                                              border:1px solid rgba(126,200,179,.32);transition:all .18s ease;white-space:nowrap;"
                                       onmouseover="this.style.background='rgba(126,200,179,.3)'"
                                       onmouseout="this.style.background='rgba(126,200,179,.18)'">
                                        View
                                    </a>

                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       style="padding:.3rem .65rem;font-size:.75rem;font-weight:600;border-radius:.5rem;
                                              text-decoration:none;color:#2D5A4A;background:rgba(168,213,194,.2);
                                              border:1px solid rgba(168,213,194,.35);transition:all .18s ease;white-space:nowrap;"
                                       onmouseover="this.style.background='rgba(168,213,194,.35)'"
                                       onmouseout="this.style.background='rgba(168,213,194,.2)'">
                                        Edit
                                    </a>

                                    @if($user->active && auth()->user()->id !== $user->id)
                                        <button onclick="openDeactivateModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                                style="padding:.3rem .65rem;font-size:.75rem;font-weight:600;border-radius:.5rem;
                                                       color:#8B5E3C;background:rgba(255,214,165,.2);
                                                       border:1px solid rgba(255,180,100,.32);cursor:pointer;
                                                       transition:all .18s ease;white-space:nowrap;font-family:'Poppins',sans-serif;"
                                                onmouseover="this.style.background='rgba(255,214,165,.38)'"
                                                onmouseout="this.style.background='rgba(255,214,165,.2)'">
                                            Deactivate
                                        </button>
                                    @elseif(!$user->active && auth()->user()->id !== $user->id)
                                        <form method="POST" action="{{ route('admin.users.update-status', $user) }}" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="active" value="1">
                                            <button type="submit"
                                                    style="padding:.3rem .65rem;font-size:.75rem;font-weight:600;border-radius:.5rem;
                                                           color:#2D6A5B;background:rgba(126,200,179,.18);
                                                           border:1px solid rgba(126,200,179,.32);cursor:pointer;
                                                           transition:all .18s ease;white-space:nowrap;font-family:'Poppins',sans-serif;"
                                                    onmouseover="this.style.background='rgba(126,200,179,.35)'"
                                                    onmouseout="this.style.background='rgba(126,200,179,.18)'">
                                                Activate
                                            </button>
                                        </form>
                                    @endif

                                    @if(auth()->user()->id !== $user->id)
                                        <form method="POST" action="{{ route('admin.users.delete', $user) }}" style="display:inline;"
                                              onsubmit="return confirm('Delete {{ addslashes($user->name) }}? This will permanently remove all their data and cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    style="padding:.3rem .65rem;font-size:.75rem;font-weight:600;border-radius:.5rem;
                                                           color:#8B3A4A;background:rgba(246,193,204,.18);
                                                           border:1px solid rgba(220,150,170,.32);cursor:pointer;
                                                           transition:all .18s ease;white-space:nowrap;font-family:'Poppins',sans-serif;"
                                                    onmouseover="this.style.background='rgba(246,193,204,.38)'"
                                                    onmouseout="this.style.background='rgba(246,193,204,.18)'">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
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
                                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8z"/>
                                        </svg>
                                    </div>
                                    <p style="font-size:.875rem;color:rgba(107,79,79,.45);font-weight:500;">No users found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
            <div style="padding:1rem 1.5rem;border-top:1px solid rgba(205,237,227,.4);background:rgba(241,250,247,.5);">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>

{{-- ══════════════════════════════════════════════
     DEACTIVATE MODAL
══════════════════════════════════════════════ --}}
<div id="deactivateModal"
     style="display:none;position:fixed;inset:0;z-index:60;align-items:center;justify-content:center;padding:1.5rem;">
    <div class="modal-backdrop"
         style="position:absolute;inset:0;"
         onclick="closeDeactivateModal()"></div>
    <div class="glass-modal"
         style="position:relative;z-index:1;border-radius:1.25rem;padding:2rem;width:100%;max-width:440px;">

        {{-- Modal header --}}
        <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;">
            <div style="width:40px;height:40px;border-radius:.875rem;display:flex;align-items:center;justify-content:center;
                        background:rgba(255,214,165,.22);border:1px solid rgba(255,180,100,.32);flex-shrink:0;">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color:#D4935A;">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 style="font-family:'Playfair Display',serif;font-size:1.15rem;font-weight:700;color:#6B4F4F;line-height:1.2;">
                    Deactivate User
                </h3>
                <p style="font-size:.78rem;color:rgba(107,79,79,.55);margin-top:.2rem;">
                    This will prevent them from accessing the platform.
                </p>
            </div>
        </div>

        <p style="font-size:.825rem;color:#6B4F4F;margin-bottom:1.25rem;
                  background:rgba(255,214,165,.15);border:1px solid rgba(255,180,100,.25);
                  border-radius:.75rem;padding:.75rem 1rem;">
            Are you sure you want to deactivate
            <strong id="userName" style="color:#8B5E3C;"></strong>?
        </p>

        <form id="deactivateForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="active" value="0">

            <div style="margin-bottom:1.1rem;">
                <label style="display:block;font-size:.8rem;font-weight:600;color:#6B4F4F;margin-bottom:.5rem;">
                    Reason for deactivation <span style="color:#D98BA0;">*</span>
                </label>
                <textarea name="deactivation_reason" rows="3" required
                          class="glass-input"
                          style="width:100%;resize:vertical;"
                          placeholder="Provide a clear reason…"></textarea>
            </div>

            <div style="display:flex;gap:.625rem;">
                <button type="submit"
                        style="flex:1;padding:.625rem 1rem;border-radius:.75rem;font-size:.825rem;font-weight:600;
                               cursor:pointer;font-family:'Poppins',sans-serif;
                               background:rgba(255,214,165,.25);color:#8B5E3C;border:1px solid rgba(255,180,100,.4);
                               transition:all .2s ease;"
                        onmouseover="this.style.background='rgba(255,214,165,.45)'"
                        onmouseout="this.style.background='rgba(255,214,165,.25)'">
                    Deactivate User
                </button>
                <button type="button" onclick="closeDeactivateModal()"
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
    function openDeactivateModal(userId, userName) {
        document.getElementById('userName').textContent = userName;
        document.getElementById('deactivateForm').action = '/admin/users/' + userId + '/status';
        const modal = document.getElementById('deactivateModal');
        modal.style.display = 'flex';
    }
    function closeDeactivateModal() {
        document.getElementById('deactivateModal').style.display = 'none';
        document.getElementById('deactivateForm').reset();
    }
</script>
@endpush
@endsection
