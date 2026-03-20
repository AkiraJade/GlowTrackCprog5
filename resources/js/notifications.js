// Notification Dropdown Component
class NotificationDropdown {
    constructor() {
        this.notifications = [];
        this.unreadCount = 0;
        this.isOpen = false;
        this.init();
    }

    init() {
        this.loadNotifications();
        this.setupEventListeners();
        
        // Auto-refresh notifications every 30 seconds
        setInterval(() => this.loadNotifications(), 30000);
    }

    setupEventListeners() {
        // Toggle dropdown
        const notificationBtn = document.getElementById('notification-btn');
        if (notificationBtn) {
            notificationBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleDropdown();
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            const dropdown = document.getElementById('notification-dropdown');
            const btn = document.getElementById('notification-btn');
            
            if (this.isOpen && dropdown && !dropdown.contains(e.target) && !btn.contains(e.target)) {
                this.closeDropdown();
            }
        });
    }

    toggleDropdown() {
        const dropdown = document.getElementById('notification-dropdown');
        if (this.isOpen) {
            this.closeDropdown();
        } else {
            this.openDropdown();
        }
    }

    openDropdown() {
        const dropdown = document.getElementById('notification-dropdown');
        if (dropdown) {
            dropdown.classList.remove('hidden');
            this.isOpen = true;
            this.loadNotifications(); // Refresh when opening
        }
    }

    closeDropdown() {
        const dropdown = document.getElementById('notification-dropdown');
        if (dropdown) {
            dropdown.classList.add('hidden');
            this.isOpen = false;
        }
    }

    async loadNotifications() {
        try {
            const response = await fetch('/notifications/recent', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                this.notifications = data.notifications || [];
                this.unreadCount = data.unread_count || 0;
                this.render();
            }
        } catch (error) {
            console.error('Error loading notifications:', error);
        }
    }

    render() {
        this.updateBadge();
        this.renderDropdown();
    }

    updateBadge() {
        const badge = document.getElementById('notification-badge');
        if (badge) {
            if (this.unreadCount > 0) {
                badge.textContent = this.unreadCount > 99 ? '99+' : this.unreadCount;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }
    }

    renderDropdown() {
        const dropdown = document.getElementById('notification-dropdown');
        if (!dropdown) return;

        const notificationList = dropdown.querySelector('.notification-list');
        const emptyState = dropdown.querySelector('.notification-empty');
        
        if (this.notifications.length === 0) {
            if (notificationList) notificationList.classList.add('hidden');
            if (emptyState) emptyState.classList.remove('hidden');
        } else {
            if (notificationList) {
                notificationList.classList.remove('hidden');
                notificationList.innerHTML = this.notifications.map(notification => this.renderNotification(notification)).join('');
            }
            if (emptyState) emptyState.classList.add('hidden');
        }
    }

    renderNotification(notification) {
        const timeAgo = this.formatTimeAgo(notification.formatted_created_at);
        const iconClass = this.getIconClass(notification.type);
        
        return `
            <div class="notification-item ${notification.is_read ? 'read' : 'unread'} border-b border-gray-100 hover:bg-gray-50 transition-colors cursor-pointer"
                 onclick="notificationDropdown.handleNotificationClick(${notification.id})">
                <div class="p-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <span class="text-2xl">${notification.icon}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    ${notification.title}
                                </p>
                                <span class="text-xs text-gray-500 ml-2">${timeAgo}</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">${notification.message}</p>
                            ${notification.data && notification.data.order_id ? `
                                <div class="mt-2">
                                    <a href="/orders/${notification.data.order_id}" 
                                       class="text-xs text-jade-green hover:text-jade-green-dark font-medium">
                                        View Order →
                                    </a>
                                </div>
                            ` : ''}
                        </div>
                        ${!notification.is_read ? '<div class="w-2 h-2 bg-red-500 rounded-full flex-shrink-0 mt-2"></div>' : ''}
                    </div>
                </div>
            </div>
        `;
    }

    getIconClass(type) {
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

    formatTimeAgo(timeAgo) {
        // Already formatted by Laravel's diffForHumans()
        return timeAgo;
    }

    async handleNotificationClick(notificationId) {
        // Mark as read
        try {
            await fetch(`/notifications/${notificationId}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            // Update local state
            const notification = this.notifications.find(n => n.id === notificationId);
            if (notification) {
                notification.is_read = true;
                this.unreadCount = Math.max(0, this.unreadCount - 1);
                this.render();
            }
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    }

    async markAllAsRead() {
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
                this.notifications.forEach(n => n.is_read = true);
                this.unreadCount = 0;
                this.render();
            }
        } catch (error) {
            console.error('Error marking all notifications as read:', error);
        }
    }
}

// Initialize the notification dropdown
let notificationDropdown;
document.addEventListener('DOMContentLoaded', function() {
    notificationDropdown = new NotificationDropdown();
});

// Global function for external access
window.markAllNotificationsAsRead = function() {
    if (notificationDropdown) {
        notificationDropdown.markAllAsRead();
    }
};
