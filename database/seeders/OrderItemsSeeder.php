<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderItemsSeeder extends Seeder
{
    /**
     * Ensure orders have proper order items.
     */
    public function run(): void
    {
        $orders = Order::whereDoesntHave('orderItems')->get();

        if ($orders->isEmpty()) {
            // If all orders have items, add more items to existing orders
            $orders = Order::limit(30)->get();
        }

        $products = Product::where('status', 'approved')->get();

        if ($products->isEmpty()) {
            $this->command->warn('No products found. Skipping order items seeding.');
            return;
        }

        foreach ($orders as $order) {
            // Remove existing items if any
            $order->orderItems()->delete();

            // Add 1-4 items per order
            $itemCount = rand(1, 4);
            $totalPrice = 0;

            for ($i = 0; $i < $itemCount; $i++) {
                $product = $products->random();
                $quantity = rand(1, 3);
                $unitPrice = $product->price;
                $total = $unitPrice * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $unitPrice,
                    'total' => $total,
                ]);

                $totalPrice += $total;
            }

            // Update order total
            $order->update(['total_amount' => $totalPrice]);
        }

        $this->command->info('Order items seeded successfully!');
    }
}
