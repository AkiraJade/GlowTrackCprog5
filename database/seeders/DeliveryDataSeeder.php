<?php

namespace Database\Seeders;

use App\Models\DeliveryPersonnel;
use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Database\Seeder;

class DeliveryDataSeeder extends Seeder
{
    /**
     * Seed delivery personnel and deliveries.
     */
    public function run(): void
    {
        // Create delivery personnel
        $deliveryPersonnel = [
            [
                'name' => 'Alice Rodriguez',
                'email' => 'alice.r@glowtrack.com',
                'phone' => '+1-555-0101',
                'is_active' => true,
            ],
            [
                'name' => 'Brian Chen',
                'email' => 'brian.c@glowtrack.com',
                'phone' => '+1-555-0102',
                'is_active' => true,
            ],
            [
                'name' => 'Sophia Martinez',
                'email' => 'sophia.m@glowtrack.com',
                'phone' => '+1-555-0103',
                'is_active' => true,
            ],
            [
                'name' => 'James Thompson',
                'email' => 'james.t@glowtrack.com',
                'phone' => '+1-555-0104',
                'is_active' => true,
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria.s@glowtrack.com',
                'phone' => '+1-555-0105',
                'is_active' => false,
            ],
        ];

        $deliveryPersonnelIds = [];
        foreach ($deliveryPersonnel as $personnel) {
            $created = DeliveryPersonnel::create($personnel);
            $deliveryPersonnelIds[] = $created->id;
        }

        // Assign deliveries to shipped orders
        $shippedOrders = Order::where('status', 'shipped')->limit(15)->get();

        $statuses = ['In Transit', 'Delivered', 'Failed', 'Returned'];

        foreach ($shippedOrders as $order) {
            Delivery::create([
                'order_id' => $order->id,
                'delivery_personnel_id' => $deliveryPersonnelIds[array_rand($deliveryPersonnelIds)],
                'status' => $statuses[array_rand($statuses)],
                'expected_delivery_date' => now()->addDays(rand(1, 4)),
                'actual_delivery_date' => rand(0, 1) ? now()->subDays(rand(0, 2)) : null,
                'collection_point' => 'Main Warehouse',
                'destination_address' => $order->shipping_address ?? '123 Customer St',
                'notes' => rand(0, 1) ? 'Package delivered safely' : null,
            ]);
        }

        $this->command->info('Delivery personnel and deliveries seeded successfully!');
    }
}
