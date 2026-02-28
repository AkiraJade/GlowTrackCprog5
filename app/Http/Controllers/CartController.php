<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display cart contents.
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add a product to cart.
     */
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->quantity,
        ]);

        // Check if product is in stock
        if ($product->quantity < $request->quantity) {
            return redirect()->back()
                ->with('error', 'Not enough stock available.');
        }

        // Check if item already exists in cart
        $existingItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingItem) {
            // Update existing item
            $newQuantity = $existingItem->quantity + $request->quantity;
            if ($newQuantity > $product->quantity) {
                return redirect()->back()
                    ->with('error', 'Not enough stock available.');
            }
            $existingItem->update(['quantity' => $newQuantity]);
        } else {
            // Add new item
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        // Reduce product stock
        $product->decrement('quantity', $request->quantity);

        return redirect()->route('cart.index')
            ->with('success', 'Product added to cart successfully!');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $oldQuantity = $cart->quantity;
        $newQuantity = $request->quantity;

        // Calculate stock difference
        $difference = $oldQuantity - $newQuantity;

        if ($difference > 0) {
            // User reduced quantity - restore stock
            $cart->product->increment('quantity', $difference);
        } else {
            // User increased quantity - check if enough stock available
            $neededStock = abs($difference);
            if ($cart->product->quantity < $neededStock) {
                return redirect()->back()
                    ->with('error', 'Not enough stock available.');
            }
            $cart->product->decrement('quantity', $neededStock);
        }

        $cart->update(['quantity' => $newQuantity]);

        return redirect()->route('cart.index')
            ->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove item from cart.
     */
    public function remove(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Restore stock to product
        $cart->product->increment('quantity', $cart->quantity);

        $cart->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Item removed from cart!');
    }

    /**
     * Clear entire cart.
     */
    public function clear()
    {
        // Get all cart items for this user
        $cartItems = Cart::where('user_id', Auth::id())->get();

        // Restore stock for all items
        foreach ($cartItems as $item) {
            $item->product->increment('quantity', $item->quantity);
        }

        // Clear cart
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Cart cleared successfully!');
    }
}
