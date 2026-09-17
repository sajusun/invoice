<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; background: #f3f4f6; color: #111827; }
        .wrapper { max-width: 640px; margin: 32px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); padding: 40px 40px 32px; text-align: center; }
        .header .company-name { font-size: 22px; font-weight: 800; color: #fff; letter-spacing: -0.5px; }
        .header .tagline { font-size: 13px; color: rgba(255,255,255,0.7); margin-top: 4px; }
        .body { padding: 40px; }
        .greeting { font-size: 16px; color: #374151; margin-bottom: 16px; }
        .greeting strong { color: #111827; }
        .intro { font-size: 14px; color: #6b7280; line-height: 1.6; margin-bottom: 28px; }
        .invoice-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px 28px; margin-bottom: 28px; }
        .invoice-box .label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: #94a3b8; margin-bottom: 14px; }
        .invoice-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #e2e8f0; }
        .invoice-row:last-child { border-bottom: none; }
        .invoice-row .key { font-size: 13px; color: #64748b; }
        .invoice-row .val { font-size: 13px; font-weight: 600; color: #111827; }
        .invoice-row .total-val { font-size: 18px; font-weight: 800; color: #1e40af; }
        .status-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .status-paid { background: #dcfce7; color: #15803d; }
        .status-unpaid { background: #fef3c7; color: #b45309; }
        .status-overdue { background: #fee2e2; color: #b91c1c; }
        .status-draft { background: #f1f5f9; color: #475569; }
        .cta { text-align: center; margin: 28px 0; }
        .cta a { display: inline-block; background: linear-gradient(135deg, #1e40af, #3b82f6); color: #ffffff; text-decoration: none; padding: 14px 36px; border-radius: 10px; font-size: 14px; font-weight: 700; letter-spacing: 0.3px; }
        .note { font-size: 13px; color: #6b7280; line-height: 1.6; background: #f0f9ff; border-left: 3px solid #3b82f6; border-radius: 4px; padding: 14px 16px; margin-bottom: 24px; }
        .footer { background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 24px 40px; text-align: center; }
        .footer p { font-size: 12px; color: #9ca3af; line-height: 1.7; }
        .footer a { color: #3b82f6; text-decoration: none; }
        @media (max-width: 600px) {
            .body, .footer, .header { padding-left: 24px; padding-right: 24px; }
            .invoice-row { flex-direction: column; align-items: flex-start; gap: 2px; }
        }
    </style>
</head>
<body>
<div class="wrapper">
    {{-- Header --}}
    <div class="header">
        @if(!empty($companyData['company_logo']))
            <img src="{{ asset('storage/' . $companyData['company_logo']) }}" alt="{{ $senderName }}" style="height:40px;margin-bottom:12px;" />
        @endif
        <div class="company-name">{{ $senderName }}</div>
        <div class="tagline">Invoice Notification</div>
    </div>

    {{-- Body --}}
    <div class="body">
        <p class="greeting">Hi <strong>{{ $invoice->customer->name }}</strong>,</p>
        <p class="intro">
            Please find your invoice below. You can view the full invoice online or download it as a PDF using the button below.
        </p>

        {{-- Invoice Summary Box --}}
        <div class="invoice-box">
            <div class="label">Invoice Summary</div>

            <div class="invoice-row">
                <span class="key">Invoice Number</span>
                <span class="val">#{{ $invoice->invoice_number }}</span>
            </div>

            <div class="invoice-row">
                <span class="key">Invoice Date</span>
                <span class="val">{{ $invoice->invoice_date?->format('d M, Y') }}</span>
            </div>

            @if($invoice->due_date)
            <div class="invoice-row">
                <span class="key">Due Date</span>
                <span class="val">{{ $invoice->due_date->format('d M, Y') }}</span>
            </div>
            @endif

            <div class="invoice-row">
                <span class="key">Currency</span>
                <span class="val">{{ $invoice->currency }}</span>
            </div>

            <div class="invoice-row">
                <span class="key">Status</span>
                <span class="val">
                    @php $s = strtolower($invoice->status); @endphp
                    <span class="status-badge {{ $s === 'paid' ? 'status-paid' : ($s === 'overdue' ? 'status-overdue' : ($s === 'draft' ? 'status-draft' : 'status-unpaid')) }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                </span>
            </div>

            @if((float)$invoice->discount_amount > 0)
            <div class="invoice-row">
                <span class="key">Discount</span>
                <span class="val">-{{ $invoice->currency }} {{ number_format((float)$invoice->discount_amount, 2) }}</span>
            </div>
            @endif

            @if((float)$invoice->tax_amount > 0)
            <div class="invoice-row">
                <span class="key">Tax</span>
                <span class="val">{{ $invoice->currency }} {{ number_format((float)$invoice->tax_amount, 2) }}</span>
            </div>
            @endif

            <div class="invoice-row">
                <span class="key">Total Amount</span>
                <span class="total-val">{{ $invoice->currency }} {{ number_format((float)$invoice->total_amount, 2) }}</span>
            </div>

            @if((float)$invoice->paid_amount > 0 && $invoice->status !== 'paid')
            <div class="invoice-row">
                <span class="key">Amount Paid</span>
                <span class="val">{{ $invoice->currency }} {{ number_format((float)$invoice->paid_amount, 2) }}</span>
            </div>
            <div class="invoice-row">
                <span class="key">Balance Due</span>
                <span class="total-val">{{ $invoice->currency }} {{ number_format(max(0, (float)$invoice->total_amount - (float)$invoice->paid_amount), 2) }}</span>
            </div>
            @endif
        </div>

        {{-- Notes --}}
        @if($invoice->notes)
        <div class="note">
            <strong>Note:</strong> {{ $invoice->notes }}
        </div>
        @endif

        {{-- CTA --}}
        <div class="cta">
            <a href="{{ route('previewInvoice', $invoice->public_hash ?: $invoice->invoice_number) }}">
                View Invoice Online →
            </a>
        </div>

        <p class="intro" style="text-align:center; font-size:12px;">
            A PDF copy of this invoice has been attached to this email.<br />
            Please reach out to us if you have any questions.
        </p>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>
            This email was sent by <strong>{{ $senderName }}</strong>
            @if(!empty($companyData['company_email']))
                · <a href="mailto:{{ $companyData['company_email'] }}">{{ $companyData['company_email'] }}</a>
            @endif
            @if(!empty($companyData['company_phone']))
                · {{ $companyData['company_phone'] }}
            @endif
        </p>
        <p style="margin-top:8px;">
            Powered by <a href="{{ config('app.url') }}">{{ config('app.name', 'Invozen') }}</a>
        </p>
    </div>
</div>
</body>
</html>
