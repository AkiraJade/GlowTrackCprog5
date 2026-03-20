<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoutineConflictWarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'skincare_routine_id',
        'ingredient_conflict_id',
        'conflicting_ingredients',
        'is_acknowledged',
        'acknowledged_at',
    ];

    protected $casts = [
        'conflicting_ingredients' => 'array',
        'is_acknowledged' => 'boolean',
        'acknowledged_at' => 'datetime',
    ];

    /**
     * Get the user that owns the conflict warning.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the skincare routine that owns the conflict warning.
     */
    public function skincareRoutine(): BelongsTo
    {
        return $this->belongsTo(SkincareRoutine::class);
    }

    /**
     * Get the ingredient conflict that owns the warning.
     */
    public function ingredientConflict(): BelongsTo
    {
        return $this->belongsTo(IngredientConflict::class);
    }

    /**
     * Mark the warning as acknowledged.
     */
    public function acknowledge(): void
    {
        $this->is_acknowledged = true;
        $this->acknowledged_at = now();
        $this->save();
    }

    /**
     * Scope a query to only include unacknowledged warnings.
     */
    public function scopeUnacknowledged($query)
    {
        return $query->where('is_acknowledged', false);
    }

    /**
     * Scope a query to only include acknowledged warnings.
     */
    public function scopeAcknowledged($query)
    {
        return $query->where('is_acknowledged', true);
    }

    /**
     * Get formatted conflicting ingredients.
     */
    public function getFormattedConflictingIngredientsAttribute(): string
    {
        if (empty($this->conflicting_ingredients)) {
            return '';
        }
        
        return implode(' + ', $this->conflicting_ingredients);
    }

    /**
     * Get the severity from the related ingredient conflict.
     */
    public function getSeverityAttribute(): string
    {
        return $this->ingredientConflict?->severity ?? 'unknown';
    }

    /**
     * Get the severity color from the related ingredient conflict.
     */
    public function getSeverityColorAttribute(): string
    {
        return $this->ingredientConflict?->severity_color ?? 'gray';
    }

    /**
     * Get the severity icon from the related ingredient conflict.
     */
    public function getSeverityIconAttribute(): string
    {
        return $this->ingredientConflict?->severity_icon ?? '❓';
    }

    /**
     * Get the severity label from the related ingredient conflict.
     */
    public function getSeverityLabelAttribute(): string
    {
        return $this->ingredientConflict?->severity_label ?? 'Unknown Risk';
    }
}
