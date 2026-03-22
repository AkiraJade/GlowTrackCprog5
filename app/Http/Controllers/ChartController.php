<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Get yearly sales data for chart
     */
    public function yearlySales(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        
        $sales = Order::where('status', '!=', 'cancelled')
            ->whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Format for Chart.js
        $months = [];
        $totals = [];
        $counts = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthData = $sales->firstWhere('month', $i);
            $months[] = Carbon::create()->month($i)->format('F');
            $totals[] = $monthData ? (float) $monthData->total : 0;
            $counts[] = $monthData ? $monthData->count : 0;
        }

        return response()->json([
            'labels' => $months,
            'totals' => $totals,
            'counts' => $counts,
        ]);
    }

    /**
     * Get sales data for custom date range
     */
    public function dateRangeSales(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $sales = Order::where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'labels' => $sales->pluck('date'),
            'totals' => $sales->pluck('total')->map(fn($total) => (float) $total),
            'counts' => $sales->pluck('count'),
        ]);
    }

    /**
     * Get product sales percentage for pie chart
     */
    public function productSalesPercentage(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $query = Order::where('status', '!=', 'cancelled');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $productSales = $query->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('products.name, SUM(order_items.price * order_items.quantity) as total_sales')
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sales', 'desc')
            ->take(10) // Top 10 products
            ->get();

        $totalSales = $productSales->sum('total_sales');

        $data = $productSales->map(function ($item) use ($totalSales) {
            return [
                'name' => $item->name,
                'sales' => (float) $item->total_sales,
                'percentage' => $totalSales > 0 ? round(($item->total_sales / $totalSales) * 100, 2) : 0,
            ];
        });

        return response()->json([
            'data' => $data,
            'total_sales' => (float) $totalSales,
        ]);
    }

    /**
     * Get category sales distribution
     */
    public function categorySalesDistribution(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $query = Order::where('status', '!=', 'cancelled');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $categorySales = $query->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('products.classification as category, SUM(order_items.price * order_items.quantity) as total_sales, COUNT(DISTINCT orders.id) as order_count')
            ->groupBy('products.classification')
            ->orderBy('total_sales', 'desc')
            ->get();

        $totalSales = $categorySales->sum('total_sales');

        $data = $categorySales->map(function ($item) use ($totalSales) {
            return [
                'category' => $item->category,
                'sales' => (float) $item->total_sales,
                'orders' => $item->order_count,
                'percentage' => $totalSales > 0 ? round(($item->total_sales / $totalSales) * 100, 2) : 0,
            ];
        });

        return response()->json([
            'data' => $data,
            'total_sales' => (float) $totalSales,
        ]);
    }

    /**
     * Get user registration trends
     */
    public function userRegistrationTrends(Request $request)
    {
        $period = $request->get('period', 'monthly'); // daily, weekly, monthly

        $query = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date');

        if ($period === 'daily') {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        } elseif ($period === 'weekly') {
            $query->where('created_at', '>=', Carbon::now()->subWeeks(12));
        } else {
            $query->where('created_at', '>=', Carbon::now()->subYear(1));
        }

        $registrations = $query->get();

        return response()->json([
            'labels' => $registrations->pluck('date'),
            'data' => $registrations->pluck('count'),
        ]);
    }

    /**
     * Get dashboard statistics
     */
    public function dashboardStats()
    {
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
        ];

        // Recent trends
        $thisMonthRevenue = Order::where('status', '!=', 'cancelled')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_amount');

        $lastMonthRevenue = Order::where('status', '!=', 'cancelled')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->sum('total_amount');

        $revenueGrowth = $lastMonthRevenue > 0 
            ? (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
            : 0;

        $stats['monthly_revenue'] = $thisMonthRevenue;
        $stats['revenue_growth'] = round($revenueGrowth, 2);

        return response()->json($stats);
    }
}
