<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .watermark {
            position: absolute;
            top: 30%;
            left: 20%;
            opacity: 0.1;
            z-index: -1;
            width: 400px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #031b4e;
            padding-bottom: 20px;
        }
        .header img.logo {
            width: 150px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #031b4e;
            font-size: 28px;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 14px;
        }
        .details-box {
            width: 100%;
            margin-bottom: 30px;
        }
        .details-box td {
            vertical-align: top;
            width: 50%;
        }
        h3 {
            color: #031b4e;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        p {
            margin: 4px 0;
            line-height: 1.5;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .invoice-table th, .invoice-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .invoice-table th {
            background-color: #f8f9fa;
            color: #031b4e;
        }
        .invoice-table .amount-col {
            text-align: right;
        }
        .total-row td {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <?php
        $logoPath = public_path('adobe.png');
        $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : null;
    ?>

    <?php if($logoBase64): ?>
        <!-- Watermark -->
        <img src="<?php echo e($logoBase64); ?>" alt="Watermark" class="watermark">
    <?php endif; ?>

    <div class="header">
        <?php if($logoBase64): ?>
            <img src="<?php echo e($logoBase64); ?>" alt="Warriors Educare Logo" class="logo">
        <?php else: ?>
            <h2>Warriors Educare</h2>
        <?php endif; ?>
        <h1>PAYMENT INVOICE</h1>
        <p>Warriors Educare</p>
    </div>

    <table class="details-box">
        <tr>
            <td>
                <h3>Invoice To:</h3>
                <p><strong>Name:</strong> <?php echo e($user->name); ?></p>
                <p><strong>Email:</strong> <?php echo e($user->email); ?></p>
                <p><strong>Phone:</strong> <?php echo e($user->phone ?? 'N/A'); ?></p>
            </td>
            <td>
                <h3>Payment Details:</h3>
                <p><strong>Transaction ID:</strong> <?php echo e($transaction->transaction_id); ?></p>
                <p><strong>Date:</strong> <?php echo e(\Carbon\Carbon::parse($transaction->created_at)->format('d F Y, h:i A')); ?></p>
                <p><strong>Status:</strong> Successful</p>
            </td>
        </tr>
    </table>

    <table class="invoice-table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Payment Type</th>
                <th class="amount-col">Amount (INR)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Warriors Educare Platform Subscription / Service Fee</td>
                <td><?php echo e(ucwords(str_replace('_', ' ', $transaction->type ?? 'Registration Fee'))); ?></td>
                <td class="amount-col">Rs. <?php echo e(number_format($transaction->amount, 2)); ?></td>
            </tr>
            <tr class="total-row">
                <td colspan="2" style="text-align: right;">Total Amount Paid</td>
                <td class="amount-col">Rs. <?php echo e(number_format($transaction->amount, 2)); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Thank you for using Warriors Educare Educational Services.</p>
        <p>This is a computer-generated document and does not require a physical signature.</p>
    </div>

</body>
</html>



<?php /**PATH D:\warrior-portal\resources\views/candidate/payment/invoice.blade.php ENDPATH**/ ?>