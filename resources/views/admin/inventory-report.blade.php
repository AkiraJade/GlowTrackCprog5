@extends('layouts.admin')

@section('title', 'Inventory Report - Admin')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 font-playfair">Inventory Report</h1>
                <p class="text-gray-600 mt-2">Stock levels and inventory management insights</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.reports') }}" class="px-6 py-2 border-2 border-admin-primary text-admin-primary rounded-full hover:bg-admin-primary hover:text-white transition font-semibold">
                    ← Back to Reports
                </a>
                <button onclick="window.print()" class="px-6 py-2 bg-admin-primary text-white rounded-full hover:bg-admin-primary/80 transition font-semibold">
                    🖨️ Print Report
                </button>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-jade-green rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-soft-brown ml-4">Total Products</h3>
                </div>
                <div class="text-3xl font-bold text-jade-green mb-2">
                    {{ $products->count() }}
                </div>
                <p class="text-sm text-soft-brown opacity-75">Active listings</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-yellow-500 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-soft-brown ml-4">Low Stock Items</h3>
                </div>
                <div class="text-3xl font-bold text-yellow-600 mb-2">
                    {{ $lowStockProducts->count() }}
                </div>
                <p class="text-sm text-soft-brown opacity-75">≤ 10 units remaining</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-red-500 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-soft-brown ml-4">Out of Stock</h3>
                </div>
                <div class="text-3xl font-bold text-red-600 mb-2">
                    {{ $outOfStockProducts->count() }}
                </div>
                <p class="text-sm text-soft-brown opacity-75">Need immediate restock</p>
            </div>
        </div>

        <!-- Out of Stock Alert -->
        @if($outOfStockProducts->count() > 0)
            <div class="bg-red-50 border-2 border-red-200 rounded-2xl p-6 mb-8">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <h3 class="text-lg font-bold text-red-800">Out of Stock Products</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($outOfStockProducts->take(6) as $product)
                        <div class="bg-white rounded-lg p-4 border border-red-200">
                            <div class="font-semibold text-gray-900">{{ $product->name }}</div>
                            <div class="text-sm text-gray-500">{{ $product->brand }}</div>
                            <div class="text-sm text-red-600 font-medium mt-1">Seller: {{ $product->seller->name }}</div>
                        </div>
                    @endforeach
                </div>
                @if($outOfStockProducts->count() > 6)
                    <p class="text-sm text-red-700 mt-4">And {{ $outOfStockProducts->count() - 6 }} more products out of stock</p>
                @endif
            </div>
        @endif

        <!-- Low Stock Alert -->
        @if($lowStockProducts->count() > 0)
            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-2xl p-6 mb-8">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <h3 class="text-lg font-bold text-yellow-800">Low Stock Products</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($lowStockProducts->take(6) as $product)
                        <div class="bg-white rounded-lg p-4 border border-yellow-200">
                            <div class="font-semibold text-gray-900">{{ $product->name }}</div>
                            <div class="text-sm text-gray-500">{{ $product->brand }}</div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-sm text-yellow-600 font-medium">{{ $product->quantity }} units left</span>
                                <span class="text-xs text-gray-500">{{ $product->seller->name }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($lowStockProducts->count() > 6)
                    <p class="text-sm text-yellow-700 mt-4">And {{ $lowStockProducts->count() - 6 }} more products with low stock</p>
                @endif
            </div>
        @endif

        <!-- Full Inventory List -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-soft-brown font-playfair">Complete Inventory List</h2>
                <div class="flex gap-2">
                    <input type="text" id="searchInput" placeholder="Search products..." 
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green">
                    <select id="stockFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-jade-green">
                        <option value="">All Stock Levels</option>
                        <option value="out">Out of Stock</option>
                        <option value="low">Low Stock (≤10)</option>
                        <option value="normal">Normal Stock (>10)</option>
                    </select>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seller</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="inventoryTable">
                        @foreach($products as $product)
                            <tr data-stock="{{ $product->quantity }}" data-name="{{ $product->name }}" data-seller="{{ $product->seller->name }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($product->photo_url)
                                            <img src="{{ $product->photo_url }}" alt="{{ $product->name }}" 
                                                 class="w-10 h-10 rounded-lg object-cover object-center mr-3">
                                        @else
                                            <div class="w-10 h-10 bg-gray-200 rounded-lg mr-3 flex items-center justify-center">
                                                <span class="text-gray-400 text-xs">No img</span>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $product->brand }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $product->seller->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $product->seller->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ₱{{ number_format($product->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium 
                                        {{ $product->quantity == 0 ? 'text-red-600' : 
                                           ($product->quantity <= 10 ? 'text-yellow-600' : 'text-gray-900') }}">
                                        {{ $product->quantity }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $product->quantity == 0 ? 'bg-red-100 text-red-800' : 
                                           ($product->quantity <= 10 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                        {{ $product->quantity == 0 ? 'Out of Stock' : 
                                           ($product->quantity <= 10 ? 'Low Stock' : 'In Stock') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('products.show', $product) }}" class="text-jade-green hover:text-jade-green-900">View</a>
                                    @if($product->quantity <= 10)
                                        <a href="mailto:{{ $product->seller->email }}?subject=Low Stock Alert for {{ $product->name }}" 
                                           class="ml-3 text-yellow-600 hover:text-yellow-900">Notify Seller</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchValue = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#inventoryTable tr');
    
    rows.forEach(row => {
        const productName = row.dataset.name.toLowerCase();
        const sellerName = row.dataset.seller.toLowerCase();
        
        if (productName.includes(searchValue) || sellerName.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Stock filter
document.getElementById('stockFilter').addEventListener('change', function(e) {
    const filterValue = e.target.value;
    const rows = document.querySelectorAll('#inventoryTable tr');
    
    rows.forEach(row => {
        const stockLevel = parseInt(row.dataset.stock);
        
        if (!filterValue) {
            row.style.display = '';
        } else if (filterValue === 'out' && stockLevel === 0) {
            row.style.display = '';
        } else if (filterValue === 'low' && stockLevel > 0 && stockLevel <= 10) {
            row.style.display = '';
        } else if (filterValue === 'normal' && stockLevel > 10) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
</div>
</div>
@endsection
