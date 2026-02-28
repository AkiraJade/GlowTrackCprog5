@extends('layouts.app')

@section('title', 'Community Forum - GlowTrack')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-soft-brown font-playfair mb-4">
                Community Forum
            </h1>
            <p class="text-lg text-soft-brown opacity-75">
                Connect with fellow skincare enthusiasts, share experiences, and get advice from our community.
            </p>
        </div>

        <!-- Forum Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <p class="text-3xl font-bold text-jade-green mb-2">{{ $stats['members'] }}</p>
                <p class="text-sm text-soft-brown opacity-75">Members</p>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <p class="text-3xl font-bold text-jade-green mb-2">{{ $stats['discussions'] }}</p>
                <p class="text-sm text-soft-brown opacity-75">Discussions</p>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <p class="text-3xl font-bold text-jade-green mb-2">{{ $stats['posts'] }}</p>
                <p class="text-sm text-soft-brown opacity-75">Posts</p>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <p class="text-3xl font-bold text-jade-green mb-2">{{ $stats['online'] }}</p>
                <p class="text-sm text-soft-brown opacity-75">Online Now</p>
            </div>
        </div>

        <!-- Forum Categories -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($categories as $name => $emoji)
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <p class="text-3xl">{{ $emoji }}</p>
                        <div>
                            <h3 class="text-lg font-bold text-soft-brown">{{ $name }}</h3>
                            <p class="text-sm text-soft-brown opacity-75">{{ strtolower(str_replace(' ', ' & ', $name)) }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between text-sm text-soft-brown opacity-75 mb-4">
                    <span>{{ $discussions->where('category', $name)->count() }} discussions</span>
                    <span>{{ $discussions->where('category', $name)->count() }} posts</span>
                </div>
                <button class="w-full py-2 bg-jade-green text-white rounded-full font-semibold hover:bg-opacity-90 transition">
                    Browse Category
                </button>
            </div>
            @endforeach
        </div>

        <!-- Recent Discussions -->
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 mb-12">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-soft-brown font-playfair">Recent Discussions</h2>
                <a href="{{ route('forum.create') }}" 
                   class="px-4 py-2 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold text-sm">
                    Start New Discussion
                </a>
            </div>
            
            @if($discussions->count() > 0)
                <div class="space-y-4">
                    @foreach($discussions as $discussion)
                    <div class="border border-light-sage rounded-xl p-6 hover:border-jade-green hover:shadow-lg transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="px-2 py-1 bg-jade-green text-white text-xs font-medium rounded-full">
                                        {{ $categories[$discussion->category] }} {{ $discussion->category }}
                                    </span>
                                    @if($discussion->is_pinned)
                                        <span class="px-2 py-1 bg-yellow-500 text-white text-xs font-medium rounded-full">
                                            📌 Pinned
                                        </span>
                                    @endif
                                    @if($discussion->is_locked)
                                        <span class="px-2 py-1 bg-red-500 text-white text-xs font-medium rounded-full">
                                            🔒 Locked
                                        </span>
                                    @endif
                                    <span class="text-xs text-soft-brown opacity-75">
                                        {{ $discussion->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <h3 class="font-bold text-soft-brown mb-2 hover:text-jade-green transition cursor-pointer">
                                    <a href="{{ route('forum.discussion', $discussion) }}" class="hover:text-jade-green transition">
                                        {{ $discussion->title }}
                                    </a>
                                </h3>
                                <p class="text-sm text-soft-brown opacity-75 mb-3">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($discussion->content), 150) }}
                                </p>
                                <div class="flex items-center gap-4 text-sm text-soft-brown opacity-75">
                                    <span>👤 {{ $discussion->user->username }}</span>
                                    <span>💬 {{ $discussion->reply_count }} replies</span>
                                    <span>👁️ {{ $discussion->views }} views</span>
                                    @if($discussion->latestReply)
                                        <span>🕐 Last reply {{ $discussion->latestReply->created_at->diffForHumans() }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $discussions->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4 opacity-50">💬</div>
                    <h3 class="text-xl font-medium text-soft-brown mb-2">No discussions yet</h3>
                    <p class="text-soft-brown opacity-75 mb-6">Be the first to start a conversation and help build our community!</p>
                    <a href="{{ route('forum.create') }}" 
                       class="inline-block px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                        Start First Discussion
                    </a>
                </div>
            @endif
        </div>

        <!-- Call to Action -->
        <div class="text-center bg-white rounded-3xl shadow-xl p-8 md:p-12">
            <h2 class="text-2xl font-bold text-soft-brown font-playfair mb-4">Join the Conversation</h2>
            <p class="text-soft-brown opacity-75 mb-8">Have a question or experience to share? Start a new discussion and connect with our community!</p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('forum.create') }}" 
                   class="px-6 py-3 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                    Start New Discussion
                </a>
                <a href="{{ route('dashboard') }}" 
                   class="px-6 py-3 border-2 border-jade-green text-jade-green rounded-full hover:bg-jade-green hover:text-white transition font-semibold">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
