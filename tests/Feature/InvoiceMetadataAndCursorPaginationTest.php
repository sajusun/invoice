<?php

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Pagination\CursorPaginator;

test('invoice and customer support arbitrary json metadata', function () {
    $user = User::factory()->create();

    $customer = Customer::create([
        'user_id' => $user->id,
        'name' => 'Tech Corp',
        'phone' => '+15550001',
        'metadata' => [
            'erp_id' => 'ERP-9988',
            'department' => 'Billing & Operations',
        ],
    ]);

    $invoice = Invoice::create([
        'user_id' => $user->id,
        'customer_id' => $customer->id,
        'invoice_number' => 'INV-TEST-001',
        'invoice_date' => now(),
        'items' => [
            ['name' => 'Cloud Hosting', 'qty' => 1, 'rate' => 150, 'total' => 150],
        ],
        'subtotal' => 150,
        'total_amount' => 150,
        'paid_amount' => 0,
        'status' => 'unpaid',
        'metadata' => [
            'ecommerce_order_id' => 'ORD-12345',
            'channel' => 'Shopify Webhook',
        ],
    ]);

    expect($customer->metadata)->toBeArray();
    expect($customer->metadata['erp_id'])->toBe('ERP-9988');

    expect($invoice->metadata)->toBeArray();
    expect($invoice->metadata['ecommerce_order_id'])->toBe('ORD-12345');

    // Test querying by metadata scope
    $foundInvoice = Invoice::whereMetadata('ecommerce_order_id', 'ORD-12345')->first();
    expect($foundInvoice)->not->toBeNull();
    expect($foundInvoice->id)->toBe($invoice->id);
});

test('smartPaginate dynamically supports cursor pagination for invoices', function () {
    $user = User::factory()->create();
    $customer = Customer::create([
        'user_id' => $user->id,
        'name' => 'Acme Inc',
        'phone' => '+15550002',
    ]);

    for ($i = 1; $i <= 5; $i++) {
        Invoice::create([
            'user_id' => $user->id,
            'customer_id' => $customer->id,
            'invoice_number' => "INV-CURSOR-{$i}",
            'invoice_date' => now()->subDays($i),
            'items' => [['name' => 'Service', 'qty' => 1, 'rate' => 100, 'total' => 100]],
            'total_amount' => 100,
            'paid_amount' => 0,
            'status' => 'unpaid',
        ]);
    }

    // Explicit cursor mode
    $cursorResult = $user->invoices()->smartPaginate(2, 'cursor');
    expect($cursorResult)->toBeInstanceOf(CursorPaginator::class);
    expect($cursorResult->perPage())->toBe(2);
    expect($cursorResult->hasMorePages())->toBeTrue();
    expect($cursorResult->nextCursor())->not->toBeNull();
});
