<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customers;

class CustomersSeeder extends Seeder
{
    public function run(): void
    {
        Customers::factory()->count(80)->create();
    }
}
