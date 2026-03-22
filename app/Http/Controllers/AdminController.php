<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SellerApplication;
use App\Models\ForumDiscussion;
use App\Models\ForumReply;
use App\Models\Notification;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesReportExport;
use App\Exports\InventoryReportExport;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_sellers' => User::where('role', 'seller')->count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_products' => Product::count(),
            'pending_products' => Product::where('status', 'pending')->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
            'pending_seller_applications' => SellerApplication::where('status', 'pending')->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $pendingProducts = Product::with('seller')->where('status', 'pending')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentOrders', 'pendingProducts'));
    }

    /**
     * Display all users
     */
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    /**
     * Show user details
     */
    public function showUser(User $user)
    {
        $warningLogs = $user->notifications()->where('type', 'user_warning')->latest()->get();

        return view('admin.user-details', compact('user', 'warningLogs'));
    }

    /**
     * Update user status (active/inactive)
     */
    public function updateUserStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $user->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'User status updated successfully.');
    }

    /**
     * Update user role
     */
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,seller,customer',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'User role updated successfully.');
    }

    /**
     * Delete user (soft delete)
     */
    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    /**
     * Display all products for admin management
     */
    public function products()
    {
        $products = Product::with('seller')->latest()->paginate(10);
        return view('admin.products', compact('products'));
    }

    /**
     * Approve a product
     */
    public function approveProduct(Product $product)
    {
        $product->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Product approved successfully.');
    }

    /**
     * Reject a product
     */
    public function rejectProduct(Request $request, Product $product)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255'
        ]);

        $product->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        return redirect()->back()->with('success', 'Product rejected successfully.');
    }

    /**
     * Restock a product
     */
    public function restockProduct(Request $request, Product $product)
    {
        $request->validate([
            'add_quantity' => 'required|integer|min:1|max:9999',
            'restock_notes' => 'nullable|string|max:255'
        ]);

        $oldQuantity = $product->quantity;
        $addedQuantity = $request->add_quantity;
        
        $product->adjustStock(
            $addedQuantity,
            'restock',
            'manual',
            null,
            $request->restock_notes
        );
        $newQuantity = $product->quantity;

        // Log the restock activity
        \Log::info('Product restocked by admin', [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'old_quantity' => $oldQuantity,
            'added_quantity' => $request->add_quantity,
            'new_quantity' => $newQuantity,
            'admin_id' => auth()->id(),
            'notes' => $request->restock_notes
        ]);

        return redirect()->back()->with('success', 
            "Product '{$product->name}' restocked successfully! Stock increased from {$oldQuantity} to {$newQuantity}."
        );
    }

    /**
     * Display all orders for admin management
     */
    public function orders()
    {
        $orders = Order::with('user', 'orderItems.product')->latest()->paginate(10);
        return view('admin.orders', compact('orders'));
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled'
        ]);

        $previousStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Create notification for the customer
        \App\Http\Controllers\NotificationController::createNotification(
            $order->user_id,
            'order_status',
            "Order Status Updated",
            "Your order #{$order->id} has been updated to {$request->status}.",
            [
                'order_id' => $order->id,
                'status' => $request->status,
                'previous_status' => $previousStatus
            ]
        );

        // Send email notification about status update
        $pdfService = new \App\Services\PDFReceiptService();
        $pdfService->sendOrderStatusUpdateEmail($order, $previousStatus);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully and customer notified.'
            ]);
        }

        return redirect()->back()->with('success', 'Order status updated successfully and customer notified.');
    }

    /**
     * Display reports page
     */
    public function reports()
    {
        return view('admin.reports');
    }

    /**
     * Display forum moderation for admins
     */
    public function forumModeration(Request $request)
    {
        $query = ForumDiscussion::with(['user', 'replies.user'])->orderBy('is_pinned', 'desc')->orderBy('last_reply_at', 'desc');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_locked', $request->status === 'locked');
        }

        $discussions = $query->paginate(10);

        return view('admin.forum-moderation', compact('discussions'));
    }

    /**
     * Delete a forum discussion (admin)
     */
    public function deleteForumDiscussion(ForumDiscussion $discussion)
    {
        $discussion->delete();

        return redirect()->route('admin.forum-moderation')->with('success', 'Discussion deleted successfully.');
    }

    /**
     * Delete a forum reply (admin)
     */
    public function deleteForumReply(ForumReply $reply)
    {
        $discussion = $reply->discussion;
        $reply->delete();

        if ($discussion) {
            $discussion->decrement('reply_count');
        }

        return back()->with('success', 'Reply deleted successfully.');
    }

    /**
     * Warn a forum user (admin) with notification
     */
    public function warnUser(Request $request, User $user)
    {
        $data = $request->validate([
            'message' => 'required|string|max:500',
        ]);

        Notification::create([
            'user_id' => $user->id,
            'type' => 'user_warning',
            'title' => 'Community Guideline Warning',
            'message' => $data['message'],
        ]);

        return back()->with('success', 'Warning sent to user and notification created.');
    }

    /**
     * List admin viewing of notifications
     */
    public function notifications()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(15);
        return view('admin.notifications', compact('notifications'));
    }

    /**
     * Generate sales report
     */
    public function salesReport(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $productId = $request->input('product_id');
        $brand = $request->input('brand');
        $productCategory = $request->input('product_category');
        $sellerId = $request->input('seller_id');

        $query = Order::whereBetween('order_date', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->with(['orderItems.product', 'user']);

        // Filter by specific product
        if ($productId) {
            $query->whereHas('orderItems', function($q) use ($productId) {
                $q->where('product_id', $productId);
            });
        }

        // Filter by brand
        if ($brand) {
            $query->whereHas('orderItems.product', function($q) use ($brand) {
                $q->where('brand', $brand);
            });
        }

        // Filter by product category
        if ($productCategory) {
            $query->whereHas('orderItems.product', function($q) use ($productCategory) {
                $q->where('classification', $productCategory);
            });
        }

        // Filter by seller
        if ($sellerId) {
            $query->whereHas('orderItems.product', function($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            });
        }

        $orders = $query->get();

        // Calculate basic metrics
        $totalRevenue = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $totalUnitsSold = $orders->sum(function($order) {
            return $order->orderItems->sum('quantity');
        });

        // Top products by revenue and units sold
        $topProductsQuery = OrderItem::whereHas('order', function($query) use ($startDate, $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate])
                  ->where('status', '!=', 'cancelled');
        });

        if ($brand) {
            $topProductsQuery->whereHas('product', function($q) use ($brand) {
                $q->where('brand', $brand);
            });
        }

        if ($productCategory) {
            $topProductsQuery->whereHas('product', function($q) use ($productCategory) {
                $q->where('classification', $productCategory);
            });
        }

        if ($sellerId) {
            $topProductsQuery->whereHas('product', function($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            });
        }

        $topProducts = $topProductsQuery->with('product')
            ->selectRaw('product_id, SUM(quantity) as total_sold, SUM(price * quantity) as total_revenue, AVG(price) as avg_price')
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();

        // Top brands by revenue
        $topBrands = OrderItem::whereHas('order', function($query) use ($startDate, $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate])
                  ->where('status', '!=', 'cancelled');
        })
        ->whereHas('product', function($q) use ($sellerId) {
            if ($sellerId) {
                $q->where('seller_id', $sellerId);
            }
        })
        ->with('product')
        ->selectRaw('products.brand, SUM(order_items.quantity) as total_sold, SUM(order_items.price * order_items.quantity) as total_revenue')
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->groupBy('products.brand')
        ->orderByDesc('total_revenue')
        ->limit(10)
        ->get();

        // Top sellers by revenue
        $topSellers = OrderItem::whereHas('order', function($query) use ($startDate, $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate])
                  ->where('status', '!=', 'cancelled');
        })
        ->with('product.seller')
        ->selectRaw('products.seller_id, SUM(order_items.quantity) as total_sold, SUM(order_items.price * order_items.quantity) as total_revenue')
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->groupBy('products.seller_id')
        ->orderByDesc('total_revenue')
        ->limit(10)
        ->get();

        // Sales by category
        $salesByCategory = OrderItem::whereHas('order', function($query) use ($startDate, $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate])
                  ->where('status', '!=', 'cancelled');
        })
        ->whereHas('product', function($q) use ($sellerId) {
            if ($sellerId) {
                $q->where('seller_id', $sellerId);
            }
        })
        ->with('product')
        ->selectRaw('products.classification, SUM(order_items.quantity) as total_sold, SUM(order_items.price * order_items.quantity) as total_revenue')
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->groupBy('products.classification')
        ->orderByDesc('total_revenue')
        ->get();

        // Daily sales trend
        $dailySales = Order::whereBetween('order_date', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->selectRaw('DATE(order_date) as date, COUNT(*) as orders, SUM(total_amount) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get filter options
        $products = Product::where('status', 'approved')->orderBy('name')->pluck('name', 'id');
        $brands = Product::where('status', 'approved')->distinct()->pluck('brand', 'brand');
        $categories = ['Cleanser', 'Moisturizer', 'Serum', 'Toner', 'Sunscreen', 'Mask', 'Exfoliant', 'Treatment'];
        $sellers = User::where('role', 'seller')->orderBy('name')->pluck('name', 'id');

        return view('admin.sales-report', compact(
            'orders', 'totalRevenue', 'totalOrders', 'averageOrderValue', 'totalUnitsSold',
            'topProducts', 'topBrands', 'topSellers', 'salesByCategory', 'dailySales',
            'startDate', 'endDate', 'productId', 'brand', 'productCategory', 'sellerId',
            'products', 'brands', 'categories', 'sellers'
        ));
    }

    /**
     * Generate inventory report
     */
    public function inventoryReport(Request $request)
    {
        $stockFilter = $request->input('stock_filter', 'all'); // all, low_stock, out_of_stock
        $expiryFilter = $request->input('expiry_filter', 'all'); // all, expired, expiring_soon
        $sellerId = $request->input('seller_id');
        $category = $request->input('category');

        $query = Product::with('seller');

        // Filter by stock status
        if ($stockFilter === 'low_stock') {
            $query->where('quantity', '>', 0)->where('quantity', '<=', 5);
        } elseif ($stockFilter === 'out_of_stock') {
            $query->where('quantity', 0);
        }

        // Filter by expiry status
        if ($expiryFilter === 'expired') {
            $query->expired();
        } elseif ($expiryFilter === 'expiring_soon') {
            $query->expiringSoon(30);
        }

        // Filter by seller
        if ($sellerId) {
            $query->where('seller_id', $sellerId);
        }

        // Filter by category
        if ($category) {
            $query->where('classification', $category);
        }

        $products = $query->orderBy('quantity', 'asc')->get();

        // Calculate inventory statistics
        $totalProducts = $products->count();
        $totalValue = $products->sum(function($product) {
            return $product->quantity * $product->price;
        });
        
        $lowStockProducts = $products->filter(function($product) {
            return $product->quantity > 0 && $product->quantity <= 5;
        });
        
        $outOfStockProducts = $products->filter(function($product) {
            return $product->quantity == 0;
        });

        $expiredProducts = $products->filter(function($product) {
            return $product->isExpired();
        });

        $expiringSoonProducts = $products->filter(function($product) {
            return $product->isExpiringSoon();
        });

        // Products by category
        $productsByCategory = $products->groupBy('classification')->map(function($categoryProducts) {
            return [
                'count' => $categoryProducts->count(),
                'total_quantity' => $categoryProducts->sum('quantity'),
                'total_value' => $categoryProducts->sum(function($product) {
                    return $product->quantity * $product->price;
                })
            ];
        });

        // Inventory value by seller
        $inventoryBySeller = $products->groupBy('seller_id')->map(function($sellerProducts) {
            $seller = $sellerProducts->first()->seller;
            return [
                'seller_name' => $seller ? $seller->name : 'Unknown',
                'product_count' => $sellerProducts->count(),
                'total_quantity' => $sellerProducts->sum('quantity'),
                'total_value' => $sellerProducts->sum(function($product) {
                    return $product->quantity * $product->price;
                })
            ];
        });

        // Restocking recommendations (products that are out of stock or low stock)
        $restockingRecommendations = $products->filter(function($product) {
            return $product->quantity <= 5;
        })->sortBy('quantity')->take(20);

        // Get filter options
        $sellers = User::where('role', 'seller')->orderBy('name')->pluck('name', 'id');
        $categories = ['Cleanser', 'Moisturizer', 'Serum', 'Toner', 'Sunscreen', 'Mask', 'Exfoliant', 'Treatment'];

        return view('admin.inventory-report', compact(
            'products', 'totalProducts', 'totalValue',
            'lowStockProducts', 'outOfStockProducts', 
            'expiredProducts', 'expiringSoonProducts',
            'productsByCategory', 'inventoryBySeller', 'restockingRecommendations',
            'stockFilter', 'expiryFilter', 'sellerId', 'category',
            'sellers', 'categories'
        ));
    }

    /**
     * Export sales report to Excel/CSV
     */
    public function exportSalesReport(Request $request)
    {
        $format = $request->input('format', 'excel'); // excel or csv
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $productId = $request->input('product_id');
        $brand = $request->input('brand');
        $productCategory = $request->input('product_category');
        $sellerId = $request->input('seller_id');

        $filename = "sales_report_{$startDate}_to_{$endDate}";
        
        if ($format === 'csv') {
            return Excel::download(new SalesReportExport(
                $startDate, $endDate, $productId, $brand, $productCategory, $sellerId
            ), $filename . '.csv');
        }
        
        return Excel::download(new SalesReportExport(
            $startDate, $endDate, $productId, $brand, $productCategory, $sellerId
        ), $filename . '.xlsx');
    }

    /**
     * Export inventory report to Excel/CSV
     */
    public function exportInventoryReport(Request $request)
    {
        $format = $request->input('format', 'excel'); // excel or csv
        $stockFilter = $request->input('stock_filter', 'all');
        $expiryFilter = $request->input('expiry_filter', 'all');
        $sellerId = $request->input('seller_id');
        $category = $request->input('category');

        $filename = "inventory_report_" . now()->format('Y-m-d');
        
        if ($format === 'csv') {
            return Excel::download(new InventoryReportExport(
                $stockFilter, $expiryFilter, $sellerId, $category
            ), $filename . '.csv');
        }
        
        return Excel::download(new InventoryReportExport(
            $stockFilter, $expiryFilter, $sellerId, $category
        ), $filename . '.xlsx');
    }

    /**
     * Display charts and analytics dashboard
     */
    public function charts()
    {
        // Get yearly sales data for charts
        $yearlySales = Order::selectRaw('YEAR(created_at) as year, SUM(total_amount) as total')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        // Get monthly sales for current year
        $monthlySales = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Get top selling products
        $topProducts = OrderItem::selectRaw('product_id, SUM(quantity) as total_sold')
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        // Get user registration trends
        $userRegistrations = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Get dashboard stats
        $stats = [
            'total_revenue' => Order::sum('total_amount'),
            'monthly_revenue' => Order::whereMonth('created_at', now()->month)->sum('total_amount'),
            'total_orders' => Order::count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'total_users' => User::count(),
            'total_products' => Product::count(),
        ];

        return view('admin.charts', compact(
            'yearlySales',
            'monthlySales', 
            'topProducts',
            'userRegistrations',
            'stats'
        ));
    }
}
