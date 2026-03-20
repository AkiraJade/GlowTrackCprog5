<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
