<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Contact Message</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f4f6f8; padding:20px;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                       style="background:#ffffff; border-radius:6px; padding:20px;">

                    <tr>
                        <td style="border-bottom:1px solid #eee; padding-bottom:10px;">
                            <h2 style="margin:0; color:#333;">
                                📩 New Contact Message
                            </h2>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top:15px;">
                            <p><strong>First Name:</strong> {{ $contact->f_name }}</p>
                            <p><strong>Last Name:</strong> {{ $contact->l_name }}</p>
                            <p><strong>Email:</strong> {{ $contact->email }}</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top:15px;">
                            <p><strong>Message:</strong></p>
                            <div style="background:#f8f9fa; padding:15px; border-radius:4px;">
                                {{ $contact->message }}
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top:20px; font-size:12px; color:#777;">
                            This message was sent from the contact form.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
