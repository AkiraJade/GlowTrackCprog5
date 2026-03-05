<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

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

        // Restore product quantities
        foreach ($order->orderItems as $item) {
            $product = $item->product;
            $product->increment('quantity', $item->quantity);
        }

        return redirect()->route('orders.index')
            ->with('success', 'Order cancelled successfully. Items have been returned to stock.');
    }
}
