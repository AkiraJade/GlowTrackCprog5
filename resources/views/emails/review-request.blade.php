<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Request - {{ $appName }}</title>
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
        .review-icon {
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
        .detail-label {
            font-weight: bold;
            color: #6b7280;
        }
        .rating-section {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        .star-rating {
            font-size: 24px;
            color: #fbbf24;
            margin: 10px 0;
        }
        .cta-button {
            display: inline-block;
            background-color: #10b981;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
            transition: background-color 0.3s ease;
        }
        .cta-button:hover {
            background-color: #059669;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ $appName }}</div>
            <div class="review-icon">⭐</div>
            <h1>Share Your Experience!</h1>
        </div>

        <p>Hi {{ $user->name }},</p>
        
        <p>Great news! Your order #{{ $order->id }} has been delivered. We'd love to hear about your experience with the products you purchased.</p>
        
        @if($product)
            <div class="order-details">
                <h3>Product to Review:</h3>
                <div class="detail-row">
                    <span class="detail-label">Product Name:</span>
                    <span>{{ $product->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Brand:</span>
                    <span>{{ $product->brand ?? 'GlowTrack' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Order Date:</span>
                    <span>{{ $order->created_at->format('M d, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Amount:</span>
                    <span>₱{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        @endif

        <div class="rating-section">
            <h3>Why Your Review Matters:</h3>
            <ul>
                <li>🌟 Help other customers make informed decisions</li>
                <li>💚 Provide valuable feedback to sellers</li>
                <li>🎁 Earn 10 loyalty points for every review!</li>
                <li>📈 Help us improve our platform</li>
            </ul>
            
            <p><strong>What to include in your review:</strong></p>
            <ul>
                <li>✨ Product effectiveness and results</li>
                <li>🎯 Your skin type and concerns</li>
                <li>📸 Before and after photos (optional)</li>
                <li>💡 Tips for other users</li>
                <li>⭐ Overall rating (1-5 stars)</li>
            </ul>
        </div>

        <div style="text-align: center;">
            <a href="{{ url('/orders/' . $order->id . '/review') }}" class="cta-button">Leave a Review</a>
        </div>

        <div class="star-rating">
            <p>Rate your experience:</p>
            <div>⭐⭐⭐⭐⭐⭐</div>
        </p>

        <p>Your honest feedback helps our community make better skincare choices and helps sellers improve their products.</p>

        <div class="footer">
            <p>This email was sent to {{ $user->email }} regarding order #{{ $order->id }}.</p>
            <p>© {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
