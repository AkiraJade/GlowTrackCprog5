<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Review;
use App\Models\SellerApplication;
use App\Models\ForumDiscussion;
use App\Models\ForumReply;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        // Check for critical system alerts
        $this->checkSystemAlerts();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentOrders', 'pendingProducts'));
    }

    /**
     * Check for system alerts and create notifications if needed
     */
    private function checkSystemAlerts(): void
    {
        $adminId = auth()->id();
        
        // Check for critical low stock products
        $criticalLowStock = Product::whereRaw('quantity <= low_stock_threshold AND low_stock_threshold > 0')
            ->where('quantity', '<=', 5)
            ->count();
            
        if ($criticalLowStock > 0) {
            $this->notifyAdmins(
                'system_alert',
                'Critical Low Stock Alert',
                "{$criticalLowStock} products are critically low on stock (5 units or less).",
                ['alert_type' => 'critical_low_stock', 'count' => $criticalLowStock]
            );
        }
        
        // Check for high number of pending orders
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        if ($pendingOrdersCount >= 20) {
            $this->notifyAdmins(
                'system_alert',
                'High Pending Orders Alert',
                "{$pendingOrdersCount} orders are pending and need attention.",
                ['alert_type' => 'high_pending_orders', 'count' => $pendingOrdersCount]
            );
        }
        
        // Check for high number of pending seller applications
        $pendingApplicationsCount = SellerApplication::where('status', 'pending')->count();
        if ($pendingApplicationsCount >= 10) {
            $this->notifyAdmins(
                'system_alert',
                'High Pending Applications Alert',
                "{$pendingApplicationsCount} seller applications are pending review.",
                ['alert_type' => 'high_pending_applications', 'count' => $pendingApplicationsCount]
            );
        }
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
            'active' => 'required|boolean',
            'deactivation_reason' => 'required_if:active,false|string|max:500',
        ]);

        // Prevent admin from deactivating themselves
        if ($user->id === auth()->id() && !$request->active) {
            return redirect()->back()->with('error', 'You cannot deactivate your own account.');
        }

        $user->update([
            'active' => $request->active,
            'deactivation_reason' => $request->active ? null : $request->deactivation_reason,
            'deactivated_at' => $request->active ? null : now(),
        ]);

        // Create notification for the user
        $message = $request->active 
            ? 'Your account has been reactivated. You can now use all platform features.'
            : 'Your account has been deactivated. Reason: ' . $request->deactivation_reason;
            
        \App\Http\Controllers\NotificationController::createNotification(
            $user->id,
            $request->active ? 'account_reactivated' : 'account_deactivated',
            $request->active ? 'Account Reactivated' : 'Account Deactivated',
            $message
        );

        return redirect()->back()->with('success', 'User status updated successfully.');
    }

    /**
     * Show edit user form
     */
    public function editUser(User $user)
    {
        return view('admin.user-edit', compact('user'));
    }

    /**
     * Update user information
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'role' => 'required|in:admin,seller,customer',
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.show', $user)->with('success', 'User information updated successfully.');
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
     * Delete user (with cascade deletion of related records)
     */
    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        try {
            // Delete related records in order to avoid foreign key constraints
            
            // Delete notifications
            $user->notifications()->delete();
            
            // Delete routine reviews and ratings
            $user->routineReviews()->delete();
            $user->routineRatings()->delete();
            $user->routineFavorites()->delete();
            
            // Delete skincare routines and journals
            $user->skincareRoutines()->delete();
            $user->skinJournals()->delete();
            
            // Delete skin profile
            $user->skinProfile()->delete();
            
            // Delete wishlist items
            $user->wishlistItems()->delete();
            
            // Delete cart items
            $user->cartItems()->delete();
            
            // Handle orders - you might want to keep them for records, but remove user reference
            foreach ($user->orders as $order) {
                $order->update(['user_id' => null]); // Or delete if you prefer
            }
            
            // Handle products if user is a seller
            if ($user->isSeller()) {
                foreach ($user->products as $product) {
                    $product->update(['seller_id' => null]); // Or delete if you prefer
                }
            }
            
            // Delete seller application if exists
            $user->sellerApplication()->delete();
            
            // Finally delete the user
            $user->delete();

            return redirect()->route('admin.users')->with('success', 'User and all related data deleted successfully.');
            
        } catch (\Exception $e) {
            \Log::error('Error deleting user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error deleting user. The user may have related records that cannot be deleted. Please check logs for details.');
        }
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
        
        // Create notification for the seller
        if ($product->seller_id) {
            \App\Http\Controllers\NotificationController::createNotification(
                $product->seller_id,
                'product_approved',
                'Product Approved',
                "Your product '{$product->name}' has been approved and is now live.",
                ['product_id' => $product->id, 'product_name' => $product->name]
            );
        }
        
        // Create notification for all admins
        $this->notifyAdmins(
            'admin_action',
            'Product Approved',
            "Product '{$product->name}' approved by admin.",
            ['product_id' => $product->id, 'admin_id' => auth()->id()]
        );
        
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
        
        // Create notification for the seller
        if ($product->seller_id) {
            \App\Http\Controllers\NotificationController::createNotification(
                $product->seller_id,
                'product_rejected',
                'Product Rejected',
                "Your product '{$product->name}' has been rejected. Reason: {$request->rejection_reason}",
                ['product_id' => $product->id, 'product_name' => $product->name, 'reason' => $request->rejection_reason]
            );
        }
        
        // Create notification for all admins
        $this->notifyAdmins(
            'admin_action',
            'Product Rejected',
            "Product '{$product->name}' rejected by admin.",
            ['product_id' => $product->id, 'admin_id' => auth()->id()]
        );

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

        // Create notification for all admins about manual restock
        $this->notifyAdmins(
            'admin_action',
            'Product Restocked',
            "Product '{$product->name}' restocked by admin. Stock increased from {$oldQuantity} to {$newQuantity}.",
            ['product_id' => $product->id, 'admin_id' => auth()->id(), 'old_quantity' => $oldQuantity, 'new_quantity' => $newQuantity]
        );

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

        // Create notification for all admins about order status change
        $this->notifyAdmins(
            'admin_action',
            'Order Status Updated',
            "Order #{$order->id} status changed from {$previousStatus} to {$request->status}.",
            ['order_id' => $order->id, 'admin_id' => auth()->id(), 'previous_status' => $previousStatus, 'new_status' => $request->status]
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
     * Display admin notifications
     */
    public function notifications(Request $request)
    {
        $user = Auth::user();
        $query = $user->notifications()->with('user')->latest();
        
        // Apply filters
        if ($request->get('filter') === 'unread') {
            $query->unread();
        } elseif ($request->get('filter') && $request->get('filter') !== 'all') {
            $query->byType($request->get('filter'));
        }
        
        $notifications = $query->paginate($request->get('per_page', 10));

        return view('admin.notifications', [
            'notifications' => $notifications,
            'unreadCount' => $user->notifications()->unread()->count(),
        ]);
    }

    /**
     * Generate sales report
     */
    public function salesReport(Request $request)
    {
        try {
            $start = \Carbon\Carbon::parse($request->input('start_date', now()->subYears(10)));
        } catch (\Exception $e) {
            $start = now()->subYears(10);
        }
        
        try {
            $end = \Carbon\Carbon::parse($request->input('end_date', now()));
        } catch (\Exception $e) {
            $end = now();
        }

        $startDate = $start->format('Y-m-d');
        $endDate = $end->format('Y-m-d');
        $sqlStart = $start->startOfDay()->toDateTimeString();
        $sqlEnd = $end->endOfDay()->toDateTimeString();
        $productId = $request->input('product_id');
        $brand = $request->input('brand');
        $productCategory = $request->input('product_category');
        $sellerId = $request->input('seller_id');

        $query = Order::whereBetween('created_at', [$sqlStart, $sqlEnd])
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
        $topProductsQuery = OrderItem::whereHas('order', function($query) use ($sqlStart, $sqlEnd) {
            $query->whereBetween('created_at', [$sqlStart, $sqlEnd])
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
        $dailySales = Order::whereBetween('created_at', [$sqlStart, $sqlEnd])
            ->where('status', '!=', 'cancelled')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(total_amount) as revenue')
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
        $startDate = $request->input('start_date', now()->subYears(10)->format('Y-m-d'));
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

    /**
     * Helper method to notify all admin users
     */
    private function notifyAdmins(string $type, string $title, string $message, array $data = []): void
    {
        $adminUsers = User::where('role', 'admin')->get();
        
        foreach ($adminUsers as $admin) {
            // Don't notify the admin who performed the action
            if ($admin->id !== auth()->id()) {
                \App\Http\Controllers\NotificationController::createNotification(
                    $admin->id,
                    $type,
                    $title,
                    $message,
                    $data
                );
            }
        }
    }

    /**
     * Display all trashed items
     */
    public function trash(Request $request)
    {
        $type = $request->query('type', 'users');
        
        $trashedCounts = [
            'users' => User::onlyTrashed()->count(),
            'products' => Product::onlyTrashed()->count(),
            'orders' => Order::onlyTrashed()->count(),
            'carts' => Cart::onlyTrashed()->count(),
            'reviews' => Review::onlyTrashed()->count(),
        ];

        $trashedItems = null;

        switch ($type) {
            case 'products':
                $trashedItems = Product::onlyTrashed()->with('seller')->latest('deleted_at')->paginate(15);
                break;
            case 'orders':
                $trashedItems = Order::onlyTrashed()->with('user')->latest('deleted_at')->paginate(15);
                break;
            case 'carts':
                $trashedItems = Cart::onlyTrashed()->with(['user', 'product'])->latest('deleted_at')->paginate(15);
                break;
            case 'reviews':
                $trashedItems = Review::onlyTrashed()->with(['product', 'user'])->latest('deleted_at')->paginate(15);
                break;
            case 'users':
            default:
                $trashedItems = User::onlyTrashed()->latest('deleted_at')->paginate(15);
                break;
        }

        return view('admin.trash', compact('trashedItems', 'type', 'trashedCounts'));
    }

    /**
     * Restore a trashed item
     */
    public function restore(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');

        switch ($type) {
            case 'user':
                $user = User::onlyTrashed()->findOrFail($id);
                $user->restore();
                $message = "User '{$user->name}' has been restored.";
                break;
            case 'product':
                $product = Product::onlyTrashed()->findOrFail($id);
                $product->restore();
                $message = "Product '{$product->name}' has been restored.";
                break;
            case 'order':
                $order = Order::onlyTrashed()->findOrFail($id);
                $order->restore();
                $message = "Order #{$order->order_id} has been restored.";
                break;
            case 'cart':
                $cart = Cart::onlyTrashed()->findOrFail($id);
                $cart->restore();
                $message = "Cart item has been restored.";
                break;
            case 'review':
                $review = Review::onlyTrashed()->findOrFail($id);
                $review->restore();
                $message = "Review has been restored.";
                break;
            default:
                return back()->with('error', 'Invalid item type.');
        }

        return back()->with('success', $message);
    }

    /**
     * Permanently delete a trashed item
     */
    public function forceDelete(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');

        switch ($type) {
            case 'user':
                $user = User::onlyTrashed()->findOrFail($id);
                $userName = $user->name;
                $user->forceDelete();
                $message = "User '{$userName}' has been permanently deleted.";
                break;
            case 'product':
                $product = Product::onlyTrashed()->findOrFail($id);
                $productName = $product->name;
                $product->forceDelete();
                $message = "Product '{$productName}' has been permanently deleted.";
                break;
            case 'order':
                $order = Order::onlyTrashed()->findOrFail($id);
                $orderId = $order->order_id;
                $order->forceDelete();
                $message = "Order #{$orderId} has been permanently deleted.";
                break;
            case 'cart':
                $cart = Cart::onlyTrashed()->findOrFail($id);
                $cart->forceDelete();
                $message = "Cart item has been permanently deleted.";
                break;
            case 'review':
                $review = Review::onlyTrashed()->findOrFail($id);
                $review->forceDelete();
                $message = "Review has been permanently deleted.";
                break;
            default:
                return back()->with('error', 'Invalid item type.');
        }

        return back()->with('success', $message);
    }
}
