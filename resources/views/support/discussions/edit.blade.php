@extends('layouts.app')

@section('title', 'Edit Discussion - GlowTrack Forum')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-soft-brown font-playfair mb-4">
                Edit Discussion
            </h1>
            <p class="text-lg text-soft-brown opacity-75">
                Update your discussion title and content.
            </p>
        </div>

        <!-- Edit Discussion Form -->
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
            <form method="POST" action="{{ route('forum.update', $discussion) }}">
                @csrf
                @method('PUT')
                
                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-soft-brown mb-2">Discussion Title</label>
                    <input type="text" id="title" name="title" required
                           value="{{ old('title', $discussion->title) }}"
                           placeholder="Enter a clear and descriptive title..."
                           class="w-full px-4 py-3 border border-light-sage rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition">
                </div>

                <!-- Category -->
                <div class="mb-6">
                    <label for="category" class="block text-sm font-medium text-soft-brown mb-2">Category</label>
                    <select id="category" name="category" required
                            class="w-full px-4 py-3 border border-light-sage rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition">
                        <option value="">Select a category</option>
                        @foreach($categories as $name => $emoji)
                            <option value="{{ $name }}" {{ old('category', $discussion->category) == $name ? 'selected' : '' }}>
                                {{ $emoji }} {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Content -->
                <div class="mb-8">
                    <label for="content" class="block text-sm font-medium text-soft-brown mb-2">Message</label>
                    <textarea id="content" name="content" rows="8" required
                              placeholder="Share your thoughts, ask questions, or provide details about your topic..."
                              class="w-full px-4 py-3 border border-light-sage rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition resize-none">{{ old('content', $discussion->content) }}</textarea>
                    <p class="text-sm text-soft-brown opacity-60 mt-2">Minimum 10 characters</p>
                </div>

                <!-- Guidelines -->
                <div class="bg-light-sage bg-opacity-50 rounded-xl p-6 mb-8">
                    <h3 class="font-bold text-soft-brown mb-3">Community Guidelines</h3>
                    <ul class="text-sm text-soft-brown opacity-75 space-y-2">
                        <li>• Be respectful and constructive in your discussions</li>
                        <li>• Stay on topic and choose the appropriate category</li>
                        <li>• No spam or promotional content</li>
                        <li>• Share personal experiences and helpful advice</li>
                        <li>• Search existing discussions before creating new ones</li>
                    </ul>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                        Update Discussion
                    </button>
                    <a href="{{ route('forum.discussion', $discussion) }}" 
                       class="flex-1 px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
