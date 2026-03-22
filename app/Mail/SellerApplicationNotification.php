<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\SellerApplication;

class SellerApplicationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $status;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct(SellerApplication $application, string $status)
    {
        $this->application = $application;
        $this->status = $status;
        $this->user = $application->user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->status === 'approved' 
            ? '🎉 Your Seller Application Has Been Approved!'
            : ($this->status === 'rejected' 
                ? 'Your Seller Application Status'
                : '📋 Your Seller Application Has Been Received');

        return new Envelope(subject: $subject);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.seller-application',
            with: [
                'application' => $this->application,
                'status' => $this->status,
                'user' => $this->user,
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
