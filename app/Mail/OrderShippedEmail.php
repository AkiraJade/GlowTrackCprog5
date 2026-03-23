<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class OrderShippedEmail extends Mailable
{
    use Queueable;

    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your Order Has Been Shipped - #{$this->order->id} - GlowTrack",
            from: config('mail.from.address', 'hello@glowtrack.test'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.order-shipped',
            with: [
                'order' => $this->order,
                'user' => $this->order->user,
                'orderItems' => $this->order->orderItems,
                'shippingAddress' => $this->order->shipping_address,
            ],
        );
    }
}
