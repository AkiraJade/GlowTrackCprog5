<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SkinProfile;
use App\Models\SkinJournal;
use App\Models\Product;
use App\Models\Review;
use App\Models\Order;
use App\Models\SkincareRoutine;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SkinTrendReportController extends Controller
{
    /**
     * Display the main skin trends dashboard.
     */
    public function index(Request $request): View
    {
        $filters = [
            'period' => $request->get('period', 'all'),
            'skin_type' => $request->get('skin_type', 'all'),
            'concern' => $request->get('concern', 'all'),
        ];

        // Get overview statistics
        $overview = $this->getOverviewStats($filters);

        // Get detailed trend data
        $skinTypeDistribution = $this->getSkinTypeDistribution($filters);
        $skinConcernsTrends = $this->getSkinConcernsTrends($filters);
        $popularIngredients = $this->getPopularIngredients($filters);
        $ageDemographics = $this->getAgeDemographics($filters);
        $seasonalTrends = $this->getSeasonalTrends($filters);
        $regionalData = $this->getRegionalTrends($filters);

        return view('admin.skin-trends', compact(
            'overview',
            'skinTypeDistribution',
            'skinConcernsTrends',
            'popularIngredients',
            'ageDemographics',
            'seasonalTrends',
            'regionalData',
            'filters'
        ));
    }

    /**
     * Get overview statistics for the dashboard.
     */
    private function getOverviewStats(array $filters): array
    {
        $dateRange = $this->getDateRange($filters['period']);

        return [
            'total_users' => User::where('created_at', '>=', $dateRange['start'])->count(),
            'active_profiles' => SkinProfile::where('created_at', '>=', $dateRange['start'])->count(),
            'total_journals' => SkinJournal::where('created_at', '>=', $dateRange['start'])->count(),
            'avg_skin_score' => SkinJournal::where('created_at', '>=', $dateRange['start'])->avg('condition_score') ?? 0,
            'most_common_concern' => $this->getMostCommonConcern($dateRange),
            'most_common_type' => $this->getMostCommonSkinType($dateRange),
        ];
    }

    /**
     * Get skin type distribution data.
     */
    private function getSkinTypeDistribution(array $filters): array
    {
        $dateRange = $this->getDateRange($filters['period']);

        $query = SkinProfile::where('created_at', '>=', $dateRange['start']);

        if ($filters['skin_type'] !== 'all') {
            $query->where('skin_type', $filters['skin_type']);
        }

        $distribution = $query->select('skin_type', DB::raw('count(*) as count'))
            ->groupBy('skin_type')
            ->orderBy('count', 'desc')
            ->get();

        return [
            'data' => $distribution,
            'total' => $distribution->sum('count'),
            'chart_data' => $distribution->map(function ($item) use ($distribution) {
                return [
                    'label' => ucfirst($item->skin_type),
                    'value' => $item->count,
                    'percentage' => $this->calculatePercentage($item->count, $distribution->sum('count')),
                ];
            }),
        ];
    }

    /**
     * Get skin concerns trends data.
     */
    private function getSkinConcernsTrends(array $filters): array
    {
        $dateRange = $this->getDateRange($filters['period']);

        $query = SkinProfile::where('created_at', '>=', $dateRange['start']);

        if ($filters['concern'] !== 'all') {
            $query->whereJsonContains('skin_concerns', $filters['concern']);
        }

        $profiles = $query->get();

        $concerns = [];
        foreach ($profiles as $profile) {
            if ($profile->skin_concerns) {
                foreach ($profile->skin_concerns as $concern) {
                    $concerns[$concern] = ($concerns[$concern] ?? 0) + 1;
                }
            }
        }

        arsort($concerns);

        return [
            'data' => $concerns,
            'top_concerns' => array_slice($concerns, 0, 10, true),
            'chart_data' => array_map(function ($count, $concern) use ($profiles) {
                return [
                    'label' => ucfirst($concern),
                    'value' => $count,
                    'percentage' => $this->calculatePercentage($count, $profiles->count()),
                ];
            }, array_values($concerns), array_keys($concerns)),
        ];
    }

    /**
     * Get popular ingredients data.
     */
    private function getPopularIngredients(array $filters): array
    {
        $dateRange = $this->getDateRange($filters['period']);

        // Get ingredients from products
        $productIngredients = Product::where('created_at', '>=', $dateRange['start'])
            ->whereNotNull('active_ingredients')
            ->get()
            ->flatMap(function ($product) {
                return $product->active_ingredients ?? [];
            })
            ->countBy(function ($ingredient) {
                return strtolower($ingredient);
            });

        // Get ingredients from reviews
        $reviewMentions = Review::where('created_at', '>=', $dateRange['start'])
            ->get()
            ->flatMap(function ($review) {
                // Extract ingredient mentions from review text (simplified)
                $commonIngredients = [
                    'retinol', 'vitamin c', 'hyaluronic acid', 'niacinamide',
                    'salicylic acid', 'aha', 'bha', 'ceramides', 'peptides'
                ];
                
                $mentions = [];
                foreach ($commonIngredients as $ingredient) {
                    if (stripos($review->comment, $ingredient) !== false) {
                        $mentions[] = $ingredient;
                    }
                }
                return $mentions;
            })
            ->countBy();

        // Combine and rank ingredients
        $allIngredients = $productIngredients->merge($reviewMentions);
        $sortedIngredients = $allIngredients->sortByDesc(function ($count) {
            return $count;
        });

        return [
            'data' => $sortedIngredients->take(20),
            'top_ingredients' => $sortedIngredients->take(10),
            'chart_data' => $sortedIngredients->take(10)->map(function ($count, $ingredient) {
                return [
                    'label' => ucfirst($ingredient),
                    'value' => $count,
                ];
            })->values(),
        ];
    }

    /**
     * Get age demographics data.
     */
    private function getAgeDemographics(array $filters): array
    {
        $dateRange = $this->getDateRange($filters['period']);

        $users = User::where('created_at', '>=', $dateRange['start'])
            ->whereHas('skinProfile')
            ->with('skinProfile')
            ->get();

        $ageGroups = [
            '18-24' => 0,
            '25-34' => 0,
            '35-44' => 0,
            '45-54' => 0,
            '55+' => 0,
        ];

        foreach ($users as $user) {
            $age = $user->created_at->age;
            if ($age >= 18 && $age <= 24) $ageGroups['18-24']++;
            elseif ($age >= 25 && $age <= 34) $ageGroups['25-34']++;
            elseif ($age >= 35 && $age <= 44) $ageGroups['35-44']++;
            elseif ($age >= 45 && $age <= 54) $ageGroups['45-54']++;
            elseif ($age >= 55) $ageGroups['55+']++;
        }

        return [
            'data' => $ageGroups,
            'total' => array_sum($ageGroups),
            'chart_data' => array_map(function ($count, $group) use ($ageGroups) {
                return [
                    'label' => $group,
                    'value' => $count,
                    'percentage' => $this->calculatePercentage($count, array_sum($ageGroups)),
                ];
            }, $ageGroups, array_keys($ageGroups)),
        ];
    }

    /**
     * Get seasonal trends data.
     */
    private function getSeasonalTrends(array $filters): array
    {
        $dateRange = $this->getDateRange($filters['period']);

        $journals = SkinJournal::where('created_at', '>=', $dateRange['start'])
            ->get()
            ->groupBy(function ($journal) {
                return $journal->created_at->format('Y-m');
            });

        $seasonalData = [];
        foreach ($journals as $month => $monthJournals) {
            $season = $this->getSeason($month);
            
            if (!isset($seasonalData[$season])) {
                $seasonalData[$season] = [
                    'avg_score' => [],
                    'total_journals' => 0,
                    'concerns' => [],
                ];
            }

            $avgScore = $monthJournals->avg('condition_score');
            $seasonalData[$season]['avg_score'][] = $avgScore;
            $seasonalData[$season]['total_journals'] += $monthJournals->count();

            // Collect concerns for this season
            foreach ($monthJournals as $journal) {
                $user = User::find($journal->user_id);
                if ($user && $user->skinProfile && $user->skinProfile->skin_concerns) {
                    foreach ($user->skinProfile->skin_concerns as $concern) {
                        if (!isset($seasonalData[$season]['concerns'][$concern])) {
                            $seasonalData[$season]['concerns'][$concern] = 0;
                        }
                        $seasonalData[$season]['concerns'][$concern]++;
                    }
                }
            }
        }

        // Process seasonal data
        foreach ($seasonalData as $season => &$data) {
            $data['avg_score'] = count($data['avg_score']) > 0 
                ? array_sum($data['avg_score']) / count($data['avg_score']) 
                : 0;
            
            arsort($data['concerns']);
            $data['top_concern'] = array_key_first($data['concerns']) ?? 'None';
        }

        return [
            'data' => $seasonalData,
            'chart_data' => array_map(function ($data, $season) {
                return [
                    'label' => ucfirst($season),
                    'avg_score' => round($data['avg_score'], 2),
                    'total_journals' => $data['total_journals'],
                    'top_concern' => $data['top_concern'],
                ];
            }, $seasonalData, array_keys($seasonalData)),
        ];
    }

    /**
     * Get regional trends data.
     */
    private function getRegionalTrends(array $filters): array
    {
        $dateRange = $this->getDateRange($filters['period']);

        $users = User::where('created_at', '>=', $dateRange['start'])
            ->whereHas('skinProfile')
            ->with('skinProfile')
            ->get();

        // Extract regions from addresses (simplified approach)
        $regionalData = [];
        foreach ($users as $user) {
            $region = $this->extractRegion($user->address);
            
            if (!isset($regionalData[$region])) {
                $regionalData[$region] = [
                    'users' => 0,
                    'skin_types' => [],
                    'concerns' => [],
                ];
            }

            $regionalData[$region]['users']++;
            
            // Track skin types
            $skinType = $user->skinProfile->skin_type;
            if (!isset($regionalData[$region]['skin_types'][$skinType])) {
                $regionalData[$region]['skin_types'][$skinType] = 0;
            }
            $regionalData[$region]['skin_types'][$skinType]++;

            // Track concerns
            if ($user->skinProfile->skin_concerns) {
                foreach ($user->skinProfile->skin_concerns as $concern) {
                    if (!isset($regionalData[$region]['concerns'][$concern])) {
                        $regionalData[$region]['concerns'][$concern] = 0;
                    }
                    $regionalData[$region]['concerns'][$concern]++;
                }
            }
        }

        // Process regional data for charts
        $chartData = [];
        foreach ($regionalData as $region => $data) {
            arsort($data['skin_types']);
            arsort($data['concerns']);

            $chartData[] = [
                'region' => $region,
                'users' => $data['users'],
                'dominant_skin_type' => array_key_first($data['skin_types']),
                'top_concern' => array_key_first($data['concerns']),
            ];
        }

        return [
            'data' => $regionalData,
            'chart_data' => $chartData,
        ];
    }

    /**
     * Export skin trends data to CSV.
     */
    public function exportCsv(Request $request): JsonResponse
    {
        $this->authorize('viewReports', User::class);

        $filters = [
            'period' => $request->get('period', 'all'),
            'skin_type' => $request->get('skin_type', 'all'),
            'concern' => $request->get('concern', 'all'),
        ];

        $data = [
            'overview' => $this->getOverviewStats($filters),
            'skin_types' => $this->getSkinTypeDistribution($filters),
            'concerns' => $this->getSkinConcernsTrends($filters),
            'ingredients' => $this->getPopularIngredients($filters),
            'age_demographics' => $this->getAgeDemographics($filters),
            'seasonal' => $this->getSeasonalTrends($filters),
            'regional' => $this->getRegionalTrends($filters),
        ];

        $filename = "skin_trends_" . now()->format('Y-m-d') . ".csv";
        $filepath = storage_path('app/temp/' . $filename);

        $this->generateCsvFile($filepath, $data);

        return response()->json([
            'message' => 'Skin trends report exported successfully',
            'filename' => $filename,
            'download_url' => route('admin.skin-trends.download', $filename),
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
     * Get real-time trend data for AJAX requests.
     */
    public function getTrendData(Request $request): JsonResponse
    {
        $this->authorize('viewReports', User::class);

        $type = $request->get('type');
        $filters = [
            'period' => $request->get('period', 'all'),
            'skin_type' => $request->get('skin_type', 'all'),
            'concern' => $request->get('concern', 'all'),
        ];

        switch ($type) {
            case 'skin_types':
                return response()->json($this->getSkinTypeDistribution($filters));
            case 'concerns':
                return response()->json($this->getSkinConcernsTrends($filters));
            case 'ingredients':
                return response()->json($this->getPopularIngredients($filters));
            case 'age_demographics':
                return response()->json($this->getAgeDemographics($filters));
            case 'seasonal':
                return response()->json($this->getSeasonalTrends($filters));
            case 'regional':
                return response()->json($this->getRegionalTrends($filters));
            default:
                return response()->json(['error' => 'Invalid trend type'], 400);
        }
    }

    /**
     * Helper methods
     */
    private function getDateRange(string $period): array
    {
        $now = now();
        
        switch ($period) {
            case '7days':
                return ['start' => $now->copy()->subDays(7), 'end' => $now];
            case '30days':
                return ['start' => $now->copy()->subDays(30), 'end' => $now];
            case '90days':
                return ['start' => $now->copy()->subDays(90), 'end' => $now];
            case '1year':
                return ['start' => $now->copy()->subYear(), 'end' => $now];
            case 'all':
            default:
                return ['start' => $now->copy()->subYears(10), 'end' => $now];
        }
    }

    private function calculatePercentage(int $value, int $total): float
    {
        return $total > 0 ? round(($value / $total) * 100, 2) : 0;
    }

    private function getMostCommonConcern(array $dateRange): string
    {
        $concerns = SkinProfile::where('created_at', '>=', $dateRange['start'])
            ->whereNotNull('skin_concerns')
            ->get()
            ->flatMap(function ($profile) {
                return $profile->skin_concerns ?? [];
            })
            ->countBy();

        return $concerns->sortDesc()->keys()->first() ?? 'None';
    }

    private function getMostCommonSkinType(array $dateRange): string
    {
        $mostCommon = SkinProfile::where('created_at', '>=', $dateRange['start'])
            ->select('skin_type', DB::raw('count(*) as count'))
            ->groupBy('skin_type')
            ->orderByDesc('count')
            ->first();

        return $mostCommon ? $mostCommon->skin_type : 'None';
    }

    private function getSeason(string $month): string
    {
        $monthNum = (int) explode('-', $month)[1];
        
        if ($monthNum >= 3 && $monthNum <= 5) return 'spring';
        if ($monthNum >= 6 && $monthNum <= 8) return 'summer';
        if ($monthNum >= 9 && $monthNum <= 11) return 'fall';
        return 'winter';
    }

    private function extractRegion(?string $address): string
    {
        if (!$address) return 'Unknown';

        // Simplified region extraction - in production, use proper geocoding
        $regions = [
            'north', 'south', 'east', 'west', 'central',
            'california', 'texas', 'new york', 'florida',
            'asia', 'europe', 'america', 'africa'
        ];

        foreach ($regions as $region) {
            if (stripos($address, $region) !== false) {
                return ucfirst($region);
            }
        }

        return 'Other';
    }

    private function generateCsvFile(string $filepath, array $data): void
    {
        $handle = fopen($filepath, 'w');
        
        // Write header
        fputcsv($handle, ['Skin Trends Report - ' . now()->format('Y-m-d')]);
        fputcsv($handle, []);

        // Overview section
        fputcsv($handle, ['Overview']);
        fputcsv($handle, ['Metric', 'Value']);
        foreach ($data['overview'] as $key => $value) {
            fputcsv($handle, [ucfirst(str_replace('_', ' ', $key)), $value]);
        }
        fputcsv($handle, []);

        // Skin types
        fputcsv($handle, ['Skin Type Distribution']);
        fputcsv($handle, ['Skin Type', 'Count', 'Percentage']);
        foreach ($data['skin_types']['chart_data'] as $item) {
            fputcsv($handle, [$item['label'], $item['value'], $item['percentage'] . '%']);
        }
        fputcsv($handle, []);

        // Top concerns
        fputcsv($handle, ['Top Skin Concerns']);
        fputcsv($handle, ['Concern', 'Count', 'Percentage']);
        foreach ($data['concerns']['top_concerns'] as $concern => $count) {
            fputcsv($handle, [ucfirst($concern), $count]);
        }
        fputcsv($handle, []);

        // Popular ingredients
        fputcsv($handle, ['Popular Ingredients']);
        fputcsv($handle, ['Ingredient', 'Usage Count']);
        foreach ($data['ingredients']['top_ingredients'] as $ingredient => $count) {
            fputcsv($handle, [ucfirst($ingredient), $count]);
        }

        fclose($handle);
    }
}
