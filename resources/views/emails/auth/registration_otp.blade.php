<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Code - Warriors Educare</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 24px 10px;
            color: #334155;
            -webkit-text-size-adjust: none;
        }
        .container {
            max-width: 560px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }
        .header {
            background: linear-gradient(135deg, #031b4e 0%, #082873 100%);
            padding: 26px 20px;
            text-align: center;
            border-bottom: 3px solid #fbc043;
        }
        .brand-box {
            display: inline-block;
            text-align: left;
        }
        .logo-badge {
            width: 36px;
            height: 36px;
            background-color: #fbc043;
            border-radius: 10px;
            text-align: center;
            line-height: 36px;
            font-weight: 900;
            font-size: 20px;
            color: #031b4e;
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }
        .brand-title {
            font-size: 20px;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: 1px;
            text-transform: uppercase;
            line-height: 1.2;
            display: inline-block;
            vertical-align: middle;
        }
        .brand-subtitle {
            font-size: 10px;
            font-weight: 700;
            color: #93c5fd;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            display: block;
            margin-top: 2px;
            text-align: center;
        }
        .content {
            padding: 36px 30px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 800;
            color: #031b4e;
            margin-bottom: 12px;
        }
        .text {
            font-size: 15px;
            line-height: 1.65;
            color: #475569;
            margin-bottom: 24px;
        }
        .otp-card {
            background: #f8fafc;
            border: 2px dashed #0ea5e9;
            border-radius: 14px;
            padding: 24px 20px;
            text-align: center;
            margin: 24px 0;
        }
        .otp-title {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #64748b;
            margin-bottom: 10px;
        }
        .otp-code {
            font-size: 38px;
            font-weight: 900;
            letter-spacing: 8px;
            color: #031b4e;
            font-family: 'Courier New', Courier, monospace;
            display: inline-block;
            background: #ffffff;
            padding: 6px 20px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }
        .expiry-note {
            font-size: 12px;
            color: #ef4444;
            font-weight: 700;
            margin-top: 12px;
        }
        .security-box {
            background-color: #f8fafc;
            border-left: 4px solid #031b4e;
            border-radius: 0 10px 10px 0;
            padding: 14px 18px;
            font-size: 12px;
            color: #64748b;
            line-height: 1.6;
            margin-top: 24px;
        }
        .footer {
            background-color: #ffffff;
            padding: 22px 20px 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            font-size: 11px;
            color: #94a3b8;
            line-height: 1.5;
        }
        .footer a {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="brand-box">
                <span class="logo-badge">W</span>
                <span class="brand-title">WARRIORS <span style="color: #fbc043;">EDUCARE</span></span>
            </div>
            <span class="brand-subtitle">India's Trusted Education Network</span>
        </div>

        <div class="content">
            <div class="greeting">Hello {{ $name }},</div>
            <p class="text">
                Thank you for registering on <strong>Warriors Educare</strong>. To verify your email address and activate your account, please enter the 6-digit verification passcode below:
            </p>

            <div class="otp-card">
                <div class="otp-title">Your 6-Digit Passcode</div>
                <div class="otp-code">{{ $otp }}</div>
                <div class="expiry-note">⏳ Valid for the next 15 minutes</div>
            </div>

            <p class="text" style="font-size: 13px; margin-bottom: 0;">
                Enter this passcode on the verification screen to authenticate your profile and get started.
            </p>

            <div class="security-box">
                🔒 <strong>Security Advice:</strong> Warriors Educare staff will never ask you for this passcode. Please do not share it with anyone. If you did not initiate this request, you can safely ignore this email.
            </div>
        </div>

        <div class="footer">
            <p style="margin: 0 0 6px 0; font-weight: 600; color: #64748b;">
                📞 Support: +91 82105 45286 &nbsp;|&nbsp; ✉️ <a href="mailto:info@warriorseducare.in">info@warriorseducare.in</a>
            </p>
            <p style="margin: 0;">&copy; {{ date('Y') }} Warriors Educare. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
