<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body>
    <h1>Password Reset Request</h1>
    <p>Hello,</p>
    <p>We received a request to reset your password. Click the link below to reset it:</p>
    <p><a href="{{ $resetLink }}">{{ $resetLink }}</a></p>
    <p>If you did not request a password reset, please ignore this email.</p>
    <p>Thanks,<br>Your App Team</p>
</body>
</html>