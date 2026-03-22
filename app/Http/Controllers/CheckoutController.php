<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Services\PDFReceiptService;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display checkout page.
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Add some items before checkout.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $shipping = 10.00; // Fixed shipping cost
        $tax = $subtotal * 0.08; // 8% tax
        $total = $subtotal + $shipping + $tax;

        return view('checkout.index', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    /**
     * Process the checkout.
     */
    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,card',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $shipping = 10.00;
        $tax = $subtotal * 0.08;
        $total = $subtotal + $shipping + $tax;

        try {
            DB::beginTransaction();

            Log::info('Checkout started', [
                'user_id' => Auth::id(),
                'cart_items_count' => $cartItems->count(),
                'subtotal' => $subtotal,
                'total' => $total,
            ]);

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'confirmed',
                'shipping_address' => $request->shipping_address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'phone' => $request->phone,
                'payment_method' => $request->payment_method,
                'order_date' => now(),
            ]);

            Log::info('Order created', ['order_id' => $order->id]);

            // Send order confirmation email with PDF receipt
            try {
                $pdfService = new PDFReceiptService();
                $pdfReceipt = $pdfService->generateReceipt($order);
                
                Mail::to($order->user->email)->send(new \App\Mail\OrderConfirmationEmail($order, $pdfReceipt));
                
                Log::info('Order confirmation email sent', [
                    'order_id' => $order->id,
                    'user_email' => $order->user->email,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send order confirmation email', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
            }

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'total' => $cartItem->price * $cartItem->quantity,
                ]);
            }

            Log::info('Order items created', ['order_id' => $order->id]);

            // Clear cart (stock is already managed by cart system)
            Cart::where('user_id', Auth::id())->delete();

            // Calculate and award loyalty points based on total quantity
            $totalQuantity = 0;
            foreach ($cartItems as $cartItem) {
                $totalQuantity += $cartItem->quantity;
            }
            
            $loyaltyPoints = User::calculateLoyaltyPoints($totalQuantity);
            $user = Auth::user();
            $user->addLoyaltyPoints($loyaltyPoints);

            Log::info('Loyalty points awarded', [
                'user_id' => Auth::id(),
                'total_quantity' => $totalQuantity,
                'points_awarded' => $loyaltyPoints,
                'order_id' => $order->id,
            ]);

            DB::commit();

            Log::info('Checkout completed successfully', ['order_id' => $order->id]);

            return redirect()->route('checkout.success', $order)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout exception', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()
                ->with('error', 'Order error: ' . $e->getMessage());
        }
    }

    /**
     * Display order success page.
     */
    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load('orderItems.product');

        // Calculate loyalty points earned for this order
        $totalQuantity = $order->orderItems->sum('quantity');
        $loyaltyPointsEarned = User::calculateLoyaltyPoints($totalQuantity);

        return view('checkout.success', compact('order', 'loyaltyPointsEarned'));
    }
}
