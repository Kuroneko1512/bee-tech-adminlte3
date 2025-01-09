<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'user_name' => fake()->unique()->userName(),
            'birthday' => fake()->date(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'status' => fake()->randomElement(['active', 'inactive']),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'flag_delete' => 0,
            'reset_password' => null,
            'remember_token' => Str::random(10),
        ];
    }
}
