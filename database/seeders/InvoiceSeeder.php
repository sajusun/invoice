<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::with('user')->get();

        $itemCatalog = [
            ['name' => 'Custom Laravel 12 Web Application Development', 'rate' => 120.00],
            ['name' => 'UI/UX Interactive Dashboard Design', 'rate' => 85.00],
            ['name' => 'RESTful API Microservice Integration & Webhooks', 'rate' => 95.00],
            ['name' => 'Cloud Infrastructure, Docker & Redis Deployment', 'rate' => 110.00],
            ['name' => 'Payment Gateway Integration (Stripe & PayPal)', 'rate' => 75.00],
            ['name' => 'Monthly Retainer & Technical Architecture Support', 'rate' => 60.00],
            ['name' => 'Database Performance Tuning & Cursor Indexing', 'rate' => 90.00],
            ['name' => 'Mobile Responsive Redesign & Accessibility', 'rate' => 70.00],
            ['name' => 'Automated Backup & Disaster Recovery Setup', 'rate' => 80.00],
            ['name' => 'Security Audit & Vulnerability Assessment', 'rate' => 130.00],
            ['name' => 'Custom PDF Invoice Template & SMTP Delivery', 'rate' => 50.00],
        ];

        $invoiceCounter = 1001;

        foreach ($customers as $customer) {
            $numInvoices = rand(2, 4);

            for ($i = 0; $i < $numInvoices; $i++) {
                $itemCount = rand(1, 3);
                $selectedKeys = (array) array_rand($itemCatalog, $itemCount);
                
                $items = [];
                $subTotal = 0;

                foreach ($selectedKeys as $key) {
                    $catalogItem = $itemCatalog[$key];
                    $qty = rand(1, 5);
                    $lineTotal = round($qty * $catalogItem['rate'], 2);
                    $subTotal += $lineTotal;

                    $items[] = [
                        'name'        => $catalogItem['name'],
                        'description' => $catalogItem['name'] . ' - Professional delivery',
                        'qty'         => $qty,
                        'rate'        => (float) $catalogItem['rate'],
                        'total'       => (float) $lineTotal,
                    ];
                }

                $needTax   = rand(0, 1) === 1;
                $taxAmount = $needTax ? round($subTotal * 0.10, 2) : 0.00;
                $discountAmount = rand(0, 5) === 0 ? 50.00 : 0.00;
                $total     = round($subTotal + $taxAmount - $discountAmount, 2);

                $statusRandom = rand(1, 100);
                if ($statusRandom <= 50) {
                    $status = 'paid';
                    $paidAmount = $total;
                } elseif ($statusRandom <= 75) {
                    $status = 'unpaid';
                    $paidAmount = 0.00;
                } elseif ($statusRandom <= 90) {
                    $status = 'overdue';
                    $paidAmount = 0.00;
                } elseif ($statusRandom <= 95) {
                    $status = 'partially_paid';
                    $paidAmount = round($total * 0.5, 2);
                } else {
                    $status = 'canceled';
                    $paidAmount = 0.00;
                }

                $daysAgo = rand(1, 120);
                $invoiceDate = now()->subDays($daysAgo);
                $dueDate = $invoiceDate->copy()->addDays(30);

                $isRecurring = rand(1, 5) === 1;
                $frequencies = ['weekly', 'monthly', 'quarterly', 'yearly'];
                $frequency = $isRecurring ? $frequencies[array_rand($frequencies)] : null;

                $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad((string) $invoiceCounter++, 5, '0', STR_PAD_LEFT);

                Invoice::updateOrCreate(
                    ['invoice_number' => $invoiceNumber],
                    [
                        'uuid'                => (string) Str::uuid(),
                        'public_hash'         => bin2hex(random_bytes(32)),
                        'user_id'             => $customer->user_id,
                        'customer_id'         => $customer->id,
                        'invoice_date'        => $invoiceDate->format('Y-m-d'),
                        'due_date'            => $dueDate->format('Y-m-d'),
                        'items'               => $items,
                        'subtotal'            => $subTotal,
                        'tax_amount'          => $taxAmount,
                        'discount_amount'     => $discountAmount,
                        'discount_type'       => 'fixed',
                        'total_amount'        => $total,
                        'paid_amount'         => $paidAmount,
                        'status'              => $status,
                        'need_tax'            => $needTax,
                        'currency'            => 'USD',
                        'notes'               => 'Thank you for your business. Please remit payment within 30 days.',
                        'terms'               => 'Payment due net 30 days. Late balances subject to 1.5% monthly interest.',
                        'is_recurring'        => $isRecurring,
                        'recurring_frequency' => $frequency,
                        'recurring_end_date'  => $isRecurring ? now()->addMonths(6)->format('Y-m-d') : null,
                        'last_recurring_at'   => $isRecurring ? now()->subDays(5)->format('Y-m-d') : null,
                        'metadata'            => [
                            'order_id'       => 'ORD-' . rand(10000, 99999),
                            'payment_method' => 'stripe_cc',
                            'project_code'   => 'PRJ-' . rand(100, 999),
                        ],
                        'created_at'          => $invoiceDate,
                        'updated_at'          => $invoiceDate,
                    ]
                );
            }
        }
    }
}
