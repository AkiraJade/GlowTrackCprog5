@extends('layouts.admin')

@section('title', 'Users Management - GlowTrack')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 font-playfair">Users Management</h1>
        <p class="text-gray-600 mt-2">Manage all platform users</p>
    </div>

        <!-- Users Table -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">All Users</h2>
                    <div class="text-sm text-gray-500">
                        {{ $users->total() }} total users
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-jade-green flex items-center justify-center">
                                                <span class="text-white font-medium">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->username }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                    @if($user->phone)
                                        <div class="text-sm text-gray-500">{{ $user->phone }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(auth()->user()->id !== $user->id)
                                        <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="role" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="seller" {{ $user->role === 'seller' ? 'selected' : '' }}>Seller</option>
                                                <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                            </select>
                                        </form>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                                               ($user->role === 'seller' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($user->role) }} (You)
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->active)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-jade-green hover:text-jade-green-900 mr-2">View</a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-900 mr-2">Edit</a>
                                    @if($user->active && auth()->user()->id !== $user->id)
                                        <button onclick="openDeactivateModal({{ $user->id }}, '{{ $user->name }}')" class="text-yellow-600 hover:text-yellow-900 mr-2">Deactivate</button>
                                    @elseif(!$user->active && auth()->user()->id !== $user->id)
                                        <form method="POST" action="{{ route('admin.users.update-status', $user) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="active" value="1">
                                            <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Activate</button>
                                        </form>
                                    @endif
                                    @if(auth()->user()->id !== $user->id)
                                        <form method="POST" action="{{ route('admin.users.delete', $user) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this user? This will permanently delete all their data including orders, products, reviews, and other related records. This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No users found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Deactivation Modal -->
<div id="deactivateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900">Deactivate User</h3>
            <p class="mt-2 text-sm text-gray-500">
                Are you sure you want to deactivate <span id="userName" class="font-semibold"></span>? This will prevent them from accessing the platform.
            </p>
            <form id="deactivateForm" method="POST" class="mt-4">
                @csrf
                @method('PUT')
                <input type="hidden" name="active" value="0">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason for deactivation:</label>
                    <textarea name="deactivation_reason" rows="3" class="w-full border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green" required></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeDeactivateModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Deactivate User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openDeactivateModal(userId, userName) {
    document.getElementById('userName').textContent = userName;
    document.getElementById('deactivateForm').action = '/admin/users/' + userId + '/status';
    document.getElementById('deactivateModal').classList.remove('hidden');
}

function closeDeactivateModal() {
    document.getElementById('deactivateModal').classList.add('hidden');
    document.getElementById('deactivateForm').reset();
}
</script>
@endsection
