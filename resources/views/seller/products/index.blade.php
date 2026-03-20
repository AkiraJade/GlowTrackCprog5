@extends('layouts.app')

@section('title', 'My Products - Seller Dashboard - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white rounded-3xl shadow-xl p-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-bold text-soft-brown font-playfair mb-3">
                            My Products 🛍️
                        </h1>
                        <p class="text-lg text-soft-brown opacity-75">
                            Manage your skincare product inventory
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('seller.products.create') }}" class="px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                            + Add New Product
                        </a>
                        <a href="{{ route('seller.dashboard') }}" class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                            ← Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Stats -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Products -->
                <div class="text-center">
                    <div class="text-3xl font-bold text-jade-green mb-2">{{ $products->total() }}</div>
                    <div class="text-sm text-soft-brown opacity-75">Total Products</div>
                </div>
                
                <!-- Approved Products -->
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-600 mb-2">
                        {{ $products->where('status', 'approved')->count() }}
                    </div>
                    <div class="text-sm text-soft-brown opacity-75">Approved</div>
                </div>
                
                <!-- Pending Products -->
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-600 mb-2">
                        {{ $products->where('status', 'pending')->count() }}
                    </div>
                    <div class="text-sm text-soft-brown opacity-75">Pending Review</div>
                </div>
                
                <!-- Out of Stock -->
                <div class="text-center">
                    <div class="text-3xl font-bold text-red-600 mb-2">
                        {{ $products->where('quantity', 0)->count() }}
                    </div>
                    <div class="text-sm text-soft-brown opacity-75">Out of Stock</div>
                </div>
            </div>
        </div>

        <!-- Products List -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            @if($products->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-soft-brown">Product</th>
                                <th class="text-left py-3 px-4 font-semibold text-soft-brown">Category</th>
                                <th class="text-left py-3 px-4 font-semibold text-soft-brown">Price</th>
                                <th class="text-left py-3 px-4 font-semibold text-soft-brown">Stock</th>
                                <th class="text-left py-3 px-4 font-semibold text-soft-brown">Status</th>
                                <th class="text-left py-3 px-4 font-semibold text-soft-brown">Reviews</th>
                                <th class="text-center py-3 px-4 font-semibold text-soft-brown">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            @if($product->photo)
                                                <img src="{{ asset('storage/' . $product->photo) }}" 
                                                     alt="{{ $product->name }}" 
                                                     class="w-12 h-12 object-cover object-center rounded-lg">
                                            @else
                                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <span class="text-gray-400 text-xs">No img</span>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-semibold text-soft-brown">{{ $product->name }}</div>
                                                <div class="text-sm text-soft-brown opacity-60">{{ $product->brand }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                            {{ $product->classification }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="font-bold text-jade-green">${{ number_format($product->price, 2) }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="font-medium {{ $product->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $product->quantity }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            {{ $product->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                               ($product->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm text-soft-brown">{{ $product->reviews_count ?? 0 }}</span>
                                            @if($product->average_rating > 0)
                                                <span class="text-yellow-500">★</span>
                                                <span class="text-sm">{{ number_format($product->average_rating, 1) }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button onclick="showRestockForm({{ $product->id }}, {{ $product->quantity }}, '{{ $product->name }}')" 
                                                    class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition"
                                                    title="Restock Product">
                                                📦
                                            </button>
                                            <a href="{{ route('seller.products.edit', $product) }}" 
                                               class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                               title="Edit Product">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('seller.products.destroy', $product) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                                        onclick="return confirm('Are you sure you want to delete this product?')"
                                                        title="Delete Product">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
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
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="text-6xl mb-4 opacity-50">📦</div>
                    <h3 class="text-2xl font-bold text-soft-brown mb-2">No products yet</h3>
                    <p class="text-soft-brown opacity-75 mb-6">Start adding your skincare products to begin selling!</p>
                    <a href="{{ route('seller.products.create') }}" class="inline-block px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                        + Add Your First Product
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Restock Product Modal -->
<div id="restockModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-soft-brown mb-4">Restock Product</h3>
        <form id="restockForm" action="{{ route('seller.products.restock') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" id="restockProductId">
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-2">Product: <span id="restockProductName" class="font-semibold"></span></p>
                <p class="text-sm text-gray-600 mb-4">Current Stock: <span id="restockCurrentStock" class="font-semibold"></span></p>
                <label class="block text-sm font-medium text-soft-brown mb-2">Add Quantity:</label>
                <input type="number" name="add_quantity" min="1" max="9999" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-jade-green"
                       placeholder="Enter quantity to add">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-soft-brown mb-2">Notes (Optional):</label>
                <textarea name="restock_notes" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-jade-green" 
                          placeholder="Add any notes about this restock"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    Restock Product
                </button>
                <button type="button" onclick="hideRestockForm()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showRestockForm(productId, currentStock, productName) {
    document.getElementById('restockProductId').value = productId;
    document.getElementById('restockProductName').textContent = productName;
    document.getElementById('restockCurrentStock').textContent = currentStock;
    document.getElementById('restockModal').classList.remove('hidden');
}

function hideRestockForm() {
    document.getElementById('restockModal').classList.add('hidden');
    document.getElementById('restockForm').reset();
}
</script>
@endsection
