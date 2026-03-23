<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\SellerApplication;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SellerPerformanceReportController extends Controller
{
    /**
     * Display the main seller performance dashboard.
     */
    public function index(Request $request): View
    {
        $filters = [
            'period' => $request->get('period', 'all'),
            'seller_status' => $request->get('seller_status', 'all'),
            'min_revenue' => $request->get('min_revenue', 0),
            'min_orders' => $request->get('min_orders', 0),
        ];

        // Get overview statistics
        $overview = $this->getOverviewStats($filters);

        // Get detailed performance data
        $topPerformers = $this->getTopPerformers($filters);
        $revenueAnalysis = $this->getRevenueAnalysis($filters);
        $fulfillmentMetrics = $this->getFulfillmentMetrics($filters);
        $satisfactionScores = $this->getSatisfactionScores($filters);
        $productPerformance = $this->getProductPerformance($filters);
        $growthTrends = $this->getGrowthTrends($filters);

        return view('admin.seller-performance', compact(
            'overview',
            'topPerformers',
            'revenueAnalysis',
            'fulfillmentMetrics',
            'satisfactionScores',
            'productPerformance',
            'growthTrends',
            'filters'
        ));
    }

    /**
     * Get overview statistics for the dashboard.
     */
    private function getOverviewStats(array $filters): array
    {
        $dateRange = $this->getDateRange($filters['period']);

        $sellers = User::where('role', 'seller')
            ->where('created_at', '>=', $dateRange['start'])
            ->when($filters['seller_status'] !== 'all', function ($query) use ($filters) {
                $query->where('seller_status', $filters['seller_status']);
            })
            ->get();

        return [
            'total_sellers' => $sellers->count(),
            'active_sellers' => $sellers->where('seller_status', 'active')->count(),
            'total_revenue' => $this->calculateTotalRevenue($sellers, $dateRange),
            'total_orders' => $this->calculateTotalOrders($sellers, $dateRange),
            'avg_revenue_per_seller' => $sellers->count() > 0 ? $this->calculateTotalRevenue($sellers, $dateRange) / $sellers->count() : 0,
            'avg_fulfillment_rate' => $this->calculateAverageFulfillmentRate($sellers, $dateRange),
            'avg_satisfaction_score' => $this->calculateAverageSatisfactionScore($sellers, $dateRange),
            'top_performer' => $this->getTopPerformer($sellers, $dateRange),
        ];
    }

    /**
     * Get top performing sellers.
     */
    private function getTopPerformers(array $filters): array
    {
        $dateRange = $this->getDateRange($filters['period']);

        $sellers = User::where('role', 'seller')
            ->where('created_at', '>=', $dateRange['start'])
            ->when($filters['seller_status'] !== 'all', function ($query) use ($filters) {
                $query->where('seller_status', $filters['seller_status']);
            })
            ->get();

        $performers = [];
        foreach ($sellers as $seller) {
            $revenue = $this->calculateSellerRevenue($seller, $dateRange);
            $orders = $this->calculateSellerOrders($seller, $dateRange);
            $fulfillmentRate = $this->calculateSellerFulfillmentRate($seller, $dateRange);
            $satisfactionScore = $this->calculateSellerSatisfactionScore($seller, $dateRange);

            if ($revenue >= $filters['min_revenue'] && $orders >= $filters['min_orders']) {
                $performers[] = [
                    'seller' => $seller,
                    'revenue' => $revenue,
                    'orders' => $orders,
                    'fulfillment_rate' => $fulfillmentRate,
                    'satisfaction_score' => $satisfactionScore,
                    'performance_score' => $this->calculatePerformanceScore($revenue, $orders, $fulfillmentRate, $satisfactionScore),
                ];
            }
        }

        // Sort by performance score
        usort($performers, function ($a, $b) {
            return $b['performance_score'] <=> $a['performance_score'];
        });

        return array_slice($performers, 0, 20);
    }

    /**
     * Get revenue analysis data.
     */
    private function getRevenueAnalysis(array $filters): array
    {
        $dateRange = $this->getDateRange($filters['period']);

        $sellers = User::where('role', 'seller')
            ->where('created_at', '>=', $dateRange['start'])
            ->when($filters['seller_status'] !== 'all', function ($query) use ($filters) {
                $query->where('seller_status', $filters['seller_status']);
            })
            ->get();

        // Revenue distribution
        $revenueRanges = [
            '0-1000' => 0,
            '1000-5000' => 0,
            '5000-10000' => 0,
            '10000-25000' => 0,
            '25000+' => 0,
        ];

        // Monthly revenue trends
        $monthlyRevenue = [];
        $currentDate = $dateRange['start']->copy();
        while ($currentDate <= $dateRange['end']) {
            $monthRevenue = 0;
            foreach ($sellers as $seller) {
                $monthRevenue += $this->calculateSellerRevenue($seller, [
                    'start' => $currentDate->copy()->startOfMonth(),
                    'end' => $currentDate->copy()->endOfMonth()
                ]);
            }
            $monthlyRevenue[$currentDate->format('Y-m')] = $monthRevenue;
            $currentDate->addMonth();
        }

        // Top revenue categories
        $categoryRevenue = [];
        foreach ($sellers as $seller) {
            $sellerRevenue = $this->calculateSellerRevenueByCategory($seller, $dateRange);
            foreach ($sellerRevenue as $category => $revenue) {
                $categoryRevenue[$category] = ($categoryRevenue[$category] ?? 0) + $revenue;
            }
        }

        arsort($categoryRevenue);

        return [
            'total_revenue' => $this->calculateTotalRevenue($sellers, $dateRange),
            'avg_revenue_per_seller' => $sellers->count() > 0 ? $this->calculateTotalRevenue($sellers, $dateRange) / $sellers->count() : 0,
            'revenue_ranges' => $revenueRanges,
            'monthly_trends' => $monthlyRevenue,
            'top_categories' => array_slice($categoryRevenue, 0, 10, true),
            'growth_rate' => $this->calculateRevenueGrowthRate($sellers, $dateRange),
        ];
    }

    /**
     * Get fulfillment metrics.
     */
    private function getFulfillmentMetrics(array $filters): array
    {
        $dateRange = $this->getDateRange($filters['period']);

        $sellers = User::where('role', 'seller')
            ->where('created_at', '>=', $dateRange['start'])
            ->when($filters['seller_status'] !== 'all', function ($query) use ($filters) {
                $query->where('seller_status', $filters['seller_status']);
            })
            ->get();

        $fulfillmentRates = [];
        $orderStatuses = [
            'pending' => 0,
            'confirmed' => 0,
            'processing' => 0,
            'shipped' => 0,
            'delivered' => 0,
            'cancelled' => 0,
            'delivery_failed' => 0,
        ];

        foreach ($sellers as $seller) {
            $rate = $this->calculateSellerFulfillmentRate($seller, $dateRange);
            $fulfillmentRates[] = $rate;

            $sellerOrders = $this->getSellerOrders($seller, $dateRange);
            foreach ($sellerOrders as $order) {
                $orderStatuses[$order->status] = ($orderStatuses[$order->status] ?? 0) + 1;
            }
        }

        return [
            'avg_fulfillment_rate' => count($fulfillmentRates) > 0 ? array_sum($fulfillmentRates) / count($fulfillmentRates) : 0,
            'fulfillment_distribution' => $this->getFulfillmentDistribution($fulfillmentRates),
            'order_status_breakdown' => $orderStatuses,
            'fast_fulfillers' => $this->getFastFulfillers($sellers, $dateRange),
            'late_shipments' => $this->getLateShipments($sellers, $dateRange),
        ];
    }

    /**
     * Get satisfaction scores.
     */
    private function getSatisfactionScores(array $filters): array
    {
        $dateRange = $this->getDateRange($filters['period']);

        $sellers = User::where('role', 'seller')
            ->where('created_at', '>=', $dateRange['start'])
            ->when($filters['seller_status'] !== 'all', function ($query) use ($filters) {
                $query->where('seller_status', $filters['seller_status']);
            })
            ->get();

        $satisfactionScores = [];
        $ratingDistribution = [
            '5' => 0,
            '4' => 0,
            '3' => 0,
            '2' => 0,
            '1' => 0,
        ];

        foreach ($sellers as $seller) {
            $score = $this->calculateSellerSatisfactionScore($seller, $dateRange);
            $satisfactionScores[] = $score;

            $sellerReviews = $this->getSellerReviews($seller, $dateRange);
            foreach ($sellerReviews as $review) {
                $ratingDistribution[$review->rating] = ($ratingDistribution[$review->rating] ?? 0) + 1;
            }
        }

        return [
            'avg_satisfaction_score' => count($satisfactionScores) > 0 ? array_sum($satisfactionScores) / count($satisfactionScores) : 0,
            'score_distribution' => $this->getScoreDistribution($satisfactionScores),
            'rating_breakdown' => $ratingDistribution,
            'top_rated_sellers' => $this->getTopRatedSellers($sellers, $dateRange),
            'improvement_trends' => $this->getSatisfactionTrends($sellers, $dateRange),
        ];
    }

    /**
     * Get product performance by seller.
     */
    private function getProductPerformance(array $filters): array
    {
        $dateRange = $this->getDateRange($filters['period']);

        $sellers = User::where('role', 'seller')
            ->where('created_at', '>=', $dateRange['start'])
            ->when($filters['seller_status'] !== 'all', function ($query) use ($filters) {
                $query->where('seller_status', $filters['seller_status']);
            })
            ->get();

        $productPerformance = [];
        foreach ($sellers as $seller) {
            $products = $this->getSellerProducts($seller, $dateRange);
            foreach ($products as $product) {
                $productPerformance[] = [
                    'product' => $product,
                    'seller' => $seller,
                    'revenue' => $this->calculateProductRevenue($product, $dateRange),
                    'orders' => $this->calculateProductOrders($product, $dateRange),
                    'rating' => $product->average_rating,
                    'reviews' => $product->review_count,
                    'stock_turnover' => $this->calculateStockTurnover($product, $dateRange),
                ];
            }
        }

        // Sort by revenue
        usort($productPerformance, function ($a, $b) {
            return $b['revenue'] <=> $a['revenue'];
        });

        return [
            'top_products' => array_slice($productPerformance, 0, 20),
            'category_performance' => $this->getCategoryPerformance($productPerformance),
            'low_performing_products' => array_slice(array_reverse($productPerformance), 0, 20),
        ];
    }

    /**
     * Get growth trends.
     */
    private function getGrowthTrends(array $filters): array
    {
        $dateRange = $this->getDateRange($filters['period']);

        $sellers = User::where('role', 'seller')
            ->where('created_at', '>=', $dateRange['start'])
            ->when($filters['seller_status'] !== 'all', function ($query) use ($filters) {
                $query->where('seller_status', $filters['seller_status']);
            })
            ->get();

        // Monthly new sellers
        $monthlyNewSellers = [];
        $currentDate = $dateRange['start']->copy();
        while ($currentDate <= $dateRange['end']) {
            $count = User::where('role', 'seller')
                ->whereMonth('created_at', $currentDate->month)
                ->whereYear('created_at', $currentDate->year)
                ->count();
            $monthlyNewSellers[$currentDate->format('Y-m')] = $count;
            $currentDate->addMonth();
        }

        // Revenue growth
        $monthlyRevenue = [];
        $currentDate = $dateRange['start']->copy();
        while ($currentDate <= $dateRange['end']) {
            $monthRevenue = 0;
            foreach ($sellers as $seller) {
                $monthRevenue += $this->calculateSellerRevenue($seller, [
                    'start' => $currentDate->copy()->startOfMonth(),
                    'end' => $currentDate->copy()->endOfMonth()
                ]);
            }
            $monthlyRevenue[$currentDate->format('Y-m')] = $monthRevenue;
            $currentDate->addMonth();
        }

        return [
            'new_sellers_trend' => $monthlyNewSellers,
            'revenue_growth_trend' => $monthlyRevenue,
            'seller_retention' => $this->calculateSellerRetention($sellers, $dateRange),
            'growth_rate' => $this->calculateGrowthRate($sellers, $dateRange),
        ];
    }

    /**
     * Export seller performance data to CSV.
     */
    public function exportCsv(Request $request): JsonResponse
    {
        $this->authorize('viewReports', User::class);

        $filters = [
            'period' => $request->get('period', 'all'),
            'seller_status' => $request->get('seller_status', 'all'),
            'min_revenue' => $request->get('min_revenue', 0),
            'min_orders' => $request->get('min_orders', 0),
        ];

        $data = [
            'overview' => $this->getOverviewStats($filters),
            'top_performers' => $this->getTopPerformers($filters),
            'revenue_analysis' => $this->getRevenueAnalysis($filters),
            'fulfillment_metrics' => $this->getFulfillmentMetrics($filters),
            'satisfaction_scores' => $this->getSatisfactionScores($filters),
            'product_performance' => $this->getProductPerformance($filters),
            'growth_trends' => $this->getGrowthTrends($filters),
        ];

        $filename = "seller_performance_" . now()->format('Y-m-d') . ".csv";
        $filepath = storage_path('app/temp/' . $filename);

        $this->generateSellerPerformanceCsv($filepath, $data);

        return response()->json([
            'message' => 'Seller performance report exported successfully',
            'filename' => $filename,
            'download_url' => route('admin.seller-performance.download', $filename),
        ]);
    }

    /**
     * Download exported CSV file.
     */
    public function downloadCsv($filename)
    {
        $this->authorize('viewReports', User::class);

        $filepath = storage_path('app/temp/' . $filename);

        if (!file_exists($filepath)) {
            abort(404, 'File not found');
        }

        return response()->download($filepath, $filename)->deleteFileAfterSend(true);
    }

    /**
     * Get real-time seller performance data for AJAX requests.
     */
    public function getSellerData(Request $request): JsonResponse
    {
        $this->authorize('viewReports', User::class);

        $type = $request->get('type');
        $filters = [
            'period' => $request->get('period', 'all'),
            'seller_status' => $request->get('seller_status', 'all'),
            'min_revenue' => $request->get('min_revenue', 0),
            'min_orders' => $request->get('min_orders', 0),
        ];

        switch ($type) {
            case 'top_performers':
                return response()->json($this->getTopPerformers($filters));
            case 'revenue_analysis':
                return response()->json($this->getRevenueAnalysis($filters));
            case 'fulfillment_metrics':
                return response()->json($this->getFulfillmentMetrics($filters));
            case 'satisfaction_scores':
                return response()->json($this->getSatisfactionScores($filters));
            case 'product_performance':
                return response()->json($this->getProductPerformance($filters));
            case 'growth_trends':
                return response()->json($this->getGrowthTrends($filters));
            default:
                return response()->json(['error' => 'Invalid data type'], 400);
        }
    }

    /**
     * Helper methods for calculations
     */
    private function calculateTotalRevenue($sellers, $dateRange): float
    {
        $total = 0;
        foreach ($sellers as $seller) {
            $total += $this->calculateSellerRevenue($seller, $dateRange);
        }
        return $total;
    }

    private function calculateSellerRevenue($seller, $dateRange): float
    {
        return OrderItem::whereHas('product', function ($query) use ($seller) {
                $query->where('seller_id', $seller->id);
            })
            ->whereHas('order', function ($query) use ($dateRange) {
                $query->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
            })
            ->sum('price');
    }

    private function calculateSellerRevenueByCategory($seller, $dateRange): array
    {
        $revenueByCategory = [];
        
        $products = Product::where('seller_id', $seller->id)
            ->where('status', 'approved')
            ->get();

        foreach ($products as $product) {
            $category = $product->classification;
            $revenue = OrderItem::where('product_id', $product->id)
                ->whereHas('order', function ($query) use ($dateRange) {
                    $query->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
                })
                ->sum('price');

            $revenueByCategory[$category] = ($revenueByCategory[$category] ?? 0) + $revenue;
        }

        return $revenueByCategory;
    }

    private function calculateTotalOrders($sellers, $dateRange): int
    {
        $total = 0;
        foreach ($sellers as $seller) {
            $total += $this->calculateSellerOrders($seller, $dateRange);
        }
        return $total;
    }

    private function calculateSellerOrders($seller, $dateRange): int
    {
        return OrderItem::whereHas('product', function ($query) use ($seller) {
                $query->where('seller_id', $seller->id);
            })
            ->whereHas('order', function ($query) use ($dateRange) {
                $query->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
            })
            ->distinct('order_id')
            ->count('order_id');
    }

    private function calculateAverageFulfillmentRate($sellers, $dateRange): float
    {
        $rates = [];
        foreach ($sellers as $seller) {
            $rates[] = $this->calculateSellerFulfillmentRate($seller, $dateRange);
        }
        return count($rates) > 0 ? array_sum($rates) / count($rates) : 0;
    }

    private function calculateSellerFulfillmentRate($seller, $dateRange): float
    {
        $totalOrders = $this->calculateSellerOrders($seller, $dateRange);
        if ($totalOrders === 0) return 0;

        $deliveredOrders = OrderItem::whereHas('product', function ($query) use ($seller) {
                $query->where('seller_id', $seller->id);
            })
            ->whereHas('order', function ($query) use ($dateRange) {
                $query->where('status', 'delivered')
                      ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
            })
            ->distinct('order_id')
            ->count('order_id');

        return ($deliveredOrders / $totalOrders) * 100;
    }

    private function calculateAverageSatisfactionScore($sellers, $dateRange): float
    {
        $scores = [];
        foreach ($sellers as $seller) {
            $score = $this->calculateSellerSatisfactionScore($seller, $dateRange);
            if ($score > 0) {
                $scores[] = $score;
            }
        }
        return count($scores) > 0 ? array_sum($scores) / count($scores) : 0;
    }

    private function calculateSellerSatisfactionScore($seller, $dateRange): float
    {
        $reviews = Review::whereHas('product', function ($query) use ($seller, $dateRange) {
                $query->where('seller_id', $seller->id)
                      ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
            })
            ->get();

        if ($reviews->isEmpty()) {
            return 0;
        }

        return $reviews->avg('rating');
    }

    private function calculatePerformanceScore($revenue, $orders, $fulfillmentRate, $satisfactionScore): float
    {
        // Weighted performance score (max 100)
        $revenueScore = min(40, ($revenue / 1000) * 40); // Max 40 points
        $orderScore = min(20, ($orders / 10) * 20); // Max 20 points
        $fulfillmentScore = ($fulfillmentRate / 100) * 25; // Max 25 points
        $satisfactionScore = ($satisfactionScore / 5) * 15; // Max 15 points

        return $revenueScore + $orderScore + $fulfillmentScore + $satisfactionScore;
    }

    private function getTopPerformer($sellers, $dateRange): array
    {
        $topPerformer = null;
        $highestScore = 0;

        foreach ($sellers as $seller) {
            $score = $this->calculatePerformanceScore(
                $this->calculateSellerRevenue($seller, $dateRange),
                $this->calculateSellerOrders($seller, $dateRange),
                $this->calculateSellerFulfillmentRate($seller, $dateRange),
                $this->calculateSellerSatisfactionScore($seller, $dateRange)
            );

            if ($score > $highestScore) {
                $highestScore = $score;
                $topPerformer = $seller;
            }
        }

        if ($topPerformer === null) {
            return [];
        }

        return [
            'seller' => $topPerformer,
            'revenue' => $this->calculateSellerRevenue($topPerformer, $dateRange),
            'orders' => $this->calculateSellerOrders($topPerformer, $dateRange),
            'fulfillment_rate' => $this->calculateSellerFulfillmentRate($topPerformer, $dateRange),
            'satisfaction_score' => $this->calculateSellerSatisfactionScore($topPerformer, $dateRange),
            'performance_score' => $highestScore,
        ];
    }

    // Additional helper methods for detailed analysis
    private function getFulfillmentDistribution($rates): array
    {
        $distribution = [
            '0-50' => 0,
            '51-70' => 0,
            '71-85' => 0,
            '86-95' => 0,
            '96-100' => 0,
        ];

        foreach ($rates as $rate) {
            if ($rate <= 50) {
                $distribution['0-50']++;
            } elseif ($rate <= 70) {
                $distribution['51-70']++;
            } elseif ($rate <= 85) {
                $distribution['71-85']++;
            } elseif ($rate <= 95) {
                $distribution['86-95']++;
            } else {
                $distribution['96-100']++;
            }
        }

        return $distribution;
    }

    private function getScoreDistribution($scores): array
    {
        $distribution = [
            '1-2' => 0,
            '2-3' => 0,
            '3-4' => 0,
            '4-5' => 0,
        ];

        foreach ($scores as $score) {
            if ($score <= 2) {
                $distribution['1-2']++;
            } elseif ($score <= 3) {
                $distribution['2-3']++;
            } elseif ($score <= 4) {
                $distribution['3-4']++;
            } else {
                $distribution['4-5']++;
            }
        }

        return $distribution;
    }

    private function getDateRange(string $period): array
    {
        $now = now();
        
        switch ($period) {
            case 'all':
                return ['start' => $now->copy()->subYears(10), 'end' => $now];
            case '7days':
                return ['start' => $now->copy()->subDays(7), 'end' => $now];
            case '30days':
                return ['start' => $now->copy()->subDays(30), 'end' => $now];
            case '90days':
                return ['start' => $now->copy()->subDays(90), 'end' => $now];
            case '1year':
                return ['start' => $now->copy()->subYear(), 'end' => $now];
            default:
                return ['start' => $now->copy()->subYears(10), 'end' => $now];
        }
    }

    private function generateSellerPerformanceCsv(string $filepath, array $data): void
    {
        $handle = fopen($filepath, 'w');
        
        // Write header
        fputcsv($handle, ['Seller Performance Report - ' . now()->format('Y-m-d')]);
        fputcsv($handle, []);

        // Overview section
        fputcsv($handle, ['Overview']);
        fputcsv($handle, ['Metric', 'Value']);
        foreach ($data['overview'] as $key => $value) {
            fputcsv($handle, [ucfirst(str_replace('_', ' ', $key)), $value]);
        }
        fputcsv($handle, []);

        // Top performers
        fputcsv($handle, ['Top Performers']);
        fputcsv($handle, ['Seller', 'Revenue', 'Orders', 'Fulfillment Rate', 'Satisfaction Score', 'Performance Score']);
        foreach ($data['top_performers'] as $performer) {
            fputcsv($handle, [
                $performer['seller']->name,
                number_format($performer['revenue'], 2),
                $performer['orders'],
                number_format($performer['fulfillment_rate'], 2) . '%',
                number_format($performer['satisfaction_score'], 2),
                number_format($performer['performance_score'], 2)
            ]);
        }
        fputcsv($handle, []);

        fclose($handle);
    }

    private function getSellerOrders($seller, $dateRange)
    {
        return Order::whereHas('orderItems', function ($query) use ($seller) {
                $query->whereHas('product', function ($productQuery) use ($seller) {
                    $productQuery->where('seller_id', $seller->id);
                });
            })
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->get();
    }

    private function getSellerReviews($seller, $dateRange)
    {
        return Review::whereHas('product', function ($query) use ($seller) {
                $query->where('seller_id', $seller->id);
            })
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->get();
    }

    private function getSellerProducts($seller, $dateRange)
    {
        return Product::where('seller_id', $seller->id)
            ->where('status', 'approved')
            ->get();
    }

    private function calculateProductRevenue($product, $dateRange): float
    {
        return OrderItem::where('product_id', $product->id)
            ->whereHas('order', function ($query) use ($dateRange) {
                $query->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
            })
            ->sum('price');
    }

    private function calculateProductOrders($product, $dateRange): int
    {
        return OrderItem::where('product_id', $product->id)
            ->whereHas('order', function ($query) use ($dateRange) {
                $query->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
            })
            ->count();
    }

    private function calculateStockTurnover($product, $dateRange): float
    {
        $soldQuantity = OrderItem::where('product_id', $product->id)
            ->whereHas('order', function ($query) use ($dateRange) {
                $query->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
            })
            ->sum('quantity');

        return $product->stock > 0 ? $soldQuantity / $product->stock : 0;
    }

    private function getCategoryPerformance($productPerformance): array
    {
        $categoryData = [];
        foreach ($productPerformance as $item) {
            $category = $item['product']->classification;
            if (!isset($categoryData[$category])) {
                $categoryData[$category] = [
                    'revenue' => 0,
                    'orders' => 0,
                    'products' => 0
                ];
            }
            $categoryData[$category]['revenue'] += $item['revenue'];
            $categoryData[$category]['orders'] += $item['orders'];
            $categoryData[$category]['products']++;
        }

        return $categoryData;
    }

    private function getFastFulfillers($sellers, $dateRange): array
    {
        $fastFulfillers = [];
        foreach ($sellers as $seller) {
            $rate = $this->calculateSellerFulfillmentRate($seller, $dateRange);
            if ($rate >= 95) {
                $fastFulfillers[] = [
                    'seller' => $seller,
                    'fulfillment_rate' => $rate
                ];
            }
        }

        usort($fastFulfillers, function ($a, $b) {
            return $b['fulfillment_rate'] <=> $a['fulfillment_rate'];
        });

        return array_slice($fastFulfillers, 0, 10);
    }

    private function getLateShipments($sellers, $dateRange): array
    {
        // This would require tracking shipping dates, for now return empty array
        return [];
    }

    private function getTopRatedSellers($sellers, $dateRange): array
    {
        $topRated = [];
        foreach ($sellers as $seller) {
            $score = $this->calculateSellerSatisfactionScore($seller, $dateRange);
            if ($score > 0) {
                $topRated[] = [
                    'seller' => $seller,
                    'satisfaction_score' => $score
                ];
            }
        }

        usort($topRated, function ($a, $b) {
            return $b['satisfaction_score'] <=> $a['satisfaction_score'];
        });

        return array_slice($topRated, 0, 10);
    }

    private function getSatisfactionTrends($sellers, $dateRange): array
    {
        // Simplified implementation - would need more detailed tracking for real trends
        return [
            'improving' => 0,
            'stable' => 0,
            'declining' => 0
        ];
    }

    private function calculateSellerRetention($sellers, $dateRange): float
    {
        $totalSellers = $sellers->count();
        if ($totalSellers === 0) return 0;

        $activeSellers = $sellers->where('seller_status', 'active')->count();
        return ($activeSellers / $totalSellers) * 100;
    }

    private function calculateGrowthRate($sellers, $dateRange): float
    {
        // Simplified growth rate calculation
        return 0;
    }

    private function calculateRevenueGrowthRate($sellers, $dateRange): float
    {
        // Simplified revenue growth rate calculation
        return 0;
    }
}
