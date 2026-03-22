<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update - {{ $appName }}</title>
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
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            margin: 15px 0;
        }
        .status-confirmed { background-color: #dbeafe; color: #1e40af; }
        .status-processing { background-color: #fef3c7; color: #92400e; }
        .status-shipped { background-color: #e0e7ff; color: #3730a3; }
        .status-delivered { background-color: #d1fae5; color: #065f46; }
        .status-cancelled { background-color: #fee2e2; color: #991b1b; }
        .order-details {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .item-info {
            flex: 1;
        }
        .item-price {
            font-weight: bold;
            color: #10b981;
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
        .status-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ $appName }}</div>
            <div class="status-icon">
                @switch($status)
                    @case('confirmed')
                        ✅
                    @case('processing')
                        ⚙️
                    @case('shipped')
                        📦
                    @case('delivered')
                        🎉
                    @case('cancelled')
                        ❌
                    @default
                        📋
                @endswitch
            </div>
            <h1>Order Status Update</h1>
            <div class="status-badge status-{{ strtolower($status) }}">
                {{ strtoupper($status) }}
            </div>
        </div>

        <div class="order-details">
            <h3>Order #{{ $order->id }}</h3>
            <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
            
            @if($order->items)
                <h4>Order Items:</h4>
                @foreach($order->items as $item)
                    <div class="order-item">
                        <div class="item-info">
                            <strong>{{ $item->product_name ?? 'Product' }}</strong>
                            <span style="color: #6b7280;">× {{ $item->quantity ?? 1 }}</span>
                        </div>
                        <div class="item-price">
                            ₱{{ number_format($item->price ?? 0, 2) }}
                        </div>
                    </div>
                @endforeach
            @endif

            <div class="total-section">
                <div class="total-amount">
                    Total: ₱{{ number_format($order->total_amount ?? 0, 2) }}
                </div>
            </div>
        </div>

        <div style="text-align: center;">
            <a href="{{ url('/orders') }}" class="cta-button">View Order Details</a>
        </div>

        @switch($status)
            @case('confirmed')
                <p style="text-align: center; margin: 20px 0;">
                    Your order has been confirmed! We're preparing your items for shipment.
                </p>
            @case('processing')
                <p style="text-align: center; margin: 20px 0;">
                    Your order is being processed. We'll notify you once it ships.
                </p>
            @case('shipped')
                <p style="text-align: center; margin: 20px 0;">
                    Your order has been shipped! Track your package for real-time updates.
                </p>
            @case('delivered')
                <p style="text-align: center; margin: 20px 0;">
                    Your order has been delivered! Enjoy your skincare products.
                </p>
            @case('cancelled')
                <p style="text-align: center; margin: 20px 0;">
                    Your order has been cancelled. If you didn't request this, please contact support.
                </p>
        @endswitch

        <div class="footer">
            <p>This email was sent to {{ $user->email }} regarding order #{{ $order->id }}.</p>
            <p>© {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
