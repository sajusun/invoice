<?php

namespace Database\Factories;

use App\Models\Invoices;
use App\Models\Customers;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoicesFactory extends Factory
{
    protected $model = Invoices::class;

    protected static int $sequenceNumber = 1001;

    public function definition(): array
    {
        $itemCatalog = [
            ['name' => 'Custom Web Application Development', 'rate' => 120.00],
            ['name' => 'UI/UX Interface & Dashboard Design', 'rate' => 85.00],
            ['name' => 'REST API Architecture & Implementation', 'rate' => 95.00],
            ['name' => 'Cloud Infrastructure & AWS Deployment', 'rate' => 110.00],
            ['name' => 'Payment Gateway Integration (Stripe/SSL)', 'rate' => 75.00],
            ['name' => 'Monthly System Maintenance & Bug Fixes', 'rate' => 60.00],
            ['name' => 'Performance Audit & Database Optimization', 'rate' => 90.00],
            ['name' => 'Mobile Responsive Redesign', 'rate' => 70.00],
            ['name' => 'Automated Backup & Disaster Recovery Setup', 'rate' => 80.00],
            ['name' => 'SEO Optimization & Technical Audit', 'rate' => 65.00],
        ];

        // Pick 1 to 4 random items
        $selectedItems = $this->faker->randomElements($itemCatalog, rand(1, 4));
        $items = [];
        $subTotal = 0;

        foreach ($selectedItems as $item) {
            $qty = rand(1, 8);
            $lineTotal = $qty * $item['rate'];
            $subTotal += $lineTotal;

            $items[] = [
                'name'  => $item['name'],
                'qty'   => $qty,
                'rate'  => (float) $item['rate'],
                'total' => (float) $lineTotal,
            ];
        }

        $needTax = $this->faker->boolean(70);
        $taxRate = $needTax ? 0.10 : 0.00; // 10% VAT
        $taxAmount = round($subTotal * $taxRate, 2);
        $totalAmount = round($subTotal + $taxAmount, 2);

        $status = $this->faker->randomElement(['paid', 'paid', 'paid', 'unpaid', 'overdue', 'canceled']);
        
        $paidAmount = match ($status) {
            'paid'     => $totalAmount,
            'unpaid'   => 0.00,
            'overdue'  => 0.00,
            'canceled' => 0.00,
            default    => $totalAmount,
        };

        $invoiceDate = $this->faker->dateTimeBetween('-5 months', 'now');

        return [
            'invoice_number' => 'INV-' . (self::$sequenceNumber++),
            'customer_id'    => Customers::first()?->id ?? 1,
            'user_id'        => User::first()?->id ?? 1,
            'invoice_date'   => $invoiceDate->format('Y-m-d'),
            'items'          => $items,
            'notes'          => $this->faker->optional(0.7)->sentence(8),
            'tax_amount'     => $taxAmount,
            'paid_amount'    => $paidAmount,
            'total_amount'   => $totalAmount,
            'status'         => $status,
            'need_tax'       => $needTax,
            'currency'       => 'USD',
            'created_at'     => $invoiceDate,
            'updated_at'     => $invoiceDate,
        ];
    }
}
