<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class OrderCancellationEmail extends Mailable
{
    use Queueable;

    public $order;
    public $user;
    public $cancellationReason;

    /**
     * Create a new message instance.
     */
    public function __construct($user, Order $order, string $cancellationReason)
    {
        $this->user = $user;
        $this->order = $order;
        $this->cancellationReason = $cancellationReason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Order Cancelled - #{$this->order->id} - GlowTrack",
            from: config('mail.from.address', 'hello@glowtrack.test'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-cancellation',
            with: [
                'order' => $this->order,
                'user' => $this->user,
                'cancellationReason' => $this->cancellationReason,
                'appName' => config('app.name', 'GlowTrack'),
                'orderItems' => $this->order->orderItems,
                'shippingAddress' => $this->order->shipping_address,
                'city' => $this->order->city,
                'state' => $this->order->state,
                'postalCode' => $this->order->postal_code,
                'phone' => $this->order->phone,
                'totalAmount' => $this->order->total_amount,
                'paymentMethod' => $this->order->payment_method,
                'orderDate' => $this->order->created_at->format('F j, Y, g:i A'),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
