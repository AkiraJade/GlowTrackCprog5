<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user (or create one if none exists)
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
                'role' => 'customer',
            ]);
        }

        // Create sample notifications
        $notifications = [
            [
                'type' => 'order_status',
                'title' => 'Order Confirmed',
                'message' => 'Your order #12345 has been confirmed and is being processed.',
                'data' => ['order_id' => 12345, 'status' => 'confirmed'],
                'is_read' => false,
            ],
            [
                'type' => 'delivery_update',
                'title' => 'Out for Delivery',
                'message' => 'Your order #12345 is out for delivery and will arrive today.',
                'data' => ['order_id' => 12345, 'delivery_id' => 678, 'status' => 'In Transit'],
                'is_read' => false,
            ],
            [
                'type' => 'low_stock',
                'title' => 'Low Stock Alert',
                'message' => 'Your product "Vitamin C Serum" is running low on stock (5 units remaining).',
                'data' => ['product_id' => 101, 'current_stock' => 5, 'threshold' => 10],
                'is_read' => false,
            ],
            [
                'type' => 'product_approved',
                'title' => 'Product Approved',
                'message' => 'Your product "Hyaluronic Acid Moisturizer" has been approved and is now live.',
                'data' => ['product_id' => 102],
                'is_read' => true,
            ],
            [
                'type' => 'new_review',
                'title' => 'New Review Received',
                'message' => 'Someone left a 5-star review on your product "Retinol Cream".',
                'data' => ['product_id' => 103, 'rating' => 5],
                'is_read' => true,
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::create(array_merge($notification, ['user_id' => $user->id]));
        }
    }
}
