<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice_Items>
 */
class Invoice_ItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $qty = rand(1, 5);
        $price = rand(100, 500);
        $total = $qty * $price;

        return [
            'invoice_number' => null,
            'name' => $this->faker->sentence(3),
            'qty' => $qty,
            'rate' => $price,
        ];
    }
}
