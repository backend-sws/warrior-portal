<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Reminder - Warriors Educare</title>
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
        .heading {
            font-size: 22px;
            font-weight: 800;
            color: #031b4e;
            margin: 0 0 16px 0;
            letter-spacing: -0.3px;
        }
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 700;
        }
        .alert-warning {
            background-color: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .text {
            font-size: 15px;
            line-height: 1.65;
            color: #475569;
            margin-bottom: 20px;
        }
        .table-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            margin: 24px 0;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table th, .details-table td {
            text-align: left;
            padding: 14px 18px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
        }
        .details-table tr:last-child th,
        .details-table tr:last-child td {
            border-bottom: none;
        }
        .details-table th {
            color: #64748b;
            font-weight: 700;
            width: 40%;
        }
        .details-table td {
            color: #0f172a;
            font-weight: 700;
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
            <h1 class="heading">Payment Notification 🔔</h1>
            
            <p class="text">Dear <strong>{{ $details['name'] }}</strong>,</p>

            <div class="alert {{ $details['is_overdue'] ? 'alert-danger' : 'alert-warning' }}">
                {{ $details['status_text'] }}
            </div>

            <p class="text">
                This is an official notification regarding your payment profile for <strong>{{ $details['assignment'] }}</strong>.
            </p>

            <div class="table-box">
                <table class="details-table">
                    <tr>
                        <th>Assignment:</th>
                        <td>{{ $details['assignment'] }}</td>
                    </tr>
                    <tr>
                        <th>Amount Due:</th>
                        <td style="color: #031b4e; font-size: 16px; font-weight: 800;">₹{{ number_format($details['amount'], 2) }}</td>
                    </tr>
                    <tr>
                        <th>Due Date:</th>
                        <td>{{ \Carbon\Carbon::parse($details['due_date'])->format('d M, Y') }}</td>
                    </tr>
                </table>
            </div>

            <p class="text" style="font-size: 13px; color: #64748b;">
                If you have already processed this transaction, please disregard this reminder. Otherwise, kindly clear the dues via PhonePe Gateway on your dashboard.
            </p>

            <div class="btn-wrapper">
                <a href="{{ route('candidate.dashboard') }}" class="btn">Pay Online via Dashboard &rarr;</a>
            </div>
        </div>

        <div class="footer">
            <p style="margin: 0 0 6px 0; font-weight: 600; color: #64748b;">
                📞 Accounts Desk: +91 82105 45286 &nbsp;|&nbsp; ✉️ <a href="mailto:info@warriorseducare.in">info@warriorseducare.in</a>
            </p>
            <p style="margin: 0;">&copy; {{ date('Y') }} Warriors Educare. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
