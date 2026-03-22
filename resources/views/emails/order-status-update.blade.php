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
        .status-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .status-update {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
            margin: 10px 0;
        }
        .status-confirmed { background-color: #dbeafe; color: #1e40af; }
        .status-processing { background-color: #fef3c7; color: #92400e; }
        .status-shipped { background-color: #e9d5ff; color: #6b21a8; }
        .status-delivered { background-color: #d1fae5; color: #065f46; }
        .status-cancelled { background-color: #fee2e2; color: #991b1b; }
        .status-pending { background-color: #f3f4f6; color: #374151; }
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
        .timeline {
            margin: 20px 0;
            padding: 0;
            list-style: none;
        }
        .timeline-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f9fafb;
            border-radius: 8px;
        }
        .timeline-icon {
            font-size: 20px;
            margin-right: 15px;
        }
        .timeline-content {
            flex: 1;
        }
        .timeline-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .timeline-desc {
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ $appName }}</div>
            <div class="status-icon">📦</div>
            <h1>Order Status Update</h1>
        </div>

        <p>Hi {{ $user->name }},</p>
        
        <p>Good news! There's an update on your order #{{ $order->id }}.</p>
        
        <div class="status-update">
            <h3>Your order status has been updated to:</h3>
            <div class="status-badge status-{{ $order->status }}">
                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
            </div>
            @if($order->status === 'shipped')
                <p>🚚 Your order is on the way! You should receive it soon.</p>
            @elseif($order->status === 'delivered')
                <p>🎉 Your order has been delivered! Enjoy your products!</p>
            @elseif($order->status === 'confirmed')
                <p>✅ Your order has been confirmed and is being prepared.</p>
            @elseif($order->status === 'processing')
                <p>⚙️ Your order is being processed and will ship soon.</p>
            @elseif($order->status === 'cancelled')
                <p>❌ Your order has been cancelled. Please contact us for more information.</p>
            @endif
        </div>

        <div class="order-details">
            <h3>Order Information</h3>
            <div class="detail-row">
                <span class="detail-label">Order Number:</span>
                <span>#{{ $order->id }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Order Date:</span>
                <span>{{ $order->created_at->format('F d, Y h:i A') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Previous Status:</span>
                <span>{{ ucfirst(str_replace('_', ' ', $previousStatus)) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Current Status:</span>
                <span class="status-badge status-{{ $order->status }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Total Amount:</span>
                <span><strong>₱{{ number_format($order->total_amount, 2) }}</strong></span>
            </div>
        </div>

        <h3>Order Timeline</h3>
        <ul class="timeline">
            <li class="timeline-item">
                <div class="timeline-icon">📝</div>
                <div class="timeline-content">
                    <div class="timeline-title">Order Placed</div>
                    <div class="timeline-desc">{{ $order->created_at->format('F d, Y h:i A') }}</div>
                </div>
            </li>
            
            @if($order->confirmed_at)
            <li class="timeline-item">
                <div class="timeline-icon">✅</div>
                <div class="timeline-content">
                    <div class="timeline-title">Order Confirmed</div>
                    <div class="timeline-desc">{{ $order->confirmed_at->format('F d, Y h:i A') }}</div>
                </div>
            </li>
            @endif
            
            @if($order->shipped_at)
            <li class="timeline-item">
                <div class="timeline-icon">🚚</div>
                <div class="timeline-content">
                    <div class="timeline-title">Order Shipped</div>
                    <div class="timeline-desc">{{ $order->shipped_at->format('F d, Y h:i A') }}</div>
                </div>
            </li>
            @endif
            
            @if($order->delivered_at)
            <li class="timeline-item">
                <div class="timeline-icon">🎉</div>
                <div class="timeline-content">
                    <div class="timeline-title">Order Delivered</div>
                    <div class="timeline-desc">{{ $order->delivered_at->format('F d, Y h:i A') }}</div>
                </div>
            </li>
            @endif
        </ul>

        <div style="text-align: center;">
            <a href="{{ url('/orders/' . $order->id) }}" class="cta-button">View Order Details</a>
        </div>

        @if($order->status === 'delivered')
        <h3>What's Next?</h3>
        <ul>
            <li>⭐ Please leave a review for the products you purchased</li>
            <li>📸 Share your experience with the community</li>
            <li>💚 Earn loyalty points for every review you write</li>
            <li>🛍️ Check out our new arrivals and special offers</li>
        </ul>
        @endif

        <div class="footer">
            <p>This email was sent to {{ $user->email }} regarding order #{{ $order->id }}.</p>
            @if($order->status === 'delivered')
                <p>Your PDF receipt is attached to this email for your records.</p>
            @endif
            <p>© {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
