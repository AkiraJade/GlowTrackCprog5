<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\DeliveryPersonnel;
use App\Models\Order;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DeliveryController extends Controller
{
    public function index(): View
    {
        $deliveries = Delivery::with(['order.user', 'deliveryPersonnel'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('delivery.index', compact('deliveries'));
    }

    public function create(): View
    {
        $orders = Order::where('status', 'processing')->get();
        $personnel = DeliveryPersonnel::where('is_active', true)->get();

        return view('delivery.create', compact('orders', 'personnel'));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'delivery_personnel_id' => 'nullable|exists:delivery_personnels,id',
            'expected_delivery_date' => 'required|date|after:today',
            'collection_point' => 'nullable|string|max:255',
            'destination_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $delivery = Delivery::create([
            'order_id' => $validated['order_id'],
            'delivery_personnel_id' => $validated['delivery_personnel_id'],
            'status' => $validated['delivery_personnel_id'] ? 'Assigned' : 'Pending Assignment',
            'expected_delivery_date' => $validated['expected_delivery_date'],
            'collection_point' => $validated['collection_point'],
            'destination_address' => $validated['destination_address'],
            'notes' => $validated['notes'],
        ]);

        // Update order status
        $delivery->order->update(['status' => 'out_for_delivery']);

        return response()->json([
            'success' => true,
            'message' => 'Delivery created successfully!',
            'delivery' => $delivery->load(['order', 'deliveryPersonnel'])
        ]);
    }

    public function show(Delivery $delivery): View
    {
        $delivery->load(['order.user', 'order.orderItems.product', 'deliveryPersonnel']);

        return view('delivery.show', compact('delivery'));
    }

    public function edit(Delivery $delivery): View
    {
        $delivery->load(['order', 'deliveryPersonnel']);
        $personnel = DeliveryPersonnel::where('is_active', true)->get();

        return view('delivery.edit', compact('delivery', 'personnel'));
    }

    public function update(Request $request, Delivery $delivery): JsonResponse
    {
        $validated = $request->validate([
            'delivery_personnel_id' => 'nullable|exists:delivery_personnels,id',
            'status' => 'required|in:Assigned,Picked Up,In Transit,Delivered,Failed,Returned',
            'expected_delivery_date' => 'required|date',
            'actual_delivery_date' => 'nullable|date',
            'collection_point' => 'nullable|string|max:255',
            'destination_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $delivery->update($validated);

        // Update order status based on delivery status
        if ($validated['status'] === 'Delivered') {
            $delivery->order->update(['status' => 'delivered']);
        } elseif ($validated['status'] === 'Failed') {
            $delivery->order->update(['status' => 'delivery_failed']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Delivery updated successfully!',
            'delivery' => $delivery->fresh()->load(['order', 'deliveryPersonnel'])
        ]);
    }

    public function updateStatus(Request $request, Delivery $delivery): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:Assigned,Picked Up,In Transit,Delivered,Failed,Returned',
            'confirmation_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string|max:1000',
        ]);

        $updateData = [
            'status' => $validated['status'],
        ];

        if ($validated['status'] === 'Delivered') {
            $updateData['actual_delivery_date'] = now();

            // Handle confirmation photo upload
            if ($request->hasFile('confirmation_photo')) {
                $photoPath = $request->file('confirmation_photo')->store('delivery_photos', 'public');
                $updateData['confirmation_photo_path'] = basename($photoPath);
            }
        }

        if (isset($validated['notes'])) {
            $updateData['notes'] = $validated['notes'];
        }

        $delivery->update($updateData);

        // Create notification for the customer
        NotificationController::createNotification(
            $delivery->order->user_id,
            'delivery_update',
            "Delivery Status Updated",
            "Your delivery for order #{$delivery->order->id} has been updated to {$validated['status']}.",
            [
                'order_id' => $delivery->order->id,
                'delivery_id' => $delivery->id,
                'status' => $validated['status']
            ]
        );

        // Update order status
        if ($validated['status'] === 'Delivered') {
            $delivery->order->update(['status' => 'delivered']);
        } elseif ($validated['status'] === 'Failed') {
            $delivery->order->update(['status' => 'delivery_failed']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Delivery status updated successfully!',
            'delivery' => $delivery->fresh()
        ]);
    }

    public function destroy(Delivery $delivery)
    {
        // Reset order status
        $delivery->order->update(['status' => 'processing']);

        $delivery->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Delivery deleted successfully!'
            ]);
        }

        return redirect()->route('admin.deliveries.index')
            ->with('success', 'Delivery deleted successfully.');
    }

    // Delivery Personnel Management
    public function personnelIndex(): View
    {
        $personnel = DeliveryPersonnel::orderBy('name')->paginate(15);

        return view('delivery.personnel.index', compact('personnel'));
    }

    public function personnelCreate(): View
    {
        return view('delivery.personnel.create');
    }

    public function personnelStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:delivery_personnels,email',
            'phone' => 'required|string|max:20',
            'is_active' => 'boolean',
        ]);

        $personnel = DeliveryPersonnel::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Delivery personnel added successfully!',
            'personnel' => $personnel
        ]);
    }

    public function personnelEdit(DeliveryPersonnel $deliveryPersonnel): View
    {
        return view('delivery.personnel.edit', compact('deliveryPersonnel'));
    }

    public function personnelUpdate(Request $request, DeliveryPersonnel $deliveryPersonnel): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:delivery_personnels,email,' . $deliveryPersonnel->id,
            'phone' => 'required|string|max:20',
            'is_active' => 'boolean',
        ]);

        $deliveryPersonnel->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Delivery personnel updated successfully!',
            'personnel' => $deliveryPersonnel->fresh()
        ]);
    }

    public function personnelDestroy(DeliveryPersonnel $deliveryPersonnel): JsonResponse
    {
        $deliveryPersonnel->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delivery personnel deleted successfully!'
        ]);
    }

    // Delivery Dashboard
    public function dashboard(): View
    {
        $stats = [
            'total_deliveries' => Delivery::count(),
            'pending_deliveries' => Delivery::whereIn('status', ['Pending Assignment', 'Assigned'])->count(),
            'in_transit' => Delivery::where('status', 'In Transit')->count(),
            'delivered_today' => Delivery::where('status', 'Delivered')
                ->whereDate('actual_delivery_date', today())->count(),
            'active_personnel' => DeliveryPersonnel::where('is_active', true)->count(),
        ];

        $recentDeliveries = Delivery::with(['order.user', 'deliveryPersonnel'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('delivery.dashboard', compact('stats', 'recentDeliveries'));
    }
}
