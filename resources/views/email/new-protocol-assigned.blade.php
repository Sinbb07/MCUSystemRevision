<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Protocol Assigned</title>
</head>
<body>
    <h2>New Research Protocol Assigned for Review</h2>
    
    <p>Dear Reviewer,</p>
    
    <p>A new research protocol has been assigned to you for review.</p>
    
    <p><strong>Protocol Code:</strong> {{ $protocolCode }}</p>
    <p><strong>Principal Investigator:</strong> {{ $piName }}</p>
    <p><strong>Review Type:</strong> {{ $reviewType }}</p>
    <p><strong>Date Assigned:</strong> {{ now()->format('F d, Y') }}</p>
    
    <p><strong>Action Required:</strong><br>
    Please log in to the ERB system to review the assigned protocol. The review must be completed within the stipulated timeframe.</p>
    
    <p>If you have any questions or concerns about this assignment, please contact the ERB administration.</p>
    
    <p>Thank you for your contribution to the research ethics review process.</p>
    
    <p>Best regards,<br>
    <strong>Ethics Review Board</strong><br>
    {{ $appName }}</p>
</body>
</html>