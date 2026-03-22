@extends('layouts.app')

@section('title', 'Notifications - GlowTrack')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-soft-brown font-playfair">Notifications</h1>
                <div class="flex items-center space-x-3">
                    <button onclick="markAllNotificationsAsRead()" 
                            class="text-sm text-jade-green hover:text-jade-green-dark font-medium transition-colors">
                        Mark all as read
                    </button>
                    <button onclick="clearAllNotifications()" 
                            class="text-sm text-red-500 hover:text-red-600 font-medium transition-colors">
                        Clear all
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center space-x-4">
                <button onclick="filterNotifications('all')" 
                        class="filter-btn px-4 py-2 text-sm font-medium rounded-full bg-jade-green text-white transition-colors"
                        data-filter="all">
                    All
                </button>
                <button onclick="filterNotifications('unread')" 
                        class="filter-btn px-4 py-2 text-sm font-medium rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors"
                        data-filter="unread">
                    Unread
                </button>
                <button onclick="filterNotifications('order_status')" 
                        class="filter-btn px-4 py-2 text-sm font-medium rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors"
                        data-filter="order_status">
                    Orders
                </button>
                <button onclick="filterNotifications('delivery_update')" 
                        class="filter-btn px-4 py-2 text-sm font-medium rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors"
                        data-filter="delivery_update">
                    Delivery
                </button>
                <button onclick="filterNotifications('low_stock')" 
                        class="filter-btn px-4 py-2 text-sm font-medium rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors"
                        data-filter="low_stock">
                    Stock
                </button>
            </div>
        </div>

        <!-- Notifications List -->
        <div id="notifications-container" class="divide-y divide-gray-200">
            @if(isset($notifications) && $notifications->count() > 0)
                @foreach($notifications as $notification)
                    <div class="notification-item px-6 py-4 hover:bg-gray-50 transition-colors {{ $notification->is_read ? '' : 'bg-blue-50' }}"
                         data-notification-id="{{ $notification->id }}"
                         onclick="handleNotificationClick({{ $notification->id }})">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <span class="text-2xl">{{ $notification->icon }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $notification->title }}
                                    </p>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-gray-500">{{ $notification->formatted_created_at }}</span>
                                        @if(!$notification->is_read)
                                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                        @endif
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                                @if($notification->data && isset($notification->data['order_id']))
                                    <div class="mt-2">
                                        <a href="/orders/{{ $notification->data['order_id'] }}" 
                                           class="text-xs text-jade-green hover:text-jade-green-dark font-medium inline-flex items-center">
                                            View Order
                                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                                <div class="mt-3 flex items-center space-x-3">
                                    <button onclick="event.stopPropagation(); markAsRead({{ $notification->id }})" 
                                            class="text-xs text-gray-500 hover:text-gray-700 {{ $notification->is_read ? 'hidden' : ''}}">
                                        Mark as read
                                    </button>
                                    <button onclick="event.stopPropagation(); deleteNotification({{ $notification->id }})" 
                                            class="text-xs text-red-500 hover:text-red-700">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Empty State -->
                <div class="px-6 py-12 text-center">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No notifications</h3>
                    <p class="text-gray-500">You're all caught up! We'll notify you when something important happens.</p>
                </div>
            @endif
        </div>

        <!-- Loading State -->
        <div id="loading-state" class="px-6 py-12 text-center">
            <div class="inline-flex items-center space-x-2">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-jade-green"></div>
                <span class="text-gray-500">Loading notifications...</span>
            </div>
        </div>

        <!-- Empty State -->
        <div id="empty-state" class="hidden px-6 py-12 text-center">
            <div class="text-gray-400 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No notifications</h3>
            <p class="text-gray-500">You're all caught up! We'll notify you when something important happens.</p>
        </div>

        <!-- Pagination -->
        <div id="pagination-container" class="px-6 py-4 border-t border-gray-200">
            @if(isset($notifications) && $notifications->lastPage() > 1)
                <div class="flex items-center justify-between">
                    <!-- Previous button -->
                    <button onclick="loadNotifications({{ $notifications->previousPage() ?: 1 }}, '{{ request->get('filter', 'all') }}')" 
                            class="px-3 py-1 text-sm {{ $notifications->previousPage() ? 'text-jade-green hover:text-jade-green-dark' : 'text-gray-400 cursor-not-allowed' }} font-medium">
                        Previous
                    </button>

                    <!-- Page numbers -->
                    <div class="flex items-center space-x-2">
                        @for($i = 1; $i <= $notifications->lastPage(); $i++)
                            @if($i == 1 || $i == $notifications->lastPage() || ($i >= $notifications->currentPage() - 2 && $i <= $notifications->currentPage() + 2))
                                <button onclick="loadNotifications({{ $i }}, '{{ request->get('filter', 'all') }}')" 
                                        class="px-3 py-1 text-sm {{ $i == $notifications->currentPage() ? 'bg-jade-green text-white' : 'text-gray-700 hover:bg-gray-100' }} rounded">
                                    {{ $i }}
                                </button>
                            @elseif($i == $notifications->currentPage() - 3 || $i == $notifications->currentPage() + 3)
                                <span class="text-gray-400">...</span>
                            @endif
                        @endfor
                    </div>

                    <!-- Next button -->
                    <button onclick="loadNotifications({{ $notifications->nextPage() ?: $notifications->lastPage() }}, '{{ request->get('filter', 'all') }}')" 
                            class="px-3 py-1 text-sm {{ $notifications->nextPage() ? 'text-jade-green hover:text-jade-green-dark' : 'text-gray-400 cursor-not-allowed' }} font-medium">
                        Next
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentPage = 1;
let currentFilter = 'all';
let notifications = [];

// Load notifications on page load
document.addEventListener('DOMContentLoaded', function() {
    // Hide loading state initially since we have server-rendered content
    document.getElementById('loading-state').classList.add('hidden');
    
    // Only load via AJAX if we need to filter or refresh
    // loadNotifications();
});

async function loadNotifications(page = 1, filter = 'all') {
    try {
        const loadingState = document.getElementById('loading-state');
        const emptyState = document.getElementById('empty-state');
        const container = document.getElementById('notifications-container');
        
        loadingState.classList.remove('hidden');
        emptyState.classList.add('hidden');
        container.innerHTML = '';

        const response = await fetch(`/notifications?page=${page}&filter=${filter}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        });

        if (response.ok) {
            const data = await response.json();
            notifications = data.notifications.data || [];
            currentPage = data.notifications.current_page || 1;
            
            loadingState.classList.add('hidden');
            
            if (notifications.length === 0) {
                emptyState.classList.remove('hidden');
            } else {
                renderNotifications(notifications);
                renderPagination(data.notifications);
            }
        }
    } catch (error) {
        console.error('Error loading notifications:', error);
        document.getElementById('loading-state').classList.add('hidden');
    }
}

function renderNotifications(notificationList) {
    const container = document.getElementById('notifications-container');
    
    container.innerHTML = notificationList.map(notification => `
        <div class="notification-item px-6 py-4 hover:bg-gray-50 transition-colors ${notification.is_read ? '' : 'bg-blue-50'}"
             onclick="handleNotificationClick(${notification.id})">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <span class="text-2xl">${getNotificationIcon(notification.type)}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-900">
                            ${notification.title}
                        </p>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-gray-500">${notification.formatted_created_at}</span>
                            ${!notification.is_read ? '<div class="w-2 h-2 bg-blue-500 rounded-full"></div>' : ''}
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">${notification.message}</p>
                    ${notification.data && notification.data.order_id ? `
                        <div class="mt-2">
                            <a href="/orders/${notification.data.order_id}" 
                               class="text-xs text-jade-green hover:text-jade-green-dark font-medium inline-flex items-center">
                                View Order
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    ` : ''}
                    <div class="mt-3 flex items-center space-x-3">
                        <button onclick="event.stopPropagation(); markAsRead(${notification.id})" 
                                class="text-xs text-gray-500 hover:text-gray-700 ${notification.is_read ? 'hidden' : ''}">
                            Mark as read
                        </button>
                        <button onclick="event.stopPropagation(); deleteNotification(${notification.id})" 
                                class="text-xs text-red-500 hover:text-red-700">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

function getNotificationIcon(type) {
    const icons = {
        'order_status': '📦',
        'delivery_update': '🚚',
        'low_stock': '⚠️',
        'product_approved': '✅',
        'product_rejected': '❌',
        'seller_approved': '🎉',
        'seller_rejected': '😞',
        'new_review': '⭐',
        'promotion': '🎁'
    };
    return icons[type] || '🔔';
}

function renderPagination(paginationData) {
    const container = document.getElementById('pagination-container');
    
    if (paginationData.last_page <= 1) {
        container.innerHTML = '';
        return;
    }

    let paginationHtml = '<div class="flex items-center justify-between">';
    
    // Previous button
    paginationHtml += `
        <button onclick="loadNotifications(${paginationData.prev_page_url ? currentPage - 1 : 1}, '${currentFilter}')" 
                class="px-3 py-1 text-sm ${paginationData.prev_page_url ? 'text-jade-green hover:text-jade-green-dark' : 'text-gray-400 cursor-not-allowed'} font-medium">
            Previous
        </button>
    `;

    // Page numbers
    paginationHtml += '<div class="flex items-center space-x-2">';
    for (let i = 1; i <= paginationData.last_page; i++) {
        if (i === 1 || i === paginationData.last_page || (i >= currentPage - 2 && i <= currentPage + 2)) {
            paginationHtml += `
                <button onclick="loadNotifications(${i}, '${currentFilter}')" 
                        class="px-3 py-1 text-sm ${i === currentPage ? 'bg-jade-green text-white' : 'text-gray-700 hover:bg-gray-100'} rounded">
                    ${i}
                </button>
            `;
        } else if (i === currentPage - 3 || i === currentPage + 3) {
            paginationHtml += '<span class="text-gray-400">...</span>';
        }
    }
    paginationHtml += '</div>';

    // Next button
    paginationHtml += `
        <button onclick="loadNotifications(${paginationData.next_page_url ? currentPage + 1 : paginationData.last_page}, '${currentFilter}')" 
                class="px-3 py-1 text-sm ${paginationData.next_page_url ? 'text-jade-green hover:text-jade-green-dark' : 'text-gray-400 cursor-not-allowed'} font-medium">
            Next
        </button>
    `;

    paginationHtml += '</div>';
    container.innerHTML = paginationHtml;
}

function filterNotifications(filter) {
    currentFilter = filter;
    
    // Update filter button styles
    document.querySelectorAll('.filter-btn').forEach(btn => {
        if (btn.dataset.filter === filter) {
            btn.className = 'filter-btn px-4 py-2 text-sm font-medium rounded-full bg-jade-green text-white transition-colors';
        } else {
            btn.className = 'filter-btn px-4 py-2 text-sm font-medium rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors';
        }
    });
    
    loadNotifications(1, filter);
}

async function markAsRead(notificationId) {
    try {
        const response = await fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        if (response.ok) {
            const data = await response.json();
            
            // Update the specific notification item
            const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notificationItem) {
                // Remove unread styling
                notificationItem.classList.remove('bg-blue-50');
                
                // Hide the mark as read button
                const markAsReadBtn = notificationItem.querySelector('button[onclick*="markAsRead"]');
                if (markAsReadBtn) {
                    markAsReadBtn.classList.add('hidden');
                }
                
                // Remove the unread indicator dot
                const unreadDot = notificationItem.querySelector('.bg-blue-500.rounded-full');
                if (unreadDot) {
                    unreadDot.remove();
                }
            }
            
            // Update unread count in the UI
            updateUnreadCount(data.unread_count);
            
            console.log('Notification marked as read successfully');
        } else {
            console.error('Failed to mark notification as read');
        }
    } catch (error) {
        console.error('Error marking notification as read:', error);
    }
}

function updateUnreadCount(count) {
    // Update notification badge in header
    const badge = document.querySelector('#notification-btn .bg-red-500');
    if (badge) {
        if (count > 0) {
            badge.textContent = count;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    }
}

async function deleteNotification(notificationId) {
    if (!confirm('Are you sure you want to delete this notification?')) {
        return;
    }

    try {
        const response = await fetch(`/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        if (response.ok) {
            loadNotifications(currentPage, currentFilter);
        }
    } catch (error) {
        console.error('Error deleting notification:', error);
    }
}

async function clearAllNotifications() {
    console.log('Clear all notifications clicked');
    
    if (!confirm('Are you sure you want to clear all notifications? This action cannot be undone.')) {
        console.log('User cancelled clear all');
        return;
    }

    console.log('User confirmed, proceeding with clear all');

    try {
        const response = await fetch('/notifications/clear-all', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        console.log('Clear all response status:', response.status);

        if (response.ok) {
            const data = await response.json();
            console.log('Clear all response data:', data);
            
            // Clear all notification items from the container
            const container = document.getElementById('notifications-container');
            if (container) {
                console.log('Updating notification container');
                container.innerHTML = `
                    <div class="px-6 py-12 text-center">
                        <div class="text-gray-400 mb-4">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No notifications</h3>
                        <p class="text-gray-500">You're all caught up! We'll notify you when something important happens.</p>
                    </div>
                `;
            }
            
            // Clear pagination
            const paginationContainer = document.getElementById('pagination-container');
            if (paginationContainer) {
                console.log('Clearing pagination');
                paginationContainer.innerHTML = '';
            }
            
            // Update unread count in the UI
            updateUnreadCount(0);
            
            console.log('All notifications cleared successfully');
        } else {
            console.error('Failed to clear notifications. Status:', response.status);
            const errorText = await response.text();
            console.error('Error response:', errorText);
        }
    } catch (error) {
        console.error('Error clearing notifications:', error);
    }
}

async function markAllNotificationsAsRead() {
    try {
        const response = await fetch('/notifications/mark-all-as-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        if (response.ok) {
            loadNotifications(currentPage, currentFilter);
        }
    } catch (error) {
        console.error('Error marking all notifications as read:', error);
    }
}

function handleNotificationClick(notificationId) {
    markAsRead(notificationId);
}
</script>
@endpush
