<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
            'social_login'      => 0,
            'plan_id'           => null,
            'expires_at'        => null,
            'created_at'        => fake()->dateTimeBetween('-6 months', 'now'),
            'updated_at'        => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Assign a specific plan to the user.
     */
    public function withPlan(string $planType = 'premium'): static
    {
        return $this->state(function (array $attributes) use ($planType) {
            $plan = Plan::where('type', $planType)->first();
            return [
                'plan_id'    => $plan?->id,
                'expires_at' => $plan && $plan->price > 0 ? now()->addDays(365) : null,
            ];
        });
    }
}
