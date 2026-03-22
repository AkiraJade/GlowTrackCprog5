<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ $appName }}</title>
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
        .welcome-title {
            font-size: 24px;
            color: #8b5a2b;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 30px;
        }
        .feature-list {
            background-color: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        .feature-list h3 {
            color: #10b981;
            margin-top: 0;
        }
        .feature-list ul {
            margin: 10px 0;
            padding-left: 20px;
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
        .highlight {
            background-color: #fef3c7;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #f59e0b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ $appName }}</div>
            <h1 class="welcome-title">Welcome, {{ $user->name }}! 🌟</h1>
        </div>

        <div class="content">
            <p>Thank you for joining GlowTrack! We're excited to be part of your skincare journey.</p>
            
            <div class="highlight">
                <strong>🎉 Special Welcome Offer!</strong> As a new member, you'll receive exclusive access to our personalized skincare recommendations and loyalty program.
            </div>

            <div class="feature-list">
                <h3>What You Can Do With GlowTrack:</h3>
                <ul>
                    <li>🛍️ Browse curated skincare products</li>
                    <li>🔍 Find products perfect for your skin type</li>
                    <li>📅 Create personalized skincare routines</li>
                    <li>⭐ Earn loyalty points on every purchase</li>
                    <li>💬 Join our community forum</li>
                    <li>📦 Track your orders in real-time</li>
                </ul>
            </div>

            <p>Ready to start your journey to healthier, glowing skin?</p>
            
            <div style="text-align: center;">
                <a href="{{ url('/dashboard') }}" class="cta-button">Go to Your Dashboard</a>
            </div>
        </div>

        <div class="footer">
            <p>This email was sent to {{ $user->email }} because you recently created an account with {{ $appName }}.</p>
            <p>© {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
