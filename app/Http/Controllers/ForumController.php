<?php

namespace App\Http\Controllers;

use App\Models\ForumDiscussion;
use App\Models\ForumReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    /**
     * Display the forum page.
     */
    public function index()
    {
        // Update current user's last seen time
        if (Auth::check()) {
            Auth::user()->update(['last_seen_at' => now()]);
        }

        $discussions = ForumDiscussion::with(['user', 'latestReply.user'])
            ->orderBy('is_pinned', 'desc')
            ->orderBy('last_reply_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $categories = [
            'Skincare Routine' => '🧴',
            'Product Reviews' => '⭐',
            'Skin Concerns' => '🤔',
            'DIY & Natural' => '🌿',
            'Beauty Tips' => '💡',
            'Off-Topic' => '☕',
        ];

        $stats = [
            'discussions' => ForumDiscussion::count(),
            'replies' => ForumReply::count(),
            'posts' => ForumDiscussion::count(), // Posts = discussions (original posts only)
            'members' => \App\Models\User::where('role', 'customer')->count(),
            'online' => $this->getOnlineUsersCount(),
        ];

        return view('support.forum', compact('discussions', 'categories', 'stats'));
    }

    /**
     * Get count of online users (active in last 5 minutes)
     */
    private function getOnlineUsersCount()
    {
        // For now, return a simple count. In production, you might want to track last activity
        return \App\Models\User::where('last_seen_at', '>', now()->subMinutes(5))->count() ?: 1;
    }

    /**
     * Show the form for creating a new discussion.
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to create a discussion.');
        }

        $categories = [
            'Skincare Routine' => '🧴',
            'Product Reviews' => '⭐',
            'Skin Concerns' => '🤔',
            'DIY & Natural' => '🌿',
            'Beauty Tips' => '💡',
            'Off-Topic' => '☕',
        ];

        return view('support.discussions.create', compact('categories'));
    }

    /**
     * Store a newly created discussion.
     */
    public function store(Request $request)
    {
        // Get authenticated user
        $user = Auth::user();
        
        if (!$user) {
            \Log::error('User not authenticated in store method');
            return redirect()->route('login')->with('error', 'Please login to create a discussion.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'category' => 'required|in:Skincare Routine,Product Reviews,Skin Concerns,DIY & Natural,Beauty Tips,Off-Topic',
        ]);

        // Create discussion without mass assignment
        $discussion = new ForumDiscussion();
        $discussion->user_id = $user->id;
        $discussion->title = $validated['title'];
        $discussion->content = $validated['content'];
        $discussion->category = $validated['category'];
        $discussion->views = 0;
        $discussion->reply_count = 0;
        $discussion->is_pinned = false;
        $discussion->is_locked = false;
        $discussion->save();

        return redirect()->route('forum.discussion', $discussion)
            ->with('success', 'Discussion created successfully!');
    }

    /**
     * Display a specific discussion.
     */
    public function show(ForumDiscussion $discussion)
    {
        // Increment view count
        $discussion->increment('views');

        $replies = $discussion->replies()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('support.discussions.show', compact('discussion', 'replies'));
    }

    /**
     * Show the form for editing a discussion.
     */
    public function edit(ForumDiscussion $discussion)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to edit discussions.');
        }

        if ($discussion->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = [
            'Skincare Routine' => '🧴',
            'Product Reviews' => '⭐',
            'Skin Concerns' => '🤔',
            'DIY & Natural' => '🌿',
            'Beauty Tips' => '💡',
            'Off-Topic' => '☕',
        ];

        return view('support.discussions.edit', compact('discussion', 'categories'));
    }

    /**
     * Update the discussion.
     */
    public function update(Request $request, ForumDiscussion $discussion)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to update discussions.');
        }

        if ($discussion->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'category' => 'required|in:Skincare Routine,Product Reviews,Skin Concerns,DIY & Natural,Beauty Tips,Off-Topic',
        ]);

        $discussion->update($validated);

        return redirect()->route('forum.discussion', $discussion)
            ->with('success', 'Discussion updated successfully!');
    }

    /**
     * Remove the discussion.
     */
    public function destroy(ForumDiscussion $discussion)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to delete discussions.');
        }

        if ($discussion->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $discussion->delete();

        return redirect()->route('support.forum')
            ->with('success', 'Discussion deleted successfully!');
    }

    /**
     * Store a reply to a discussion.
     */
    public function reply(Request $request, ForumDiscussion $discussion)
    {
        \Log::info('Reply method called for discussion: ' . $discussion->id);
        
        if (!Auth::check()) {
            \Log::error('User not authenticated in reply method');
            return redirect()->route('login')->with('error', 'Please login to post a reply.');
        }

        if ($discussion->is_locked) {
            return back()->with('error', 'This discussion is locked and cannot accept new replies.');
        }

        $validated = $request->validate([
            'content' => 'required|string|min:3',
        ]);

        \Log::info('Validation passed. Content: ' . $validated['content']);

        try {
            // Create reply without mass assignment
            $reply = new ForumReply();
            $reply->discussion_id = $discussion->id;
            $reply->user_id = Auth::id();
            $reply->content = $validated['content'];
            $reply->is_best_answer = false;
            
            \Log::info('About to save reply...');
            $reply->save();
            \Log::info('Reply saved with ID: ' . $reply->id);

            // Update discussion stats
            $discussion->increment('reply_count');
            $discussion->update(['last_reply_at' => now()]);
            \Log::info('Discussion stats updated');

            return back()->with('success', 'Reply posted successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating reply: ' . $e->getMessage());
            \Log::error('Error trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Failed to post reply. Please try again.');
        }
    }

    /**
     * Store a reply to another reply.
     */
    public function replyToReply(Request $request, $replyId)
    {
        \Log::info('Reply to reply method called with reply ID: ' . $replyId);
        
        if (!Auth::check()) {
            \Log::error('User not authenticated in reply to reply method');
            return redirect()->route('login')->with('error', 'Please login to post a reply.');
        }

        // Find the parent reply manually
        $parentReply = ForumReply::find($replyId);
        if (!$parentReply) {
            \Log::error('Parent reply not found with ID: ' . $replyId);
            return back()->with('error', 'Reply not found.');
        }

        \Log::info('Parent reply found: ' . $parentReply->id);
        \Log::info('Parent reply discussion_id: ' . $parentReply->discussion_id);

        // Get the discussion directly
        $discussion = ForumDiscussion::find($parentReply->discussion_id);
        if (!$discussion) {
            \Log::error('Discussion not found for parent reply: ' . $parentReply->discussion_id);
            return back()->with('error', 'Discussion not found.');
        }

        if ($discussion->is_locked) {
            return back()->with('error', 'This discussion is locked and cannot accept new replies.');
        }

        $validated = $request->validate([
            'content' => 'required|string|min:3',
        ]);

        \Log::info('Reply to reply validation passed. Content: ' . $validated['content']);

        try {
            // Create reply to reply
            $reply = new ForumReply();
            $reply->discussion_id = $parentReply->discussion_id;
            $reply->user_id = Auth::id();
            $reply->parent_reply_id = $parentReply->id;
            $reply->content = $validated['content'];
            $reply->is_best_answer = false;
            
            \Log::info('About to save reply to reply...');
            $reply->save();
            \Log::info('Reply to reply saved with ID: ' . $reply->id);

            // Update discussion stats
            $discussion->increment('reply_count');
            $discussion->update(['last_reply_at' => now()]);
            \Log::info('Discussion stats updated');

            return back()->with('success', 'Reply posted successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating reply to reply: ' . $e->getMessage());
            \Log::error('Error trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Failed to post reply. Please try again.');
        }
    }

    /**
     * Delete a reply.
     */
    public function deleteReply(ForumReply $reply)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to delete replies.');
        }

        if ($reply->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $discussion = $reply->discussion;
        $reply->delete();

        // Update discussion reply count
        $discussion->decrement('reply_count');

        return back()->with('success', 'Reply deleted successfully!');
    }
}
