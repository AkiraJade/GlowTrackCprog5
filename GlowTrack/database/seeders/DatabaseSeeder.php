<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin account
        User::factory()->create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@glowtrack.com',
            'phone' => '+1234567890',
            'address' => '123 Admin Street, Admin City, AC 12345',
            'role' => 'admin',
        ]);

        // Create customer accounts
        User::factory()->create([
            'name' => 'John Customer',
            'username' => 'john_customer',
            'email' => 'john@glowtrack.com',
            'phone' => '+1234567891',
            'address' => '456 Customer Avenue, Customer City, CC 67890',
            'role' => 'customer',
        ]);

        User::factory()->create([
            'name' => 'Jane Customer',
            'username' => 'jane_customer',
            'email' => 'jane@glowtrack.com',
            'phone' => '+1234567892',
            'address' => '789 Customer Boulevard, Customer Town, CT 11223',
            'role' => 'customer',
        ]);

        // Create seller account
        User::factory()->create([
            'name' => 'Sarah Seller',
            'username' => 'sarah_seller',
            'email' => 'sarah@glowtrack.com',
            'phone' => '+1234567893',
            'address' => '321 Seller Road, Seller City, SC 44556',
            'role' => 'seller',
        ]);

        // Create additional random users for testing
        User::factory(10)->create();

        // Seed products
        $this->call(ProductSeeder::class);
    }
}
