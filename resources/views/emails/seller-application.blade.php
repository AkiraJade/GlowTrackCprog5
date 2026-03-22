<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Application - {{ $appName }}</title>
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
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 16px;
            margin: 15px 0;
        }
        .status-approved { background-color: #d1fae5; color: #065f46; }
        .status-rejected { background-color: #fee2e2; color: #991b1b; }
        .status-pending { background-color: #dbeafe; color: #1e40af; }
        .application-details {
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
            <div class="status-icon">
                @switch($status)
                    @case('approved')
                        🎉
                    @case('rejected')
                        📋
                    @case('pending')
                        ⏳
                    @default
                        📧
                @endswitch
            </div>
            <h1>Seller Application {{ ucfirst($status) }}</h1>
            <div class="status-badge status-{{ $status }}">
                {{ strtoupper($status) }}
            </div>
        </div>

        <p>Hi {{ $user->name }},</p>

        @switch($status)
            @case('approved')
                <p>Congratulations! 🎉 Your seller application has been <strong>approved</strong>. You can now start listing your skincare products on {{ $appName }}.</p>
                
                <div style="text-align: center;">
                    <a href="{{ url('/seller/dashboard') }}" class="cta-button">Go to Seller Dashboard</a>
                </div>

                <div class="application-details">
                    <h3>Business Details:</h3>
                    <div class="detail-row">
                        <span class="detail-label">Business Name:</span>
                        <span>{{ $application->business_name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Contact Person:</span>
                        <span>{{ $application->contact_person }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Application ID:</span>
                        <span>#{{ $application->id }}</span>
                    </div>
                </div>

            @case('rejected')
                <p>We regret to inform you that your seller application has been <strong>reviewed and could not be approved</strong> at this time.</p>
                
                <div class="application-details">
                    <h3>Application Details:</h3>
                    <div class="detail-row">
                        <span class="detail-label">Business Name:</span>
                        <span>{{ $application->business_name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Application Date:</span>
                        <span>{{ $application->created_at->format('M d, Y') }}</span>
                    </div>
                    @if($application->rejection_reason)
                        <div class="detail-row">
                            <span class="detail-label">Reason:</span>
                            <span>{{ $application->rejection_reason }}</span>
                        </div>
                    @endif
                </div>

                <p>You can reapply after addressing the feedback provided. If you have questions, please contact our support team.</p>

            @case('pending')
                <p>Thank you for your interest in becoming a seller on {{ $appName }}! We have <strong>received your application</strong> and it's currently under review.</p>
                
                <div class="application-details">
                    <h3>Application Details:</h3>
                    <div class="detail-row">
                        <span class="detail-label">Business Name:</span>
                        <span>{{ $application->business_name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Application Date:</span>
                        <span>{{ $application->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Application ID:</span>
                        <span>#{{ $application->id }}</span>
                    </div>
                </div>

                <p><strong>What happens next?</strong></p>
                <ul>
                    <li>Our team will review your application within 3-5 business days</li>
                    <li>You'll receive an email notification once a decision is made</li>
                    <li>We may contact you for additional information if needed</li>
                </ul>

            @default
                <p>Your seller application status has been updated.</p>
        @endswitch

        <div class="footer">
            <p>This email was sent to {{ $user->email }} regarding seller application #{{ $application->id }}.</p>
            <p>© {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
