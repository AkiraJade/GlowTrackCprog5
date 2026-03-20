<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkincareRoutine extends Model
{
    protected $fillable = [
        'name',
        'schedule',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(RoutineStep::class, 'routine_id')->orderBy('step_order');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(RoutineFavorite::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(RoutineRating::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(RoutineReview::class);
    }

    public function getAverageRating(): float
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

    public function getRatingCount(): int
    {
        return $this->ratings()->count();
    }

    public function isFavoritedBy(?User $user): bool
    {
        if (!$user) return false;
        return $this->favorites()->where('user_id', $user->id)->exists();
    }

    public function getUserRating(?User $user): ?int
    {
        if (!$user) return null;
        return $this->ratings()->where('user_id', $user->id)->value('rating');
    }

    public function getUserReview(?User $user): ?RoutineReview
    {
        if (!$user) return null;
        return $this->reviews()->where('user_id', $user->id)->first();
    }

    public function getAvailableSteps(): array
    {
        return ['Cleanser', 'Toner', 'Serum', 'Moisturizer', 'SPF', 'Other'];
    }

    public function getStepIcon(string $step): string
    {
        return match($step) {
            'Cleanser' => '💧',
            'Toner' => '🌸',
            'Serum' => '💉',
            'Moisturizer' => '🧴',
            'SPF' => '☀️',
            'Other' => '✨',
            default => '📝'
        };
    }
}
