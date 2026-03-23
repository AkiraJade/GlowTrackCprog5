@extends('layouts.admin')

@section('title', 'Manage Deliveries - GlowTrack Admin')

@section('content')
<!-- Deliveries Container -->
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Manage Deliveries</h1>
                <p class="text-gray-600">Track and manage all delivery operations</p>
            </div>
            <a href="{{ route('admin.deliveries.create') }}"
               class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-semibold shadow-lg">
                + Create Delivery
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6 border border-gray-200">
        <form method="GET" action="{{ route('admin.deliveries.index') }}" class="flex flex-wrap gap-4">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Filter</label>
                <select name="status" id="status"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="Pending Assignment" {{ request('status') == 'Pending Assignment' ? 'selected' : '' }}>Pending Assignment</option>
                    <option value="Assigned" {{ request('status') == 'Assigned' ? 'selected' : '' }}>Assigned</option>
                    <option value="Picked Up" {{ request('status') == 'Picked Up' ? 'selected' : '' }}>Picked Up</option>
                    <option value="In Transit" {{ request('status') == 'In Transit' ? 'selected' : '' }}>In Transit</option>
                    <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="Failed" {{ request('status') == 'Failed' ? 'selected' : '' }}>Failed</option>
                    <option value="Returned" {{ request('status') == 'Returned' ? 'selected' : '' }}>Returned</option>
                </select>
            </div>

            <div>
                <label for="personnel" class="block text-sm font-medium text-gray-700 mb-2">Delivery Personnel</label>
                <select name="delivery_personnel_id" id="personnel"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
                    <option value="">All Personnel</option>
                    @foreach(App\Models\DeliveryPersonnel::where('is_active', true)->get() as $person)
                        <option value="{{ $person->id }}"
                                {{ request('delivery_personnel_id') == $person->id ? 'selected' : '' }}>
                            {{ $person->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                Apply Filters
            </button>
        </form>
    </div>

    <!-- Deliveries Table -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200">
        @if($deliveries->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delivery Personnel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expected Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actual Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($deliveries as $delivery)
                            <tr class="hover:bg-gray-50 {{ $delivery->isOverdue() ? 'bg-red-50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900">#{{ $delivery->order->id }}</span>
                                        @if($delivery->isOverdue())
                                            <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Overdue</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $delivery->order->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $delivery->order->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $delivery->deliveryPersonnel ? $delivery->deliveryPersonnel->name : 'Not Assigned' }}
                                    </div>
                                    @if($delivery->deliveryPersonnel)
                                        <div class="text-xs text-gray-500">{{ $delivery->deliveryPersonnel->phone }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $delivery->getStatusBadgeColor() }}">
                                        {{ $delivery->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $delivery->expected_delivery_date ? $delivery->expected_delivery_date->format('M d, Y') : 'Not Set' }}
                                    </div>
                                    @if($delivery->expected_delivery_date)
                                        <div class="text-xs text-gray-500">
                                            {{ $delivery->getDaysUntilDelivery() }} days from now
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $delivery->actual_delivery_date ? $delivery->actual_delivery_date->format('M d, Y') : 'Not Delivered' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div style="display:flex;align-items:center;gap:.4rem;flex-wrap:wrap;">
                                        <a href="{{ route('admin.deliveries.show', $delivery) }}"
                                           style="padding:.3rem .65rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                                  text-decoration:none;color:#2D6A5B;background:rgba(126,200,179,.18);
                                                  border:1px solid rgba(126,200,179,.32);transition:all .18s ease;white-space:nowrap;"
                                           onmouseover="this.style.background='rgba(126,200,179,.3)'"
                                           onmouseout="this.style.background='rgba(126,200,179,.18)'">
                                            View
                                        </a>
                                        <a href="{{ route('admin.deliveries.edit', $delivery) }}"
                                           style="padding:.3rem .65rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                                  text-decoration:none;color:#2D5A4A;background:rgba(168,213,194,.2);
                                                  border:1px solid rgba(168,213,194,.35);transition:all .18s ease;white-space:nowrap;"
                                           onmouseover="this.style.background='rgba(168,213,194,.35)'"
                                           onmouseout="this.style.background='rgba(168,213,194,.2)'">
                                            Edit
                                        </a>

                                        <!-- Status Update Buttons -->
                                        @if(in_array($delivery->status, ['Assigned', 'Picked Up', 'In Transit']))
                                            <button onclick="updateDeliveryStatus({{ $delivery->id }}, 'Delivered')"
                                                    style="padding:.3rem .65rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                                           color:#2D6A5B;background:rgba(126,200,179,.15);
                                                           border:1px solid rgba(126,200,179,.28);cursor:pointer;
                                                           transition:all .18s ease;white-space:nowrap;font-family:'Poppins',sans-serif;"
                                                    onmouseover="this.style.background='rgba(126,200,179,.3)'"
                                                    onmouseout="this.style.background='rgba(126,200,179,.15)'">
                                                ✓ Delivered
                                            </button>
                                        @endif

                                        @if(in_array($delivery->status, ['Assigned', 'Picked Up']))
                                            <button onclick="updateDeliveryStatus({{ $delivery->id }}, 'Failed')"
                                                    style="padding:.3rem .65rem;font-size:.72rem;font-weight:600;border-radius:.5rem;
                                                           color:#8B5E3C;background:rgba(255,214,165,.2);
                                                           border:1px solid rgba(255,180,100,.28);cursor:pointer;
                                                           transition:all .18s ease;white-space:nowrap;font-family:'Poppins',sans-serif;"
                                                    onmouseover="this.style.background='rgba(255,214,165,.38)'"
                                                    onmouseout="this.style.background='rgba(255,214,165,.2)'">
                                                ✕ Failed
                                            </button>
                                        @endif

                                        <form action="{{ route('admin.deliveries.destroy', $delivery) }}" method="POST" style="display:inline;"
                                              onsubmit="return confirm('Delete delivery for Order #{{ $delivery->order->id }}? This cannot be undone.')">
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
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $deliveries->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-500 mb-4">No deliveries found.</div>
                <a href="{{ route('admin.deliveries.create') }}"
                   class="px-6 py-3 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-semibold shadow-lg">
                    + Create First Delivery
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function updateDeliveryStatus(deliveryId, status) {
    if (confirm('Are you sure you want to update the delivery status to ' + status + '?')) {
        fetch('/admin/deliveries/' + deliveryId + '/status', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: status,
                notes: 'Status updated via admin panel'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Delivery status updated successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error updating delivery status');
        });
    }
}
</script>
@endsection
