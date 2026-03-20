<div id="notification-dropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50 opacity-0 invisible group-hover:visible group-hover:opacity-100 transition-opacity duration-200">
    <!-- Header -->
    <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
        <div class="text-xs text-gray-500">{{ $unreadCount ?? 0 }} new</div>
    </div>

    <!-- Notification List -->
    <div class="max-h-64 overflow-y-auto">
        @forelse($recentNotifications ?? collect() as $notification)
            <a href="{{ route('notifications.index') }}" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                <div class="flex items-start gap-2">
                    <span class="text-lg">{{ $notification->icon }}</span>
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-800">{{ $notification->title }}</div>
                        <div class="text-xs text-gray-500">{{ \Illuminate\Support\Str::limit($notification->message, 70) }}</div>
                        <div class="text-[11px] text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </a>
        @empty
            <div class="px-4 py-6 text-center text-sm text-gray-500">
                No notifications yet.
            </div>
        @endforelse
    </div>

    <!-- Footer -->
    <div class="px-4 py-3 border-t border-gray-200 text-right">
        <a href="{{ route('notifications.index') }}" class="text-xs text-jade-green hover:text-jade-green-dark font-medium">
            View all notifications
            <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
</div>
