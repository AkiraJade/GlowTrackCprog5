<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use App\Models\User;

class ReviewRequestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $order;
    public $product;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Order $order, $product = null)
    {
        $this->user = $user;
        $this->order = $order;
        $this->product = $product;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⭐ How Was Your GlowTrack Experience?',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.review-request',
            with: [
                'user' => $this->user,
                'order' => $this->order,
                'product' => $this->product,
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
