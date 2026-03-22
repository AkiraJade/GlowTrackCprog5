<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Cancelled - {{ $appName }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f8f9fa; }
        .container { background-color: #ffffff; border-radius: 12px; padding: 40px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { font-size: 28px; font-weight: bold; color: #10b981; margin-bottom: 10px; }
        .status-icon { font-size: 48px; margin-bottom: 20px; }
        .status-update { background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 20px; margin: 20px 0; text-align: center; }
        .status-badge { display: inline-block; padding: 8px 16px; border-radius: 25px; font-weight: bold; font-size: 14px; text-transform: uppercase; margin: 10px 0; background-color: #fee2e2; color: #991b1b; }
        .order-details { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin: 20px 0; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e2e8f0; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-weight: bold; color: #6b7280; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ $appName }}</div>
            <div class="status-icon">❌</div>
            <h1>Order Cancelled</h1>
        </div>

        <p>Hi {{ $user->name }},</p>
        
        <p>Your order #{{ $order->id }} has been cancelled as requested.</p>
        
        <div class="status-update">
            <h3>Order Status: Cancelled</h3>
            <div class="status-badge">Cancelled</div>
            <p>We're sorry to see your order cancelled. If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
        </div>

        @if($cancellationReason)
        <div class="order-details">
            <h3>Cancellation Reason</h3>
            <p>{{ $cancellationReason }}</p>
        </div>
        @endif

        <div class="order-details">
            <h3>Order Information</h3>
            <div class="detail-row">
                <span class="detail-label">Order Number:</span>
                <span>#{{ $order->id }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Order Date:</span>
                <span>{{ $orderDate }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Total Amount:</span>
                <span><strong>₱{{ number_format($totalAmount, 2) }}</strong></span>
            </div>
        </div>

        <div class="footer">
            <p>This email was sent to {{ $user->email }} regarding order #{{ $order->id }}.</p>
            <p>© {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
