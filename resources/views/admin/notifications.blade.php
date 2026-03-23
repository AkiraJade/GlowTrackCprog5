@extends('layouts.admin')

@section('title', 'Notifications - GlowTrack')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 font-playfair">Admin Notifications</h1>
        <p class="text-gray-600 mt-2">View and manage admin notifications and system alerts.</p>
    </div>

    <!-- Notification Filters -->
    <div class="mb-6 bg-white rounded-xl shadow-md border border-gray-200 p-4">
        <div class="flex flex-wrap gap-4 items-center">
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium text-gray-700">Filter:</label>
                <select id="notificationFilter" class="border-gray-300 rounded-md focus:ring-jade-green focus:border-jade-green">
                    <option value="all">All Notifications</option>
                    <option value="unread">Unread Only</option>
                    <option value="admin_action">Admin Actions</option>
                    <option value="new_seller_application">New Applications</option>
                    <option value="system_alert">System Alerts</option>
                    <option value="order_status">Order Updates</option>
                    <option value="low_stock">Low Stock</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button onclick="markAllAsRead()" class="px-4 py-2 bg-jade-green text-white rounded-md hover:bg-green-600 transition text-sm">
                    Mark All Read
                </button>
                <button onclick="clearAllNotifications()" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition text-sm">
                    Clear All
                </button>
            </div>
            <div class="ml-auto">
                <span class="text-sm text-gray-600">
                    <span id="unreadCount" class="font-semibold text-jade-green">{{ $notifications->firstWhere('is_read', false) ? $notifications->where('is_read', false)->count() : 0 }}</span> unread
                </span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
        @if($notifications->count())
            <div class="space-y-4" id="notificationsList">
                @foreach($notifications as $notification)
                    <li class="p-4 border border-gray-100 rounded-lg {{ $notification->is_read ? 'bg-white' : 'bg-green-50' }} list-none">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-lg">{{ $notification->icon ?? '🔔' }}</span>
                                    <p class="text-sm font-semibold text-gray-900">{{ $notification->title }}</p>
                                    @if(!$notification->is_read)
                                        <span class="px-2 py-1 bg-jade-green text-white text-xs rounded-full">New</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-700 mb-2">{{ $notification->message }}</p>
                                <div class="flex items-center gap-4 text-xs text-gray-500">
                                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                                    <span class="px-2 py-1 bg-{{ $notification->color ?? 'gray' }}-100 text-{{ $notification->color ?? 'gray' }}-800 rounded">
                                        {{ ucfirst(str_replace('_', ' ', $notification->type)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex gap-2 ml-4">
                                @if(!$notification->is_read)
                                    <form method="POST" action="{{ route('notifications.mark-read', $notification) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-jade-green text-xs hover:text-green-600">Mark read</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('notifications.destroy', $notification) }}" class="inline" onsubmit="return confirm('Delete this notification?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 text-xs hover:text-red-600">Delete</button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </div>

            <div class="mt-6">{{ $notifications->links() }}</div>
        @else
            <div class="text-center py-8">
                <div class="text-4xl mb-4">🔔</div>
                <p class="text-sm text-gray-500">No notifications yet.</p>
                <p class="text-xs text-gray-400 mt-2">Admin notifications will appear here when important events occur.</p>
            </div>
        @endif
    </div>
</div>

<script>
function markAllAsRead() {
    if (confirm('Mark all notifications as read?')) {
        fetch('{{ route("notifications.mark-all-read") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            location.reload();
        });
    }
}

function clearAllNotifications() {
    if (confirm('Delete all notifications? This action cannot be undone.')) {
        fetch('{{ route("notifications.clear-all") }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            location.reload();
        });
    }
}

// Filter notifications
document.getElementById('notificationFilter').addEventListener('change', function() {
    const filter = this.value;
    const url = new URL(window.location);
    url.searchParams.set('filter', filter);
    window.location = url.toString();
});
</script>
@endsection