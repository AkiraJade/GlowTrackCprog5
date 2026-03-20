<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class SkinJournal extends Model
{
    protected $fillable = [
        'entry_date',
        'condition_score',
        'observations',
        'photo_path',
    ];

    protected $casts = [
        'entry_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getConditionScoreColor(): string
    {
        return match($this->condition_score) {
            1 => 'text-red-600',
            2 => 'text-orange-600',
            3 => 'text-yellow-600',
            4 => 'text-green-600',
            5 => 'text-emerald-600',
            default => 'text-gray-600'
        };
    }

    public function getConditionScoreLabel(): string
    {
        return match($this->condition_score) {
            1 => 'Poor',
            2 => 'Fair',
            3 => 'Good',
            4 => 'Very Good',
            5 => 'Excellent',
            default => 'Unknown'
        };
    }

    /**
     * Get average condition score trends.
     */
    public static function getAverageScoreTrends($period = '30days')
    {
        $dateRange = match($period) {
            '7days' => now()->subDays(7),
            '30days' => now()->subDays(30),
            '90days' => now()->subDays(90),
            '1year' => now()->subYear(),
            default => now()->subDays(30)
        };

        return static::where('entry_date', '>=', $dateRange)
            ->select(
                DB::raw('DATE(entry_date) as date'),
                DB::raw('AVG(condition_score) as avg_score'),
                DB::raw('COUNT(*) as entry_count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get condition score distribution.
     */
    public static function getScoreDistribution($dateRange = null)
    {
        $query = static::query();
        
        if ($dateRange && isset($dateRange['start'])) {
            $query->where('entry_date', '>=', $dateRange['start']);
        }

        return $query->select('condition_score', DB::raw('count(*) as count'))
            ->groupBy('condition_score')
            ->orderBy('condition_score')
            ->get();
    }

    /**
     * Get monthly journal entry trends.
     */
    public static function getMonthlyEntryTrends($months = 12)
    {
        return static::select(
                DB::raw('DATE_FORMAT(entry_date, "%Y-%m") as month'),
                DB::raw('COUNT(*) as entry_count'),
                DB::raw('AVG(condition_score) as avg_score')
            )
            ->where('entry_date', '>=', now()->subMonths($months))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    /**
     * Get skin condition trends by skin type.
     */
    public static function getTrendsBySkinType($dateRange = null)
    {
        $query = static::query()
            ->join('users', 'skin_journals.user_id', '=', 'users.id')
            ->join('skin_profiles', 'users.id', '=', 'skin_profiles.user_id')
            ->select(
                'skin_profiles.skin_type',
                DB::raw('AVG(skin_journals.condition_score) as avg_score'),
                DB::raw('COUNT(skin_journals.id) as entry_count')
            );
        
        if ($dateRange && isset($dateRange['start'])) {
            $query->where('skin_journals.entry_date', '>=', $dateRange['start']);
        }

        return $query->groupBy('skin_profiles.skin_type')
            ->orderBy('avg_score', 'desc')
            ->get();
    }

    /**
     * Get seasonal skin condition trends.
     */
    public static function getSeasonalTrends($year = null)
    {
        $year = $year ?? now()->year;
        
        return static::select(
                DB::raw('CASE 
                    WHEN MONTH(entry_date) IN (3,4,5) THEN "Spring"
                    WHEN MONTH(entry_date) IN (6,7,8) THEN "Summer"
                    WHEN MONTH(entry_date) IN (9,10,11) THEN "Fall"
                    ELSE "Winter"
                END as season'),
                DB::raw('AVG(condition_score) as avg_score'),
                DB::raw('COUNT(*) as entry_count'),
                DB::raw('MIN(condition_score) as min_score'),
                DB::raw('MAX(condition_score) as max_score')
            )
            ->whereYear('entry_date', $year)
            ->groupBy('season')
            ->get();
    }

    /**
     * Get users with most consistent journaling.
     */
    public static function getMostConsistentUsers($limit = 10, $dateRange = null)
    {
        $query = static::query()
            ->select('user_id', DB::raw('COUNT(*) as entry_count'))
            ->groupBy('user_id');
        
        if ($dateRange && isset($dateRange['start'])) {
            $query->where('entry_date', '>=', $dateRange['start']);
        }

        return $query->orderBy('entry_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get skin improvement trends.
     */
    public static function getImprovementTrends($dateRange = null)
    {
        $query = static::query();
        
        if ($dateRange && isset($dateRange['start'])) {
            $query->where('entry_date', '>=', $dateRange['start']);
        }

        // Get users with multiple entries to track improvement
        $usersWithMultipleEntries = $query->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) >= 2')
            ->pluck('user_id');

        $improvements = [];
        foreach ($usersWithMultipleEntries as $userId) {
            $firstEntry = static::where('user_id', $userId)
                ->orderBy('entry_date', 'asc')
                ->first();
            
            $lastEntry = static::where('user_id', $userId)
                ->orderBy('entry_date', 'desc')
                ->first();

            if ($firstEntry && $lastEntry) {
                $improvement = $lastEntry->condition_score - $firstEntry->condition_score;
                $improvements[] = [
                    'user_id' => $userId,
                    'improvement' => $improvement,
                    'first_score' => $firstEntry->condition_score,
                    'last_score' => $lastEntry->condition_score,
                    'days_tracked' => $firstEntry->entry_date->diffInDays($lastEntry->entry_date)
                ];
            }
        }

        // Sort by improvement (highest first)
        usort($improvements, function ($a, $b) {
            return $b['improvement'] <=> $a['improvement'];
        });

        return array_slice($improvements, 0, 20);
    }
}
