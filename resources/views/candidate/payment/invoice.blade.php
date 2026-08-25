<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt - {{ $transaction->transaction_id ?? $transaction->id }}</title>
    <style>
        @page {
            margin: 20px 25px;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 10px;
            color: #1e293b;
            font-size: 12px;
            line-height: 1.4;
        }
        .watermark {
            position: absolute;
            top: 25%;
            left: 20%;
            opacity: 0.06;
            z-index: -100;
            width: 380px;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #031b4e;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo-box {
            text-align: left;
        }
        .logo-box img {
            width: 120px;
            max-height: 70px;
        }
        .header-title {
            text-align: right;
        }
        .header-title h1 {
            margin: 0;
            color: #031b4e;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .header-title p {
            margin: 2px 0 0 0;
            color: #64748b;
            font-size: 11px;
        }
        .badge-paid {
            display: inline-block;
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
            font-size: 10px;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 6px;
            text-transform: uppercase;
            margin-top: 4px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .meta-table td {
            vertical-align: top;
            width: 50%;
        }
        .card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 15px;
        }
        .card-title {
            font-size: 11px;
            font-weight: bold;
            color: #031b4e;
            text-transform: uppercase;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 4px;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        .meta-row {
            margin-bottom: 4px;
            font-size: 11px;
        }
        .meta-label {
            color: #64748b;
            font-weight: 500;
        }
        .meta-val {
            color: #0f172a;
            font-weight: bold;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 20px;
        }
        .invoice-table th, .invoice-table td {
            border: 1px solid #e2e8f0;
            padding: 10px 12px;
            text-align: left;
        }
        .invoice-table th {
            background-color: #031b4e;
            color: #ffffff;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .item-title {
            font-weight: bold;
            color: #0f172a;
            font-size: 12px;
            margin: 0;
        }
        .item-desc {
            font-size: 10.5px;
            color: #475569;
            margin: 4px 0 0 0;
            line-height: 1.4;
        }
        .item-badge {
            display: inline-block;
            background-color: #ede9fe;
            color: #6d28d9;
            border: 1px solid #ddd6fe;
            padding: 2px 6px;
            font-size: 9.5px;
            font-weight: bold;
            border-radius: 4px;
            margin-top: 3px;
        }
        .amount-col {
            text-align: right;
            white-space: nowrap;
        }
        .total-row td {
            font-weight: bold;
            background-color: #f1f5f9;
            font-size: 12px;
        }
        .total-amount {
            color: #047857;
            font-size: 13px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
            line-height: 1.5;
        }
    </style>
</head>
<body>

    @php
        $logoPath = public_path('adobe.png');
        $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : null;

        // Determine specific service details
        $lead = $transaction->tuitionLead ?? $transaction->invoice?->tuitionLead;
        $jobApp = $transaction->invoice?->jobApplication;
        $job = $jobApp?->jobPost;

        $serviceTitle = 'Service Charge Payment';
        $serviceCategory = 'Consultancy';
        $itemDescription = 'Warriors Educare Education & Placement Services';
        $refBadge = null;

        if ($lead) {
            $tuitionId = $lead->tuition_id ?: ('TUI-' . str_pad($lead->id, 4, '0', STR_PAD_LEFT));
            $serviceTitle = 'Home Tuition Placement Service Charge';
            $serviceCategory = 'Home Tuition';
            $refBadge = 'Tuition ID: ' . $tuitionId;
            $itemDescription = 'Tuition Requirement for Class ' . ($lead->class ?? 'N/A') . ' (' . ($lead->subjects ?? 'All Subjects') . ')';
            if ($lead->location || $lead->city) {
                $itemDescription .= ' | Area: ' . trim(($lead->location ? $lead->location . ', ' : '') . ($lead->city ?? ''));
            }
        } elseif ($job) {
            $jobId = $job->job_id ?: ('JOB-' . str_pad($job->id, 4, '0', STR_PAD_LEFT));
            $serviceTitle = 'Teacher Job Placement Service Charge';
            $serviceCategory = 'School Placement';
            $refBadge = 'Job ID: ' . $jobId;
            $itemDescription = 'Teaching Position: ' . $job->title . ' (' . ($job->subject?->name ?? 'General Teaching') . ')';
            if ($job->city || $job->state) {
                $itemDescription .= ' | Location: ' . trim(($job->city ? $job->city . ', ' : '') . ($job->state ?? ''));
            }
        } elseif ($transaction->type === 'registration_fee') {
            $plan = ucfirst($user->profile?->plan_type ?? 'Standard');
            $serviceTitle = 'Teacher Portal Registration & Profile Verification';
            $serviceCategory = 'Platform Membership';
            $refBadge = 'Plan: ' . $plan;
            $itemDescription = 'Teacher Profile Verification, Digital Agreement & Application Access (' . $plan . ' Plan)';
        } else {
            $serviceTitle = $transaction->invoice?->title ?? 'Teacher Consultancy & Placement Charge';
            $serviceCategory = 'Service Charge';
            if ($transaction->invoice_id) {
                $refBadge = 'Invoice #' . ($transaction->invoice?->invoice_number ?: $transaction->invoice_id);
            }
            $itemDescription = $transaction->invoice?->description ?? 'Service charge settlement for educational placement coordination.';
        }
    @endphp

    @if($logoBase64)
        <!-- Background Watermark -->
        <img src="{{ $logoBase64 }}" alt="Watermark" class="watermark">
    @endif

    <!-- Header Table -->
    <table class="header-table">
        <tr>
            <td class="logo-box">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Warriors Educare">
                @else
                    <h2 style="margin: 0; color: #031b4e;">WARRIORS EDUCARE</h2>
                @endif
                <p style="margin: 3px 0 0 0; color: #475569; font-size: 10px;">Educational Placement & Home Tuition Consultancy</p>
            </td>
            <td class="header-title">
                <h1>OFFICIAL PAYMENT RECEIPT</h1>
                <p>Receipt Ref: <strong>#{{ $transaction->transaction_id ?? $transaction->id }}</strong></p>
                <div class="badge-paid">✓ Payment Successful</div>
            </td>
        </tr>
    </table>

    <!-- Billing & Transaction Details Cards -->
    <table class="meta-table">
        <tr>
            <td style="padding-right: 10px;">
                <div class="card">
                    <div class="card-title">Candidate Information (Billed To)</div>
                    <div class="meta-row"><span class="meta-label">Full Name:</span> <span class="meta-val">{{ $user->name }}</span></div>
                    <div class="meta-row"><span class="meta-label">Email:</span> <span class="meta-val">{{ $user->email }}</span></div>
                    <div class="meta-row"><span class="meta-label">Phone:</span> <span class="meta-val">{{ $user->phone ?? 'N/A' }}</span></div>
                    @if($user->profile?->candidate_id)
                        <div class="meta-row"><span class="meta-label">Candidate ID:</span> <span class="meta-val">{{ $user->profile->candidate_id }}</span></div>
                    @endif
                </div>
            </td>
            <td style="padding-left: 10px;">
                <div class="card">
                    <div class="card-title">Transaction Details</div>
                    <div class="meta-row"><span class="meta-label">Transaction ID:</span> <span class="meta-val">{{ $transaction->transaction_id ?? ('TXN_' . $transaction->id) }}</span></div>
                    @if($transaction->payment_id)
                        <div class="meta-row"><span class="meta-label">Gateway Pay ID:</span> <span class="meta-val">{{ $transaction->payment_id }}</span></div>
                    @endif
                    <div class="meta-row"><span class="meta-label">Payment Date:</span> <span class="meta-val">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y, h:i A') }}</span></div>
                    <div class="meta-row"><span class="meta-label">Payment Gateway:</span> <span class="meta-val">{{ ucfirst($transaction->gateway ?: 'PhonePe') }} ({{ strtoupper($transaction->payment_method ?: 'ONLINE') }})</span></div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Itemized Breakdown Table -->
    <table class="invoice-table">
        <thead>
            <tr>
                <th style="width: 55%;">Item & Service Description</th>
                <th style="width: 25%;">Category / Reference</th>
                <th style="width: 20%;" class="amount-col">Amount (INR)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <p class="item-title">{{ $serviceTitle }}</p>
                    <p class="item-desc">{{ $itemDescription }}</p>
                </td>
                <td>
                    <span style="font-weight: bold; color: #0f172a;">{{ $serviceCategory }}</span>
                    @if($refBadge)
                        <br><span class="item-badge">{{ $refBadge }}</span>
                    @endif
                </td>
                <td class="amount-col">
                    <strong>₹{{ number_format($transaction->amount, 2) }}</strong>
                </td>
            </tr>
            <tr class="total-row">
                <td colspan="2" style="text-align: right; text-transform: uppercase;">
                    Total Paid Amount
                </td>
                <td class="amount-col total-amount">
                    ₹{{ number_format($transaction->amount, 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Footer Note -->
    <div class="footer">
        <p><strong>Warriors Educare</strong> — Official Payment Acknowledgement Receipt.</p>
        <p>This is an automated computer-generated electronic receipt. No physical signature is required.</p>
    </div>

</body>
</html>
