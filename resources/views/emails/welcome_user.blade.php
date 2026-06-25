<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Welcome</title>
</head>

<body style="font-family: Arial, sans-serif;">

    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #333;">Email Verification</h2>
        <p style="color: #555;">Hallo {{ $userData['name'] }},</p>
        <p style="color: #555;">Your account has been successfully created.</p>
        <table border="1" cellpadding="8" cellspacing="0" align="center">
            <tr>
                <td><strong>Name</strong></td>
                <td>{{ $userData['name'] }}</td>
            </tr>
            <tr>
                <td><strong>Username</strong></td>
                <td style="text-decoration: none;">{{ $userData['email'] }}</td>
            </tr>
            <tr>
                <td><strong>Password</strong></td>
                <td>{{ $userData['password'] }}</td>
            </tr>
            <tr>
                <td><strong>Role</strong></td>
                <td>{{ getColumnByName('roles', $userData['role_id'], 'name') }}</td>
            </tr>
        </table>

        <p style="color: #555;">To Verify Your Email Address, please click the button below to access the dashboard:</p>
        <div style="text-align: center; margin: 20px 0;">
            <a href="{{ $userData['verificationUrl'] }}" target="_blank"
                style="background-color: #28a745; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Verify
                Email</a>
        </div>
        <p style="color: #555; margin-top: 20px;">If you have any questions or need assistance, feel free to contact our
            support team.</p>
        <p style="color: #555;">Best regards,<br>Our Team</p>
    </div>

</body>

</html>
