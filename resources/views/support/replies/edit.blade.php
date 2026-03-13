@extends('layouts.app')

@section('title', 'Edit Reply - GlowTrack Forum')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Navigation -->
        <div class="mb-8">
            <a href="{{ route('forum.discussion', $reply->discussion) }}" 
               class="inline-flex items-center text-jade-green hover:text-soft-brown transition font-semibold">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Discussion
            </a>
        </div>

        <!-- Edit Reply Form -->
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-2">Edit Reply</h1>
                <p class="text-soft-brown opacity-75">Update your reply in the discussion: "{{ $reply->discussion->title }}"</p>
            </div>

            <!-- Original Reply Preview -->
            <div class="bg-gray-50 rounded-xl p-6 mb-8 border-l-4 border-gray-300">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-semibold text-gray-600">Original Reply</span>
                    <span class="text-xs text-gray-500">Posted {{ $reply->created_at->diffForHumans() }}</span>
                </div>
                <div class="prose max-w-none text-gray-700">
                    <p>{{ nl2br(e($reply->content)) }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('forum.update-reply', $reply) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label for="content" class="block text-soft-brown font-semibold mb-3">
                        Your Reply
                    </label>
                    <textarea 
                        id="content" 
                        name="content" 
                        rows="6" 
                        class="w-full px-4 py-3 border-2 border-light-sage rounded-xl focus:outline-none focus:ring-2 focus:ring-jade-green focus:border-transparent resize-none"
                        placeholder="Update your reply..."
                        required>{{ old('content', $reply->content) }}</textarea>
                    @error('content')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" 
                            class="px-6 py-3 bg-jade-green text-white rounded-xl hover:bg-jade-green-600 transition font-semibold">
                        Update Reply
                    </button>
                    <a href="{{ route('forum.discussion', $reply->discussion) }}" 
                       class="px-6 py-3 border-2 border-light-sage text-soft-brown rounded-xl hover:bg-light-sage transition font-semibold text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Tips -->
        <div class="mt-8 bg-white bg-opacity-60 rounded-xl p-6 border border-light-sage">
            <h3 class="font-semibold text-soft-brown mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-jade-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Editing Tips
            </h3>
            <ul class="text-sm text-soft-brown space-y-2">
                <li>• Be respectful and constructive in your edits</li>
                <li>• Keep your reply relevant to the discussion</li>
                <li>• Your edit history is visible to other users</li>
                <li>• You can only edit your own replies</li>
            </ul>
        </div>
    </div>
</div>
@endsection
