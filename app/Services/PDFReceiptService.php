<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFReceiptService
{
    public function __construct()
    {
        // No constructor needed
    }

    /**
     * Generate PDF receipt for an order
     */
    public function generateReceipt(Order $order): string
    {
        $data = [
            'order' => $order,
            'user' => $order->user,
            'orderItems' => $order->orderItems->load('product'),
            'billingAddress' => $order->billing_address ?? $order->user->address,
            'shippingAddress' => $order->shipping_address ?? $order->user->address,
            'appName' => config('app.name'),
            'receiptDate' => now()->format('F d, Y'),
            'receiptNumber' => 'RCP-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
        ];

        $pdf = PDF::loadView('pdf.receipt', $data);
        
        // Configure PDF settings
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'defaultFont' => 'Arial',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        return $pdf->download('receipt-' . $order->id . '.pdf');
    }

    /**
     * Generate PDF receipt and save to storage
     */
    public function saveReceipt(Order $order): string
    {
        $pdfContent = $this->generateReceipt($order);
        $filename = 'receipts/receipt-' . $order->id . '-' . time() . '.pdf';
        
        \Storage::disk('public')->put($filename, $pdfContent);
        
        return $filename;
    }

    /**
     * Generate PDF receipt as download response
     */
    public function downloadReceipt(Order $order)
    {
        $data = [
            'order' => $order,
            'user' => $order->user,
            'orderItems' => $order->orderItems->load('product'),
            'billingAddress' => $order->billing_address ?? $order->user->address,
            'shippingAddress' => $order->shipping_address ?? $order->user->address,
            'appName' => config('app.name'),
            'receiptDate' => now()->format('F d, Y'),
            'receiptNumber' => 'RCP-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
        ];

        $pdf = PDF::loadView('pdf.receipt', $data);
        
        return $pdf->download('receipt-' . $order->id . '.pdf');
    }

    /**
     * Send order confirmation email with PDF receipt
     */
    public function sendOrderConfirmationEmail(Order $order): bool
    {
        try {
            // Generate PDF receipt
            $pdfReceipt = $this->generateReceipt($order);
            
            // Send email with PDF attachment
            Mail::to($order->user->email)->send(new \App\Mail\OrderConfirmationEmail($order, $pdfReceipt));
            
            // Log the email sent
            \Log::info('Order confirmation email sent', [
                'order_id' => $order->id,
                'user_email' => $order->user->email,
            ]);
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send order confirmation email', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
            
            return false;
        }
    }

    /**
     * Send order status update email
     */
    public function sendOrderStatusUpdateEmail(Order $order, string $previousStatus): bool
    {
        try {
            $pdfReceipt = null;
            
            // Attach PDF receipt if order is delivered
            if (in_array($order->status, ['delivered', 'completed'])) {
                $pdfReceipt = $this->generateReceipt($order);
            }
            
            // Send email
            Mail::to($order->user->email)->send(new \App\Mail\OrderStatusUpdateEmail($order, $previousStatus, $pdfReceipt));
            
            // Log the email sent
            \Log::info('Order status update email sent', [
                'order_id' => $order->id,
                'user_email' => $order->user->email,
                'new_status' => $order->status,
                'previous_status' => $previousStatus,
            ]);
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send order status update email', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
            
            return false;
        }
    }
}
