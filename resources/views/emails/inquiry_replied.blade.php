<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Inquiry Reply - GetCare</title>
</head>
<body style="margin: 0; padding: 0; background-color: #faf9f6; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333333; -webkit-font-smoothing: antialiased;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #faf9f6; padding: 40px 0;">
        <tr>
            <td align="center">
                <!-- Email container -->
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border: 1px solid #e8e6e1; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                    
                    <!-- Header Banner -->
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 50px 40px; text-align: center;">
                            <h1 style="color: #f59e0b; font-family: 'Georgia', serif; font-size: 32px; font-weight: 300; margin: 0; letter-spacing: 0.1em; text-transform: uppercase;">GetCare</h1>
                            <p style="color: #94a3b8; font-size: 13px; font-weight: 500; margin: 10px 0 0 0; letter-spacing: 0.2em; text-transform: uppercase;">Concierge Support Response</p>
                        </td>
                    </tr>
                    
                    <!-- Content Area -->
                    <tr>
                        <td style="padding: 40px 40px 30px 40px;">
                            <h2 style="font-family: 'Georgia', serif; font-size: 24px; color: #0f172a; margin-top: 0; font-weight: normal; line-height: 1.3;">A representative has replied to your inquiry</h2>
                            <p style="font-size: 15px; line-height: 1.6; color: #4b5563; margin-bottom: 24px;">
                                Hello {{ $customerMessage->first_name }} {{ $customerMessage->last_name }}, we have reviewed your support inquiry regarding <strong>{{ ucwords(str_replace('_', ' ', $customerMessage->inquiry_type)) }}</strong>. Below is the message trail for your reference.
                            </p>
                            
                            <!-- Messages Trail Box -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 30px; border-collapse: separate; border-spacing: 0;">
                                <tr>
                                    <td style="background-color: #faf9f6; border: 1px solid #e8e6e1; border-radius: 12px; padding: 20px;">
                                        <!-- Original Message -->
                                        <div style="margin-bottom: 15px; border-bottom: 1px solid #e8e6e1; padding-bottom: 15px;">
                                            <span style="font-size: 11px; color: #9ca3af; text-transform: uppercase; font-weight: bold; letter-spacing: 0.05em;">Your Inquiry:</span>
                                            <p style="font-size: 14px; line-height: 1.5; color: #6b7280; margin: 5px 0 0 0; font-style: italic;">
                                                "{{ $customerMessage->message }}"
                                            </p>
                                        </div>
                                        
                                        <!-- Admin Reply -->
                                        <div>
                                            <span style="font-size: 11px; color: #f59e0b; text-transform: uppercase; font-weight: bold; letter-spacing: 0.05em;">GetCare Concierge Reply:</span>
                                            <p style="font-size: 14px; line-height: 1.6; color: #0f172a; margin: 5px 0 0 0; font-weight: 500;">
                                                {!! nl2br(e($customerMessage->reply)) !!}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 15px; line-height: 1.6; color: #4b5563; margin-bottom: 30px;">
                                You can view your full communication history and submit follow-ups directly from your customer dashboard.
                            </p>

                            <!-- Action Button -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 35px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/dashboard') }}" style="display: inline-block; padding: 15px 40px; background-color: #0f172a; color: #ffffff; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 14px; letter-spacing: 0.15em; text-transform: uppercase; box-shadow: 0 5px 15px rgba(15,23,42,0.15); transition: background-color 0.3s;">
                                            Go to Support Dashboard
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <hr style="border: 0; border-top: 1px solid #f3f4f6; margin: 30px 0;">
                            
                            <p style="font-size: 14px; line-height: 1.6; color: #6b7280; margin-bottom: 0; text-align: center;">
                                If you have any further questions, you can respond directly from your account page.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #faf9f6; padding: 30px 40px; text-align: center; border-top: 1px solid #e8e6e1;">
                            <p style="color: #9ca3af; font-size: 12px; margin: 0 0 8px 0;">&copy; {{ date('Y') }} GetCare. All rights reserved.</p>
                            <p style="color: #d1d5db; font-size: 11px; margin: 0;">This email is sent to you because you submitted a customer care inquiry.</p>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
