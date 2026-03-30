<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with comprehensive data for all reports.
     */
    public function run(): void
    {
        // Create core users first
        $adminUser = User::where('email', 'admin@glowtrack.com')->first();
        
        if (!$adminUser) {
            User::factory()->create([
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'admin@glowtrack.com',
                'phone' => '+1234567890',
                'address' => '123 Admin Street, Admin City, AC 12345',
                'role' => 'admin',
            ]);
        }

        // Create comprehensive data
        $this->call([
            IngredientConflictSeeder::class,      // Ingredient compatibility data
            ProductSeeder::class,                  // Skincare products
            SkinTrendDataSeeder::class,            // Users, skin profiles, journals, reviews
            SellerPerformanceDataSeeder::class,    // Sellers, applications, orders
            ForumDataSeeder::class,                // Forum discussions and replies
            DeliveryDataSeeder::class,             // Delivery personnel and deliveries
            OrderItemsSeeder::class,               // Comprehensive order items
            CartSeeder::class,                     // Customer shopping carts
            RoutineSeeder::class,                  // Skincare routines
            NotificationSeeder::class,             // System notifications
        ]);
    }
}
