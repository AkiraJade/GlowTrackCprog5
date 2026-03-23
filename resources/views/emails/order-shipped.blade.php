<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order Has Been Shipped - {{ $user->name }} from GlowTrack</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #10b981;
            margin-bottom: 10px;
        }
        .shipped-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .order-details {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .tracking-info {
            background-color: #e0f2fe;
            border: 1px solid #0ea5e9;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            background-color: #10b981;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 10px 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">✨ GlowTrack</div>
            <div class="shipped-icon">🚚</div>
            <h1>Your Order Has Been Shipped!</h1>
            <p>Great news! Your skincare products are on their way.</p>
        </div>

        <div class="order-details">
            <h2 style="margin-top: 0; color: #10b981;">Order Details</h2>
            <div class="detail-row">
                <strong>Order Number:</strong>
                <span>#{{ $order->id }}</span>
            </div>
            <div class="detail-row">
                <strong>Order Date:</strong>
                <span>{{ $order->order_date->format('M d, Y') }}</span>
            </div>
            <div class="detail-row">
                <strong>Shipping To:</strong>
                <span>{{ $shippingAddress->first_name }} {{ $shippingAddress->last_name }}</span>
            </div>
            <div class="detail-row">
                <strong>Estimated Delivery:</strong>
                <span>{{ $order->order_date->addDays(3)->format('M d, Y') }}</span>
            </div>
        </div>

        @if($order->tracking_number)
        <div class="tracking-info">
            <h3 style="margin-top: 0; color: #0ea5e9;">📦 Tracking Information</h3>
            <p><strong>Tracking Number:</strong> {{ $order->tracking_number }}</p>
            <p>You can track your package using the link below:</p>
            <a href="#" class="btn" style="background-color: #0ea5e9;">Track Your Package</a>
        </div>
        @endif

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('dashboard') }}" class="btn">View Order Details</a>
            <a href="{{ route('products.index') }}" class="btn" style="background-color: #6b7280;">Continue Shopping</a>
        </div>

        <div class="footer">
            <p>Thank you for choosing GlowTrack for your skincare journey!</p>
            <p>If you have any questions, please contact our support team.</p>
            <p>&copy; 2024 GlowTrack. All rights reserved.</p>
        </div>
    </div>
</body>
</html>