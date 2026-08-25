<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f0f2f5; color: #1a1a2e; margin: 0; padding: 20px; }
        .container { background-color: #ffffff; border-radius: 12px; padding: 0; max-width: 640px; margin: 0 auto; box-shadow: 0 4px 24px rgba(0,0,0,0.08); overflow: hidden; }
        .header { background: linear-gradient(135deg, #031b4e 0%, #0a3d91 100%); padding: 28px 32px; }
        .header h1 { color: #ffffff; font-size: 22px; margin: 0 0 6px 0; }
        .header p { color: rgba(255,255,255,0.7); font-size: 13px; margin: 0; }
        .body { padding: 28px 32px; }
        .metric-grid { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 24px; }
        .metric-card { flex: 1; min-width: 120px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 16px; text-align: center; }
        .metric-card .number { font-size: 28px; font-weight: 800; line-height: 1; }
        .metric-card .label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-top: 4px; }
        .metric-due .number { color: #f59e0b; }
        .metric-overdue .number { color: #ef4444; }
        .metric-followup .number { color: #6366f1; }
        .metric-amount .number { color: #10b981; font-size: 22px; }
        .section { margin-bottom: 20px; }
        .section h3 { font-size: 14px; font-weight: 700; color: #031b4e; margin: 0 0 10px 0; padding-bottom: 6px; border-bottom: 2px solid #e2e8f0; }
        .account-table { width: 100%; border-collapse: collapse; font-size: 12px; }
        .account-table th { text-align: left; padding: 8px 10px; background: #f1f5f9; color: #64748b; font-weight: 700; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0; }
        .account-table td { padding: 8px 10px; border-bottom: 1px solid #f1f5f9; color: #1e293b; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 6px; font-size: 10px; font-weight: 700; }
        .badge-overdue { background: #fef2f2; color: #ef4444; border: 1px solid #fecaca; }
        .badge-due { background: #fffbeb; color: #f59e0b; border: 1px solid #fde68a; }
        .badge-followup { background: #eef2ff; color: #6366f1; border: 1px solid #c7d2fe; }
        .cta { display: inline-block; background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); color: #ffffff; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 14px; margin-top: 16px; }
        .footer { padding: 20px 32px; background: #f8fafc; border-top: 1px solid #e2e8f0; text-align: center; font-size: 11px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Daily Payment Collection Summary</h1>
            <p>{{ \Carbon\Carbon::today()->format('l, d F Y') }} — Warriors Educare Admin</p>
        </div>

        <div class="body">
            {{-- Quick Metrics --}}
            <div class="metric-grid">
                <div class="metric-card metric-due">
                    <div class="number">{{ $summary['due_today_count'] ?? 0 }}</div>
                    <div class="label">Due Today</div>
                </div>
                <div class="metric-card metric-overdue">
                    <div class="number">{{ $summary['overdue_count'] ?? 0 }}</div>
                    <div class="label">Overdue</div>
                </div>
                <div class="metric-card metric-followup">
                    <div class="number">{{ $summary['follow_up_today_count'] ?? 0 }}</div>
                    <div class="label">Follow-Ups</div>
                </div>
                <div class="metric-card metric-amount">
                    <div class="number">₹{{ number_format($summary['today_collection_target'] ?? 0) }}</div>
                    <div class="label">Today's Target</div>
                </div>
            </div>

            {{-- Monthly Snapshot --}}
            <div class="metric-grid">
                <div class="metric-card">
                    <div class="number" style="color: #031b4e; font-size: 20px;">{{ $summary['total_active'] ?? 0 }}</div>
                    <div class="label">Active Tuitions</div>
                </div>
                <div class="metric-card">
                    <div class="number" style="color: #10b981; font-size: 18px;">₹{{ number_format($summary['collected_this_month'] ?? 0) }}</div>
                    <div class="label">Collected This Month</div>
                </div>
                <div class="metric-card">
                    <div class="number" style="color: #ef4444; font-size: 18px;">₹{{ number_format($summary['pending_amount'] ?? 0) }}</div>
                    <div class="label">Pending Amount</div>
                </div>
            </div>

            {{-- Payments Due Today --}}
            @if(!empty($summary['due_today_accounts']) && count($summary['due_today_accounts']) > 0)
            <div class="section">
                <h3>⏰ Payments Due Today ({{ count($summary['due_today_accounts']) }})</h3>
                <table class="account-table">
                    <tr><th>Student</th><th>Parent</th><th>Mobile</th><th>Amount</th><th>Status</th></tr>
                    @foreach($summary['due_today_accounts'] as $account)
                    <tr>
                        <td><strong>{{ $account->student_name }}</strong><br><span style="color:#94a3b8; font-size:10px;">{{ $account->class ?? '' }} • {{ $account->subject ?? '' }}</span></td>
                        <td>{{ $account->parent_name }}</td>
                        <td>{{ $account->mobile_number }}</td>
                        <td><strong>₹{{ number_format($account->monthly_fee) }}</strong></td>
                        <td><span class="badge badge-due">DUE TODAY</span></td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif

            {{-- Overdue Payments --}}
            @if(!empty($summary['overdue_accounts']) && count($summary['overdue_accounts']) > 0)
            <div class="section">
                <h3>🔴 Overdue Payments ({{ count($summary['overdue_accounts']) }})</h3>
                <table class="account-table">
                    <tr><th>Student</th><th>Parent</th><th>Mobile</th><th>Amount</th><th>Days Overdue</th></tr>
                    @foreach($summary['overdue_accounts'] as $account)
                    <tr>
                        <td><strong>{{ $account->student_name }}</strong></td>
                        <td>{{ $account->parent_name }}</td>
                        <td>{{ $account->mobile_number }}</td>
                        <td><strong>₹{{ number_format($account->monthly_fee) }}</strong></td>
                        <td><span class="badge badge-overdue">{{ $account->days_overdue }} days</span></td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif

            {{-- Follow-up Due Today --}}
            @if(!empty($summary['follow_up_accounts']) && count($summary['follow_up_accounts']) > 0)
            <div class="section">
                <h3>📞 Follow-Up Collections Today ({{ count($summary['follow_up_accounts']) }})</h3>
                <table class="account-table">
                    <tr><th>Student</th><th>Parent</th><th>Mobile</th><th>Amount</th><th>Notes</th></tr>
                    @foreach($summary['follow_up_accounts'] as $account)
                    <tr>
                        <td><strong>{{ $account->student_name }}</strong></td>
                        <td>{{ $account->parent_name }}</td>
                        <td>{{ $account->mobile_number }}</td>
                        <td><strong>₹{{ number_format($account->monthly_fee) }}</strong></td>
                        <td style="font-size:11px; color:#6366f1; font-style:italic;">{{ Str::limit($account->follow_up_notes, 40) }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif

            <div style="text-align: center; margin-top: 24px;">
                <a href="{{ url('/admin/tuition-fees') }}" class="cta">Open Collection Dashboard →</a>
            </div>
        </div>

        <div class="footer">
            <p>This is an automated daily summary from Warriors Educare Admin Panel.</p>
            <p>Sardar Patel Colony, Sandalpur Rd, Kumhrar, Patna, Bihar</p>
        </div>
    </div>
</body>
</html>
