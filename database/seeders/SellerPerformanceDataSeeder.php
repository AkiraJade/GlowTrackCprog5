<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\SellerApplication;
use Carbon\Carbon;

class SellerPerformanceDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding seller performance data...');

        // Create demo sellers with diverse performance levels
        $this->createDemoSellers();
        
        // Create products for sellers
        $this->createSellerProducts();
        
        // Create orders and order items
        $this->createSellerOrders();
        
        // Create reviews for seller products
        $this->createSellerReviews();

        $this->command->info('Seller performance data seeded successfully!');
    }

    private function createDemoSellers(): void
    {
        // Create sellers with different performance tiers
        $sellerProfiles = [
            // Platinum tier sellers (top performers)
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.j@glowtrack.com',
                'tier' => 'Platinum',
                'status' => 'active',
                'joined' => Carbon::now()->subYears(2),
                'monthly_revenue' => 8000,
                'monthly_orders' => 85,
                'fulfillment_rate' => 98.5,
                'satisfaction_score' => 4.7
            ],
            [
                'name' => 'Mike Chen',
                'email' => 'mike.chen@glowtrack.com',
                'tier' => 'Platinum',
                'status' => 'active',
                'joined' => Carbon::now()->subYears(1)->subMonths(6),
                'monthly_revenue' => 6500,
                'monthly_orders' => 72,
                'fulfillment_rate' => 96.2,
                'satisfaction_score' => 4.5
            ],
            
            // Gold tier sellers
            [
                'name' => 'Emma Wilson',
                'email' => 'emma.wilson@glowtrack.com',
                'tier' => 'Gold',
                'status' => 'active',
                'joined' => Carbon::now()->subYears(1)->subMonths(3),
                'monthly_revenue' => 4500,
                'monthly_orders' => 68,
                'fulfillment_rate' => 94.8,
                'satisfaction_score' => 4.3
            ],
            [
                'name' => 'James Brown',
                'email' => 'james.brown@glowtrack.com',
                'tier' => 'Gold',
                'status' => 'active',
                'joined' => Carbon::now()->subMonths(10),
                'monthly_revenue' => 3800,
                'monthly_orders' => 55,
                'fulfillment_rate' => 92.1,
                'satisfaction_score' => 4.4
            ],
            
            // Silver tier sellers
            [
                'name' => 'Lisa Anderson',
                'email' => 'lisa.anderson@glowtrack.com',
                'tier' => 'Silver',
                'status' => 'active',
                'joined' => Carbon::now()->subMonths(8),
                'monthly_revenue' => 2500,
                'monthly_orders' => 48,
                'fulfillment_rate' => 89.7,
                'satisfaction_score' => 4.2
            ],
            [
                'name' => 'David Martinez',
                'email' => 'david.martinez@glowtrack.com',
                'tier' => 'Silver',
                'status' => 'active',
                'joined' => Carbon::now()->subMonths(6),
                'monthly_revenue' => 2200,
                'monthly_orders' => 42,
                'fulfillment_rate' => 87.5,
                'satisfaction_score' => 4.1
            ],
            
            // Bronze tier sellers
            [
                'name' => 'Jennifer Taylor',
                'email' => 'jennifer.taylor@glowtrack.com',
                'tier' => 'Bronze',
                'status' => 'active',
                'joined' => Carbon::now()->subMonths(4),
                'monthly_revenue' => 1500,
                'monthly_orders' => 35,
                'fulfillment_rate' => 85.2,
                'satisfaction_score' => 3.9
            ],
            [
                'name' => 'Robert Davis',
                'email' => 'robert.davis@glowtrack.com',
                'tier' => 'Bronze',
                'status' => 'active',
                'joined' => Carbon::now()->subMonths(3),
                'monthly_revenue' => 1200,
                'monthly_orders' => 28,
                'fulfillment_rate' => 82.8,
                'satisfaction_score' => 3.8
            ],
            
            // Standard tier sellers (new/low performers)
            [
                'name' => 'Maria Garcia',
                'email' => 'maria.garcia@glowtrack.com',
                'tier' => 'Standard',
                'status' => 'active',
                'joined' => Carbon::now()->subMonths(2),
                'monthly_revenue' => 800,
                'monthly_orders' => 18,
                'fulfillment_rate' => 78.5,
                'satisfaction_score' => 3.6
            ],
            [
                'name' => 'Thomas Wilson',
                'email' => 'thomas.wilson@glowtrack.com',
                'tier' => 'Standard',
                'status' => 'inactive',
                'joined' => Carbon::now()->subMonths(1),
                'monthly_revenue' => 300,
                'monthly_orders' => 8,
                'fulfillment_rate' => 75.0,
                'satisfaction_score' => 3.4
            ],
            
            // Suspended sellers
            [
                'name' => 'Amanda Thompson',
                'email' => 'amanda.thompson@glowtrack.com',
                'tier' => 'Standard',
                'status' => 'suspended',
                'joined' => Carbon::now()->subMonths(5),
                'monthly_revenue' => 400,
                'monthly_orders' => 12,
                'fulfillment_rate' => 65.0,
                'satisfaction_score' => 2.8
            ]
        ];

        foreach ($sellerProfiles as $profile) {
            $user = User::updateOrCreate(
                ['email' => $profile['email']],
                [
                    'name' => $profile['name'],
                    'username' => 'seller_' . rand(10000, 99999),
                    'password' => bcrypt('password'),
                    'role' => 'seller',
                    'address' => $this->generateSellerAddress(),
                    'created_at' => $profile['joined'],
                ]
            );

            // Create seller application
            SellerApplication::create([
                'user_id' => $user->id,
                'brand_name' => $profile['name'] . "'s Skincare",
                'business_description' => 'Premium skincare products with natural ingredients',
                'business_license' => 'LIC-' . strtoupper(Str::random(8)),
                'contact_person' => $profile['name'],
                'contact_email' => $profile['email'],
                'contact_phone' => $this->generatePhoneNumber(),
                'business_address' => $this->generateSellerAddress(),
                'website_url' => 'https://www.' . strtolower(str_replace(' ', '', $profile['name'])) . '.com',
                'product_categories' => implode(', ', ['Serum', 'Moisturizer', 'Treatment', 'Mask']),
                'status' => 'approved',
                'reviewed_at' => $profile['joined'],
                'reviewed_by' => 1,
                'created_at' => $profile['joined'],
            ]);
        }
    }

    private function createSellerProducts(): void
    {
        $sellers = User::where('role', 'seller')->get();
        $productTemplates = [
            // High-performing products
            ['name' => 'Retinol 1% Serum', 'category' => 'Serum', 'price' => 89.99, 'rating' => 4.8],
            ['name' => 'Vitamin C Brightening Cream', 'category' => 'Moisturizer', 'price' => 69.99, 'rating' => 4.6],
            ['name' => 'Hyaluronic Acid 2% + B5', 'category' => 'Serum', 'price' => 54.99, 'rating' => 4.7],
            ['name' => 'Niacinamide 10% Booster', 'category' => 'Serum', 'price' => 44.99, 'rating' => 4.5],
            ['name' => 'AHA 30% + BHA 2% Peeling Solution', 'category' => 'Treatment', 'price' => 79.99, 'rating' => 4.4],
            
            // Mid-range products
            ['name' => 'Gentle Cleansing Gel', 'category' => 'Cleanser', 'price' => 29.99, 'rating' => 4.3],
            ['name' => 'Balancing Toner', 'category' => 'Toner', 'price' => 34.99, 'rating' => 4.2],
            ['name' => 'Daily Moisturizer SPF 30', 'category' => 'Moisturizer', 'price' => 49.99, 'rating' => 4.1],
            ['name' => 'Eye Cream', 'category' => 'Treatment', 'price' => 59.99, 'rating' => 4.0],
            ['name' => 'Face Mask Set', 'category' => 'Mask', 'price' => 39.99, 'rating' => 3.9],
            
            // Budget products
            ['name' => 'Basic Cleanser', 'category' => 'Cleanser', 'price' => 19.99, 'rating' => 3.8],
            ['name' => 'Simple Moisturizer', 'category' => 'Moisturizer', 'price' => 24.99, 'rating' => 3.7],
            ['name' => 'Toner Spray', 'category' => 'Toner', 'price' => 22.99, 'rating' => 3.6],
            ['name' => 'Sheet Masks (5 pack)', 'category' => 'Mask', 'price' => 15.99, 'rating' => 3.5],
            ['name' => 'Lip Balm', 'category' => 'Treatment', 'price' => 12.99, 'rating' => 3.4]
        ];

        foreach ($sellers as $seller) {
            // Create 3-8 products per seller based on their tier
            $productCount = $this->getProductCountForTier($seller);
            
            for ($i = 0; $i < $productCount; $i++) {
                $template = $productTemplates[array_rand($productTemplates)];
                
                // Adjust price and rating based on seller tier
                $adjustedPrice = $this->adjustPriceForTier($template['price'], $seller);
                $adjustedRating = $this->adjustRatingForTier($template['rating'], $seller);
                
                Product::create([
                    'name' => $template['name'],
                    'slug' => Str::slug($template['name']) . '-' . uniqid(),
                    'description' => "High-quality {$template['category']} from {$seller->name}'s collection. Perfect for all skin types.",
                    'brand' => $seller->name . "'s Skincare",
                    'classification' => $template['category'],
                    'price' => $adjustedPrice,
                    'size_volume' => '30ml',
                    'quantity' => rand(20, 200),
                    'low_stock_threshold' => 10,
                    'skin_types' => $this->getCompatibleSkinTypes(),
                    'active_ingredients' => $this->getActiveIngredients($template['category']),
                    'seller_id' => $seller->id,
                    'status' => 'approved',
                    'is_verified' => true,
                    'average_rating' => $adjustedRating,
                    'review_count' => rand(5, 50),
                    'created_at' => $seller->created_at->addDays(rand(1, 30)),
                ]);
            }
        }
    }

    private function createSellerOrders(): void
    {
        $sellers = User::where('role', 'seller')->get();
        $customers = User::where('role', 'customer')->take(50)->get();
        
        if ($customers->isEmpty()) {
            // Create some demo customers if none exist
            for ($i = 1; $i <= 20; $i++) {
                $customers->push(User::create([
                    'name' => "Customer {$i}",
                    'email' => "customer{$i}@example.com",
                    'password' => bcrypt('password'),
                    'role' => 'customer',
                    'address' => $this->generateCustomerAddress(),
                    'created_at' => Carbon::now()->subMonths(rand(1, 12)),
                ]));
            }
        }

        foreach ($sellers as $seller) {
            // Create orders based on seller's performance tier
            $orderCount = $this->getOrderCountForTier($seller);
            
            for ($i = 0; $i < $orderCount; $i++) {
                $orderDate = Carbon::now()->subDays(rand(1, 90));
                $customer = $customers->random();
                
                // Create order
                $order = Order::create([
                    'order_id' => 'ORD-' . strtoupper(Str::random(10)),
                    'user_id' => $customer->id,
                    'total_amount' => 0, // Will be calculated
                    'status' => $this->getOrderStatus($seller, $orderDate),
                    'shipping_address' => $this->generateCustomerAddress(),
                    'payment_method' => collect(['credit_card', 'paypal', 'apple_pay', 'google_pay', 'cash_on_delivery'])->random(),
                    'notes' => $this->generateOrderNotes(),
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);

                // Add order items
                $orderTotal = 0;
                $itemCount = rand(1, 3);
                $sellerProducts = Product::where('seller_id', $seller->id)->get();
                
                for ($j = 0; $j < $itemCount; $j++) {
                    $product = $sellerProducts->random();
                    $quantity = rand(1, 2);
                    $price = $product->price * $quantity;
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $product->price,
                        'total' => $price,
                        'created_at' => $orderDate,
                        'updated_at' => $orderDate,
                    ]);
                    
                    $orderTotal += $price;
                }
                
                // Update order total
                $order->total_amount = $orderTotal;
                $order->save();
            }
        }
    }

    private function createSellerReviews(): void
    {
        $products = Product::where('status', 'approved')->get();
        $customers = User::where('role', 'customer')->get();
        
        foreach ($products as $product) {
            // Create 5-20 reviews per product
            $reviewCount = rand(5, 20);
            $selectedUsers = [];
            
            for ($i = 0; $i < $reviewCount; $i++) {
                $attempt = 0;
                do {
                    $customer = $customers->random();
                    $attempt++;
                } while(in_array($customer->id, $selectedUsers) && $attempt < 20);
                
                if (in_array($customer->id, $selectedUsers)) {
                    continue;
                }
                
                $selectedUsers[] = $customer->id;
                
                $existingReview = Review::where('product_id', $product->id)
                    ->where('user_id', $customer->id)
                    ->first();
                    
                if (!$existingReview) {
                    $productRating = $product->average_rating;
                    $seller = $product->seller;
                    
                    // Adjust rating based on seller performance
                    $adjustedRating = $this->adjustReviewRating($productRating, $seller);
                    
                    Review::create([
                        'product_id' => $product->id,
                        'user_id' => $customer->id,
                        'rating' => $adjustedRating,
                        'comment' => $this->generateReviewComment($product, $seller, $adjustedRating),
                        'skin_type' => $this->getRandomSkinType(),
                        'improvements_observed' => $this->generateImprovements($adjustedRating),
                        'created_at' => Carbon::now()->subDays(rand(1, 180)),
                    ]);
                }
            }
        }
    }

    // Helper methods
    private function getProductCountForTier($seller): int
    {
        $tier = $this->getSellerTier($seller);
        
        $counts = [
            'Platinum' => rand(6, 8),
            'Gold' => rand(4, 6),
            'Silver' => rand(3, 5),
            'Bronze' => rand(2, 4),
            'Standard' => rand(1, 3)
        ];
        
        return $counts[$tier] ?? 2;
    }

    private function getOrderCountForTier($seller): int
    {
        $tier = $this->getSellerTier($seller);
        
        $counts = [
            'Platinum' => rand(80, 120),
            'Gold' => rand(50, 80),
            'Silver' => rand(30, 50),
            'Bronze' => rand(15, 30),
            'Standard' => rand(5, 15)
        ];
        
        return $counts[$tier] ?? 10;
    }

    private function adjustPriceForTier($basePrice, $seller): float
    {
        $tier = $this->getSellerTier($seller);
        
        $multipliers = [
            'Platinum' => 1.2,
            'Gold' => 1.1,
            'Silver' => 1.0,
            'Bronze' => 0.9,
            'Standard' => 0.8
        ];
        
        return $basePrice * ($multipliers[$tier] ?? 1.0);
    }

    private function adjustRatingForTier($baseRating, $seller): float
    {
        $tier = $this->getSellerTier($seller);
        
        $adjustments = [
            'Platinum' => 0.3,
            'Gold' => 0.2,
            'Silver' => 0.1,
            'Bronze' => 0.0,
            'Standard' => -0.1
        ];
        
        $adjusted = $baseRating + ($adjustments[$tier] ?? 0);
        return max(1.0, min(5.0, $adjusted));
    }

    private function adjustReviewRating($baseRating, $seller): float
    {
        $tier = $this->getSellerTier($seller);
        
        // Most reviews should be close to the product rating with some variation
        $rating = $baseRating + (rand(-10, 10) / 10);
        
        // Adjust based on seller tier
        if ($tier === 'Platinum') {
            $rating += rand(-5, 15) / 10;
        } elseif ($tier === 'Gold') {
            $rating += rand(-10, 10) / 10;
        } elseif ($tier === 'Standard') {
            $rating += rand(-15, 5) / 10;
        }
        
        return max(1.0, min(5.0, $rating));
    }

    private function getSellerTier($seller): string
    {
        // Determine tier based on seller's performance metrics
        if ($seller->seller_status === 'suspended') {
            return 'Standard';
        }
        
        // This would normally be calculated from actual performance metrics
        // For seeding, we'll use a simple heuristic based on creation date
        $daysSinceJoined = $seller->created_at->diffInDays(now());
        
        if ($daysSinceJoined > 600) return 'Platinum';
        if ($daysSinceJoined > 400) return 'Gold';
        if ($daysSinceJoined > 200) return 'Silver';
        if ($daysSinceJoined > 100) return 'Bronze';
        
        return 'Standard';
    }

    private function getOrderStatus($seller, $orderDate): string
    {
        $tier = $this->getSellerTier($seller);
        $daysSinceOrder = $orderDate->diffInDays(now());
        
        // Higher tier sellers have better fulfillment rates
        if ($daysSinceOrder > 30) {
            return 'delivered';
        } elseif ($daysSinceOrder > 14) {
            if ($tier === 'Platinum' || $tier === 'Gold') {
                return 'delivered';
            } else {
                return rand(0, 1) ? 'delivered' : 'shipped';
            }
        } elseif ($daysSinceOrder > 7) {
            $statuses = ['processing', 'shipped', 'delivered'];
            if ($tier === 'Standard' || $tier === 'Bronze') {
                $statuses[] = 'cancelled';
            }
            return $statuses[array_rand($statuses)];
        } else {
            $statuses = ['pending', 'confirmed', 'processing'];
            if ($tier === 'Standard' || $tier === 'Bronze') {
                $statuses[] = 'cancelled';
            }
            return $statuses[array_rand($statuses)];
        }
    }

    private function generateSellerAddress(): string
    {
        $addresses = [
            '123 Business Ave, Suite 100, New York, NY 10001',
            '456 Commerce Blvd, Los Angeles, CA 90001',
            '789 Market Street, San Francisco, CA 94102',
            '321 Innovation Drive, Austin, TX 78701',
            '555 Entrepreneur Way, Chicago, IL 60601'
        ];
        
        return $addresses[array_rand($addresses)];
    }

    private function generateCustomerAddress(): string
    {
        $addresses = [
            '123 Main St, Apt 4B, New York, NY 10001',
            '456 Oak Avenue, Los Angeles, CA 90001',
            '789 Pine Road, San Francisco, CA 94102',
            '321 Elm Street, Austin, TX 78701',
            '555 Maple Drive, Chicago, IL 60601'
        ];
        
        return $addresses[array_rand($addresses)];
    }

    private function generatePhoneNumber(): string
    {
        return '(' . rand(200, 999) . ') ' . rand(200, 999) . '-' . rand(1000, 9999);
    }

    private function getCompatibleSkinTypes(): array
    {
        $allTypes = ['Normal', 'Oily', 'Dry', 'Combination', 'Sensitive'];
        return array_rand(array_flip($allTypes), rand(2, 5));
    }

    private function getActiveIngredients($category): array
    {
        $ingredients = [
            'Serum' => ['Retinol', 'Vitamin C', 'Hyaluronic Acid', 'Niacinamide'],
            'Moisturizer' => ['Hyaluronic Acid', 'Ceramides', 'Peptides', 'Vitamin E'],
            'Cleanser' => ['Salicylic Acid', 'Glycerin', 'Tea Tree Oil', 'Aloe Vera'],
            'Toner' => ['Witch Hazel', 'Rose Water', 'AHA', 'BHA'],
            'Treatment' => ['Retinol', 'AHA', 'BHA', 'Peptides'],
            'Mask' => ['Clay', 'Charcoal', 'Hyaluronic Acid', 'Vitamin C']
        ];
        
        $categoryIngredients = $ingredients[$category] ?? ['Hyaluronic Acid'];
        $selected = array_rand(array_flip($categoryIngredients), rand(1, 3));
        return (array) $selected;
    }

    private function generateOrderNotes(): string
    {
        $notes = [
            'Please ship in eco-friendly packaging',
            'Gift wrap requested',
            'Customer requested expedited shipping',
            'Leave at front door',
            'Call before delivery',
            'Fragile items - handle with care'
        ];
        
        return $notes[array_rand($notes)];
    }

    private function generateReviewComment($product, $seller, $rating): string
    {
        $templates = [
            'Amazing product from {$seller}! {$product} works wonders.',
            'Love this {$product}! {$seller} ships quickly.',
            'Great quality {$product}. Will buy again from {$seller}.',
            '{$seller} provides excellent customer service. {$product} is fantastic.',
            '{$product} exceeded my expectations. {$seller} is reliable.',
            'Good value for money. {$product} from {$seller} is worth it.',
            '{$seller} packages items beautifully. {$product} is high quality.',
            'Impressed with this {$product}. {$seller} is professional.'
        ];
        
        if ($rating >= 4.5) {
            return str_replace(['{$seller}', '{$product}'], [$seller->name, $product->name], $templates[array_rand($templates)]);
        } elseif ($rating >= 3.5) {
            return "Good {$product} from {$seller}. Works as expected.";
        } else {
            return "{$product} from {$seller} is okay, but could be better.";
        }
    }

    private function getRandomSkinType(): string
    {
        $types = ['Normal', 'Oily', 'Dry', 'Combination', 'Sensitive'];
        return $types[array_rand($types)];
    }

    private function generateImprovements($rating): string
    {
        if ($rating >= 4.5) {
            $improvements = [
                'Brighter complexion',
                'Smoother texture',
                'Reduced acne',
                'More hydrated skin',
                'Even skin tone'
            ];
        } elseif ($rating >= 3.5) {
            $improvements = [
                'Some improvement',
                'Noticeable difference',
                'Slight improvement',
                'Works moderately well'
            ];
        } else {
            $improvements = [
                'Minimal improvement',
                'Needs more time',
                'Not much change',
                'Disappointing results'
            ];
        }
        
        return $improvements[array_rand($improvements)];
    }
}
