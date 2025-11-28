<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class CustomersFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->name(),
            'email'       => $this->faker->unique()->safeEmail(),
            'phone'       => $this->faker->phoneNumber(),
            'address'     => $this->faker->address(),
            'user_id'     => 1,
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
