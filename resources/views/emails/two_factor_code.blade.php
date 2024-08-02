<!DOCTYPE html>
<html>
<head>
    <title>Two Factor Code</title>
</head>
<body>
    <h1>Hello {{ $user->first_name }},</h1>
    <p>Your two-factor authentication code is: {{ $twoFactorCode }}</p>
    <p>This code will expire in 10 minutes.</p>
</body>
</html>
