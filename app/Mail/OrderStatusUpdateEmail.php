<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class OrderStatusUpdateEmail extends Mailable
{
    use Queueable;

    public $order;
    public $previousStatus;
    public $pdfReceipt;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, string $previousStatus, $pdfReceipt = null)
    {
        $this->order = $order;
        $this->previousStatus = $previousStatus;
        $this->pdfReceipt = $pdfReceipt;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Order Status Update - #{$this->order->id} - GlowTrack",
            from: config('mail.from.address', 'hello@glowtrack.test'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.order-status-update',
            with: [
                'order' => $this->order,
                'user' => $this->order->user,
                'pdfReceipt' => $this->pdfReceipt,
                'previousStatus' => $this->previousStatus,
                'newStatus' => $this->order->status,
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
        $attachments = [];

        if ($this->pdfReceipt) {
            $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromData(fn() => $this->pdfReceipt, 'receipt-' . $this->order->id . '.pdf')
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
