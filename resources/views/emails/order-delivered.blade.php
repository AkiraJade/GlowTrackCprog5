<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order Has Been Delivered - {{ $user->name }} from GlowTrack</title>
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
        .delivered-icon {
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
        .review-section {
            background-color: #f0fdf4;
            border: 1px solid #10b981;
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
            <div class="delivered-icon">✅</div>
            <h1>Your Order Has Been Delivered!</h1>
            <p>Your skincare products have arrived safely. We hope you love them!</p>
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
                <strong>Delivered To:</strong>
                <span>{{ $shippingAddress->first_name }} {{ $shippingAddress->last_name }}</span>
            </div>
            <div class="detail-row">
                <strong>Delivery Date:</strong>
                <span>{{ $order->updated_at->format('M d, Y') }}</span>
            </div>
        </div>

        <div class="review-section">
            <h3 style="margin-top: 0; color: #10b981;">💬 Share Your Experience</h3>
            <p>We'd love to hear about your experience with our products! Your feedback helps us improve and helps other customers find the perfect skincare solutions.</p>
            <a href="{{ route('products.index') }}" class="btn">Leave a Review</a>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('dashboard') }}" class="btn">View Order Details</a>
            <a href="{{ route('products.index') }}" class="btn" style="background-color: #6b7280;">Shop More Products</a>
        </div>

        <div class="footer">
            <p>Thank you for being part of the GlowTrack community!</p>
            <p>If you have any questions about your order, please contact our support team.</p>
            <p>&copy; 2024 GlowTrack. All rights reserved.</p>
        </div>
    </div>
</body>
</html>