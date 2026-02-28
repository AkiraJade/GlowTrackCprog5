@extends('layouts.app')

@section('title', 'Loyalty Program - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-soft-brown font-playfair mb-4">
                GlowTrack Rewards
            </h1>
            <p class="text-lg text-soft-brown opacity-75">
                Earn points, unlock rewards, and enjoy exclusive benefits as a loyal customer.
            </p>
        </div>

        <!-- Points Overview -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-20 h-20 bg-jade-green rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl font-bold text-white">{{ $loyaltyData['current_points'] }}</span>
                    </div>
                    <h3 class="font-bold text-soft-brown mb-2">Current Points</h3>
                    <p class="text-sm text-soft-brown opacity-75">Available to redeem</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 bg-gold rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl font-bold text-white">{{ $loyaltyData['tier'] }}</span>
                    </div>
                    <h3 class="font-bold text-soft-brown mb-2">Member Tier</h3>
                    <p class="text-sm text-soft-brown opacity-75">{{ $loyaltyData['member_since'] }}</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl font-bold text-white">{{ $loyaltyData['total_earned'] }}</span>
                    </div>
                    <h3 class="font-bold text-soft-brown mb-2">Total Earned</h3>
                    <p class="text-sm text-soft-brown opacity-75">All-time points</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl font-bold text-white">{{ $loyaltyData['total_redeemed'] }}</span>
                    </div>
                    <h3 class="font-bold text-soft-brown mb-2">Points Redeemed</h3>
                    <p class="text-sm text-soft-brown opacity-75">Rewards claimed</p>
                </div>
            </div>
            
            <!-- Progress to Next Tier -->
            <div class="mt-8 p-6 bg-light-sage bg-opacity-50 rounded-xl">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-soft-brown">{{ $loyaltyData['tier'] }} Member</span>
                    <span class="text-sm font-medium text-soft-brown">{{ $loyaltyData['next_tier'] }} Member</span>
                </div>
                <div class="w-full bg-white rounded-full h-3 mb-2">
                    <div class="bg-jade-green h-3 rounded-full" style="width: 50%"></div>
                </div>
                <p class="text-xs text-soft-brown opacity-75 text-center">{{ $loyaltyData['points_to_next_tier'] }} points to {{ $loyaltyData['next_tier }}</p>
            </div>
        </div>

        <!-- Available Rewards -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6">Available Rewards</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($rewards as $reward)
                <div class="border border-light-sage rounded-xl p-6 hover:border-jade-green hover:shadow-lg transition {{ !$reward['available'] ? 'opacity-50' : '' }}">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="px-2 py-1 bg-jade-green text-white text-xs font-medium rounded-full mb-2 inline-block">
                                {{ $reward['category'] }}
                            </span>
                            <h3 class="font-bold text-soft-brown mb-2">{{ $reward['name'] }}</h3>
                            <p class="text-sm text-soft-brown opacity-75 mb-4">{{ $reward['description'] }}</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center mb-2">
                                <span class="text-lg font-bold text-white">{{ $reward['points_cost'] }}</span>
                            </div>
                            <p class="text-xs text-soft-brown opacity-75">points</p>
                        </div>
                    </div>
                    
                    @if($reward['available'])
                        @if($loyaltyData['current_points'] >= $reward['points_cost'])
                            <form method="POST" action="{{ route('loyalty.redeem') }}">
                                @csrf
                                <input type="hidden" name="reward_id" value="{{ $reward['id'] }}">
                                <button type="submit" 
                                        class="w-full py-2 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold"
                                        onclick="return confirm('Are you sure you want to redeem {{ $reward['name'] }} for {{ $reward['points_cost'] }} points?')">
                                    Redeem Reward
                                </button>
                            </form>
                        @else
                            <button disabled 
                                    class="w-full py-2 bg-gray-300 text-gray-500 rounded-full font-semibold cursor-not-allowed">
                                Need {{ $reward['points_cost'] - $loyaltyData['current_points'] }} more points
                            </button>
                        @endif
                    @else
                        <button disabled 
                                class="w-full py-2 bg-gray-300 text-gray-500 rounded-full font-semibold cursor-not-allowed">
                            Currently Unavailable
                        </button>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Ways to Earn Points -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6">How to Earn Points</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($earningWays as $way)
                <div class="flex items-start gap-4 p-4 bg-light-sage bg-opacity-30 rounded-xl">
                    <div class="w-12 h-12 bg-jade-green rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold">+</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-soft-brown mb-1">{{ $way['action'] }}</h4>
                        <p class="text-sm text-jade-green font-semibold mb-1">{{ $way['points'] }}</p>
                        <p class="text-xs text-soft-brown opacity-75">{{ $way['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Redemption History -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-6">Redemption History</h2>
            
            @if($redemptionHistory->count() > 0)
                <div class="space-y-4">
                    @foreach($redemptionHistory as $redemption)
                    <div class="flex items-center justify-between p-4 border border-light-sage rounded-xl">
                        <div>
                            <h4 class="font-bold text-soft-brown">{{ $redemption['reward_name'] }}</h4>
                            <p class="text-sm text-soft-brown opacity-75">{{ $redemption['redeemed_at'] }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-red-500">-{{ $redemption['points_used'] }} points</p>
                            <span class="px-2 py-1 bg-gray-200 text-gray-700 text-xs font-medium rounded-full">
                                {{ $redemption['status'] }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-4xl mb-4 opacity-50">🎁</div>
                    <p class="text-soft-brown opacity-75">No rewards redeemed yet. Start earning points to claim your first reward!</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
