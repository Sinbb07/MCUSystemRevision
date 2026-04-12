<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Full Board Meeting Invitation</title>
</head>
<body>
    <h2>Full Board Meeting Invitation</h2>
    
    <p>Dear Reviewer,</p>
    
    <p>You have been selected to participate in a face-to-face Full Board Meeting to review a research protocol.</p>
    
    <p><strong>Protocol ID:</strong> {{ $protocolId }}</p>
    <p><strong>Assignment ID:</strong> {{ $assignmentId }}</p>
    <p><strong>Invited By:</strong> {{ $assignedBy->user_Fname }} {{ $assignedBy->user_Lname }}</p>
    <p><strong>Date of Invitation:</strong> {{ now()->format('F d, Y') }}</p>
    
    <p><strong>Meeting Details:</strong><br>
    As a valued member of the Full Board Review Committee, your presence and expertise are requested for the upcoming face-to-face meeting to thoroughly evaluate this research protocol.</p>
    
    <p><strong>Important Information:</strong><br>
    - A formal meeting invitation with date, time, and venue will be sent to you in the coming days<br>
    - Please review the protocol materials in preparation for the meeting<br>
    - Your assessment and insights during the meeting are crucial for the ethical review process</p>
    
    <p>If you have any scheduling conflicts or questions about this assignment, please contact the ERB administration as soon as possible.</p>
    
    <p>We look forward to your valuable participation in this important ethical review process.</p>
    
    <p>Best regards,<br>
    <strong>Ethics Review Board</strong><br>
    {{ $appName }}</p>
</body>
</html>