<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Seed shopping carts with products.
     */
    public function run(): void
    {
        $customers = User::where('role', 'customer')->limit(15)->get();
        $products = Product::where('status', 'approved')->get();

        if ($products->isEmpty()) {
            $this->command->warn('No products found. Skipping cart seeding.');
            return;
        }

        foreach ($customers as $customer) {
            // Clear existing cart
            Cart::where('user_id', $customer->id)->delete();

            // Create new cart with 2-5 items ~40% of customers have carts
            if (rand(0, 100) < 40) {
                $itemCount = rand(2, 5);
                $selectedProducts = [];
                for ($i = 0; $i < $itemCount; $i++) {
                    $product = $products->random();

                    if (in_array($product->id, $selectedProducts)) {
                        continue;
                    }
                    $selectedProducts[] = $product->id;

                    Cart::create([
                        'user_id' => $customer->id,
                        'product_id' => $product->id,
                        'quantity' => rand(1, 3),
                        'price' => $product->price,
                    ]);
                }
            }
        }

        $this->command->info('Shopping carts seeded successfully!');
    }
}
