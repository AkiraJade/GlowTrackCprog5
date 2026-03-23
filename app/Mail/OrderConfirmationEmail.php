<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class OrderConfirmationEmail extends Mailable
{
    use Queueable;

    public $order;
    public $pdfReceipt;
    public $tempFiles = [];

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, $pdfReceipt = null)
    {
        $this->order = $order;
        $this->pdfReceipt = $pdfReceipt;
    }

    /**
     * Clean up temporary files
     */
    public function __destruct()
    {
        foreach ($this->tempFiles as $tempFile) {
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Order Confirmation - #{$this->order->id} - GlowTrack",
            from: config('mail.from.address', 'hello@glowtrack.test'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.order-confirmation',
            with: [
                'order' => $this->order,
                'user' => $this->order->user,
                'pdfReceipt' => $this->pdfReceipt,
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
            // Save PDF to temporary file for attachment
            $tempPath = storage_path('app/temp_receipt_' . $this->order->id . '_' . time() . '.pdf');
            file_put_contents($tempPath, $this->pdfReceipt);
            
            // Track for cleanup
            $this->tempFiles[] = $tempPath;
            
            $attachments[] = $tempPath;
        }

        return $attachments;
    }
}
