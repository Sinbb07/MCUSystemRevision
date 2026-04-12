<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Document Deleted</title>
</head>
<body>
    <h2>Document Deleted - Resubmission Required</h2>
    
    <p>Dear {{ $user->name }},</p>
    
    <p>Your research document has been deleted by an administrator and requires resubmission.</p>
    
    <p><strong>Form to Resubmit:</strong> {{ $data['form_name'] }}</p>
    <p><strong>Original Document:</strong> {{ $data['document_name'] }}</p>
    <p><strong>Deleted on:</strong> {{ $data['deleted_at'] }}</p>
    <p><strong>Reason:</strong> {{ $data['delete_reason'] }}</p>
    
    <p><strong>Action Required:</strong> Please log in to the system and resubmit <strong>{{ $data['form_name'] }}</strong> with the necessary corrections.</p>
    
    <p>If you have any questions, please contact the research administration office.</p>
    
    <p>Thank you,<br>
    Ethical Research Board Administrator</p>
</body>
</html>