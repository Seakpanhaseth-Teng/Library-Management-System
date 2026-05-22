<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Your Password</h1>

    <p>You are receiving this email because we received a password reset request for your account.</p>

    <p>
        <a href="{{ $url }}" style="display: inline-block; padding: 12px 24px; background-color: #2563eb; color: #ffffff; text-decoration: none; border-radius: 6px;">
            Reset Password
        </a>
    </p>

    <p>This password reset link will expire in {{ config('auth.passwords.users.expire') }} minutes.</p>

    <p>If you did not request a password reset, no further action is required.</p>
</body>
</html>