<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoutineStep extends Model
{
    protected $fillable = [
        'step_type',
        'product_name',
        'product_id',
        'step_order',
    ];

    public function routine(): BelongsTo
    {
        return $this->belongsTo(SkincareRoutine::class, 'routine_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getStepIcon(): string
    {
        return match($this->step_type) {
            'Cleanser' => '💧',
            'Toner' => '🌸',
            'Serum' => '💉',
            'Moisturizer' => '🧴',
            'SPF' => '☀️',
            'Other' => '✨',
            default => '📝'
        };
    }

    public function isCustomProduct(): bool
    {
        return is_null($this->product_id) && !is_null($this->product_name);
    }
}
