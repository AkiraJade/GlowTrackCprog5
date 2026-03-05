<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateTestOrdersSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get customer user
        $customer = User::where('email', 'john@glowtrack.com')->first();
        if (!$customer) {
            $this->command->error('Customer john@glowtrack.com not found!');
            return;
        }

        // Get some products
        $products = Product::where('status', 'approved')->take(3)->get();
        if ($products->count() < 1) {
            $this->command->error('No approved products found!');
            return;
        }

        // Create test orders for customer
        $orders = [
            [
                'status' => 'confirmed',
                'total_amount' => 89.97,
                'shipping_address' => '456 Customer Avenue, Customer City, CC 67890',
                'city' => 'Customer City',
                'state' => 'CC',
                'postal_code' => '67890',
                'phone' => '+1234567891',
                'payment_method' => 'cod',
                'order_date' => now()->subDays(2),
            ],
            [
                'status' => 'processing',
                'total_amount' => 45.99,
                'shipping_address' => '456 Customer Avenue, Customer City, CC 67890',
                'city' => 'Customer City',
                'state' => 'CC',
                'postal_code' => '67890',
                'phone' => '+1234567891',
                'payment_method' => 'card',
                'order_date' => now()->subDays(1),
            ],
            [
                'status' => 'delivered',
                'total_amount' => 125.50,
                'shipping_address' => '456 Customer Avenue, Customer City, CC 67890',
                'city' => 'Customer City',
                'state' => 'CC',
                'postal_code' => '67890',
                'phone' => '+1234567891',
                'payment_method' => 'cod',
                'order_date' => now()->subDays(5),
            ],
        ];

        foreach ($orders as $orderData) {
            $order = Order::create([
                'user_id' => $customer->id,
                'total_amount' => $orderData['total_amount'],
                'status' => $orderData['status'],
                'shipping_address' => $orderData['shipping_address'],
                'city' => $orderData['city'],
                'state' => $orderData['state'],
                'postal_code' => $orderData['postal_code'],
                'phone' => $orderData['phone'],
                'payment_method' => $orderData['payment_method'],
                'order_date' => $orderData['order_date'],
            ]);

            // Add some order items
            $itemCount = rand(1, 3);
            $selectedProducts = $products->take($itemCount);
            
            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 2);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);
            }

            $this->command->info("Created order #{$order->id} for customer {$customer->email}");
        }

        $this->command->info('');
        $this->command->info('=== Test Orders Created ===');
        $this->command->info('Customer: john@glowtrack.com | Password: password');
        $this->command->info('Orders created: 3 (confirmed, processing, delivered)');
        $this->command->info('You can now log in as john@glowtrack.com and view these orders!');
    }
}
