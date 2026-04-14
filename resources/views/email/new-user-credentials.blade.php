<!DOCTYPE html>
<html>
<head>
    <title>Account Credentials</title>
</head>
<body>
    <h2>Welcome to {{ $appName }}!</h2>
    
    <p>Dear {{ $user->user_Fname }} {{ $user->user_Lname }},</p>
    
    <p>Your account has been created successfully. Here are your login credentials:</p>
    
    <div style="background: #f4f4f4; padding: 15px; margin: 15px 0;">
        <p><strong>User ID:</strong> {{ $user->user_ID }}</p>
        <p><strong>Email:</strong> {{ $user->user_Email }}</p>
        <p><strong>Password:</strong> {{ $plainPassword }}</p>
        <p><strong>Access Level:</strong> {{ $user->user_Access }}</p>
    </div>
    
    <p><strong>Important:</strong> For security reasons, please change your password after first login.</p>
    
    <p>Best regards,<br>
    {{ $appName }} Team</p>
</body>
</html>