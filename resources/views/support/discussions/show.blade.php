@extends('layouts.app')

@section('title', $discussion->title . ' - GlowTrack Forum')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Navigation -->
        <div class="mb-8">
            <a href="{{ route('support.forum') }}" 
               class="inline-flex items-center text-jade-green hover:text-soft-brown transition font-semibold">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Forum
            </a>
        </div>

        <!-- Discussion Details -->
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 mb-8">
            <!-- Discussion Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 bg-jade-green text-white text-sm font-medium rounded-full">
                            {{ $discussion->category }}
                        </span>
                        @if($discussion->is_pinned)
                            <span class="px-3 py-1 bg-yellow-500 text-white text-sm font-medium rounded-full">
                                📌 Pinned
                            </span>
                        @endif
                        @if($discussion->is_locked)
                            <span class="px-3 py-1 bg-red-500 text-white text-sm font-medium rounded-full">
                                🔒 Locked
                            </span>
                        @endif
                    </div>
                    @if($discussion->user_id === Auth::id())
                        <div class="flex gap-2">
                            <a href="{{ route('forum.edit', $discussion) }}" 
                               class="text-jade-green hover:text-soft-brown transition font-semibold text-sm">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('forum.destroy', $discussion) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this discussion?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-500 hover:text-red-700 transition font-semibold text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
                
                <h1 class="text-3xl font-bold text-soft-brown font-playfair mb-4">
                    {{ $discussion->title }}
                </h1>
                
                <div class="flex items-center gap-4 text-sm text-soft-brown opacity-75">
                    <span>👤 {{ $discussion->user->username }}</span>
                    <span>📅 {{ $discussion->created_at->format('M d, Y \a\t g:i A') }}</span>
                    <span>👁️ {{ $discussion->views }} views</span>
                    <span>💬 {{ $discussion->reply_count }} replies</span>
                </div>
            </div>

            <!-- Discussion Content -->
            <div class="prose max-w-none text-soft-brown mb-8">
                <p>{{ nl2br(e($discussion->content)) }}</p>
            </div>

            <!-- Reply Form -->
            @if(!$discussion->is_locked)
                <div class="border-t border-light-sage pt-8">
                    <h3 class="text-xl font-bold text-soft-brown mb-4">Add Your Reply</h3>
                    <form method="POST" action="{{ route('forum.reply', $discussion) }}">
                        @csrf
                        <div class="mb-4">
                            <textarea name="content" rows="4" required
                                      placeholder="Share your thoughts on this discussion..."
                                      class="w-full px-4 py-3 border border-light-sage rounded-xl focus:ring-2 focus:ring-jade-green focus:border-transparent transition resize-none"></textarea>
                        </div>
                        <button type="submit" 
                                class="px-6 py-2 bg-jade-green text-white rounded-full hover:shadow-lg transition font-semibold">
                            Post Reply
                        </button>
                    </form>
                </div>
            @else
                <div class="border-t border-light-sage pt-8 text-center">
                    <p class="text-soft-brown opacity-75">This discussion is locked and no longer accepts new replies.</p>
                </div>
            @endif
        </div>

        <!-- Replies Section -->
        @if($discussion->replies->count() > 0)
            <div class="border-t border-light-sage pt-8">
                <h3 class="text-xl font-bold text-soft-brown mb-6">{{ $discussion->reply_count }} {{ $discussion->reply_count == 1 ? 'Reply' : 'Replies' }}</h3>
                
                <div class="space-y-6">
                    @foreach($discussion->replies->where('parent_reply_id', null) as $reply)
                        <div class="bg-light-sage bg-opacity-30 rounded-xl p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-jade-green rounded-full flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($reply->user->username, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-soft-brown">{{ $reply->user->username }}</p>
                                        <p class="text-xs text-soft-brown opacity-75">{{ $reply->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                
                                @if($reply->user_id === Auth::id())
                                    <form method="POST" action="{{ route('forum.delete-reply', $reply) }}" 
                                          onsubmit="return confirm('Are you sure you want to delete this reply?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-500 hover:text-red-700 transition font-semibold text-sm">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                            
                            <div class="prose max-w-none text-soft-brown mb-4">
                                <p>{{ nl2br(e($reply->content)) }}</p>
                            </div>

                            <!-- Reply to Reply Button -->
                            <div class="mb-4">
                                <button onclick="toggleReplyForm({{ $reply->id }})" 
                                        class="text-jade-green hover:text-jade-green/80 transition font-semibold text-sm">
                                    💬 Reply to this
                                </button>
                            </div>

                            <!-- Reply to Reply Form (Hidden by default) -->
                            <div id="reply-form-{{ $reply->id }}" class="hidden mb-4">
                                <form method="POST" action="{{ route('forum.reply-to-reply', ['replyId' => $reply->id]) }}" class="space-y-3">
                                    @csrf
                                    <textarea name="content" rows="3" required
                                              placeholder="Write a reply to {{ $reply->user->username }}..."
                                              class="w-full px-3 py-2 border border-light-sage rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent transition resize-none text-sm"></textarea>
                                    <div class="flex gap-2">
                                        <button type="submit" 
                                                class="px-4 py-2 bg-jade-green text-white rounded-lg hover:shadow-lg transition font-semibold text-sm">
                                            Post Reply
                                        </button>
                                        <button type="button" onclick="toggleReplyForm({{ $reply->id }})" 
                                                class="px-4 py-2 border border-light-sage text-soft-brown rounded-lg hover:bg-light-sage transition font-semibold text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Nested Replies -->
                            @if($reply->childReplies->count() > 0)
                                <div class="ml-8 mt-4 space-y-4">
                                    @foreach($reply->childReplies as $childReply)
                                        <div class="bg-white bg-opacity-50 rounded-lg p-4 border-l-4 border-jade-green">
                                            <div class="flex items-start justify-between mb-3">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-8 h-8 bg-jade-green rounded-full flex items-center justify-center text-white text-sm font-bold">
                                                        {{ strtoupper(substr($childReply->user->username, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-soft-brown text-sm">{{ $childReply->user->username }}</p>
                                                        <p class="text-xs text-soft-brown opacity-75">{{ $childReply->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                                                
                                                @if($childReply->user_id === Auth::id())
                                                    <form method="POST" action="{{ route('forum.delete-reply', $childReply) }}" 
                                                          onsubmit="return confirm('Are you sure you want to delete this reply?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="text-red-500 hover:text-red-700 transition font-semibold text-xs">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            
                                            <div class="prose max-w-none text-soft-brown text-sm">
                                                <p>{{ nl2br(e($childReply->content)) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function toggleReplyForm(replyId) {
    const form = document.getElementById('reply-form-' + replyId);
    form.classList.toggle('hidden');
    
    // Focus on the textarea when showing the form
    if (!form.classList.contains('hidden')) {
        const textarea = form.querySelector('textarea');
        if (textarea) {
            textarea.focus();
        }
    }
}
</script>

@endsection
