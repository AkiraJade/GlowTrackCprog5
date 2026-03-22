<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Email</title>
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
            background-color: #4a7c59;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 8px 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Test Email</h1>
    </div>
    
    <div class="content">
        <p>This is a test email from GlowTrack to verify that the rate limiting is working properly.</p>
        
        <p><strong>Time sent:</strong> {{ date('Y-m-d H:i:s') }}</p>
        
        <p>If you received this email, it means the rate limiting system is functioning correctly.</p>
        
        <p>Best regards,<br>The GlowTrack Team</p>
    </div>
</body>
</html>
