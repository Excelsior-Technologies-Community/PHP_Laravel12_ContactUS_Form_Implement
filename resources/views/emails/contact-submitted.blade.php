<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contact Submitted</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background: #4CAF50; color: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { color: #333; line-height: 1.6; }
        .details { background: #f9f9f9; padding: 15px; border-radius: 8px; margin: 20px 0; }
        .detail-item { padding: 8px 0; border-bottom: 1px solid #eee; }
        .detail-item:last-child { border-bottom: none; }
        .footer { text-align: center; margin-top: 30px; color: #777; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>We Received Your Message!</h1>
        </div>
        <div class="content">
            <p>Dear <strong>{{ $contact->name }} {{ $contact->last_name }}</strong>,</p>
            <p>Thank you for contacting us. We have received your message and will get back to you as soon as possible.</p>
            
            <div class="details">
                <div class="detail-item"><strong>Name:</strong> {{ $contact->name }} {{ $contact->last_name }}</div>
                <div class="detail-item"><strong>Email:</strong> {{ $contact->email }}</div>
                <div class="detail-item"><strong>Mobile:</strong> {{ $contact->mobile }}</div>
                @if($contact->subject)
                <div class="detail-item"><strong>Subject:</strong> {{ $contact->subject }}</div>
                @endif
                <div class="detail-item"><strong>Priority:</strong> {{ ucfirst($contact->priority) }}</div>
                <div class="detail-item"><strong>Status:</strong> {{ ucfirst($contact->status) }}</div>
                <div class="detail-item"><strong>Message:</strong> {{ $contact->message }}</div>
                <div class="detail-item"><strong>Submitted At:</strong> {{ $contact->created_at->format('d M Y, H:i A') }}</div>
            </div>

            <p>You can track your message status by visiting our tracking page.</p>
            <p>Best regards,<br><strong>{{ config('app.name') }} Team</strong></p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
