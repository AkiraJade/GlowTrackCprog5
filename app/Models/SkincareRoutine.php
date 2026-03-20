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
        return $this->hasMany(RoutineStep::class)->orderBy('step_order');
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
