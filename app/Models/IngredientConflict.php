<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IngredientConflict extends Model
{
    use HasFactory;

    protected $fillable = [
        'ingredient_1',
        'ingredient_2',
        'severity',
        'description',
        'recommendation',
        'alternatives',
        'is_active',
    ];

    protected $casts = [
        'alternatives' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the routine conflict warnings for this ingredient conflict.
     */
    public function routineConflictWarnings(): HasMany
    {
        return $this->hasMany(RoutineConflictWarning::class);
    }

    /**
     * Scope a query to only include active conflicts.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by severity.
     */
    public function scopeBySeverity($query, $severity)
    {
        return $query->where('severity', $severity);
    }

    /**
     * Get severity color for UI display.
     */
    public function getSeverityColorAttribute(): string
    {
        return match($this->severity) {
            'low' => 'yellow',
            'moderate' => 'orange',
            'high' => 'red',
            'severe' => 'purple',
            default => 'gray',
        };
    }

    /**
     * Get severity icon for UI display.
     */
    public function getSeverityIconAttribute(): string
    {
        return match($this->severity) {
            'low' => '⚠️',
            'moderate' => '⚡',
            'high' => '🔥',
            'severe' => '☠️',
            default => '❓',
        };
    }

    /**
     * Get severity label for display.
     */
    public function getSeverityLabelAttribute(): string
    {
        return match($this->severity) {
            'low' => 'Low Risk',
            'moderate' => 'Moderate Risk',
            'high' => 'High Risk',
            'severe' => 'Severe Risk',
            default => 'Unknown',
        };
    }

    /**
     * Check if this conflict involves the given ingredient.
     */
    public function involvesIngredient(string $ingredient): bool
    {
        return strtolower($this->ingredient_1) === strtolower($ingredient) ||
               strtolower($this->ingredient_2) === strtolower($ingredient);
    }

    /**
     * Get the other ingredient in the conflict pair.
     */
    public function getOtherIngredient(string $ingredient): string
    {
        if (strtolower($this->ingredient_1) === strtolower($ingredient)) {
            return $this->ingredient_2;
        }
        
        if (strtolower($this->ingredient_2) === strtolower($ingredient)) {
            return $this->ingredient_1;
        }
        
        return '';
    }

    /**
     * Format the conflict pair for display.
     */
    public function getConflictPairAttribute(): string
    {
        return "{$this->ingredient_1} + {$this->ingredient_2}";
    }

    /**
     * Get formatted alternatives list.
     */
    public function getFormattedAlternativesAttribute(): string
    {
        if (empty($this->alternatives)) {
            return 'None available';
        }
        
        return implode(', ', $this->alternatives);
    }
}
