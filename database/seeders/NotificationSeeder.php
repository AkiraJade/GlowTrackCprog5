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
                'is_read' => false,
            ],
            [
                'type' => 'delivery_update',
                'title' => 'Out for Delivery',
                'message' => 'Your order #12345 is out for delivery and will arrive today.',
                'is_read' => false,
            ],
            [
                'type' => 'low_stock',
                'title' => 'Low Stock Alert',
                'message' => 'Your product "Vitamin C Serum" is running low on stock (5 units remaining).',
                'is_read' => false,
            ],
            [
                'type' => 'product_approved',
                'title' => 'Product Approved',
                'message' => 'Your product "Hyaluronic Acid Moisturizer" has been approved and is now live.',
                'is_read' => false,
            ],
            [
                'type' => 'new_review',
                'title' => 'New Review',
                'message' => 'Your product received a 5-star review from a customer.',
                'is_read' => false,
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::create(array_merge($notification, ['user_id' => $user->id]));
        }
    }
}
