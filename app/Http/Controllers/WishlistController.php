<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
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
    public function toggle(Request $request, $product)
    {
        try {
            $productId = $product;
            
            // Validate product exists
            $productExists = Product::find($productId);
            if (!$productExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

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
        } catch (\Exception $e) {
            \Log::error('Wishlist toggle error: ' . $e->getMessage(), [
                'product_id' => $product,
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error updating wishlist: ' . $e->getMessage()
            ], 500);
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
