<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Reply - {{ $appName }}</title>
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
        .reply-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .discussion-details {
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
        .reply-preview {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
            font-style: italic;
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
            <div class="reply-icon">💬</div>
            <h1>New Reply in Your Discussion</h1>
        </div>

        <p>Hi {{ $user->name }},</p>
        
        <p>Great news! Someone has replied to your discussion in the {{ $appName }} community forum.</p>
        
        <div class="discussion-details">
            <h3>Your Discussion:</h3>
            <div class="detail-row">
                <span class="detail-label">Title:</span>
                <span>{{ $discussion->title }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Category:</span>
                <span>{{ $discussion->category }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Posted:</span>
                <span>{{ $discussion->created_at->format('M d, Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Replies:</span>
                <span>{{ $discussion->replies_count ?? 1 }} replies</span>
            </div>
        </div>

        @if($reply)
            <div class="reply-preview">
                <h4>Latest Reply Preview:</h4>
                <p>{{ Str::limit($reply->content, 150) }}...</p>
                @if(strlen($reply->content) > 150)
                    <p><em>Click the button below to read the full reply.</em></p>
                @endif
            </div>
        @endif

        <div style="text-align: center;">
            <a href="{{ url('/support/forum/' . $discussion->id) }}" class="cta-button">View Discussion</a>
        </div>

        <p><strong>Why this matters:</strong></p>
        <ul>
            <li>🎯 Stay engaged with your community</li>
            <li>💡 Get valuable insights and answers</li>
            <li>🌟 Help others by responding to replies</li>
            <li>📈 Build your reputation as a helpful community member</li>
        </ul>

        <p>Keep the conversation going and help our community thrive!</p>

        <div class="footer">
            <p>This email was sent to {{ $user->email }} regarding discussion "{{ $discussion->title }}".</p>
            <p>© {{ date('Y') }} {{ $appName }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
