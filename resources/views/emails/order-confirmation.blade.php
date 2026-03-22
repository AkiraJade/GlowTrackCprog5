<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - {{ $user->name }} from GlowTrack</title>
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
        .order-icon {
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
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .items-table th {
            background-color: #f3f4f6;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #e5e7eb;
        }
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        .items-table .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9fafb;
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
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #dbeafe;
            color: #1e40af;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
            <div class="order-icon">🛍️</div>
            <h1>Order Confirmed!</h1>
        </div>

        <p>Hi {{ $user->name }},</p>
        
        <p>Thank you for your order! We're pleased to confirm that your order #{{ $order->id }} has been received and is being processed.</p>
        
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
                <span class="detail-label">Status:</span>
                <span class="status-badge">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payment Method:</span>
                <span>{{ ucfirst($order->payment_method ?? 'Cash on Delivery') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Total Amount:</span>
                <span><strong>₱{{ number_format($order->total_amount, 2) }}</strong></span>
            </div>
        </div>

        <h3>Order Items</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Brand</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Quantity</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->product->brand }}</td>
                        <td class="text-right">₱{{ number_format($item->price, 2) }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                    <td class="text-right"><strong>₱{{ number_format($order->total_amount, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="order-details">
            <h3>Shipping Information</h3>
            <div class="detail-row">
                <span class="detail-label">Shipping Address:</span>
                <span>{{ $order->shipping_address ?? $user->address }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Contact Number:</span>
                <span>{{ $user->phone }}</span>
            </div>
        </div>

        <div style="text-align: center;">
            <a href="{{ url('/orders/' . $order->id) }}" class="cta-button">Track Your Order</a>
        </div>

        <h3>What's Next?</h3>
        <ul>
            <li>📦 We'll process your order within 1-2 business days</li>
            <li>🚚 You'll receive a shipping confirmation email once your order is on the way</li>
            <li>📱 You can track your order status in your account dashboard</li>
            <li>💬 Need help? Reply to this email or contact our customer service</li>
        </ul>

        <div class="footer">
            <p>This email was sent to {{ $user->email }} regarding order #{{ $order->id }}.</p>
            <p>Your PDF receipt is attached to this email for your records.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
