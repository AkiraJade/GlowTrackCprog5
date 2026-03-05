<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get seller users
        $sellers = User::where('role', 'seller')->get();
        
        if ($sellers->isEmpty()) {
            // Create a seller if none exists
            $seller = User::factory()->seller()->create();
            $sellers = collect([$seller]);
        }

        $products = [
            [
                'name' => 'Vitamin C Brightening Serum',
                'description' => 'A powerful 20% Vitamin C serum that brightens skin, reduces dark spots, and provides antioxidant protection. Formulated with hyaluronic acid for hydration.',
                'brand' => 'GlowLab',
                'classification' => 'Serum',
                'price' => 29.99,
                'size_volume' => '30ml',
                'quantity' => 50,
                'skin_types' => ['Normal', 'Dry', 'Combination'],
                'active_ingredients' => ['Vitamin C', 'Hyaluronic Acid', 'Ferulic Acid'],
                'photo' => 'product-1.jpg',
            ],
            [
                'name' => 'Gentle Foaming Cleanser',
                'description' => 'A pH-balanced, sulfate-free cleanser that effectively removes impurities without stripping the skin. Perfect for daily use.',
                'brand' => 'SkinPure',
                'classification' => 'Cleanser',
                'price' => 18.50,
                'size_volume' => '150ml',
                'quantity' => 75,
                'skin_types' => ['Normal', 'Dry', 'Sensitive'],
                'active_ingredients' => ['Glycerin', 'Ceramides', 'Green Tea Extract'],
                'photo' => 'product-2.jpg',
            ],
            [
                'name' => 'Retinol Anti-Aging Night Cream',
                'description' => 'A gentle yet effective retinol cream that reduces fine lines, wrinkles, and improves skin texture. Contains peptides for enhanced results.',
                'brand' => 'DermEssence',
                'classification' => 'Moisturizer',
                'price' => 45.00,
                'size_volume' => '50ml',
                'quantity' => 30,
                'skin_types' => ['Normal', 'Oily', 'Combination'],
                'active_ingredients' => ['Retinol', 'Peptides', 'Niacinamide'],
                'photo' => 'product-3.jpg',
            ],
            [
                'name' => 'Hyaluronic Acid Hydrating Serum',
                'description' => 'Multi-molecular hyaluronic acid serum that provides deep hydration and plumps the skin. Lightweight and fast-absorbing.',
                'brand' => 'BeautyPro',
                'classification' => 'Serum',
                'price' => 24.99,
                'size_volume' => '30ml',
                'quantity' => 60,
                'skin_types' => ['Dry', 'Normal', 'Sensitive'],
                'active_ingredients' => ['Hyaluronic Acid', 'Vitamin B5', 'Ceramides'],
                'photo' => 'product-4.jpg',
            ],
            [
                'name' => 'Salicylic Acid Acne Treatment',
                'description' => '2% Salicylic acid treatment that clears acne, reduces inflammation, and prevents future breakouts. Non-drying formula.',
                'brand' => 'ClearSkin',
                'classification' => 'Treatment',
                'price' => 22.00,
                'size_volume' => '30ml',
                'quantity' => 40,
                'skin_types' => ['Oily', 'Combination'],
                'active_ingredients' => ['Salicylic Acid', 'Tea Tree Oil', 'Zinc'],
                'photo' => 'product-5.jpg',
            ],
            [
                'name' => 'Broad Spectrum SPF 50 Sunscreen',
                'description' => 'Lightweight, non-greasy sunscreen with SPF 50 protection. Water-resistant and suitable for all skin types.',
                'brand' => 'RadiantCare',
                'classification' => 'Sunscreen',
                'price' => 32.00,
                'size_volume' => '100ml',
                'quantity' => 80,
                'skin_types' => ['Normal', 'Dry', 'Oily', 'Combination', 'Sensitive'],
                'active_ingredients' => ['Zinc Oxide', 'Titanium Dioxide', 'Vitamin E'],
                'photo' => 'product-6.jpg',
            ],
            [
                'name' => 'Niacinamide 10% Serum',
                'description' => '10% Niacinamide serum that minimizes pores, controls oil, and improves skin tone. Helps with acne and rosacea.',
                'brand' => 'GlowLab',
                'classification' => 'Serum',
                'price' => 26.50,
                'size_volume' => '30ml',
                'quantity' => 55,
                'skin_types' => ['Oily', 'Combination'],
                'active_ingredients' => ['Niacinamide', 'Zinc', 'Hyaluronic Acid'],
                'photo' => 'product-7.jpg',
            ],
            [
                'name' => 'Glycolic Acid Exfoliating Toner',
                'description' => '5% Glycolic acid toner that exfoliates dead skin cells, improves texture, and brightens complexion. AHA formula.',
                'brand' => 'SkinPure',
                'classification' => 'Toner',
                'price' => 20.00,
                'size_volume' => '200ml',
                'quantity' => 45,
                'skin_types' => ['Normal', 'Oily', 'Combination'],
                'active_ingredients' => ['Glycolic Acid', 'Aloe Vera', 'Green Tea'],
                'photo' => 'product-8.jpg',
            ],
            [
                'name' => 'Deep Hydration Face Mask',
                'description' => 'Intensive hydrating sheet mask with hyaluronic acid and ceramides. Provides instant moisture and glow.',
                'brand' => 'BeautyPro',
                'classification' => 'Mask',
                'price' => 8.99,
                'size_volume' => '25ml',
                'quantity' => 100,
                'skin_types' => ['Dry', 'Normal', 'Sensitive'],
                'active_ingredients' => ['Hyaluronic Acid', 'Ceramides', 'Aloe Vera'],
                'photo' => 'product-9.jpg',
            ],
            [
                'name' => 'Ceramide Repair Moisturizer',
                'description' => 'Rich moisturizer with ceramides that strengthens skin barrier and provides long-lasting hydration.',
                'brand' => 'DermEssence',
                'classification' => 'Moisturizer',
                'price' => 38.00,
                'size_volume' => '50ml',
                'quantity' => 35,
                'skin_types' => ['Dry', 'Sensitive', 'Normal'],
                'active_ingredients' => ['Ceramides', 'Hyaluronic Acid', 'Niacinamide'],
                'photo' => 'product-10.jpg',
            ],
            [
                'name' => 'Bakuchiol Natural Retinol Alternative',
                'description' => 'Plant-based retinol alternative that provides anti-aging benefits without irritation. Gentle and effective.',
                'brand' => 'ClearSkin',
                'classification' => 'Serum',
                'price' => 34.99,
                'size_volume' => '30ml',
                'quantity' => 25,
                'skin_types' => ['Sensitive', 'Dry', 'Normal'],
                'active_ingredients' => ['Bakuchiol', 'Peptides', 'Vitamin E'],
                'photo' => 'product-11.jpg',
            ],
            [
                'name' => 'Azelaic Acid Brightening Treatment',
                'description' => '10% Azelaic acid treatment that targets hyperpigmentation, acne, and rosacea. Gentle and effective.',
                'brand' => 'RadiantCare',
                'classification' => 'Treatment',
                'price' => 28.00,
                'size_volume' => '30ml',
                'quantity' => 30,
                'skin_types' => ['Normal', 'Oily', 'Combination'],
                'active_ingredients' => ['Azelaic Acid', 'Niacinamide', 'Vitamin C'],
                'photo' => 'product-12.jpg',
            ],
        ];

        foreach ($products as $productData) {
            $seller = $sellers->random();
            $productData['seller_id'] = $seller->id;
            $productData['status'] = 'approved'; // Make products visible
            $productData['is_verified'] = rand(0, 1); // Random verification status
            $productData['average_rating'] = rand(30, 50) / 10; // Random rating 3.0-5.0
            $productData['review_count'] = rand(0, 200); // Random review count
            $productData['slug'] = \Illuminate\Support\Str::slug($productData['name']) . '-' . uniqid();
            
            Product::create($productData);
        }

        // Create some pending products for admin review
        $pendingProducts = [
            [
                'name' => 'New Organic Face Oil',
                'description' => 'Luxurious face oil with organic ingredients for deep nourishment.',
                'brand' => 'OrganicGlow',
                'classification' => 'Treatment',
                'price' => 42.00,
                'size_volume' => '30ml',
                'quantity' => 20,
                'skin_types' => ['Dry', 'Normal'],
                'active_ingredients' => ['Rosehip Oil', 'Jojoba Oil', 'Vitamin E'],
                'photo' => 'product-13.jpg',
            ],
            [
                'name' => 'Charcoal Detox Mask',
                'description' => 'Deep cleansing charcoal mask that draws out impurities and toxins.',
                'brand' => 'PureSkin',
                'classification' => 'Mask',
                'price' => 15.99,
                'size_volume' => '75ml',
                'quantity' => 40,
                'skin_types' => ['Oily', 'Combination'],
                'active_ingredients' => ['Activated Charcoal', 'Kaolin Clay', 'Tea Tree Oil'],
                'photo' => 'product-14.jpg',
            ],
        ];

        foreach ($pendingProducts as $productData) {
            $seller = $sellers->random();
            $productData['seller_id'] = $seller->id;
            $productData['status'] = 'pending'; // Pending admin review
            $productData['is_verified'] = false;
            $productData['average_rating'] = 0;
            $productData['review_count'] = 0;
            $productData['slug'] = \Illuminate\Support\Str::slug($productData['name']) . '-' . uniqid();
            
            Product::create($productData);
        }
    }
}
