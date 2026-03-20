<div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
    <!-- Header -->
    <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
        <div class="flex items-center space-x-2">
            <button onclick="notificationDropdown.loadNotifications()" 
                    class="text-xs text-gray-500 hover:text-gray-700 transition-colors"
                    title="Refresh">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </button>
            <button onclick="markAllNotificationsAsRead()" 
                    class="text-xs text-jade-green hover:text-jade-green-dark transition-colors font-medium"
                    title="Mark all as read">
                Mark all read
            </button>
        </div>
    </div>

    <!-- Notification List -->
    <div class="notification-list max-h-96 overflow-y-auto">
        <!-- Notifications will be rendered here by JavaScript -->
    </div>

    <!-- Empty State -->
    <div class="notification-empty hidden px-4 py-8 text-center">
        <div class="text-gray-400 mb-2">
            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
        </div>
        <p class="text-sm text-gray-500">No notifications yet</p>
        <p class="text-xs text-gray-400 mt-1">We'll notify you when something important happens</p>
    </div>

    <!-- Footer -->
    <div class="px-4 py-3 border-t border-gray-200">
        <a href="/notifications" 
           class="text-xs text-jade-green hover:text-jade-green-dark font-medium flex items-center justify-center">
            View all notifications
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
</div>
