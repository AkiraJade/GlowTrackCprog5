@extends('layouts.app')

@section('title', 'Privacy Settings - GlowTrack Knowledge Base')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-6">Privacy Settings</h1>
        <p class="text-lg text-soft-brown opacity-75 mb-8">Control your privacy and manage how your information is used.</p>
        
        <div class="bg-white rounded-3xl shadow-xl p-8">
            <p class="text-soft-brown mb-6">Your privacy is important to us. Learn how to control your data and privacy settings.</p>
            
            <h2 class="text-xl font-bold text-soft-brown mb-4">Privacy Controls</h2>
            <ul class="list-disc list-inside space-y-2 text-soft-brown mb-6">
                <li>Profile visibility settings</li>
                <li>Email marketing preferences</li>
                <li>Order notifications</li>
                <li>Data sharing preferences</li>
                <li>Account deletion options</li>
            </ul>
            
            <h2 class="text-xl font-bold text-soft-brown mb-4">Data Protection</h2>
            <p class="text-soft-brown mb-4">We protect your data with:</p>
            <ul class="list-disc list-inside space-y-2 text-soft-brown">
                <li>256-bit SSL encryption</li>
                <li>Secure data storage</li>
                <li>Regular security audits</li>
                <li>GDPR compliance</li>
                <li>Limited data access</li>
            </ul>
        </div>
    </div>
</div>
@endsection
