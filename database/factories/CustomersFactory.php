<?php

namespace Database\Factories;

use App\Models\Customers;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customers>
 */
class CustomersFactory extends Factory
{
    protected $model = Customers::class;

    public function definition(): array
    {
        return [
            'user_id'    => User::first()?->id ?? 1,
            'name'       => $this->faker->company() . ' (' . $this->faker->name() . ')',
            'email'      => $this->faker->unique()->safeEmail(),
            'phone'      => $this->faker->phoneNumber(),
            'address'    => $this->faker->streetAddress() . ', ' . $this->faker->city() . ', ' . $this->faker->stateAbbr(),
            'created_at' => $this->faker->dateTimeBetween('-5 months', 'now'),
            'updated_at' => now(),
        ];
    }
}
