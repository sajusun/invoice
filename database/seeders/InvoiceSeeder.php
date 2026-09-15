<?php

namespace Database\Seeders;

use App\Models\Customers;
use App\Models\Invoices;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customers::all();

        $itemCatalog = [
            ['name' => 'Custom Laravel Web Application Development', 'rate' => 120.00],
            ['name' => 'UI/UX Interactive Dashboard Design', 'rate' => 85.00],
            ['name' => 'RESTful API Integration & Documentation', 'rate' => 95.00],
            ['name' => 'Cloud Infrastructure & Docker Deployment', 'rate' => 110.00],
            ['name' => 'Payment Gateway Integration (Stripe & PayPal)', 'rate' => 75.00],
            ['name' => 'Monthly Retainer & Technical Support', 'rate' => 60.00],
            ['name' => 'Database Performance Tuning & Indexing', 'rate' => 90.00],
            ['name' => 'Mobile Responsive Redesign & Accessibility', 'rate' => 70.00],
            ['name' => 'Automated Backup & Disaster Recovery Setup', 'rate' => 80.00],
            ['name' => 'SEO Optimization & Technical Audit', 'rate' => 65.00],
            ['name' => 'Security Audit & Vulnerability Assessment', 'rate' => 130.00],
            ['name' => 'Email Template Design & SMTP Setup', 'rate' => 50.00],
        ];

        // Determine starting invoice number
        $lastInvoice = Invoices::orderByDesc('id')->first();
        $invoiceCounter = 1001;
        if ($lastInvoice && preg_match('/INV-(\d+)/', $lastInvoice->invoice_number, $matches)) {
            $invoiceCounter = ((int) $matches[1]) + 1;
        }

        foreach ($customers as $customer) {
            // If customer already has seeded invoices, avoid duplicate generation
            if ($customer->invoices()->count() >= 2) {
                continue;
            }

            $numInvoices = rand(2, 4);

            for ($i = 0; $i < $numInvoices; $i++) {
                $itemCount = rand(1, 3);
                $selectedKeys = (array) array_rand($itemCatalog, $itemCount);
                
                $items = [];
                $subTotal = 0;

                foreach ($selectedKeys as $key) {
                    $catalogItem = $itemCatalog[$key];
                    $qty = rand(1, 6);
                    $lineTotal = $qty * $catalogItem['rate'];
                    $subTotal += $lineTotal;

                    $items[] = [
                        'name'  => $catalogItem['name'],
                        'qty'   => $qty,
                        'rate'  => (float) $catalogItem['rate'],
                        'total' => (float) $lineTotal,
                    ];
                }

                $needTax   = rand(0, 1) === 1;
                $taxAmount = $needTax ? round($subTotal * 0.10, 2) : 0.00;
                $total     = round($subTotal + $taxAmount, 2);

                $statusRandom = rand(1, 100);
                if ($statusRandom <= 60) {
                    $status = 'paid';
                    $paidAmount = $total;
                } elseif ($statusRandom <= 80) {
                    $status = 'unpaid';
                    $paidAmount = 0.00;
                } elseif ($statusRandom <= 95) {
                    $status = 'overdue';
                    $paidAmount = 0.00;
                } else {
                    $status = 'canceled';
                    $paidAmount = 0.00;
                }

                $daysAgo = rand(1, 150);
                $invoiceDate = now()->subDays($daysAgo)->format('Y-m-d');
                $invoiceNumber = 'INV-' . $invoiceCounter++;

                Invoices::updateOrCreate(
                    ['invoice_number' => $invoiceNumber],
                    [
                        'user_id'        => $customer->user_id,
                        'customer_id'    => $customer->id,
                        'invoice_date'   => $invoiceDate,
                        'items'          => $items,
                        'notes'          => 'Thank you for your business. Please remit payment according to agreed terms.',
                        'tax_amount'     => $taxAmount,
                        'paid_amount'    => $paidAmount,
                        'total_amount'   => $total,
                        'status'         => $status,
                        'need_tax'       => $needTax,
                        'currency'       => 'USD',
                        'created_at'     => now()->subDays($daysAgo),
                        'updated_at'     => now()->subDays($daysAgo),
                    ]
                );
            }
        }
    }
}
