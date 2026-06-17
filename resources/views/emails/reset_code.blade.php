<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Verification Code</title>
</head>
<body style="margin: 0; padding: 0; background-color: #faf9f6; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333333; -webkit-font-smoothing: antialiased;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #faf9f6; padding: 40px 0;">
        <tr>
            <td align="center">
                <!-- Email container -->
                <table border="0" cellpadding="0" cellspacing="0" width="550" style="background-color: #ffffff; border: 1px solid #e8e6e1; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                    
                    <!-- Header Banner -->
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 40px 40px; text-align: center;">
                            <h1 style="color: #f59e0b; font-family: 'Georgia', serif; font-size: 28px; font-weight: 300; margin: 0; letter-spacing: 0.1em; text-transform: uppercase;">GetCare</h1>
                            <p style="color: #94a3b8; font-size: 11px; font-weight: 500; margin: 8px 0 0 0; letter-spacing: 0.2em; text-transform: uppercase;">Security concierge</p>
                        </td>
                    </tr>
                    
                    <!-- Content Area -->
                    <tr>
                        <td style="padding: 40px 45px 30px 45px;">
                            <h2 style="font-family: 'Georgia', serif; font-size: 22px; color: #0f172a; margin-top: 0; font-weight: normal; line-height: 1.3; text-align: center;">Reset Your Password</h2>
                            
                            <p style="font-size: 15px; line-height: 1.6; color: #4b5563; text-align: center; margin-bottom: 30px;">
                                We received a request to reset your account password. Please use the 6-digit verification code below to authorize this request:
                            </p>
                            
                            <!-- 6 Digit Code Box -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 30px;">
                                <tr>
                                    <td align="center">
                                        <div style="background-color: #faf9f6; border: 1px dashed #d1c7bd; border-radius: 16px; padding: 20px 40px; display: inline-block; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);">
                                            <span style="font-family: 'Courier New', Courier, monospace; font-size: 38px; font-weight: bold; color: #0f172a; letter-spacing: 12px; margin-left: 12px; display: block; line-height: 1;">{{ $code }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="font-size: 13px; line-height: 1.6; color: #9ca3af; text-align: center; margin-bottom: 30px;">
                                This security code is temporary and will expire in 15 minutes. <br>If you did not request a password reset, please ignore this email.
                            </p>
                            
                            <hr style="border: 0; border-top: 1px solid #f3f4f6; margin: 30px 0;">
                            
                            <p style="font-size: 12px; line-height: 1.6; color: #9ca3af; text-align: center; margin-bottom: 0;">
                                For your security, never share this code with anyone. GetCare support representatives will never ask you for your authorization codes or passwords.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #faf9f6; padding: 25px 40px; text-align: center; border-top: 1px solid #e8e6e1;">
                            <p style="color: #9ca3af; font-size: 12px; margin: 0 0 5px 0;">&copy; {{ date('Y') }} GetCare. All rights reserved.</p>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
