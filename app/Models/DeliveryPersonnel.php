<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryPersonnel extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }

    public function activeDeliveries(): HasMany
    {
        return $this->deliveries()->whereIn('status', ['Assigned', 'Picked Up', 'In Transit']);
    }

    public function completedDeliveries(): HasMany
    {
        return $this->deliveries()->where('status', 'Delivered');
    }

    public function getDeliveryStats(): array
    {
        $total = $this->deliveries()->count();
        $completed = $this->completedDeliveries()->count();
        $active = $this->activeDeliveries()->count();

        return [
            'total' => $total,
            'completed' => $completed,
            'active' => $active,
            'completion_rate' => $total > 0 ? round(($completed / $total) * 100, 1) : 0,
        ];
    }

    public function getStatusBadge(): string
    {
        return $this->is_active 
            ? '<span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Active</span>'
            : '<span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Inactive</span>';
    }
}
