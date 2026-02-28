@extends('layouts.app')

@section('title', 'Order Management - Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold text-soft-brown font-playfair">Order Management</h1>
                <p class="text-soft-brown opacity-75 mt-2">Manage and track customer orders</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="px-6 py-2 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                ← Back to Dashboard
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex flex-wrap gap-4 items-center">
                <div class="flex-1 min-w-64">
                    <input type="text" id="searchInput" placeholder="Search by order ID or customer name..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green">
                </div>
                <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="processing">Processing</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                <input type="date" id="dateFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green">
            </div>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-soft-brown font-playfair">Orders ({{ $orders->total() }})</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $order->order_id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $order->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $order->items->count() }} items</div>
                                    @foreach($order->items->take(2) as $item)
                                        <div class="text-xs text-gray-500">{{ $item->product->name }} ({{ $item->quantity }})</div>
                                    @endforeach
                                    @if($order->items->count() > 2)
                                        <div class="text-xs text-gray-400">+{{ $order->items->count() - 2 }} more</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select onchange="updateOrderStatus({{ $order->id }}, this.value)" 
                                            class="px-2 py-1 text-xs font-medium rounded-full border-0 focus:ring-2 focus:ring-jade-green
                                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($order->status === 'confirmed' ? 'bg-blue-100 text-blue-800' :
                                               ($order->status === 'processing' ? 'bg-purple-100 text-purple-800' :
                                               ($order->status === 'shipped' ? 'bg-indigo-100 text-indigo-800' :
                                               ($order->status === 'delivered' ? 'bg-green-100 text-green-800' :
                                               ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' :
                                               'bg-gray-100 text-gray-800'))))) }}">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('orders.show', $order) }}" class="text-jade-green hover:text-jade-green-900">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>

<script>
function updateOrderStatus(orderId, newStatus) {
    if (confirm(`Are you sure you want to update order status to "${newStatus}"?`)) {
        fetch(`/admin/orders/${orderId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error updating order status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating order status');
        });
    } else {
        // Reset the select to original value
        location.reload();
    }
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchValue = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const orderId = row.querySelector('td:nth-child(1)')?.textContent.toLowerCase();
        const customerName = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase();
        
        if (orderId?.includes(searchValue) || customerName?.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Status filter
document.getElementById('statusFilter').addEventListener('change', function(e) {
    const statusValue = e.target.value;
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const statusSelect = row.querySelector('td:nth-child(5) select');
        const status = statusSelect?.value;
        
        if (!statusValue || status === statusValue) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Date filter
document.getElementById('dateFilter').addEventListener('change', function(e) {
    const dateValue = e.target.value;
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const dateCell = row.querySelector('td:nth-child(6)');
        const orderDate = dateCell?.textContent.trim();
        
        if (!dateValue || orderDate.includes(dateValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
@endsection
