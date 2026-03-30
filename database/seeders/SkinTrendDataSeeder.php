<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\SkinProfile;
use App\Models\SkinJournal;
use App\Models\Product;
use App\Models\Review;
use Carbon\Carbon;

class SkinTrendDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding skin trend data...');
        
        // Create demo users with diverse skin profiles
        $userProfiles = [
            // Young users (18-24)
            ['age' => 19, 'region' => 'North', 'skin_type' => 'Oily', 'concerns' => ['Acne', 'Oily Skin']],
            // Young adults (25-34)
            ['age' => 22, 'region' => 'South', 'skin_type' => 'Combination', 'concerns' => ['Acne', 'Hyperpigmentation']],
            // Middle-aged (35-44)
            ['age' => 36, 'region' => 'North', 'skin_type' => 'Dry', 'concerns' => ['Aging', 'Dryness', 'Fine Lines']],
        ];

        foreach ($userProfiles as $profile) {
            $user = User::create([
                'name' => 'User ' . $profile['age'],
                'username' => 'user_' . rand(10000, 99999),
                'email' => 'user' . $profile['age'] . '_' . rand(10000, 99999) . '@example.com',
                'phone' => '+1234567890',
                'address' => '123 Demo Street, Demo City, DC 12345',
                'role' => 'customer',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
            ]);
            
            // Create skin profile
            SkinProfile::create([
                'user_id' => $user->id,
                'skin_type' => $profile['skin_type'],
                'skin_concerns' => implode(', ', $profile['concerns']),
                'notes' => 'Demo profile for trend analysis',
                'created_at' => $user->created_at,
            ]);
        }
        
        $this->command->info('Demo users created successfully!');
    }

    private function createSkinJournals(): void
    {
        $this->command->info('Creating skin journals with trend data...');
        
        $users = User::with('skinProfile')->where('role', 'customer')->get();
        
        foreach ($users as $user) {
            // Create 5-15 journal entries per user
            for ($i = 0; $i < 5; $i++) {
                $journalDate = Carbon::now()->subDays(rand(1, 365))->subMonths(rand(1, 12));
                
                SkinJournal::create([
                    'user_id' => $user->id,
                    'entry_date' => $journalDate,
                    'condition_score' => rand(1, 5),
                    'observations' => 'Sample journal entry for trend analysis',
                    'created_at' => $journalDate,
                    'photo_path' => rand(0, 3) === 0 ? 'demo_photos/' . $user->id . '_' . $journalDate->format('Y-m-d') . '.jpg' : null,
                ]);
            }
        }
        
        $this->command->info('Skin journals seeded successfully!');
    }

    private function createTrendProducts(): void
    {
        $products = [
            [
                'name' => 'Retinol Serum',
                'description' => 'A powerful retinol serum that reduces fine lines and wrinkles. Contains peptides for enhanced results.',
                'brand' => 'DermEssence',
                'classification' => 'Serum',
                'price' => 45.00,
                'size_volume' => '30ml',
                'quantity' => 30,
            ],
            [
                'name' => 'Hyaluronic Acid',
                'description' => 'Multi-molecular hyaluronic acid serum that provides deep hydration and plumps up skin. Lightweight and fast-absorbing.',
                'brand' => 'BeautyPro',
                'classification' => 'Serum',
                'price' => 24.99,
                'size_volume' => '30ml',
                'quantity' => 40,
            ],
            [
                'name' => 'Vitamin C Moisturizer',
                'description' => 'A gentle moisturizer with ceramides and niacinamide for barrier support and hydration.',
                'brand' => 'SkinCare Pro',
                'classification' => 'Moisturizer',
                'price' => 19.99,
                'size_volume' => '50ml',
                'quantity' => 60,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }

    private function createTrendReviews(): void
    {
        $products = Product::where('status', 'approved')->get();
        $users = User::where('role', 'customer')->take(50)->get();
        
        foreach ($products as $product) {
            // Create 5-20 reviews per product
            for ($i = 0; $i < 5; $i++) {
                $reviewDate = Carbon::now()->subDays(rand(1, 365))->subMonths(rand(1, 12));
                
                Review::create([
                    'user_id' => $users->random()->id,
                    'product_id' => $product->id,
                    'rating' => rand(3, 5),
                    'comment' => 'Great product! Works perfectly with my skin type.',
                    'review_date' => $reviewDate,
                    'created_at' => $reviewDate,
                ]);
            }
        }
        
        $this->command->info('Trend reviews seeded successfully!');
    }
}
