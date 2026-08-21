<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }} - Warriors Educare</title>
    <style>
        body {
            font-family: 'DejaVu Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 30px;
            color: #0f172a;
            font-size: 13px;
            background-color: #ffffff;
            position: relative;
        }

        .watermark {
            position: absolute;
            top: 30%;
            left: 25%;
            width: 50%;
            opacity: 0.1;
            z-index: -100;
        }

        .header-table {
            width: 100%;
            margin-bottom: 25px;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 15px;
        }

        .logo-img {
            max-height: 55px;
            width: auto;
        }

        .header-title {
            text-align: right;
        }

        .header-title h1 {
            margin: 0;
            color: #1e3a8a;
            font-size: 22px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header-title p {
            margin: 4px 0 0 0;
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            font-size: 11px;
            font-weight: bold;
            border-radius: 12px;
            text-transform: uppercase;
            margin-top: 6px;
        }

        .badge-paid {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .badge-unpaid {
            background-color: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .details-table {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }

        .details-table td {
            vertical-align: top;
            width: 50%;
        }

        .card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 15px;
        }

        h3 {
            color: #1e3a8a;
            font-size: 13px;
            margin: 0 0 10px 0;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        p {
            margin: 4px 0;
            line-height: 1.4;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 25px;
        }

        .invoice-table th, .invoice-table td {
            border: 1px solid #e2e8f0;
            padding: 12px;
            text-align: left;
        }

        .invoice-table th {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }

        .amount-col {
            text-align: right !important;
        }

        .total-row td {
            font-weight: bold;
            background-color: #f1f5f9;
            font-size: 14px;
        }

        .footer {
            margin-top: 35px;
            text-align: center;
            font-size: 11px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }

        .no-print {
            margin-bottom: 20px;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    @if(!empty($isPrint))
    <div class="no-print" style="text-align: right;">
        <button onclick="window.print()" style="background-color: #1e3a8a; color: white; border: none; padding: 10px 20px; font-weight: bold; border-radius: 8px; cursor: pointer;">
            🖨️ Print Invoice
        </button>
        <a href="{{ route('parent.serviceCharge.index') }}" style="margin-left: 10px; color: #64748b; text-decoration: none; font-weight: bold;">
            ← Back
        </a>
    </div>
    @endif

    @php
        $logoPath = public_path('WhatsApp Image 2026-08-05 at 12.56.09 PM.jpeg');
        $logoBase64 = file_exists($logoPath) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath)) : null;
    @endphp

    @if($logoBase64)
        <img src="{{ $logoBase64 }}" class="watermark" alt="Watermark">
    @endif

    <!-- Invoice Header -->
    <table class="header-table">
        <tr>
            <td style="vertical-align: middle;">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" class="logo-img" alt="Warriors Educare Logo">
                @else
                    <h2 style="color: #1e3a8a; margin:0;">Warriors Educare</h2>
                @endif
                <p style="margin-top: 5px; color: #64748b; font-size: 11px;">Empowering Educational Leadership</p>
            </td>
            <td class="header-title">
                <h1>Service Charge Invoice</h1>
                <p>Invoice #{{ $invoice->invoice_number }}</p>
                <span class="badge {{ $invoice->status === 'Paid' ? 'badge-paid' : 'badge-unpaid' }}">
                    {{ ucfirst($invoice->status) }}
                </span>
            </td>
        </tr>
    </table>

    <!-- Customer & Summary Cards -->
    <table class="details-table">
        <tr>
            <td style="padding-right: 10px;">
                <div class="card">
                    <h3>Billed To (Parent):</h3>
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Mobile:</strong> {{ $user->phone ?? ($invoice->lead->parent_mobile ?? 'N/A') }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                </div>
            </td>
            <td style="padding-left: 10px;">
                <div class="card">
                    <h3>Invoice Summary:</h3>
                    <p><strong>Issued Date:</strong> {{ $invoice->created_at ? $invoice->created_at->format('d M, Y') : 'N/A' }}</p>
                    <p><strong>Due Date:</strong> {{ $invoice->due_date ? $invoice->due_date->format('d M, Y') : 'N/A' }}</p>
                    <p><strong>Payment Status:</strong> {{ $invoice->status }}</p>
                    @if($invoice->status === 'Paid' && $invoice->updated_at)
                        <p><strong>Paid Date:</strong> {{ $invoice->updated_at->format('d M, Y, h:i A') }}</p>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <!-- Invoice Items Table -->
    <table class="invoice-table">
        <thead>
            <tr>
                <th>Description / Lead Info</th>
                <th>Details</th>
                <th class="amount-col">Amount ($ USD)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>{{ $invoice->title }}</strong><br>
                    <small style="color: #64748b;">
                        Service charge for parent home tuition booking and tutor matching services.
                    </small>
                </td>
                <td>
                    @if($invoice->lead)
                        Class: {{ $invoice->lead->class }}<br>
                        Subjects: {{ $invoice->lead->subjects }}<br>
                        Location: {{ $invoice->lead->location ?? 'N/A' }}
                    @else
                        General Home Tuition Service Charge
                    @endif
                </td>
                <td class="amount-col">${{ number_format($invoice->amount, 2) }} USD</td>
            </tr>
            <tr class="total-row">
                <td colspan="2" style="text-align: right;">Total Amount {{ $invoice->status === 'Paid' ? 'Paid' : 'Due' }}</td>
                <td class="amount-col" style="color: #1e3a8a;">${{ number_format($invoice->amount, 2) }} USD</td>
            </tr>
        </tbody>
    </table>

    @if($invoice->status === 'Paid')
    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 12px; margin-bottom: 20px; font-size: 12px;">
        <strong style="color: #15803d;">Payment Confirmation:</strong> This invoice has been marked as fully PAID online.
        @if($transaction)
            <span style="color: #374151;">(Txn ID: <code>{{ $transaction->transaction_id }}</code>)</span>
        @endif
    </div>
    @endif

    <div class="footer">
        <p><strong>Warriors Educare Portal</strong> — Premium Educational Services</p>
        <p>This is a computer-generated invoice document. No physical signature required.</p>
    </div>

    @if(!empty($isPrint))
    <script>
        window.onload = function() {
            setTimeout(function() { window.print(); }, 500);
        }
    </script>
    @endif

</body>
</html>
