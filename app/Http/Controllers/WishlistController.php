<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Toggle product in wishlist (add if not present, remove if present).
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user();
        $productId = $request->product_id;

        if ($user->isInWishlist($productId)) {
            // Remove from wishlist
            $user->removeFromWishlist($productId);
            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Product removed from wishlist'
            ]);
        } else {
            // Add to wishlist
            $wishlistItem = $user->addToWishlist($productId);
            return response()->json([
                'success' => true,
                'action' => 'added',
                'message' => 'Product added to wishlist'
            ]);
        }
    }

    /**
     * Display user's wishlist.
     */
    public function index()
    {
        $user = Auth::user();
        $wishlistItems = $user->wishlistItems()
            ->with('product')
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Remove item from wishlist.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user();
        $user->removeFromWishlist($request->product_id);

        return back()->with('success', 'Product removed from wishlist');
    }
}
