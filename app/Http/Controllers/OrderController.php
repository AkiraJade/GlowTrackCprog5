<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusNotification;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display customer's order history.
     */
    public function index(Request $request)
    {
        // Admins can see all orders, customers can only see their own
        if (auth()->user()->isAdmin()) {
            $orders = Order::with(['orderItems.product', 'orderItems.product.seller'])
                ->latest()
                ->paginate(10);
        } else {
            $orders = Order::where('user_id', auth()->id())
                ->with(['orderItems.product', 'orderItems.product.seller'])
                ->latest()
                ->paginate(10);
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Display seller's orders (only orders containing their products).
     */
    public function sellerOrders(Request $request)
    {
        $query = Order::whereHas('orderItems.product', function($query) {
            $query->where('seller_id', auth()->id());
        })->with(['user', 'orderItems.product' => function($query) {
            $query->where('seller_id', auth()->id());
        }]);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('order_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('order_date', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(10);
        $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];

        return view('seller.orders.index', compact('orders', 'statuses'));
    }

    /**
     * Display specific order details for seller.
     */
    public function sellerShow(Order $order)
    {
        // Check if order contains seller's products
        $hasSellerProducts = $order->orderItems()->whereHas('product', function($query) {
            $query->where('seller_id', auth()->id());
        })->exists();

        if (!$hasSellerProducts) {
            abort(403, 'Unauthorized action.');
        }

        $order->load(['user', 'orderItems.product' => function($query) {
            $query->where('seller_id', auth()->id());
        }]);

        return view('seller.orders.show', compact('order'));
    }

    /**
     * Update order status (for sellers).
     */
    public function sellerUpdateStatus(Order $order, Request $request)
    {
        // Check if order contains seller's products
        $hasSellerProducts = $order->orderItems()->whereHas('product', function($query) {
            $query->where('seller_id', auth()->id());
        })->exists();

        if (!$hasSellerProducts) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:confirmed,processing,shipped',
            'notes' => 'nullable|string|max:500',
        ]);

        // Validate status transitions
        $validTransitions = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['processing', 'cancelled'],
            'processing' => ['shipped'],
            'shipped' => ['delivered'],
        ];

        $currentStatus = $order->status;
        $newStatus = $request->status;

        if (!isset($validTransitions[$currentStatus]) || !in_array($newStatus, $validTransitions[$currentStatus])) {
            return redirect()->back()->with('error', 'Invalid status transition.');
        }

        $order->update([
            'status' => $newStatus,
            'notes' => $request->notes ? $request->notes : $order->notes,
        ]);

        // Send email notification to customer
        try {
            Mail::to($order->user->email)->send(new OrderStatusNotification($order->user, $order, $newStatus));
            \Log::info('Order status email sent', [
                'order_id' => $order->id,
                'status' => $newStatus,
                'email' => $order->user->email
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send order status email', [
                'order_id' => $order->id,
                'status' => $newStatus,
                'error' => $e->getMessage()
            ]);
        }

        // Create notification for the customer
        NotificationController::createNotification(
            $order->user_id,
            'order_status',
            "Order Status Updated",
            "Your order #{$order->id} has been updated to {$newStatus}.",
            [
                'order_id' => $order->id,
                'status' => $newStatus,
                'total_amount' => $order->total_amount
            ]
        );

        return redirect()->route('seller.orders.show', $order)
            ->with('success', "Order status updated to {$newStatus}.");
    }

    /**
     * Prepare order for shipment.
     */
    public function sellerPrepareShipment(Order $order, Request $request)
    {
        // Check if order contains seller's products
        $hasSellerProducts = $order->orderItems()->whereHas('product', function($query) {
            $query->where('seller_id', auth()->id());
        })->exists();

        if (!$hasSellerProducts) {
            abort(403, 'Unauthorized action.');
        }

        if ($order->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Order must be confirmed before preparing for shipment.');
        }

        $request->validate([
            'tracking_number' => 'nullable|string|max:100',
            'shipping_notes' => 'nullable|string|max:500',
        ]);

        $order->update([
            'status' => 'processing',
            'notes' => ($order->notes ? $order->notes . "\n" : '') . 
                      "Prepared for shipment. " . 
                      ($request->tracking_number ? "Tracking: {$request->tracking_number}. " : "") .
                      ($request->shipping_notes ? $request->shipping_notes : ""),
        ]);

        return redirect()->route('seller.orders.show', $order)
            ->with('success', 'Order prepared for shipment.');
    }

    /**
     * Display specific order details.
     */
    public function show(Order $order)
    {
        // Allow admins to view all orders, customers can only view their own
        if (!auth()->user()->isAdmin() && $order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load(['orderItems.product', 'orderItems.product.seller']);

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order.
     */
    public function cancel(Order $order, Request $request)
    {
        // Ensure user can only cancel their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow cancellation for pending or confirmed orders
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return redirect()->back()->with('error', 'This order cannot be cancelled.');
        }

        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        // Update order status
        $order->update([
            'status' => 'cancelled',
            'notes' => 'Cancelled by customer: ' . $request->reason,
        ]);

        // Create notification for the customer
        \App\Http\Controllers\NotificationController::createNotification(
            $order->user_id,
            'order_status',
            "Order Cancelled",
            "Your order #{$order->id} has been cancelled.",
            [
                'order_id' => $order->id,
                'status' => 'cancelled',
                'reason' => $request->reason
            ]
        );

        // Send email notification to customer
        try {
            Mail::to($order->user->email)->send(new \App\Mail\OrderCancellationEmail($order->user, $order, $request->reason));
            \Log::info('Order cancellation email sent', [
                'order_id' => $order->id,
                'email' => $order->user->email
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send order cancellation email', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }

        // Restore product quantities
        foreach ($order->orderItems as $item) {
            $product = $item->product;
            $product->adjustStock($item->quantity, 'return', 'order', $order->id, 'Order cancelled by customer');
        }

        return redirect()->route('orders.index')
            ->with('success', 'Order cancelled successfully. Items have been returned to stock.');
    }
}
