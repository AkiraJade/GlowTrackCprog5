@extends('layouts.admin')

@section('title', 'Forum Moderation - GlowTrack')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 font-playfair">Forum Moderation</h1>
        <p class="text-gray-600 mt-2">Review forum discussions and enforce community standards.</p>
    </div>

    <div class="mb-4 flex gap-2">
        <a href="{{ route('admin.forum-moderation') }}" class="px-3 py-2 rounded-lg {{ request('category') ? 'bg-white text-gray-600' : 'bg-jade-green text-white' }}">All</a>
        <a href="{{ route('admin.forum-moderation', ['category' => 'Product Reviews']) }}" class="px-3 py-2 rounded-lg {{ request('category') === 'Product Reviews' ? 'bg-jade-green text-white' : 'bg-white text-gray-600' }}">Product Reviews</a>
        <a href="{{ route('admin.forum-moderation', ['category' => 'Skin Concerns']) }}" class="px-3 py-2 rounded-lg {{ request('category') === 'Skin Concerns' ? 'bg-jade-green text-white' : 'bg-white text-gray-600' }}">Skin Concerns</a>
        <a href="{{ route('admin.forum-moderation', ['category' => 'Beauty Tips']) }}" class="px-3 py-2 rounded-lg {{ request('category') === 'Beauty Tips' ? 'bg-jade-green text-white' : 'bg-white text-gray-600' }}">Beauty Tips</a>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discussion</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Replies</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posted</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($discussions as $discussion)
                    <tr>
                        <td class="px-6 py-4">
                            <a href="{{ route('forum.discussion', $discussion) }}" class="font-medium text-jade-green hover:underline">{{ $discussion->title }}</a>
                            <div class="text-xs text-gray-500">{{ $discussion->category }}</div>
                        </td>
                        <td class="px-6 py-4">
                            {{ $discussion->user->name }}<br>
                            <span class="text-xs text-gray-500">{{ $discussion->user->email }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $discussion->reply_count }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $discussion->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <form action="{{ route('admin.forum-moderation.discussions.delete', $discussion) }}" method="POST" class="inline" onsubmit="return confirm('Delete this discussion and all replies?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                            <form action="{{ route('admin.forum-moderation.users.warn', $discussion->user) }}" method="POST" class="inline">
                                @csrf
                                <input name="message" type="hidden" value="Your discussion ‘{{ $discussion->title }}’ was flagged for review. Please follow community rules.">
                                <button type="submit" class="text-yellow-600 hover:text-yellow-800">Warn</button>
                            </form>
                        </td>
                    </tr>
                    @foreach($discussion->replies as $reply)
                        <tr class="bg-gray-50">
                            <td class="px-6 py-2" colspan="2">
                                ↳ {{ Str::limit($reply->content, 120) }}
                                <div class="text-xs text-gray-400">by {{ $reply->user->name }}</div>
                            </td>
                            <td class="px-6 py-2 text-xs text-gray-500">reply</td>
                            <td class="px-6 py-2 text-xs text-gray-500">{{ $reply->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-2 text-xs">
                                <form action="{{ route('admin.forum-moderation.replies.delete', $reply) }}" method="POST" class="inline" onsubmit="return confirm('Delete this reply?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                                <form action="{{ route('admin.forum-moderation.users.warn', $reply->user) }}" method="POST" class="inline">
                                    @csrf
                                    <input name="message" type="hidden" value="Your forum reply was flagged for review. Please respect community guidelines.">
                                    <button type="submit" class="text-yellow-600 hover:text-yellow-800">Warn</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No discussions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">{{ $discussions->withQueryString()->links() }}</div>
    </div>
</div>
@endsection