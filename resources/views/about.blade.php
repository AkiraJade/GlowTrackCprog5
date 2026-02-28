@extends('layouts.app')

@section('title', 'About GlowTrack - Premium Skincare Platform')

@section('content')
<!-- About Hero Section -->
<section class="py-20 bg-gradient-to-br from-mint-cream to-pastel-green">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-soft-brown font-playfair mb-6">About GlowTrack</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Your comprehensive skincare management and e-commerce platform, designed to revolutionize how you discover, purchase, and manage your skincare journey.
            </p>
        </div>
    </div>
</section>

<!-- Platform Overview -->
<section id="about" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-4xl font-bold text-soft-brown font-playfair mb-6">Revolutionizing Skincare Management</h2>
                <p class="text-gray-600 mb-6">
                    GlowTrack is a sophisticated skincare e-commerce platform developed by Navasca, Sedriel H. and Orlanda, Ardee Jade B. from BSIT-S-2A. Our platform combines cutting-edge technology with skincare expertise to deliver a seamless experience for skincare enthusiasts, sellers, and administrators.
                </p>
                <p class="text-gray-600 mb-6">
                    Built with Laravel and modern web technologies, GlowTrack offers a comprehensive ecosystem where users can discover personalized skincare products, track their skin progress, build customized routines, and connect with verified sellers.
                </p>
                <div class="flex space-x-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-jade-green">8+</div>
                        <div class="text-sm text-gray-600">Core Features</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-jade-green">139</div>
                        <div class="text-sm text-gray-600">Functional Requirements</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-jade-green">100%</div>
                        <div class="text-sm text-gray-600">Skincare Focused</div>
                    </div>
                </div>
            </div>
            <div class="bg-pastel-green rounded-2xl p-8">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white rounded-lg p-4 text-center">
                        <div class="text-2xl mb-2">🧴</div>
                        <div class="text-sm font-medium">Product Management</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 text-center">
                        <div class="text-2xl mb-2">📦</div>
                        <div class="text-sm font-medium">Order Tracking</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 text-center">
                        <div class="text-2xl mb-2">📊</div>
                        <div class="text-sm font-medium">Progress Tracking</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 text-center">
                        <div class="text-2xl mb-2">✨</div>
                        <div class="text-sm font-medium">Routine Builder</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
