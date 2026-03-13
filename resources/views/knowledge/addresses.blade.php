@extends('layouts.app')

@section('title', 'Manage Addresses - GlowTrack Knowledge Base')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-6">Manage Addresses</h1>
        <p class="text-lg text-soft-brown opacity-75 mb-8">Add, edit, and manage your shipping and billing addresses for faster checkout.</p>
        
        <div class="bg-white rounded-3xl shadow-xl p-8">
            <p class="text-soft-brown mb-6">This article helps you manage your delivery addresses. Add multiple addresses for home, work, or other locations to make checkout faster.</p>
            
            <h2 class="text-xl font-bold text-soft-brown mb-4">How to Add an Address</h2>
            <ol class="list-decimal list-inside space-y-2 text-soft-brown mb-6">
                <li>Go to Profile Settings</li>
                <li>Click "Manage Addresses"</li>
                <li>Click "Add New Address"</li>
                <li>Fill in address details</li>
                <li>Save the address</li>
            </ol>
            
            <h2 class="text-xl font-bold text-soft-brown mb-4">Address Information Required</h2>
            <ul class="list-disc list-inside space-y-2 text-soft-brown mb-6">
                <li>Street address</li>
                <li>City/Municipality</li>
                <li>Province</li>
                <li>Postal code</li>
                <li>Contact phone number</li>
            </ul>
            
            <h2 class="text-xl font-bold text-soft-brown mb-4">Tips for Accurate Delivery</h2>
            <ul class="list-disc list-inside space-y-2 text-soft-brown">
                <li>Include building name and floor number</li>
                <li>Provide landmarks for hard-to-find locations</li>
                <li>Add delivery instructions for gated communities</li>
                <li>Keep multiple addresses for convenience</li>
            </ul>
        </div>
    </div>
</div>
@endsection
