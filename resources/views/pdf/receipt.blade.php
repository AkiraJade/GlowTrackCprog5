<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Receipt - {{ $receiptNumber }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #10b981;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #10b981;
            margin-bottom: 5px;
        }
        .receipt-info {
            text-align: center;
            color: #666;
            font-size: 11px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
            color: #10b981;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .info-item {
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 80px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            background-color: #f3f4f6;
            padding: 8px;
            text-align: left;
            border-bottom: 2px solid #e5e7eb;
        }
        .items-table td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        .items-table .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9fafb;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #666;
            font-size: 11px;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-confirmed { background-color: #dbeafe; color: #1e40af; }
        .status-processing { background-color: #fef3c7; color: #92400e; }
        .status-shipped { background-color: #e9d5ff; color: #6b21a8; }
        .status-delivered { background-color: #d1fae5; color: #065f46; }
        .status-cancelled { background-color: #fee2e2; color: #991b1b; }
        .status-pending { background-color: #f3f4f6; color: #374151; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">{{ $appName }}</div>
        <div class="receipt-info">
            <strong>Order Receipt</strong><br>
            Receipt #: {{ $receiptNumber }}<br>
            Date: {{ $receiptDate }}
        </div>
    </div>

    <div class="section">
        <div class="info-grid">
            <div>
                <div class="section-title">Order Information</div>
                <div class="info-item">
                    <span class="info-label">Order ID:</span> #{{ $order->id }}
                </div>
                <div class="info-item">
                    <span class="info-label">Order Date:</span> {{ $order->created_at->format('F d, Y h:i A') }}
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span> 
                    <span class="status-badge status-{{ $order->status }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Payment:</span> {{ ucfirst($order->payment_method ?? 'Cash on Delivery') }}
                </div>
            </div>
            <div>
                <div class="section-title">Customer Information</div>
                <div class="info-item">
                    <span class="info-label">Name:</span> {{ $user->name }}
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span> {{ $user->email }}
                </div>
                <div class="info-item">
                    <span class="info-label">Phone:</span> {{ $user->phone }}
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Shipping Address</div>
        <div>{{ $shippingAddress }}</div>
    </div>

    <div class="section">
        <div class="section-title">Order Items</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Brand</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Qty</th>
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
                    <td colspan="4" style="text-align: right;"><strong>Subtotal:</strong></td>
                    <td class="text-right">₱{{ number_format($order->total_amount, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="4" style="text-align: right;"><strong>Shipping:</strong></td>
                    <td class="text-right">₱{{ number_format($order->shipping_fee ?? 0, 2) }}</td>
                </tr>
                <tr class="total-row" style="border-top: 2px solid #10b981;">
                    <td colspan="4" style="text-align: right;"><strong>Total Amount:</strong></td>
                    <td class="text-right"><strong>₱{{ number_format($order->total_amount, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    @if($order->notes)
    <div class="section">
        <div class="section-title">Order Notes</div>
        <div>{{ $order->notes }}</div>
    </div>
    @endif

    <div class="footer">
        <p><strong>Thank you for your order!</strong></p>
        <p>This receipt serves as proof of purchase. Please keep it for your records.</p>
        <p>For questions or concerns, please contact our customer service.</p>
        <p>&copy; {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
    </div>
</body>
</html>
