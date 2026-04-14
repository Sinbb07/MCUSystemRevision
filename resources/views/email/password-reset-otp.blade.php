<!DOCTYPE html>
<html>
<head>
    <title>Password Reset OTP</title>
</head>
<body>
    <h2>Password Reset Request</h2>
    
    <p>Dear {{ $user->user_Fname }} {{ $user->user_Lname }},</p>
    
    <p>You requested to reset your password for your {{ $appName }} account. Use the OTP code below to proceed:</p>
    
    <div>
        <p><strong>Your OTP Code:</strong></p>
        <h1>{{ $otp }}</h1>
        <p><em>This code will expire in 15 minutes</em></p>
    </div>
    
    <p><strong>Security Tips:</strong></p>
    <ul>
        <li>Never share this OTP with anyone</li>
        <li>This OTP can only be used once</li>
        <li>If you didn't request this reset, please ignore this email</li>
    </ul>
    
    <p>Best regards,<br>
    <strong>{{ $appName }} Team</strong></p>
    
    <p><small>This is an automated message. Please do not reply to this email.</small></p>
</body>
</html>