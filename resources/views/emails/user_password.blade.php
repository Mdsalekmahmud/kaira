<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Your Account Created</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f8; font-family: Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding: 30px 0;">

                <!-- Main Card -->
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:8px; overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background:#0d6efd; color:#ffffff; padding:20px; text-align:center;">
                            <h2 style="margin:0;">Your Account Has Been Created!</h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:25px; color:#333;">

                            <p>Hello {{ $user->name }},</p>
                            <p>
                                We are Created a account for you. You can now log in to your account using the credentials provided.
                                Below are your temporary password place change it after login to your account.
                            </p>

                            <!-- Order Info -->
                            <table width="100%" cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
                                <tr>
                                    <td><strong>User Email:</strong></td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Temporary Password:</strong></td>
                                    <td>{{ $password }}</td>
                                </tr>
                                </tr>
                                
                                
                            </table>

                             

                            <p style="margin-top:30px;">
                                Regards,<br>
                                <strong>{{ config('app.name') }}</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f1f1f1; padding:15px; text-align:center; font-size:12px; color:#777;">
                            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>





