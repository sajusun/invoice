<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            PlanSeeder::class,
            UserSeeder::class,
            CustomersSeeder::class,
            InvoiceSeeder::class,
            PaymentSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
