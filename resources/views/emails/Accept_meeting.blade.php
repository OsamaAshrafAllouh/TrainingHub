<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Accepted - Training Hub</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #28a745; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { background: #f8f9fa; padding: 20px; border-radius: 0 0 5px 5px; }
        .meeting-details { background: white; padding: 15px; margin: 15px 0; border-left: 4px solid #28a745; }
        .footer { text-align: center; margin-top: 20px; color: #666; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Meeting Accepted</h1>
        </div>

        <div class="content">
            <p>Dear <strong>{{ $advisorName }}</strong>,</p>

            <p>Your meeting request for the program <strong>"{{ $programName }}"</strong> has been accepted.</p>

            <div class="meeting-details">
                <h3>Meeting Details:</h3>
                <ul>
                    <li><strong>Date:</strong> {{ $date }}</li>
                    <li><strong>Time:</strong> {{ $time }}</li>
                </ul>
            </div>

            <p><strong>Important:</strong> Meeting link will be sent one hour before the scheduled time.</p>

            <p>Thank you for using Training Hub.</p>
        </div>

        <div class="footer">
            <p>Best regards,<br>The Training Hub Team</p>
            <p>© {{ date('Y') }} Training Hub. All rights reserved</p>
        </div>
    </div>
</body>
</html>
