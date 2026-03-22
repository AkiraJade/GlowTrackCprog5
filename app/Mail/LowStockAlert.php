<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;
use App\Models\User;

class LowStockAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $seller;
    public $product;
    public $currentStock;
    public $threshold;

    /**
     * Create a new message instance.
     */
    public function __construct(User $seller, Product $product, int $currentStock, int $threshold)
    {
        $this->seller = $seller;
        $this->product = $product;
        $this->currentStock = $currentStock;
        $this->threshold = $threshold;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠️ Low Stock Alert - ' . $this->product->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.low-stock',
            with: [
                'seller' => $this->seller,
                'product' => $this->product,
                'currentStock' => $this->currentStock,
                'threshold' => $this->threshold,
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
