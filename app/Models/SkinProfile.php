<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class SkinProfile extends Model
{
    protected $fillable = [
        'user_id',
        'skin_type',
        'notes',
    ];

    protected $casts = [
        'user_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAvailableSkinTypes(): array
    {
        return ['Oily', 'Dry', 'Combination', 'Sensitive', 'Normal'];
    }

    public function getAvailableConcerns(): array
    {
        return [
            'Acne', 'Hyperpigmentation', 'Aging', 'Dryness', 
            'Oily Skin', 'Sensitive Skin', 'Dark Spots', 'Fine Lines'
        ];
    }

    public function getAvailableAllergies(): array
    {
        return [
            'Niacinamide', 'Retinol', 'Hyaluronic Acid', 'Vitamin C',
            'Salicylic Acid', 'Benzoyl Peroxide', 'Fragrance', 'Alcohol'
        ];
    }

    /**
     * Get skin type distribution for trend analysis.
     */
    public static function getSkinTypeDistribution($dateRange = null)
    {
        $query = static::query();
        
        if ($dateRange && isset($dateRange['start'])) {
            $query->where('created_at', '>=', $dateRange['start']);
        }

        return $query->select('skin_type', DB::raw('count(*) as count'))
            ->groupBy('skin_type')
            ->orderBy('count', 'desc')
            ->get();
    }

    /**
     * Get top skin concerns for trend analysis.
     */
    public static function getTopConcerns($limit = 10, $dateRange = null)
    {
        $query = static::query();
        
        if ($dateRange && isset($dateRange['start'])) {
            $query->where('created_at', '>=', $dateRange['start']);
        }

        $profiles = $query->whereNotNull('skin_concerns')->get();
        
        $concerns = [];
        foreach ($profiles as $profile) {
            if ($profile->skin_concerns) {
                foreach ($profile->skin_concerns as $concern) {
                    $concerns[$concern] = ($concerns[$concern] ?? 0) + 1;
                }
            }
        }

        arsort($concerns);
        return array_slice($concerns, 0, $limit, true);
    }

    /**
     * Get skin type and concern combinations.
     */
    public static function getTypeConcernCombinations($dateRange = null)
    {
        $query = static::query();
        
        if ($dateRange && isset($dateRange['start'])) {
            $query->where('created_at', '>=', $dateRange['start']);
        }

        return $query->whereNotNull('skin_concerns')
            ->get()
            ->groupBy(function ($profile) {
                return $profile->skin_type;
            })
            ->map(function ($profiles) {
                $concerns = [];
                foreach ($profiles as $profile) {
                    if ($profile->skin_concerns) {
                        foreach ($profile->skin_concerns as $concern) {
                            $concerns[$concern] = ($concerns[$concern] ?? 0) + 1;
                        }
                    }
                }
                arsort($concerns);
                return $concerns;
            });
    }

    /**
     * Get allergy trends.
     */
    public static function getAllergyTrends($limit = 10, $dateRange = null)
    {
        $query = static::query();
        
        if ($dateRange && isset($dateRange['start'])) {
            $query->where('created_at', '>=', $dateRange['start']);
        }

        $profiles = $query->whereNotNull('ingredient_allergies')->get();
        
        $allergies = [];
        foreach ($profiles as $profile) {
            if ($profile->ingredient_allergies) {
                foreach ($profile->ingredient_allergies as $allergy) {
                    $allergies[$allergy] = ($allergies[$allergy] ?? 0) + 1;
                }
            }
        }

        arsort($allergies);
        return array_slice($allergies, 0, $limit, true);
    }

    /**
     * Get monthly profile creation trends.
     */
    public static function getMonthlyTrends($months = 12)
    {
        return static::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths($months))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }
}
