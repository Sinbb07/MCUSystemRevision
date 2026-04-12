<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Exemption Granted</title>
</head>
<body>
    <h2>Certificate of Exemption Granted</h2>
    
    <p>Dear {{ $pi->user_Fname }} {{ $pi->user_Lname }},</p>
    
    <p>We are pleased to inform you that your research protocol has been granted a Certificate of Exemption.</p>
    
    <p><strong>Protocol Code:</strong> {{ $protocol->protocol_ID }}</p>
    <p><strong>Research Title:</strong> {{ $research->research_title ?? 'N/A' }}</p>
    <p><strong>Date Granted:</strong> {{ now()->format('F d, Y') }}</p>
    
    <p>Your research has been exempted from full ERB review as it meets the criteria for exemption under the institutional guidelines.</p>
    
    <p><strong>Next Steps:</strong><br>
    You may proceed with your research activities. Please ensure you adhere to all ethical guidelines and maintain proper documentation.</p>
    
    <p>The Certificate of Exemption will be sent to you in the next coming days.</p>
    
    <p>If you have any questions, please contact the Research Administration Office.</p>
    
    <p>Congratulations on this milestone!</p>
    
    <p>Best regards,<br>
    <strong>Ethics Review Board</strong><br>
    {{ $appName }}</p>
</body>
</html>