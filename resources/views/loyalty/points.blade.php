@extends('layouts.app')

@section('title', 'Loyalty Points - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-soft-brown font-playfair mb-4">
                Loyalty Points
            </h1>
            <p class="text-lg text-soft-brown opacity-75">
                Earn rewards and save on your favorite skincare products
            </p>
        </div>

        <!-- Main Points Card -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8 relative overflow-hidden">
            <!-- Star decoration -->
            <div class="absolute top-6 right-6">
                <div class="w-16 h-16 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg">
                    <span class="text-2xl">⭐</span>
                </div>
            </div>
            
            <div class="text-center">
                <div class="mb-6">
                    <div class="text-8xl font-bold text-jade-green mb-4">
                        {{ Auth::user()->loyalty_points ?? 0 }}
                    </div>
                    <h2 class="text-2xl font-semibold text-soft-brown mb-2">Current Points</h2>
                    <p class="text-lg text-soft-brown opacity-75">Redeem rewards</p>
                </div>
                
                <!-- Progress Bar -->
                <div class="max-w-md mx-auto">
                    <div class="flex justify-between text-sm text-soft-brown opacity-75 mb-2">
                        <span>Bronze</span>
                        <span>Silver (100 pts)</span>
                        <span>Gold (500 pts)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <?php
                        $points = Auth::user()->loyalty_points ?? 0;
                        $progress = min($points / 500 * 100, 100);
                        ?>
                        <div class="bg-jade-green h-3 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- How to Earn Points -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <h3 class="text-2xl font-bold text-soft-brown font-playfair mb-6">How to Earn Points</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-jade-green rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold">🛍️</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-soft-brown mb-2">Make Purchases</h4>
                        <p class="text-sm text-soft-brown opacity-75">Earn 1 point for every product quantity purchased</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-blush-pink rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold">✍️</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-soft-brown mb-2">Write Reviews</h4>
                        <p class="text-sm text-soft-brown opacity-75">Share your experience and earn 10 points per review</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold">🎂</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-soft-brown mb-2">Birthday Bonus</h4>
                        <p class="text-sm text-soft-brown opacity-75">Get 25 bonus points on your birthday</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-warm-peach rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold">👥</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-soft-brown mb-2">Refer Friends</h4>
                        <p class="text-sm text-soft-brown opacity-75">Earn 50 points when friends make their first purchase</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Rewards -->
        <div class="bg-white rounded-3xl shadow-xl p-8">
            <h3 class="text-2xl font-bold text-soft-brown font-playfair mb-6">Available Rewards</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- 10% Discount -->
                <div class="border-2 border-light-sage rounded-xl p-6 hover:border-jade-green hover:shadow-lg transition">
                    <div class="text-center mb-4">
                        <div class="w-16 h-16 bg-jade-green rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-white font-bold text-xl">🎫</span>
                        </div>
                        <h4 class="font-bold text-soft-brown mb-2">10% Off</h4>
                        <p class="text-sm text-soft-brown opacity-75 mb-4">Get 10% discount on your next order</p>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-jade-green mb-2">100 pts</div>
                        @if((Auth::user()->loyalty_points ?? 0) >= 100)
                            <form method="POST" action="{{ route('loyalty.redeem') }}" class="inline">
                                @csrf
                                <input type="hidden" name="reward_id" value="1">
                                <button type="submit" 
                                        class="px-6 py-2 bg-jade-green text-white rounded-full hover:bg-opacity-90 transition font-semibold"
                                        onclick="return confirm('Redeem 10% discount for 100 points?')">
                                    Redeem
                                </button>
                            </form>
                        @else
                            <button disabled class="px-6 py-2 bg-gray-300 text-gray-500 rounded-full font-semibold cursor-not-allowed">
                                Need 100 pts
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Free Shipping -->
                <div class="border-2 border-light-sage rounded-xl p-6 hover:border-jade-green hover:shadow-lg transition">
                    <div class="text-center mb-4">
                        <div class="w-16 h-16 bg-blush-pink rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-white font-bold text-xl">🚚</span>
                        </div>
                        <h4 class="font-bold text-soft-brown mb-2">Free Shipping</h4>
                        <p class="text-sm text-soft-brown opacity-75 mb-4">Free shipping on your next order</p>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-jade-green mb-2">50 pts</div>
                        @if((Auth::user()->loyalty_points ?? 0) >= 50)
                            <form method="POST" action="{{ route('loyalty.redeem') }}" class="inline">
                                @csrf
                                <input type="hidden" name="reward_id" value="2">
                                <button type="submit" 
                                        class="px-6 py-2 bg-jade-green text-white rounded-full hover:bg-opacity-90 transition font-semibold"
                                        onclick="return confirm('Redeem free shipping for 50 points?')">
                                    Redeem
                                </button>
                            </form>
                        @else
                            <button disabled class="px-6 py-2 bg-gray-300 text-gray-500 rounded-full font-semibold cursor-not-allowed">
                                Need 50 pts
                            </button>
                        @endif
                    </div>
                </div>

                <!-- VIP Consultation -->
                <div class="border-2 border-light-sage rounded-xl p-6 hover:border-jade-green hover:shadow-lg transition">
                    <div class="text-center mb-4">
                        <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-white font-bold text-xl">💆</span>
                        </div>
                        <h4 class="font-bold text-soft-brown mb-2">VIP Consultation</h4>
                        <p class="text-sm text-soft-brown opacity-75 mb-4">30-minute skincare consultation</p>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-jade-green mb-2">300 pts</div>
                        @if((Auth::user()->loyalty_points ?? 0) >= 300)
                            <form method="POST" action="{{ route('loyalty.redeem') }}" class="inline">
                                @csrf
                                <input type="hidden" name="reward_id" value="6">
                                <button type="submit" 
                                        class="px-6 py-2 bg-jade-green text-white rounded-full hover:bg-opacity-90 transition font-semibold"
                                        onclick="return confirm('Redeem VIP consultation for 300 points?')">
                                    Redeem
                                </button>
                            </form>
                        @else
                            <button disabled class="px-6 py-2 bg-gray-300 text-gray-500 rounded-full font-semibold cursor-not-allowed">
                                Need 300 pts
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mt-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl text-center">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mt-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl text-center">
                {{ session('error') }}
            </div>
        @endif

    </div>
</div>
@endsection
