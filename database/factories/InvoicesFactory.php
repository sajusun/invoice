<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvoicesFactory extends Factory
{
    public function definition(): array
    {
        $subTotal = $this->faker->randomFloat(2, 50, 500);
        $tax = $subTotal * 0.10; // 10% VAT
        $total = $subTotal + $tax;

        return [
            'invoice_number' => 'INV-' . $this->faker->unique()->numerify('####'),
            'customer_id' => null, // will be set in seeder
            'invoice_date' => $this->faker->date(),
            'user_id' => 1,
            'items'=>json_encode($this->items()),
            'status' => $this->faker->randomElement(['paid', 'unpaid', 'overdue']),
            'paid_amount' => $subTotal,
            'tax_amount' => $tax,
            'total_amount' => $total,
        ];
    }
      function items(){
        $qty = rand(1, 5);
        $price = rand(100, 500);
        $total = $qty * $price;

        return [
            'description' => $this->faker->sentence(3),
            'quantity' => $qty,
            'price' => $price,
        ];
    }
}
