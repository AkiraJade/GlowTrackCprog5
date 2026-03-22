<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyalty Points - {{ $appName }}</title>
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
        .points-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .points-earned {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            margin: 20px 0;
        }
        .points-amount {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .points-label {
            font-size: 18px;
            opacity: 0.9;
        }
        .balance-info {
            background-color: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
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
            <div class="points-icon">🌟</div>
            <h1>Loyalty Points Earned!</h1>
        </div>

        <p>Hi {{ $user->name }},</p>
        
        <p>Congratulations! You've just earned <strong>{{ $points }} loyalty points</strong> on {{ $appName }}!</p>
        
        <div class="points-earned">
            <div class="points-amount">+{{ $points }}</div>
            <div class="points-label">Loyalty Points</div>
        </div>

        <div class="balance-info">
            <h3>📊 Your Account Summary:</h3>
            <div style="display: flex; justify-content: space-between; margin: 10px 0;">
                <span><strong>Points Earned:</strong></span>
                <span>+{{ $points }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin: 10px 0;">
                <span><strong>Reason:</strong></span>
                <span>{{ $reason }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin: 10px 0; border-top: 1px solid #10b981; padding-top: 10px;">
                <span><strong>Current Balance:</strong></span>
                <span style="font-size: 18px; color: #10b981;">{{ $currentBalance }} points</span>
            </div>
        </div>

        <div style="text-align: center;">
            <a href="{{ url('/loyalty') }}" class="cta-button">View Rewards</a>
        </div>

        <p><strong>What can you do with your points?</strong></p>
        <ul>
            <li>🎁 Redeem exclusive discounts</li>
            <li>📦 Get free products</li>
            <li>💆 Access VIP consultations</li>
            <li>🎉 Unlock special rewards</li>
        </ul>

        <p>Keep earning points by:</p>
        <ul>
            <li>🛍️ Making purchases (1 point per ₱1 spent)</li>
            <li>⭐ Writing reviews (10 points per review)</li>
            <li>👥 Referring friends (50 points per referral)</li>
            <li>💬 Forum participation (5 points per helpful post)</li>
            <li>🎂 Birthday bonuses (25 points)</li>
        </ul>

        <div class="footer">
            <p>This email was sent to {{ $user->email }} regarding loyalty points update.</p>
            <p>© {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
