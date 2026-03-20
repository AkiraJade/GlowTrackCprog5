<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoutineFavorite extends Model
{
    protected $fillable = [
        'user_id',
        'skincare_routine_id',
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
