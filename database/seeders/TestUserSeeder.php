<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SellerApplication;
use App\Models\Product;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'glowadmin',
            'email' => 'glowadmin@test.com',
            'phone' => '+639123456789',
            'address' => '123 Admin Street, Manila, Philippines',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'loyalty_points' => 0,
        ]);

        // Create Seller Users
        $seller1 = User::create([
            'name' => 'Beauty Skincare PH',
            'username' => 'beautyseller',
            'email' => 'beautyseller@test.com',
            'phone' => '+639123456780',
            'address' => '456 Seller Ave, Quezon City, Philippines',
            'role' => 'seller',
            'password' => Hash::make('password'),
            'loyalty_points' => 0,
        ]);

        $seller2 = User::create([
            'name' => 'Natural Glow Store',
            'username' => 'naturalglow',
            'email' => 'naturalglow@test.com',
            'phone' => '+639123456781',
            'address' => '789 Beauty Blvd, Makati, Philippines',
            'role' => 'seller',
            'password' => Hash::make('password'),
            'loyalty_points' => 0,
        ]);

        // Create Customer Users
        $customer1 = User::create([
            'name' => 'Jane Doe',
            'username' => 'janedoe',
            'email' => 'janedoe@test.com',
            'phone' => '+639123456782',
            'address' => '321 Customer St, Pasig, Philippines',
            'role' => 'customer',
            'password' => Hash::make('password'),
            'loyalty_points' => 150,
        ]);

        $customer2 = User::create([
            'name' => 'John Smith',
            'username' => 'johnsmith',
            'email' => 'johnsmith@test.com',
            'phone' => '+639123456783',
            'address' => '654 Shopper Rd, Mandaluyong, Philippines',
            'role' => 'customer',
            'password' => Hash::make('password'),
            'loyalty_points' => 75,
        ]);

        // Create Seller Applications (approved)
        SellerApplication::create([
            'user_id' => $seller1->id,
            'brand_name' => 'Beauty Skincare PH',
            'contact_email' => 'contact@beautyskincare.ph',
            'contact_phone' => '+639123456780',
            'business_address' => '456 Seller Ave, Quezon City, Philippines',
            'business_description' => 'Premium skincare products made with natural ingredients from the Philippines. We specialize in gentle yet effective formulations suitable for tropical climate.',
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => $admin->id,
        ]);

        SellerApplication::create([
            'user_id' => $seller2->id,
            'brand_name' => 'Natural Glow Store',
            'contact_email' => 'hello@naturalglow.com',
            'contact_phone' => '+639123456781',
            'business_address' => '789 Beauty Blvd, Makati, Philippines',
            'business_description' => 'Organic and natural skincare solutions for sensitive skin. Our products are cruelty-free and environmentally conscious.',
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => $admin->id,
        ]);

        // Create Test Products
        $products = [
            [
                'name' => 'Vitamin C Brightening Serum',
                'slug' => 'vitamin-c-brightening-serum-bsk1',
                'description' => 'A potent Vitamin C serum that brightens and evens skin tone. Contains 20% L-Ascorbic Acid with ferulic acid and vitamin E for maximum stability and effectiveness.',
                'brand' => 'Beauty Skincare PH',
                'classification' => 'Serum',
                'price' => 899.99,
                'size_volume' => '30ml',
                'quantity' => 25,
                'skin_types' => ['Oily', 'Dry', 'Combination', 'Sensitive', 'Normal'],
                'active_ingredients' => ['Vitamin C', 'Ferulic Acid', 'Vitamin E', 'Hyaluronic Acid'],
                'seller_id' => $seller1->id,
                'status' => 'approved',
                'is_verified' => true,
                'average_rating' => 4.5,
                'review_count' => 12,
                'expiry_date' => now()->addMonths(18),
                'inventory_notes' => 'Store in cool, dry place away from direct sunlight',
            ],
            [
                'name' => 'Gentle Cleansing Foam',
                'slug' => 'gentle-cleansing-foam-bsk2',
                'description' => 'A mild pH-balanced cleanser that effectively removes impurities without stripping the skin\'s natural moisture barrier.',
                'brand' => 'Beauty Skincare PH',
                'classification' => 'Cleanser',
                'price' => 449.99,
                'size_volume' => '150ml',
                'quantity' => 3,
                'skin_types' => ['Dry', 'Sensitive', 'Normal'],
                'active_ingredients' => ['Glycerin', 'Ceramides', 'Panthenol'],
                'seller_id' => $seller1->id,
                'status' => 'approved',
                'is_verified' => true,
                'average_rating' => 4.8,
                'review_count' => 8,
                'expiry_date' => now()->addMonths(12),
                'inventory_notes' => 'Low stock - reorder soon',
            ],
            [
                'name' => 'Organic Aloe Vera Moisturizer',
                'slug' => 'organic-aloe-vera-moisturizer-ngs1',
                'description' => 'Lightweight moisturizer infused with organic aloe vera to soothe and hydrate sensitive skin.',
                'brand' => 'Natural Glow Store',
                'classification' => 'Moisturizer',
                'price' => 699.99,
                'size_volume' => '50ml',
                'quantity' => 15,
                'skin_types' => ['Sensitive', 'Dry', 'Normal'],
                'active_ingredients' => ['Aloe Vera', 'Chamomile', 'Green Tea Extract'],
                'seller_id' => $seller2->id,
                'status' => 'approved',
                'is_verified' => true,
                'average_rating' => 4.6,
                'review_count' => 15,
                'expiry_date' => now()->addMonths(9),
                'inventory_notes' => 'New product line',
            ],
            [
                'name' => 'Niacinamide 10% Serum',
                'slug' => 'niacinamide-10-serum-ngs2',
                'description' => '10% Niacinamide serum to minimize pores, control oil, and improve skin texture.',
                'brand' => 'Natural Glow Store',
                'classification' => 'Serum',
                'price' => 599.99,
                'size_volume' => '30ml',
                'quantity' => 0,
                'skin_types' => ['Oily', 'Combination'],
                'active_ingredients' => ['Niacinamide', 'Zinc PCA', 'Hyaluronic Acid'],
                'seller_id' => $seller2->id,
                'status' => 'approved',
                'is_verified' => true,
                'average_rating' => 4.7,
                'review_count' => 20,
                'expiry_date' => now()->subMonths(1), // Expired product for testing
                'inventory_notes' => 'Out of stock - restock needed',
            ],
            [
                'name' => 'Hydrating Sunscreen SPF 50',
                'slug' => 'hydrating-sunscreen-spf50-bsk3',
                'description' => 'Broad spectrum SPF 50 sunscreen that provides protection without leaving white cast.',
                'brand' => 'Beauty Skincare PH',
                'classification' => 'Sunscreen',
                'price' => 799.99,
                'size_volume' => '50ml',
                'quantity' => 8,
                'skin_types' => ['Oily', 'Dry', 'Combination', 'Sensitive', 'Normal'],
                'active_ingredients' => ['Zinc Oxide', 'Titanium Dioxide', 'Niacinamide'],
                'seller_id' => $seller1->id,
                'status' => 'approved',
                'is_verified' => true,
                'average_rating' => 4.4,
                'review_count' => 6,
                'expiry_date' => now()->addDays(15), // Expiring soon
                'inventory_notes' => 'Expiring in 15 days',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('Test users and products created successfully!');
        $this->command->info('');
        $this->command->info('=== TEST ACCOUNTS ===');
        $this->command->info('ADMIN: glowadmin@test.com / password');
        $this->command->info('SELLER 1: beautyseller@test.com / password');
        $this->command->info('SELLER 2: naturalglow@test.com / password');
        $this->command->info('CUSTOMER 1: janedoe@test.com / password');
        $this->command->info('CUSTOMER 2: johnsmith@test.com / password');
        $this->command->info('');
        $this->command->info('=== BRAND PAGE URLs ===');
        $this->command->info('Beauty Skincare PH: http://localhost:8000/brand/' . $seller1->id);
        $this->command->info('Natural Glow Store: http://localhost:8000/brand/' . $seller2->id);
    }
}
