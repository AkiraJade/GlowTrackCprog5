<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoyaltyController extends Controller
{
    /**
     * Display the loyalty program page.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get real loyalty points data from user
        $currentPoints = $user->loyalty_points ?? 0;
        
        // Calculate tier based on points
        $tier = 'Bronze';
        $nextTier = 'Silver';
        $pointsToNextTier = 100;
        
        if ($currentPoints >= 500) {
            $tier = 'Gold';
            $nextTier = 'Platinum';
            $pointsToNextTier = 1000 - $currentPoints;
        } elseif ($currentPoints >= 100) {
            $tier = 'Silver';
            $nextTier = 'Gold';
            $pointsToNextTier = 500 - $currentPoints;
        } else {
            $pointsToNextTier = 100 - $currentPoints;
        }
        
        // Calculate total earned (for demo, we'll use current points as total earned)
        // In a real app, you'd track this separately
        $totalEarned = $currentPoints;
        $totalRedeemed = 0; // For demo, assume no points redeemed yet
        
        $loyaltyData = [
            'current_points' => $currentPoints,
            'total_earned' => $totalEarned,
            'total_redeemed' => $totalRedeemed,
            'tier' => $tier,
            'next_tier' => $nextTier,
            'points_to_next_tier' => max(0, $pointsToNextTier),
            'member_since' => $user->created_at->format('F Y'),
        ];

        // Available rewards
        $rewards = [
            [
                'id' => 1,
                'name' => '10% Off Next Purchase',
                'description' => 'Get 10% discount on your next order',
                'points_cost' => 100,
                'category' => 'Discounts',
                'available' => true,
            ],
            [
                'id' => 2,
                'name' => 'Free Shipping',
                'description' => 'Free shipping on your next order',
                'points_cost' => 50,
                'category' => 'Discounts',
                'available' => true,
            ],
            [
                'id' => 3,
                'name' => 'GlowTrack Skincare Set',
                'description' => 'Complete skincare routine set',
                'points_cost' => 500,
                'category' => 'Products',
                'available' => false,
            ],
            [
                'id' => 4,
                'name' => 'Face Mask Bundle',
                'description' => 'Pack of 5 premium face masks',
                'points_cost' => 200,
                'category' => 'Products',
                'available' => true,
            ],
            [
                'id' => 5,
                'name' => '15% Off Next Purchase',
                'description' => 'Get 15% discount on your next order',
                'points_cost' => 150,
                'category' => 'Discounts',
                'available' => true,
            ],
            [
                'id' => 6,
                'name' => 'VIP Consultation',
                'description' => '30-minute skincare consultation with expert',
                'points_cost' => 300,
                'category' => 'Services',
                'available' => true,
            ],
        ];

        // User's redemption history
        $redemptionHistory = [
            [
                'reward_name' => 'Free Shipping',
                'points_used' => 50,
                'redeemed_at' => now()->subDays(15)->format('M d, Y'),
                'status' => 'Used',
            ],
            [
                'reward_name' => '10% Off Next Purchase',
                'points_used' => 100,
                'redeemed_at' => now()->subDays(30)->format('M d, Y'),
                'status' => 'Used',
            ],
        ];

        // Ways to earn points
        $earningWays = [
            [
                'action' => 'Make a Purchase',
                'points' => '1 point per $1 spent',
                'description' => 'Earn points for every dollar you spend',
            ],
            [
                'action' => 'Write a Review',
                'points' => '10 points',
                'description' => 'Share your experience with our products',
            ],
            [
                'action' => 'Refer a Friend',
                'points' => '50 points',
                'description' => 'When your friend makes their first purchase',
            ],
            [
                'action' => 'Birthday Bonus',
                'points' => '25 points',
                'description' => 'Special birthday treat from us',
            ],
            [
                'action' => 'Forum Participation',
                'points' => '5 points',
                'description' => 'Helpful posts in our community forum',
            ],
        ];

        return view('loyalty.index', compact('loyaltyData', 'rewards', 'redemptionHistory', 'earningWays'));
    }

    /**
     * Redeem a reward.
     */
    public function redeem(Request $request)
    {
        $rewardId = $request->input('reward_id');
        
        $rewards = [
            1 => ['name' => '10% Off Next Purchase', 'points_cost' => 100],
            2 => ['name' => 'Free Shipping', 'points_cost' => 50],
            4 => ['name' => 'Face Mask Bundle', 'points_cost' => 200],
            5 => ['name' => '15% Off Next Purchase', 'points_cost' => 150],
            6 => ['name' => 'VIP Consultation', 'points_cost' => 300],
        ];

        if (!isset($rewards[$rewardId])) {
            return back()->with('error', 'Reward not found.');
        }

        $reward = $rewards[$rewardId];
        
        // Check actual user points
        $user = Auth::user();
        $userPoints = $user->loyalty_points ?? 0;
        
        if ($userPoints < $reward['points_cost']) {
            return back()->with('error', 'Insufficient points for this reward.');
        }

        // In a real app, you would:
        // 1. Create a redemption record
        // 2. Deduct points from user account
        // 3. Generate coupon code or process reward
        
        // For demo, we'll just show success message
        return back()->with('success', "Successfully redeemed {$reward['name']}! Check your email for details.");
    }
}
