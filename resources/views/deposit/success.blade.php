<!DOCTYPE html>
<html>
<head>
    <title>Deposit Successful</title>
</head>
<body style="text-align:center; padding:50px;">
    <h1 style="color:green;">✓ Deposit Completed</h1>

    <p>Your deposit was completed successfully.</p>

    <p><strong>Stripe Session ID:</strong> {{ $session_id }}</p>

    <a href="/" style="padding:10px 20px; background:green; color:white; text-decoration:none;">
        Return Home
    </a>
</body>
</html>
