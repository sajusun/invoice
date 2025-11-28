<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customers;
use App\Models\Invoice_Items;
use App\Models\Invoices;
use Database\Factories\Invoice_ItemsFactory;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customers::all();

        foreach ($customers as $customer) {
            Invoices::factory()
                ->count(rand(2,5))
                ->create([
                    'customer_id' => $customer->id,
                ]);
        }
    }

}
