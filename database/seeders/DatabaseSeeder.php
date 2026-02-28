<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with minimal user set.
     */
    public function run(): void
    {
        // Create only essential admin account
        User::factory()->create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@glowtrack.com',
            'phone' => '+1234567890',
            'address' => '123 Admin Street, Admin City, AC 12345',
            'role' => 'admin',
        ]);

        // Create only essential seller account
        User::factory()->create([
            'name' => 'Sarah Seller',
            'username' => 'sarah_seller',
            'email' => 'sarah@glowtrack.com',
            'phone' => '+1234567893',
            'address' => '321 Seller Road, Seller City, SC 44556',
            'role' => 'seller',
        ]);

        // Create only essential customer account
        User::factory()->create([
            'name' => 'John Customer',
            'username' => 'john_customer',
            'email' => 'john@glowtrack.com',
            'phone' => '+1234567891',
            'address' => '456 Customer Avenue, Customer City, CC 67890',
            'role' => 'customer',
        ]);

        // Products removed - ready for custom products
        // $this->call(ProductSeeder::class); // Commented out to prevent auto-seeding
    }
}
