<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoutineRating extends Model
{
    protected $fillable = [
        'user_id',
        'skincare_routine_id',
        'rating',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function skincareRoutine(): BelongsTo
    {
        return $this->belongsTo(SkincareRoutine::class);
    }
}
