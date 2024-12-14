<!DOCTYPE html>
<html>
<head>
    <title>Message Reply</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; border-radius: 10px; padding: 20px; margin-bottom: 20px;">
        <h2 style="color: #2d3748; margin-bottom: 15px;">Message Reply</h2>
        <p style="margin-bottom: 20px;">We have received your message and here is our response:</p>
        
        <div style="background-color: #ffffff; border-left: 4px solid #4299e1; padding: 15px; margin-bottom: 20px;">
            {{ $reply_msg }}
        </div>

        <p style="color: #718096; font-size: 14px;">Thank you for contacting us. If you have any further questions, please don't hesitate to reach out.</p>
    </div>

    <div style="text-align: center; color: #718096; font-size: 12px; margin-top: 30px;">
        <p>&copy; {{ date('Y') }} EduLearn. All rights reserved.</p>
    </div>
</body>
</html>
