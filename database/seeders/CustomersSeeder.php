<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customers;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Customers::factory()->count(120)->create();
    }
}
