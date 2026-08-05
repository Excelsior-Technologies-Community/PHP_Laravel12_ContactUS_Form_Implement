<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Reply</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background: #2196F3; color: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { color: #333; line-height: 1.6; }
        .reply-box { background: #e3f2fd; padding: 15px; border-left: 4px solid #2196F3; border-radius: 8px; margin: 20px 0; }
        .footer { text-align: center; margin-top: 30px; color: #777; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Admin Replied to Your Message</h1>
        </div>
        <div class="content">
            <p>Dear <strong>{{ $reply->contactMessage->name }} {{ $reply->contactMessage->last_name }}</strong>,</p>
            <p>We have replied to your message. Here is our response:</p>
            
            <div class="reply-box">
                <p>{{ $reply->reply }}</p>
            </div>

            <p><strong>Replied By:</strong> {{ $reply->user->name ?? 'Admin' }}</p>
            <p><strong>Replied At:</strong> {{ $reply->created_at->format('d M Y, H:i A') }}</p>

            <p>Best regards,<br><strong>{{ config('app.name') }} Team</strong></p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
