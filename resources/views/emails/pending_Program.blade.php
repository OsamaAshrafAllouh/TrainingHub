<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Pending - Training Hub</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #dc3545; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { background: #f8f9fa; padding: 20px; border-radius: 0 0 5px 5px; }
        .warning-box { background: white; padding: 15px; margin: 15px 0; border-left: 4px solid #dc3545; }
        .fees { background: #fff3cd; padding: 10px; border-radius: 3px; border: 1px solid #ffeaa7; }
        .footer { text-align: center; margin-top: 20px; color: #666; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Program Status: Pending</h1>
        </div>
        
        <div class="content">
            <p>Dear <strong>{{ $trainee_name }}</strong>,</p>
            
            <div class="warning-box">
                <h3>⚠️ Important Notice</h3>
                <p>Your enrollment in the program <strong>"{{ $course_name }}"</strong> has been set to <strong>PENDING</strong> status.</p>
                
                <p><strong>Reason:</strong> Payment has not been completed for this program.</p>
                
                <div class="fees">
                    <p><strong>Program Fees:</strong> {{ $fees }}</p>
                </div>
                
                <p><strong>Action Required:</strong> Please complete the payment to reactivate your program access.</p>
                
                <p><strong>Note:</strong> Once payment is received, your program status will automatically return to "Accepted".</p>
            </div>
            
            <p>If you have any questions about payment, please contact our support team.</p>
        </div>
        
        <div class="footer">
            <p>Best regards,<br>The Training Hub Team</p>
            <p>© {{ date('Y') }} Training Hub. All rights reserved</p>
        </div>
    </div>
</body>
</html>
