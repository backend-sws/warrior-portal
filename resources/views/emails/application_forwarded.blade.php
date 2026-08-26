<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Shortlisted - Warriors Educare</title>
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
            max-width: 580px;
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
        .congrats-badge {
            display: inline-block;
            background-color: #ecfdf5;
            color: #065f46;
            font-size: 12px;
            font-weight: 800;
            padding: 4px 12px;
            border-radius: 20px;
            border: 1px solid #a7f3d0;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .heading {
            font-size: 22px;
            font-weight: 800;
            color: #031b4e;
            margin: 0 0 16px 0;
            letter-spacing: -0.3px;
        }
        .text {
            font-size: 15px;
            line-height: 1.65;
            color: #475569;
            margin-bottom: 20px;
        }
        .job-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #10b981;
            border-radius: 0 12px 12px 0;
            padding: 18px 20px;
            margin: 24px 0;
        }
        .job-title {
            font-size: 16px;
            font-weight: 800;
            color: #031b4e;
            margin-bottom: 4px;
        }
        .school-name {
            font-size: 14px;
            font-weight: 600;
            color: #64748b;
        }
        .remarks-box {
            background-color: #f0fdf4;
            border: 1px dashed #34d399;
            border-radius: 10px;
            padding: 14px 18px;
            margin: 20px 0;
            font-size: 13px;
            color: #065f46;
        }
        .btn-wrapper {
            text-align: center;
            margin: 32px 0 24px;
        }
        .btn {
            display: inline-block;
            background-color: #031b4e;
            color: #ffffff !important;
            padding: 14px 32px;
            font-size: 15px;
            font-weight: 800;
            text-decoration: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(3,27,78,0.18);
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
            <span class="congrats-badge">🎉 Shortlisted Profile</span>
            <h1 class="heading">Congratulations, {{ $application->candidate->name }}!</h1>
            
            <p class="text">
                We have great news regarding your job application. Your profile has been reviewed and successfully shortlisted!
            </p>

            <div class="job-card">
                <div class="job-title">{{ $application->jobPost->title }}</div>
                <div class="school-name">🏛️ {{ $application->jobPost->employer->name ?? 'Partner Educational Institution' }}</div>
            </div>

            <p class="text">
                Your verified credentials have been directly forwarded to the school administration. The institution will contact you shortly to schedule an interview or demo session. Please keep an eye on your email and phone.
            </p>

            @if($application->remarks)
            <div class="remarks-box">
                <strong>📝 Admin Remarks:</strong><br>
                {{ $application->remarks }}
            </div>
            @endif

            <div class="btn-wrapper">
                <a href="{{ route('login') }}" class="btn">View Application Status &rarr;</a>
            </div>

            <p class="text" style="font-size: 13px; color: #64748b; margin-bottom: 0;">
                Best of luck with your upcoming recruitment rounds!
            </p>
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
