<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Credentials - Training System</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #007bff; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { background: #f8f9fa; padding: 20px; border-radius: 0 0 5px 5px; }
        .credentials { background: white; padding: 15px; margin: 15px 0; border-left: 4px solid #007bff; }
        .footer { text-align: center; margin-top: 20px; color: #666; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Training System</h1>
        </div>
        
        <div class="content">
            <p>Welcome to the Training System! Your account has been created successfully.</p>
            
            <div class="credentials">
                <h3>Login Credentials:</h3>
                <p><strong>Unique User ID:</strong> {{ $trainee_id }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
            </div>
            
            <p><strong>Important Notes:</strong></p>
            <ul>
                <li>Keep these credentials in a safe place</li>
                <li>Use <strong>Unique User ID</strong> or <strong>Email</strong> to login</li>
                <li>You can change your password from your profile page</li>
                <li>Do not share these credentials with anyone</li>
            </ul>
            
            <p>Thank you for joining our training program!</p>
        </div>
        
        <div class="footer">
            <p>This is an automated email, please do not reply</p>
            <p>© {{ date('Y') }} Training System. All rights reserved</p>
        </div>
    </div>
</body>
</html>
