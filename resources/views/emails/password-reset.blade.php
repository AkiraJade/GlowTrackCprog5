<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password - GlowTrack</title>
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
        .reset-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .security-notice {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            background-color: #10b981;
            color: white;
            padding: 14px 28px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
            text-align: center;
        }
        .btn:hover {
            background-color: #059669;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #666;
            font-size: 14px;
        }
        .link-expiry {
            color: #dc2626;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">✨ GlowTrack</div>
            <div class="reset-icon">🔐</div>
            <h1>Reset Your Password</h1>
            <p>We received a request to reset your password for your GlowTrack account.</p>
        </div>

        <div class="security-notice">
            <h3 style="margin-top: 0; color: #92400e;">🔒 Security Notice</h3>
            <p>If you didn't request this password reset, please ignore this email. Your password will remain unchanged.</p>
            <p>This reset link will expire in <span class="link-expiry">60 minutes</span> for your security.</p>
        </div>

        <div style="text-align: center;">
            <a href="{{ $resetUrl }}" class="btn">Reset My Password</a>
        </div>

        <div style="margin: 30px 0; padding: 20px; background-color: #f8fafc; border-radius: 8px;">
            <h3 style="margin-top: 0; color: #10b981;">Having trouble with the button?</h3>
            <p>Copy and paste this link into your browser:</p>
            <p style="word-break: break-all; background-color: #e2e8f0; padding: 10px; border-radius: 4px; font-family: monospace; font-size: 14px;">
                {{ $resetUrl }}
            </p>
        </div>

        <div class="footer">
            <p>This password reset link was requested for the email address: <strong>{{ $user->email }}</strong></p>
            <p>If you have any questions, please contact our support team.</p>
            <p>&copy; 2024 GlowTrack. All rights reserved.</p>
        </div>
    </div>
</body>
</html>