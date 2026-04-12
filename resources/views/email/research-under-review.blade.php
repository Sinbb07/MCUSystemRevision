<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Research Under Review</title>
</head>
<body>
    <h2>Research Protocol Under Review</h2>
    
    <p>Dear Researcher,</p>
    
    <p>Your research protocol has been received and is currently under review by the Ethics Review Board.</p>
    
    <p><strong>Protocol Code:</strong> {{ $protocolCode }}</p>
    <p><strong>Review Type:</strong> {{ $reviewType }}</p>
    <p><strong>Date Submitted:</strong> {{ now()->format('F d, Y') }}</p>
    
    <p><strong>Review Process:</strong><br>
    Your submission is now undergoing the standard review process. You will be notified once the review is complete.</p>
    
    <p>Please allow adequate time for the review process. The ERB committee will contact you if additional information is required.</p>
    
    <p>Thank you for your patience.</p>
    
    <p>Best regards,<br>
    <strong>Ethics Review Board</strong><br>
    {{ $appName }}</p>
</body>
</html>