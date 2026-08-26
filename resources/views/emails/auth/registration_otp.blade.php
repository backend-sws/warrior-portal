<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Code - Warriors Educare</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f7f5;
            margin: 0;
            padding: 0;
            color: #1e293b;
        }
        .container {
            max-width: 540px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #031b4e;
            padding: 30px 24px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 20px;
            margin: 12px 0 0 0;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .content {
            padding: 36px 30px;
        }
        .greeting {
            font-size: 16px;
            font-weight: 600;
            color: #031b4e;
            margin-bottom: 12px;
        }
        .text {
            font-size: 14px;
            line-height: 1.6;
            color: #475569;
            margin-bottom: 24px;
        }
        .otp-card {
            background: #f8fafc;
            border: 2px dashed #0ea5e9;
            border-radius: 16px;
            padding: 24px 20px;
            text-align: center;
            margin: 24px 0;
        }
        .otp-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #64748b;
            margin-bottom: 8px;
        }
        .otp-code {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 8px;
            color: #031b4e;
            font-family: 'Courier New', Courier, monospace;
            display: inline-block;
        }
        .expiry-note {
            font-size: 12px;
            color: #ef4444;
            font-weight: 600;
            margin-top: 8px;
        }
        .security-box {
            background-color: #f1f5f9;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 12px;
            color: #64748b;
            line-height: 1.5;
            margin-top: 24px;
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            font-size: 11px;
            color: #94a3b8;
        }
        .footer a {
            color: #0ea5e9;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0; color: #ffffff; font-size: 22px;">Warriors Educare</h1>
            <p style="margin: 4px 0 0 0; color: #93c5fd; font-size: 12px;">#1 Education Recruitment Network</p>
        </div>

        <div class="content">
            <div class="greeting">Hello {{ $name }},</div>
            <p class="text">
                Thank you for creating an account on <strong>Warriors Educare</strong>. To verify your email address and activate your account, please use the 6-digit One-Time Passcode (OTP) below:
            </p>

            <div class="otp-card">
                <div class="otp-title">Your Verification Code</div>
                <div class="otp-code">{{ $otp }}</div>
                <div class="expiry-note">⏳ Valid for the next 15 minutes</div>
            </div>

            <p class="text" style="font-size: 13px;">
                Enter this code on the registration verification screen to authenticate your email and complete your setup.
            </p>

            <div class="security-box">
                🔒 <strong>Security Warning:</strong> Warriors Educare staff will never ask you for your OTP. Please do not share this passcode with anyone. If you did not attempt to register, please ignore this email.
            </div>
        </div>

        <div class="footer">
            <p style="margin: 0 0 6px 0;">&copy; {{ date('Y') }} Warriors Educare. All rights reserved.</p>
            <p style="margin: 0;">Need assistance? Contact <a href="mailto:support@warriorseducare.com">support@warriorseducare.com</a></p>
        </div>
    </div>
</body>
</html>
