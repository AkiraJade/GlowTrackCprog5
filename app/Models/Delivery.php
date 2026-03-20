<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    protected $fillable = [
        'order_id',
        'delivery_personnel_id',
        'status',
        'expected_delivery_date',
        'actual_delivery_date',
        'collection_point',
        'destination_address',
        'confirmation_photo_path',
        'notes',
    ];

    protected $casts = [
        'expected_delivery_date' => 'date',
        'actual_delivery_date' => 'date',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function deliveryPersonnel(): BelongsTo
    {
        return $this->belongsTo(DeliveryPersonnel::class);
    }

    public function getStatusColor(): string
    {
        return match($this->status) {
            'Pending Assignment' => 'text-gray-600',
            'Assigned' => 'text-blue-600',
            'Picked Up' => 'text-yellow-600',
            'In Transit' => 'text-purple-600',
            'Delivered' => 'text-green-600',
            'Failed' => 'text-red-600',
            'Returned' => 'text-orange-600',
            default => 'text-gray-600'
        };
    }

    public function getStatusBadgeColor(): string
    {
        return match($this->status) {
            'Pending Assignment' => 'bg-gray-100 text-gray-800',
            'Assigned' => 'bg-blue-100 text-blue-800',
            'Picked Up' => 'bg-yellow-100 text-yellow-800',
            'In Transit' => 'bg-purple-100 text-purple-800',
            'Delivered' => 'bg-green-100 text-green-800',
            'Failed' => 'bg-red-100 text-red-800',
            'Returned' => 'bg-orange-100 text-orange-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function isOverdue(): bool
    {
        return $this->expected_delivery_date && 
               $this->expected_delivery_date < now() && 
               !in_array($this->status, ['Delivered', 'Failed', 'Returned']);
    }

    public function getDaysUntilDelivery(): int
    {
        if (!$this->expected_delivery_date) return 0;
        return now()->diffInDays($this->expected_delivery_date, false);
    }
}
