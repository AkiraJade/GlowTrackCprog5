<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SellerApplication;
use Illuminate\Http\Request;

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
        return view('admin.user-details', compact('user'));
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
     * Display all orders for admin management
     */
    public function orders()
    {
        $orders = Order::with('user', 'items.product')->latest()->paginate(10);
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

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Display reports page
     */
    public function reports()
    {
        return view('admin.reports');
    }

    /**
     * Generate sales report
     */
    public function salesReport(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->with('items.product', 'user')
            ->get();

        $totalRevenue = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $topProducts = OrderItem::whereHas('order', function($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate])
                  ->where('status', '!=', 'cancelled');
        })
        ->with('product')
        ->selectRaw('product_id, SUM(quantity) as total_sold, SUM(price * quantity) as total_revenue')
        ->groupBy('product_id')
        ->orderByDesc('total_sold')
        ->limit(10)
        ->get();

        return view('admin.sales-report', compact(
            'orders', 'totalRevenue', 'totalOrders', 'averageOrderValue', 
            'topProducts', 'startDate', 'endDate'
        ));
    }

    /**
     * Generate inventory report
     */
    public function inventoryReport()
    {
        $products = Product::with('seller')
            ->select(['*', 'stock_quantity'])
            ->orderBy('stock_quantity', 'asc')
            ->get();

        $lowStockProducts = $products->filter(function($product) {
            return $product->stock_quantity <= 10;
        });

        $outOfStockProducts = $products->filter(function($product) {
            return $product->stock_quantity == 0;
        });

        return view('admin.inventory-report', compact(
            'products', 'lowStockProducts', 'outOfStockProducts'
        ));
    }
}
