<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
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

        return view('products.index', compact('products', 'classifications', 'skinTypes', 'ingredients'));
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
            $query->latest()->take(5);
        }]);

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

        return view('products.show', compact('product', 'relatedProducts'));
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
     * Display seller's products.
     */
    public function myProducts(Request $request)
    {
        if (!auth()->user()->isSeller() && !auth()->user()->isAdmin()) {
            abort(403, 'Only sellers and admins can view their products.');
        }

        $products = Product::where('seller_id', auth()->id())
            ->withCount('reviews')
            ->latest()
            ->paginate(10);

        return view('products.my-products', compact('products'));
    }
}
