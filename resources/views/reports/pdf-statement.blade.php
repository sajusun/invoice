<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Financial Statement - {{ $companyData['name'] ?? 'Invozen' }}</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        body {
            font-size: 11px;
            color: #1e293b;
            margin: 0;
            padding: 24px;
            line-height: 1.4;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .header-left {
            vertical-align: top;
        }
        .header-right {
            text-align: right;
            vertical-align: top;
        }
        .company-name {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .statement-title {
            font-size: 16px;
            font-weight: 800;
            color: #2563eb;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .meta-text {
            font-size: 10px;
            color: #64748b;
        }
        .summary-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .summary-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
        }
        .summary-label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 4px;
        }
        .summary-val {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .data-table th {
            background-color: #f1f5f9;
            color: #475569;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 8px 6px;
            border-bottom: 2px solid #cbd5e1;
            text-align: left;
        }
        .data-table td {
            padding: 7px 6px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10px;
        }
        .text-right {
            text-align: right;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-paid {
            background-color: #dcfce7;
            color: #15803d;
        }
        .badge-unpaid {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .badge-overdue {
            background-color: #fef3c7;
            color: #b45309;
        }
        .footer {
            margin-top: 30px;
            padding-top: 12px;
            border-top: 1px solid #e2e8f0;
            font-size: 9px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td class="header-left">
                <div class="company-name">{{ $companyData['name'] ?? 'Invozen' }}</div>
                <div class="meta-text">{{ $companyData['address'] ?? '' }}</div>
                <div class="meta-text">Email: {{ $companyData['email'] ?? $user->email }} | Phone: {{ $companyData['phone'] ?? 'N/A' }}</div>
                @if(!empty($companyData['tax_id']))
                    <div class="meta-text">Tax Registration / VAT ID: {{ $companyData['tax_id'] }}</div>
                @endif
            </td>
            <td class="header-right">
                <div class="statement-title">Financial Statement</div>
                <div class="meta-text"><strong>Period:</strong> {{ $summary['date_range']['label'] }}</div>
                <div class="meta-text"><strong>Generated on:</strong> {{ date('M d, Y h:i A') }}</div>
                <div class="meta-text"><strong>Currency:</strong> {{ $currency }}</div>
            </td>
        </tr>
    </table>

    <!-- Executive Summary Cards -->
    <table class="summary-grid">
        <tr>
            <td style="width: 20%; padding-right: 6px;">
                <div class="summary-card">
                    <div class="summary-label">Total Invoiced</div>
                    <div class="summary-val">{{ $currency }} {{ number_format($summary['total_billed'], 2) }}</div>
                </div>
            </td>
            <td style="width: 20%; padding: 0 3px;">
                <div class="summary-card">
                    <div class="summary-label">Collected Cash</div>
                    <div class="summary-val" style="color: #16a34a;">{{ $currency }} {{ number_format($summary['total_paid'], 2) }}</div>
                </div>
            </td>
            <td style="width: 20%; padding: 0 3px;">
                <div class="summary-card">
                    <div class="summary-label">Outstanding Due</div>
                    <div class="summary-val" style="color: #ea580c;">{{ $currency }} {{ number_format($summary['total_due'], 2) }}</div>
                </div>
            </td>
            <td style="width: 20%; padding: 0 3px;">
                <div class="summary-card">
                    <div class="summary-label">Tax Collected</div>
                    <div class="summary-val">{{ $currency }} {{ number_format($summary['total_tax'], 2) }}</div>
                </div>
            </td>
            <td style="width: 20%; padding-left: 6px;">
                <div class="summary-card">
                    <div class="summary-label">Collection Rate</div>
                    <div class="summary-val" style="color: #2563eb;">{{ $summary['collection_rate'] }}%</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Invoices Detail Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Client</th>
                <th>Date</th>
                <th>Due Date</th>
                <th>Status</th>
                <th class="text-right">Subtotal</th>
                <th class="text-right">Tax</th>
                <th class="text-right">Total</th>
                <th class="text-right">Paid</th>
                <th class="text-right">Balance Due</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices as $inv)
                @php
                    $due = max(0, (float) $inv->total_amount - (float) $inv->paid_amount);
                @endphp
                <tr>
                    <td style="font-weight: 700; font-family: monospace;">{{ $inv->invoice_number }}</td>
                    <td>{{ $inv->customer?->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($inv->invoice_date)->format('M d, Y') }}</td>
                    <td>{{ $inv->due_date ? \Carbon\Carbon::parse($inv->due_date)->format('M d, Y') : '-' }}</td>
                    <td>
                        <span class="badge {{ $inv->status === 'paid' ? 'badge-paid' : ($inv->status === 'overdue' ? 'badge-overdue' : 'badge-unpaid') }}">
                            {{ ucfirst($inv->status) }}
                        </span>
                    </td>
                    <td class="text-right">{{ number_format($inv->subtotal, 2) }}</td>
                    <td class="text-right">{{ number_format($inv->tax_amount, 2) }}</td>
                    <td class="text-right" style="font-weight: 700;">{{ number_format($inv->total_amount, 2) }}</td>
                    <td class="text-right" style="color: #16a34a;">{{ number_format($inv->paid_amount, 2) }}</td>
                    <td class="text-right" style="font-weight: 700; color: {{ $due > 0 ? '#ea580c' : '#64748b' }};">
                        {{ number_format($due, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="text-align: center; padding: 20px; color: #94a3b8;">
                        No invoice records found for the selected date range.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if($invoices->isNotEmpty())
            <tfoot>
                <tr style="background-color: #f8fafc; font-weight: 800; border-top: 2px solid #cbd5e1;">
                    <td colspan="5">STATEMENT TOTALS ({{ $invoices->count() }} Invoices)</td>
                    <td class="text-right">{{ number_format($summary['subtotal_amount'], 2) }}</td>
                    <td class="text-right">{{ number_format($summary['total_tax'], 2) }}</td>
                    <td class="text-right">{{ number_format($summary['total_billed'], 2) }}</td>
                    <td class="text-right" style="color: #16a34a;">{{ number_format($summary['total_paid'], 2) }}</td>
                    <td class="text-right" style="color: #ea580c;">{{ number_format($summary['total_due'], 2) }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    <div class="footer">
        Generated automatically by {{ config('app.name', 'Invozen') }} Financial Management Suite • Page 1 of 1
    </div>
</body>
</html>
