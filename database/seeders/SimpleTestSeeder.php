<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SellerApplication;
use App\Models\Product;

class SimpleTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'admin2026',
            'email' => 'admin2026@test.com',
            'phone' => '+639123456789',
            'address' => '123 Admin Street, Manila, Philippines',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'loyalty_points' => 0,
        ]);

        // Create Seller User
        $seller1 = User::create([
            'name' => 'Beauty Skincare PH',
            'username' => 'beauty2026',
            'email' => 'beauty2026@test.com',
            'phone' => '+639123456780',
            'address' => '456 Seller Ave, Quezon City, Philippines',
            'role' => 'seller',
            'password' => Hash::make('password'),
            'loyalty_points' => 0,
        ]);

        // Create Customer User
        $customer1 = User::create([
            'name' => 'Jane Doe',
            'username' => 'jane2026',
            'email' => 'jane2026@test.com',
            'phone' => '+639123456782',
            'address' => '321 Customer St, Pasig, Philippines',
            'role' => 'customer',
            'password' => Hash::make('password'),
            'loyalty_points' => 150,
        ]);

        // Create Seller Application
        SellerApplication::create([
            'user_id' => $seller1->id,
            'brand_name' => 'Beauty Skincare PH',
            'contact_person' => 'Beauty Skincare PH',
            'contact_email' => 'beauty2026@test.com',
            'contact_phone' => '+639123456780',
            'business_address' => '456 Seller Ave, Quezon City, Philippines',
            'business_description' => 'Premium skincare products made with natural ingredients from the Philippines.',
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => $admin->id,
        ]);

        // Create Test Product
        Product::create([
            'name' => 'Vitamin C Brightening Serum',
            'slug' => 'vitamin-c-brightening-serum-test',
            'description' => 'A potent Vitamin C serum that brightens and evens skin tone.',
            'brand' => 'Beauty Skincare PH',
            'classification' => 'Serum',
            'price' => 899.99,
            'size_volume' => '30ml',
            'quantity' => 25,
            'skin_types' => ['Oily', 'Dry', 'Combination', 'Sensitive', 'Normal'],
            'active_ingredients' => ['Vitamin C', 'Ferulic Acid', 'Vitamin E'],
            'seller_id' => $seller1->id,
            'status' => 'approved',
            'is_verified' => true,
            'average_rating' => 4.5,
            'review_count' => 12,
            'expiry_date' => now()->addMonths(18),
        ]);

        $this->command->info('=== TEST ACCOUNTS CREATED ===');
        $this->command->info('ADMIN: admin2026@test.com / password');
        $this->command->info('SELLER: beauty2026@test.com / password');
        $this->command->info('CUSTOMER: jane2026@test.com / password');
        $this->command->info('Brand Page: http://localhost:8000/brand/' . $seller1->id);
    }
}
