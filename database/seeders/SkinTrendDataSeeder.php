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
        $this->createDemoUsers();
        
        // Create skin journals with trend data
        $this->createSkinJournals();
        
        // Create products with popular ingredients
        $this->createTrendProducts();
        
        // Create reviews with ingredient mentions
        $this->createTrendReviews();

        $this->command->info('Skin trend data seeded successfully!');
    }

    private function createDemoUsers(): void
    {
        // Create users across different age groups and regions
        $userProfiles = [
            // Young users (18-24)
            ['age' => 19, 'region' => 'North', 'skin_type' => 'Oily', 'concerns' => ['Acne', 'Oily Skin']],
            ['age' => 22, 'region' => 'South', 'skin_type' => 'Combination', 'concerns' => ['Acne', 'Hyperpigmentation']],
            ['age' => 20, 'region' => 'East', 'skin_type' => 'Sensitive', 'concerns' => ['Sensitive Skin', 'Acne']],
            ['age' => 23, 'region' => 'West', 'skin_type' => 'Normal', 'concerns' => ['Hyperpigmentation']],
            
            // Young adults (25-34)
            ['age' => 26, 'region' => 'Central', 'skin_type' => 'Combination', 'concerns' => ['Aging', 'Dryness']],
            ['age' => 29, 'region' => 'North', 'skin_type' => 'Dry', 'concerns' => ['Dryness', 'Fine Lines']],
            ['age' => 31, 'region' => 'South', 'skin_type' => 'Oily', 'concerns' => ['Acne', 'Oily Skin']],
            ['age' => 27, 'region' => 'East', 'skin_type' => 'Sensitive', 'concerns' => ['Sensitive Skin', 'Redness']],
            ['age' => 33, 'region' => 'West', 'skin_type' => 'Normal', 'concerns' => ['Hyperpigmentation', 'Dark Spots']],
            ['age' => 30, 'region' => 'Central', 'skin_type' => 'Combination', 'concerns' => ['Aging', 'Acne']],
            
            // Middle-aged (35-44)
            ['age' => 36, 'region' => 'North', 'skin_type' => 'Dry', 'concerns' => ['Aging', 'Dryness', 'Fine Lines']],
            ['age' => 39, 'region' => 'South', 'skin_type' => 'Normal', 'concerns' => ['Aging', 'Hyperpigmentation']],
            ['age' => 41, 'region' => 'East', 'skin_type' => 'Combination', 'concerns' => ['Dryness', 'Fine Lines']],
            ['age' => 38, 'region' => 'West', 'skin_type' => 'Sensitive', 'concerns' => ['Sensitive Skin', 'Redness']],
            ['age' => 43, 'region' => 'Central', 'skin_type' => 'Oily', 'concerns' => ['Acne', 'Hyperpigmentation']],
            
            // Older adults (45-54)
            ['age' => 46, 'region' => 'North', 'skin_type' => 'Dry', 'concerns' => ['Aging', 'Dryness', 'Fine Lines']],
            ['age' => 49, 'region' => 'South', 'skin_type' => 'Normal', 'concerns' => ['Aging', 'Hyperpigmentation']],
            ['age' => 51, 'region' => 'East', 'skin_type' => 'Sensitive', 'concerns' => ['Sensitive Skin', 'Dryness']],
            ['age' => 47, 'region' => 'West', 'skin_type' => 'Combination', 'concerns' => ['Aging', 'Fine Lines']],
            
            // Seniors (55+)
            ['age' => 56, 'region' => 'Central', 'skin_type' => 'Dry', 'concerns' => ['Aging', 'Dryness', 'Fine Lines']],
            ['age' => 62, 'region' => 'North', 'skin_type' => 'Normal', 'concerns' => ['Aging', 'Hyperpigmentation']],
            ['age' => 58, 'region' => 'South', 'skin_type' => 'Sensitive', 'concerns' => ['Sensitive Skin', 'Dryness']],
        ];

        foreach ($userProfiles as $profile) {
            $user = User::create([
                'name' => $this->generateUserName($profile['age'], $profile['region']),
                'username' => 'user_' . rand(10000, 99999),
                'email' => $this->generateUserEmail($profile['age'], $profile['region']),
                'password' => bcrypt('password'),
                'role' => 'customer',
                'address' => $this->generateAddress($profile['region']),
                'created_at' => Carbon::now()->subYears(rand(1, 3))->subMonths(rand(0, 11)),
            ]);

            // Create skin profile
            SkinProfile::create([
                'user_id' => $user->id,
                'skin_type' => $profile['skin_type'],
                'skin_concerns' => $profile['concerns'],
                'ingredient_allergies' => $this->generateAllergies(),
                'notes' => 'Demo profile for trend analysis',
                'created_at' => $user->created_at,
            ]);
        }
    }

    private function createSkinJournals(): void
    {
        $users = User::with('skinProfile')->where('role', 'customer')->get();

        foreach ($users as $user) {
            // Create 5-15 journal entries per user over the past year
            $entryCount = rand(5, 15);
            
            for ($i = 0; $i < $entryCount; $i++) {
                $entryDate = Carbon::now()->subDays(rand(1, 365));
                
                // Generate realistic skin scores based on skin type and concerns
                $baseScore = $this->generateBaseScore($user->skinProfile);
                $score = max(1, min(5, $baseScore + rand(-1, 1)));
                
                SkinJournal::create([
                    'user_id' => $user->id,
                    'entry_date' => $entryDate,
                    'condition_score' => $score,
                    'observations' => $this->generateJournalObservations($user->skinProfile, $score),
                    'photo_path' => rand(0, 3) === 0 ? 'demo_photos/' . $user->id . '_' . $entryDate->format('Y-m-d') . '.jpg' : null,
                    'created_at' => $entryDate,
                ]);
            }
        }
    }

    private function createTrendProducts(): void
    {
        // Create products with popular ingredients
        $products = [
            ['name' => 'Retinol Serum', 'ingredients' => ['retinol', 'hyaluronic acid', 'niacinamide'], 'type' => 'Serum'],
            ['name' => 'Vitamin C Brightening Serum', 'ingredients' => ['vitamin c', 'hyaluronic acid', 'ferulic acid'], 'type' => 'Serum'],
            ['name' => 'Hyaluronic Acid Moisturizer', 'ingredients' => ['hyaluronic acid', 'ceramides', 'niacinamide'], 'type' => 'Moisturizer'],
            ['name' => 'Salicylic Acid Cleanser', 'ingredients' => ['salicylic acid', 'glycerin', 'tea tree oil'], 'type' => 'Cleanser'],
            ['name' => 'Niacinamide Booster', 'ingredients' => ['niacinamide', 'zinc', 'hyaluronic acid'], 'type' => 'Serum'],
            ['name' => 'AHA Exfoliating Toner', 'ingredients' => ['glycolic acid', 'lactic acid', 'witch hazel'], 'type' => 'Toner'],
            ['name' => 'Peptide Complex', 'ingredients' => ['peptides', 'copper peptide', 'matrixyl'], 'type' => 'Serum'],
            ['name' => 'Ceramide Repair Cream', 'ingredients' => ['ceramides', 'hyaluronic acid', 'cholesterol'], 'type' => 'Moisturizer'],
            ['name' => 'BHA Spot Treatment', 'ingredients' => ['salicylic acid', 'zinc', 'tea tree oil'], 'type' => 'Treatment'],
            ['name' => 'Vitamin E Oil', 'ingredients' => ['vitamin e', 'jojoba oil', 'argan oil'], 'type' => 'Treatment'],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']) . '-' . uniqid(),
                'description' => "Premium {$product['type']} with active ingredients for optimal skin health.",
                'brand' => 'GlowTrack Labs',
                'classification' => $product['type'],
                'price' => rand(1999, 8999) / 100,
                'size_volume' => '30ml',
                'quantity' => rand(50, 500),
                'low_stock_threshold' => 20,
                'skin_types' => $this->getCompatibleSkinTypes($product['ingredients']),
                'active_ingredients' => $product['ingredients'],
                'seller_id' => 1, // Assuming admin user with ID 1
                'status' => 'approved',
                'is_verified' => true,
                'average_rating' => rand(35, 50) / 10,
                'review_count' => rand(10, 100),
                'created_at' => Carbon::now()->subMonths(rand(1, 12)),
            ]);
        }
    }

    private function createTrendReviews(): void
    {
        $products = Product::where('status', 'approved')->get();
        $users = User::where('role', 'customer')->take(50)->get();

        foreach ($products as $product) {
            // Create 5-20 reviews per product
            $reviewCount = rand(5, 20);
            $selectedUsers = [];
            
            for ($i = 0; $i < $reviewCount; $i++) {
                // Get a unique user for this product
                $attempt = 0;
                do {
                    $user = $users->random();
                    $attempt++;
                } while (in_array($user->id, $selectedUsers) && $attempt < 10);

                // Skip if we couldn't find a unique user
                if (in_array($user->id, $selectedUsers)) {
                    continue;
                }

                $selectedUsers[] = $user->id;

                // Check if review already exists
                $existingReview = Review::where('product_id', $product->id)
                    ->where('user_id', $user->id)
                    ->first();

                if (!$existingReview) {
                    Review::create([
                        'product_id' => $product->id,
                        'user_id' => $user->id,
                        'rating' => rand(3, 5),
                        'comment' => $this->generateReviewComment($product, $user),
                        'skin_type' => $user->skinProfile->skin_type ?? 'Normal',
                        'before_photo' => rand(0, 3) === 0 ? 'review_photos/before_' . $product->id . '_' . $i . '.jpg' : null,
                        'after_photo' => rand(0, 3) === 0 ? 'review_photos/after_' . $product->id . '_' . $i . '.jpg' : null,
                        'created_at' => Carbon::now()->subDays(rand(1, 180)),
                    ]);
                }
            }
        }
    }

    // Helper methods
    private function generateUserName($age, $region): string
    {
        $firstNames = ['Emma', 'Olivia', 'Sophia', 'Ava', 'Isabella', 'Mia', 'Charlotte', 'Amelia', 'Harper', 'Evelyn'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];
        
        return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
    }

    private function generateUserEmail($age, $region): string
    {
        $names = ['emma', 'olivia', 'sophia', 'ava', 'isabella', 'mia', 'charlotte'];
        $domains = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com'];
        
        return $names[array_rand($names)] . rand(100, 999) . '@' . $domains[array_rand($domains)];
    }

    private function generateAddress($region): string
    {
        $addresses = [
            'North' => '123 North Street, New York, NY',
            'South' => '456 South Avenue, Miami, FL',
            'East' => '789 East Road, Boston, MA',
            'West' => '321 West Boulevard, Los Angeles, CA',
            'Central' => '555 Central Drive, Chicago, IL'
        ];
        
        return $addresses[$region] ?? 'Unknown Address';
    }

    private function generateAllergies(): array
    {
        $allAllergies = ['Niacinamide', 'Retinol', 'Hyaluronic Acid', 'Vitamin C', 'Salicylic Acid', 'Benzoyl Peroxide', 'Fragrance', 'Alcohol'];
        
        // 30% chance of having an allergy
        if (rand(1, 10) <= 3) {
            return [array_rand($allAllergies)];
        }
        
        return [];
    }

    private function generateBaseScore($skinProfile): int
    {
        $baseScores = [
            'Normal' => 4,
            'Oily' => 3,
            'Dry' => 3,
            'Combination' => 3,
            'Sensitive' => 2
        ];
        
        return $baseScores[$skinProfile->skin_type] ?? 3;
    }

    private function generateJournalObservations($skinProfile, $score): string
    {
        $observations = [
            5 => ['Skin looks great today!', 'Perfect skin condition', 'Feeling confident about my skin'],
            4 => ['Good skin day', 'Skin looks healthy', 'Minor improvements visible'],
            3 => ['Average skin condition', 'Some issues but manageable', 'Skin is okay today'],
            2 => ['Skin acting up', 'Some irritation', 'Not the best skin day'],
            1 => ['Skin is very irritated', 'Bad reaction', 'Skin condition is poor']
        ];
        
        $baseObservation = $observations[$score][array_rand($observations[$score])];
        
        // Add concern-specific observations
        if ($skinProfile->skin_concerns) {
            $concernObs = [
                'Acne' => ['New breakout appeared', 'Acne seems calmer today', 'Pimples are healing'],
                'Dryness' => ['Skin feels hydrated', 'Still feeling dry', 'Moisturizer helping'],
                'Aging' => ['Fine lines seem reduced', 'Noticing some wrinkles', 'Skin looks youthful'],
                'Hyperpigmentation' => ['Dark spots fading', 'Pigmentation still visible', 'Some improvement seen']
            ];
            
            foreach ($skinProfile->skin_concerns as $concern) {
                if (isset($concernObs[$concern]) && rand(1, 3) === 1) {
                    $baseObservation .= ' - ' . $concernObs[$concern][array_rand($concernObs[$concern])];
                    break;
                }
            }
        }
        
        return $baseObservation;
    }

    private function getCompatibleSkinTypes($ingredients): array
    {
        $compatibility = [
            'retinol' => ['Normal', 'Dry', 'Combination'],
            'vitamin c' => ['Normal', 'Oily', 'Combination'],
            'hyaluronic acid' => ['Normal', 'Dry', 'Oily', 'Combination', 'Sensitive'],
            'niacinamide' => ['Normal', 'Oily', 'Combination', 'Sensitive'],
            'salicylic acid' => ['Oily', 'Combination'],
            'aha' => ['Normal', 'Oily', 'Combination'],
            'ceramides' => ['Normal', 'Dry', 'Sensitive'],
            'peptides' => ['Normal', 'Dry', 'Combination']
        ];
        
        $compatibleTypes = ['Normal']; // Default for all
        
        foreach ($ingredients as $ingredient) {
            if (isset($compatibility[strtolower($ingredient)])) {
                $compatibleTypes = array_merge($compatibleTypes, $compatibility[strtolower($ingredient)]);
            }
        }
        
        return array_unique($compatibleTypes);
    }

    private function generateReviewComment($product, $user): string
    {
        $templates = [
            "This {$product->classification} really works for my {$user->skinProfile->skin_type} skin.",
            "Great results with this product! Highly recommend.",
            "Works well with my skincare routine.",
            "Love the ingredients in this product.",
            "Good value for money.",
            "Will definitely repurchase.",
            "Saw improvements after consistent use.",
            "Perfect for my skin concerns."
        ];
        
        $comment = $templates[array_rand($templates)];
        
        // Add ingredient-specific comments
        if ($product->active_ingredients && rand(1, 2) === 1) {
            $ingredient = $product->active_ingredients[array_rand($product->active_ingredients)];
            $comment .= " The {$ingredient} really makes a difference.";
        }
        
        return $comment;
    }

    private function generateImprovements($product): string
    {
        $improvements = [
            'Reduced acne breakouts',
            'Improved skin texture',
            'More hydrated skin',
            'Reduced redness',
            'Brighter complexion',
            'Fewer fine lines',
            'More even skin tone',
            'Less oily skin',
            'Calmer sensitive skin',
            'Better overall appearance'
        ];
        
        return $improvements[array_rand($improvements)];
    }
}
