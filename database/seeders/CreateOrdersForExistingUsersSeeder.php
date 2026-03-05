<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateOrdersForExistingUsersSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all customer users
        $customers = User::where('role', 'customer')->get();
        
        if ($customers->isEmpty()) {
            $this->command->error('No customer users found!');
            return;
        }

        // Get some products
        $products = Product::where('status', 'approved')->get();
        if ($products->count() < 1) {
            $this->command->error('No approved products found!');
            return;
        }

        foreach ($customers as $customer) {
            $this->command->info("Creating orders for customer: {$customer->email} (ID: {$customer->id})");
            
            // Create 2-3 orders per customer
            $orderCount = rand(2, 3);
            for ($i = 0; $i < $orderCount; $i++) {
                $statuses = ['confirmed', 'processing', 'delivered'];
                $status = $statuses[$i];
                
                $order = Order::create([
                    'order_id' => 'ORD-' . str_pad(uniqid(), 8, '0', STR_PAD_LEFT),
                    'user_id' => $customer->id,
                    'total_amount' => rand(50, 200) + (rand(0, 99) / 100),
                    'status' => $status,
                    'shipping_address' => $customer->address ?? 'Default Address',
                    'city' => 'Default City',
                    'state' => 'Default State',
                    'postal_code' => '12345',
                    'phone' => $customer->phone ?? '+1234567890',
                    'payment_method' => rand(0, 1) ? 'cod' : 'card',
                    'order_date' => now()->subDays($i + 1),
                ]);

                // Add 1-2 order items
                $itemCount = rand(1, 2);
                $selectedProducts = $products->shuffle()->take($itemCount);
                
                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 2);
                    $total = $product->price * $quantity;
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $product->price,
                        'total' => $total,
                    ]);
                }

                $this->command->info("  Created order #{$order->id} (Status: {$status})");
            }
        }

        $this->command->info('');
        $this->command->info('=== Orders Created Successfully ===');
        $this->command->info('Customer accounts with orders:');
        foreach ($customers as $customer) {
            $orderCount = Order::where('user_id', $customer->id)->count();
            $this->command->info("  {$customer->email} - {$orderCount} orders");
        }
        $this->command->info('');
        $this->command->info('You can now log in as any customer and view their orders!');
    }
}
