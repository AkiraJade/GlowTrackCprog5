<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'brandPage']);
    }

    /**
     * Display a listing of products with filtering.
     */
    public function index(Request $request)
    {
        $query = Product::query()->approved()->inStock();

        // Search by name or brand
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('brand', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by classification
        if ($request->filled('classification')) {
            $query->byClassification($request->classification);
        }

        // Filter by skin type
        if ($request->filled('skin_type')) {
            $query->bySkinType($request->skin_type);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by ingredients
        if ($request->filled('ingredient')) {
            $query->byIngredient($request->ingredient);
        }

        // Filter by verified sellers only
        if ($request->filled('verified_only')) {
            $query->verified();
        }

        // Sort options
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['name', 'price', 'average_rating', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $products = $query->paginate(12);

        // Get filter options
        $classifications = ['Cleanser', 'Moisturizer', 'Serum', 'Toner', 'Sunscreen', 'Mask', 'Exfoliant', 'Treatment'];
        $skinTypes = ['Oily', 'Dry', 'Combination', 'Sensitive', 'Normal'];
        $ingredients = [
            'Niacinamide', 'Retinol', 'Hyaluronic Acid', 'Vitamin C', 'Salicylic Acid',
            'Glycolic Acid', 'Ceramides', 'Peptides', 'Azelaic Acid', 'Bakuchiol'
        ];

        // Get user's wishlist items if authenticated
        $wishlistProductIds = [];
        if (auth()->check()) {
            $wishlistProductIds = auth()->user()->wishlistItems()->pluck('product_id')->toArray();
        }

        return view('products.index', compact('products', 'classifications', 'skinTypes', 'ingredients', 'wishlistProductIds'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        if (!auth()->user()->isSeller() && !auth()->user()->isAdmin()) {
            abort(403, 'Only sellers and admins can create products.');
        }

        $classifications = ['Cleanser', 'Moisturizer', 'Serum', 'Toner', 'Sunscreen', 'Mask', 'Exfoliant', 'Treatment'];
        $skinTypes = ['Oily', 'Dry', 'Combination', 'Sensitive', 'Normal'];
        
        return view('products.create', compact('classifications', 'skinTypes'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isSeller() && !auth()->user()->isAdmin()) {
            abort(403, 'Only sellers and admins can create products.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'brand' => 'required|string|max:255',
            'classification' => 'required|in:Cleanser,Moisturizer,Serum,Toner,Sunscreen,Mask,Exfoliant,Treatment',
            'price' => 'required|numeric|min:0|max:999999.99',
            'size_volume' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
            'skin_types' => 'required|array|min:1',
            'skin_types.*' => 'in:Oily,Dry,Combination,Sensitive,Normal',
            'active_ingredients' => 'required|array|min:1',
            'active_ingredients.*' => 'string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['seller_id'] = auth()->id();
        $data['status'] = 'pending'; // All new products start as pending

        // Handle single photo upload (for backward compatibility)
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('products', 'public');
            $data['photo'] = $photoPath;
        }

        $product = Product::create($data);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('products', 'public');
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'sort_order' => $index,
                    'is_primary' => $index === 0, // First image is primary
                ]);
            }
        } elseif ($request->hasFile('photo')) {
            // If only single photo was uploaded, create a ProductImage record
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $data['photo'],
                'sort_order' => 0,
                'is_primary' => true,
            ]);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product submitted successfully! It will be reviewed by an administrator.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        if ($product->status !== 'approved') {
            abort(404);
        }

        // Load related data
        $product->load(['seller', 'reviews' => function ($query) {
            $query->with('user')->orderBy('updated_at', 'desc')->take(5);
        }, 'images']);

        // Get current user's review (if any)
        $userReview = null;
        if (auth()->check()) {
            $userReview = Review::where('product_id', $product->id)
                ->where('user_id', auth()->id())
                ->first();
        }

        // Ensure user's review is included in the reviews list
        $reviews = $product->reviews;
        if ($userReview && !$reviews->contains('id', $userReview->id)) {
            $reviews = $reviews->merge([$userReview->load('user')])->sortByDesc('updated_at')->take(5);
        }

        // Can the current user review this product?
        $canReview = auth()->check() && auth()->user()->hasPurchasedProduct($product->id);

        // Get related products
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->approved()
            ->where(function ($query) use ($product) {
                $query->where('classification', $product->classification)
                      ->orWhereJsonContains('skin_types', $product->skin_types);
            })
            ->inStock()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts', 'userReview', 'reviews', 'canReview'));
    }

    /**
     * Store a new or updated review for a product.
     */
    public function storeReview(Request $request, Product $product)
    {
        if ($product->status !== 'approved') {
            abort(404);
        }

        $existingReview = Review::where('product_id', $product->id)
            ->where('user_id', auth()->id())
            ->first();

        if (!auth()->user()->hasPurchasedProduct($product->id)) {
            return redirect()->route('products.show', $product)
                ->with('error', 'You can only review products you have purchased.');
        }

        if ($existingReview) {
            // Updating existing review
            $request->validate([
                'rating' => 'nullable|integer|min:1|max:5',
                'comment' => 'required|string|max:2000',
            ]);

            $data = ['comment' => $request->comment];
            if ($request->filled('rating')) {
                $data['rating'] = $request->rating;
            }

            $existingReview->update($data);
        } else {
            // Creating new review
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string|max:2000',
            ]);

            Review::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
        }

        return redirect()->route('products.show', $product)
            ->with('success', 'Your review has been submitted.');
    }

    /**
     * Delete the user's review for a product.
     */
    public function deleteReview(Product $product)
    {
        if ($product->status !== 'approved') {
            abort(404);
        }

        $review = Review::where('product_id', $product->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($review) {
            $review->delete();
        }

        return redirect()->route('products.show', $product)
            ->with('success', 'Your review has been deleted.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        // Check if user can edit this product
        if (auth()->id() !== $product->seller_id && !auth()->user()->isAdmin()) {
            abort(403, 'You can only edit your own products.');
        }

        $classifications = ['Cleanser', 'Moisturizer', 'Serum', 'Toner', 'Sunscreen', 'Mask', 'Exfoliant', 'Treatment'];
        $skinTypes = ['Oily', 'Dry', 'Combination', 'Sensitive', 'Normal'];
        
        // Load product images
        $product->load('images');
        
        return view('products.edit', compact('product', 'classifications', 'skinTypes'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        // Check if user can edit this product
        if (auth()->id() !== $product->seller_id && !auth()->user()->isAdmin()) {
            abort(403, 'You can only edit your own products.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'brand' => 'required|string|max:255',
            'classification' => 'required|in:Cleanser,Moisturizer,Serum,Toner,Sunscreen,Mask,Exfoliant,Treatment',
            'price' => 'required|numeric|min:0|max:999999.99',
            'size_volume' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
            'skin_types' => 'required|array|min:1',
            'skin_types.*' => 'in:Oily,Dry,Combination,Sensitive,Normal',
            'active_ingredients' => 'required|array|min:1',
            'active_ingredients.*' => 'string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer',
        ]);

        $data = $request->all();

        // Handle photo upload (for backward compatibility)
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($product->photo) {
                Storage::disk('public')->delete($product->photo);
            }
            
            $photo = $request->file('photo');
            $photoPath = $photo->store('products', 'public');
            $data['photo'] = $photoPath;
        }

        // Handle removing images
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imageId) {
                $image = $product->images()->find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $maxSortOrder = $product->images()->max('sort_order') ?? 0;
            
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('products', 'public');
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'sort_order' => $maxSortOrder + $index + 1,
                    'is_primary' => false, // Don't change primary on update
                ]);
            }
        }

        // Handle setting primary image
        if ($request->has('primary_image')) {
            // Reset all images to non-primary
            $product->images()->update(['is_primary' => false]);
            
            // Set new primary image
            $primaryImage = $product->images()->find($request->primary_image);
            if ($primaryImage) {
                $primaryImage->update(['is_primary' => true]);
            }
        }

        // Reset status to pending if product was previously approved
        if ($product->status === 'approved') {
            $data['status'] = 'pending';
        }

        $product->update($data);

        return redirect()->route('products.show', $product)
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        // Check if user can delete this product
        if (auth()->id() !== $product->seller_id && !auth()->user()->isAdmin()) {
            abort(403, 'You can only delete your own products.');
        }

        // Delete photo if exists
        if ($product->photo) {
            Storage::disk('public')->delete($product->photo);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Display seller's products (legacy route - redirects to seller routes).
     */
    public function myProducts(Request $request)
    {
        if (!auth()->user()->isSeller() && !auth()->user()->isAdmin()) {
            abort(403, 'Only sellers and admins can view their products.');
        }

        // Redirect sellers to the new seller-specific route
        if (auth()->user()->isSeller()) {
            return redirect()->route('seller.products.index');
        }

        // Admins can use the old view for now
        $products = Product::where('seller_id', auth()->id())
            ->withCount('reviews')
            ->latest()
            ->paginate(10);

        return view('products.my-products', compact('products'));
    }

    // Seller-specific product management methods
    /**
     * Display seller's products management page.
     */
    public function sellerIndex(Request $request)
    {
        if (!auth()->user()->isSeller() && !auth()->user()->isAdmin()) {
            abort(403, 'Only sellers and admins can view their products.');
        }

        $products = Product::where('seller_id', auth()->id())
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->latest()
            ->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product for sellers.
     */
    public function sellerCreate()
    {
        if (!auth()->user()->isSeller() && !auth()->user()->isAdmin()) {
            abort(403, 'Only sellers and admins can create products.');
        }

        $classifications = ['Cleanser', 'Moisturizer', 'Serum', 'Toner', 'Sunscreen', 'Mask', 'Exfoliant', 'Treatment'];
        $skinTypes = ['Oily', 'Dry', 'Combination', 'Sensitive', 'Normal'];
        
        return view('seller.products.create', compact('classifications', 'skinTypes'));
    }

    /**
     * Store a newly created product for sellers.
     */
    public function sellerStore(Request $request)
    {
        if (!auth()->user()->isSeller() && !auth()->user()->isAdmin()) {
            abort(403, 'Only sellers and admins can create products.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'brand' => 'required|string|max:255',
            'classification' => 'required|in:Cleanser,Moisturizer,Serum,Toner,Sunscreen,Mask,Exfoliant,Treatment',
            'price' => 'required|numeric|min:0|max:999999.99',
            'size_volume' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
            'skin_types' => 'required|array|min:1',
            'skin_types.*' => 'in:Oily,Dry,Combination,Sensitive,Normal',
            'active_ingredients' => 'required|array|min:1',
            'active_ingredients.*' => 'string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['seller_id'] = auth()->id();
        $data['status'] = 'pending'; // All new products start as pending

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('products', 'public');
            $data['photo'] = $photoPath;
        }

        Product::create($data);

        return redirect()->route('seller.products.index')
            ->with('success', 'Product submitted successfully! It will be reviewed by an administrator.');
    }

    /**
     * Show the form for editing the specified product for sellers.
     */
    public function sellerEdit(Product $product)
    {
        // Check if user can edit this product
        if (auth()->id() !== $product->seller_id && !auth()->user()->isAdmin()) {
            abort(403, 'You can only edit your own products.');
        }

        $classifications = ['Cleanser', 'Moisturizer', 'Serum', 'Toner', 'Sunscreen', 'Mask', 'Exfoliant', 'Treatment'];
        $skinTypes = ['Oily', 'Dry', 'Combination', 'Sensitive', 'Normal'];
        
        return view('seller.products.edit', compact('product', 'classifications', 'skinTypes'));
    }

    /**
     * Update the specified product for sellers.
     */
    public function sellerUpdate(Request $request, Product $product)
    {
        // Check if user can edit this product
        if (auth()->id() !== $product->seller_id && !auth()->user()->isAdmin()) {
            abort(403, 'You can only edit your own products.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'brand' => 'required|string|max:255',
            'classification' => 'required|in:Cleanser,Moisturizer,Serum,Toner,Sunscreen,Mask,Exfoliant,Treatment',
            'price' => 'required|numeric|min:0|max:999999.99',
            'size_volume' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
            'skin_types' => 'required|array|min:1',
            'skin_types.*' => 'in:Oily,Dry,Combination,Sensitive,Normal',
            'active_ingredients' => 'required|array|min:1',
            'active_ingredients.*' => 'string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($product->photo) {
                Storage::disk('public')->delete($product->photo);
            }
            
            $photo = $request->file('photo');
            $photoPath = $photo->store('products', 'public');
            $data['photo'] = $photoPath;
        }

        // Reset status to pending if product was previously approved
        if ($product->status === 'approved') {
            $data['status'] = 'pending';
        }

        $product->update($data);

        return redirect()->route('seller.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product for sellers.
     */
    public function sellerDestroy(Product $product)
    {
        // Check if user can delete this product
        if (auth()->id() !== $product->seller_id && !auth()->user()->isAdmin()) {
            abort(403, 'You can only delete your own products.');
        }

        // Delete photo if exists
        if ($product->photo) {
            Storage::disk('public')->delete($product->photo);
        }

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Display seller brand page.
     */
    public function brandPage(User $seller)
    {
        // Only show brand pages for verified sellers
        if (!$seller->isSeller() || !$seller->sellerApplication || $seller->sellerApplication->status !== 'approved') {
            abort(404, 'Seller not found or not verified.');
        }

        $products = Product::where('seller_id', $seller->id)
            ->where('status', 'approved')
            ->with(['reviews'])
            ->latest()
            ->paginate(12);

        // Calculate seller statistics
        $stats = [
            'total_products' => $products->total(),
            'total_reviews' => $seller->products()->withCount('reviews')->get()->sum('reviews_count'),
            'average_rating' => $seller->products()->where('status', 'approved')->avg('average_rating') ?: 0,
            'total_sales' => \App\Models\Order::whereHas('orderItems.product', function($query) use ($seller) {
                $query->where('seller_id', $seller->id);
            })->where('status', '!=', 'cancelled')->sum('total_amount'),
        ];

        // Get featured products (highest rated)
        $featuredProducts = Product::where('seller_id', $seller->id)
            ->where('status', 'approved')
            ->where('average_rating', '>', 0)
            ->orderBy('average_rating', 'desc')
            ->take(3)
            ->get();

        return view('brand.show', compact('seller', 'products', 'stats', 'featuredProducts'));
    }
}
