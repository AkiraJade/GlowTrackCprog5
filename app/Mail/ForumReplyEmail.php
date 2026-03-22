<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\ForumReply;
use App\Models\ForumDiscussion;

class ForumReplyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $discussion;
    public $reply;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, ForumDiscussion $discussion, ForumReply $reply = null)
    {
        $this->user = $user;
        $this->discussion = $discussion;
        $this->reply = $reply;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '💬 New Reply in Your Discussion',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.forum-reply',
            with: [
                'user' => $this->user,
                'discussion' => $this->discussion,
                'reply' => $this->reply,
                'appName' => config('app.name'),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
