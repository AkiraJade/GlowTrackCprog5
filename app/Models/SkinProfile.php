<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkinProfile extends Model
{
    protected $fillable = [
        'skin_type',
        'skin_concerns',
        'ingredient_allergies',
        'notes',
    ];

    protected $casts = [
        'skin_concerns' => 'array',
        'ingredient_allergies' => 'array',
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
}
