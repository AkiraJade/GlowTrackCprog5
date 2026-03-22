<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Your Email Address</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f3f4f6;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-radius: 0 0 8px 8px;
        }
        .button {
            display: inline-block;
            background-color: #4f46e5;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to {{ $appName }}!</h1>
    </div>
    
    <div class="content">
        <p>Hi {{ $user->name }},</p>
        
        <p>Thank you for signing up! Please verify your email address by clicking the button below:</p>
        
        <center>
            <a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>
        </center>
        
        <p>Or copy and paste this link into your browser:</p>
        <p style="word-break: break-all; color: #4f46e5;">{{ $verificationUrl }}</p>
        
        <p>This verification link will expire in 60 minutes.</p>
        
        <p>If you did not create an account, no further action is required.</p>
        
        <p>Best regards,<br>The {{ $appName }} Team</p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
    </div>
</body>
</html>
