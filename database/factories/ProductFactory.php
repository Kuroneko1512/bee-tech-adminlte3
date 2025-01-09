<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'sku' => fake()->unique()->bothify('SKU-####-????'),
            'name' => fake()->word(),
            'stock' => fake()->numberBetween(0, 1000),
            'avatar' => fake()->imageUrl(),
            'expired_date' => fake()->dateTimeBetween('now', '+2 years'),
            'category_id' => ProductCategory::inRandomOrder()->first()->id,
            'flag_delete' => 0,
        ];
    }
}
