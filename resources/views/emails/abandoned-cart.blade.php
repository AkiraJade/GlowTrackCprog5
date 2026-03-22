<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Purchase - {{ $appName }}</title>
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
        .cart-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .cart-items {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .item-info {
            flex: 1;
        }
        .item-name {
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 5px;
        }
        .item-details {
            color: #6b7280;
            font-size: 14px;
        }
        .item-price {
            font-weight: bold;
            color: #10b981;
            font-size: 16px;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid #e2e8f0;
        }
        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #10b981;
        }
        .discount-badge {
            background-color: #fef3c7;
            color: #92400e;
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            margin: 15px 0;
            display: inline-block;
        }
        .cta-button {
            display: inline-block;
            background-color: #10b981;
            color: white;
            padding: 15px 30px;
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
            <div class="cart-icon">🛒</div>
            <h1>Did You Forget Something?</h1>
        </div>

        <p>Hi {{ $user->name }},</p>
        
        <p>We noticed you have some amazing skincare products waiting in your cart! Don't miss out on achieving your glow goals.</p>
        
        @if($cartItems->count() > 0)
            <div class="cart-items">
                <h3>Your Cart Items:</h3>
                @foreach($cartItems as $item)
                    <div class="cart-item">
                        <div class="item-info">
                            <div class="item-name">{{ $item->name ?? 'Skincare Product' }}</div>
                            <div class="item-details">
                                {{ $item->quantity ?? 1 }} × ₱{{ number_format($item->price ?? 0, 2) }}
                                @if($item->skin_type)
                                    • {{ $item->skin_type }}
                                @endif
                            </div>
                        </div>
                        <div class="item-price">
                            ₱{{ number_format(($item->price ?? 0) * ($item->quantity ?? 1), 2) }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="total-section">
                <div class="total-amount">
                    Total: ₱{{ number_format($totalAmount, 2) }}
                </div>
            </div>
        @endif

        <div class="discount-badge">
            🎁 Limited Time: Complete your order now and get free shipping on orders over ₱500!
        </div>

        <div style="text-align: center;">
            <a href="{{ url('/cart') }}" class="cta-button">Complete Your Purchase</a>
        </div>

        <p><strong>Why complete your order now?</strong></p>
        <ul>
            <li>🌟 Products may sell out or prices may change</li>
            <li>💚 Take the first step towards healthier skin</li>
            <li>🎁 Earn loyalty points on every purchase</li>
            <li>📦 Fast and reliable delivery</li>
        </ul>

        <p>These items are reserved for you, but they won't last forever!</p>

        <div class="footer">
            <p>This email was sent to {{ $user->email }} because you have items in your cart.</p>
            <p>© {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
