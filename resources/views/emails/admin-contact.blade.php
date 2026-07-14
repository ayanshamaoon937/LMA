<!DOCTYPE html>
<html lang="en">

<body style="margin:0; padding:0; background-color:#f4f4f4; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <!-- Email Container -->
                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 8px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td align="left" style="background-color:#09205d; padding: 20px;">
                            <img src="{{ asset('assets/images/logo.webp') }}" alt="" height="70px">
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px 30px 20px 30px;">
                            <p style="color:#555555; font-size:16px; margin-top:0;">Hi.</p>

                             <p style="color:#555555; font-size:16px; line-height:1.5;">
                               Message Details
                            </p>

                            <p style="color:#555555; font-size:16px; line-height:1.5;">
                                {{ 'Email : ' . $email }}
                            </p>
                            <p style="color:#555555; font-size:16px; line-height:1.5;">
                                {{ 'Message : ' . $userMessage }}
                            </p>
                          
                            <p style="color:#555555; font-size:16px; line-height:1.5;">
                               Welcome to {{ config('app.name') }}
                            </p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f4f4f4; padding: 20px; text-align:center;">
                            <p style="color:#888888; font-size:14px; margin:0;">
                                Thank you, <br>
                                The {{ config('app.name') }} Team
                            </p>
                            <p style="color:#888888; font-size:14px; margin:5px 0 0 0;">
                                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
                <!-- End Email Container -->
            </td>
        </tr>
    </table>
</body>

</html>
