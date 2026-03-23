<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SkincareRoutine;
use App\Models\Product;
use Illuminate\Database\Seeder;

class RoutineSeeder extends Seeder
{
    /**
     * Seed skincare routines for customers.
     */
    public function run(): void
    {
        $customers = User::where('role', 'customer')->limit(25)->get();
        $products = Product::where('status', 'approved')->get();

        if ($products->isEmpty()) {
            $this->command->warn('No products found. Skipping routine seeding.');
            return;
        }

        $routineNames = [
            'Morning Hydration Routine',
            'Evening Deep Clean Routine',
            'Weekly Exfoliating Routine',
            'Sensitive Skin Care Routine',
            'Anti-Aging Routine',
            'Acne Fighting Routine',
            'Summer Glow Routine',
            'Winter Repair Routine',
            'Quick 5-Minute Routine',
            'Lazy Day Routine',
        ];

        $routineDescriptions = [
            'A hydrating routine focused on moisture and protection',
            'Deep cleansing routine for nighttime skin recovery',
            'Weekly exfoliation for smooth, bright skin',
            'Gentle routine for reactive or irritated skin',
            'Anti-aging routine with powerful actives',
            'Routine targeting breakouts and blemishes',
            'Light summer routine for sun protection',
            'Heavy winter routine for dry, damaged skin',
            'Fast and effective morning routine',
            'Minimal routine for those busy days',
        ];

        foreach ($customers as $customer) {
            // 60% of customers have routines
            if (rand(0, 100) < 60) {
                $routineCount = rand(1, 3);

                for ($i = 0; $i < $routineCount; $i++) {
                    $routine = new SkincareRoutine();
                    $routine->user_id = $customer->id;
                    $routine->name = $routineNames[array_rand($routineNames)];
                    $routine->schedule = ['AM', 'PM'][array_rand(['AM', 'PM'])];
                    $routine->is_public = rand(0, 1) ? true : false;
                    $routine->save();

                    // Add 3-6 products to routine
                    $routineProductCount = rand(3, 6);
                    $selectedProducts = $products->random($routineProductCount);

                    $stepTypes = ['Cleanser', 'Toner', 'Serum', 'Moisturizer', 'SPF', 'Other'];

                    foreach ($selectedProducts as $index => $product) {
                        $routine->steps()->create([
                            'step_type' => $stepTypes[array_rand($stepTypes)],
                            'product_name' => $product->name,
                            'product_id' => $product->id,
                            'step_order' => $index + 1,
                        ]);
                    }
                }
            }
        }

        $this->command->info('Skincare routines seeded successfully!');
    }
}
