@extends('layouts.admin')

@section('title', 'Notifications - GlowTrack')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 font-playfair">Notifications</h1>
        <p class="text-gray-600 mt-2">View and manage your notifications.</p>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
        @if($notifications->count())
            <ul class="space-y-4">
                @foreach($notifications as $notification)
                    <li class="p-4 border border-gray-100 rounded-lg {{ $notification->is_read ? 'bg-white' : 'bg-green-50' }}">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $notification->title }}</p>
                                <p class="text-sm text-gray-700">{{ $notification->message }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            <form method="POST" action="{{ route('notifications.mark-read', $notification) }}">
                                @csrf
                                <button class="text-jade-green text-xs">Mark read</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">{{ $notifications->links() }}</div>
        @else
            <p class="text-sm text-gray-500">No notifications yet.</p>
        @endif
    </div>
</div>
@endsection