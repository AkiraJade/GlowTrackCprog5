<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ForumDiscussion;
use App\Models\ForumReply;
use Illuminate\Database\Seeder;

class ForumDataSeeder extends Seeder
{
    /**
     * Seed forum discussions and replies.
     */
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();

        if ($customers->isEmpty()) {
            return;
        }

        $discussions = [
            [
                'title' => 'Best Routine for Oily Skin',
                'content' => 'I have extremely oily skin and struggle to keep my face matte throughout the day. What products and routine would you recommend for managing shine and preventing breakouts?',
                'category' => 'skincare-tips',
            ],
            [
                'title' => 'Retinol vs Retinoid: Whats the Difference?',
                'content' => 'Can someone explain the difference between retinol and retinoid? I see both terms used but Im confused about which one is stronger and more effective.',
                'category' => 'ingredients',
            ],
            [
                'title' => 'Dealing with Sensitive Skin',
                'content' => 'My skin is very reactive to products. I get redness and irritation easily. How do I build a routine that won\'t cause flare-ups?',
                'category' => 'skincare-tips',
            ],
            [
                'title' => 'Product Recommendations for Combination Skin',
                'content' => 'I have combination skin - oily in my T-zone but dry on my cheeks. Finding products that balance both is really difficult. Any suggestions?',
                'category' => 'product-recommendations',
            ],
            [
                'title' => 'How Often Should I Exfoliate?',
                'content' => 'Ive heard conflicting information about exfoliation frequency. What does the community recommend? Are chemical exfoliants better than physical ones?',
                'category' => 'skincare-tips',
            ],
            [
                'title' => 'Best Ingredients for Dark Circles',
                'content' => 'I have dark circles under my eyes that makeup can\'t fully cover. Are there any ingredients or products proven to help reduce them?',
                'category' => 'ingredients',
            ],
            [
                'title' => 'Vitamin C Serum Experience',
                'content' => 'Has anyone noticed a real difference using vitamin C serums? How do you incorporate it into your routine? Morning or night?',
                'category' => 'ingredients',
            ],
            [
                'title' => 'Acne-Prone Skin: To Pop or Not to Pop?',
                'content' => 'What\'s the consensus on treating acne? Should we extract pimples or let them heal on their own? Looking for professional advice.',
                'category' => 'skincare-tips',
            ],
        ];

        $replies = [
            'I had similar concerns and found the answer in consistency! Use products designed for your skin type.',
            'Great question! I recommend starting with a gentle routine and building from there.',
            'This really depends on your skin\'s sensitivity level. Maybe try patch testing first?',
            'I\'ve had amazing results with this approach. Stick with it for at least 4-6 weeks to see changes.',
            'The GlowTrack products are specifically formulated for different skin types, might be worth checking out!',
            'Professional here - I recommend seeing a dermatologist if you\'re experiencing severe reactions.',
            'Same issue here! Found that the key is a good moisturizer paired with targeted treatments.',
            'Everyone\'s skin is different, but I found success following this routine...',
            'This ingredient made a huge difference for me. Start low and go slow with concentration!',
            'Not all products work for everyone, but these recommendations are solid starting points.',
        ];

        // Create discussions
        foreach ($discussions as $index => $discussion) {
            $author = $customers->random();

            $createdDiscussion = ForumDiscussion::create([
                'user_id' => $author->id,
                'title' => $discussion['title'],
                'content' => $discussion['content'],
                'category' => $discussion['category'],
                'reply_count' => 0,
                'views' => rand(50, 500),
            ]);

            // Add 2-5 replies to each discussion
            $replyCount = rand(2, 5);
            for ($i = 0; $i < $replyCount; $i++) {
                $replier = $customers->random();

                ForumReply::create([
                    'discussion_id' => $createdDiscussion->id,
                    'user_id' => $replier->id,
                    'content' => $replies[array_rand($replies)],
                ]);

                // Increment reply count
                $createdDiscussion->increment('reply_count');
            }

            // Update discussion timestamps randomly
            $createdDiscussion->update([
                'created_at' => now()->subDays(rand(1, 60)),
                'updated_at' => now()->subDays(rand(0, 30)),
            ]);
        }

        $this->command->info('Forum discussions and replies seeded successfully!');
    }
}
