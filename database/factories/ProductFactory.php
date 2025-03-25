<?php

namespace Database\Factories;

use App\Models\Category;
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
            'name' => fake()->name(),
            'category_id' => rand(1, 40),
            'sku' => 'SKU-' . rand(0, 10000),
            'description' => fake()->text(),
            'cost_price' => rand(1, 500),
            'selling_price' => rand(200, 20000),
            'stock' => rand(1, 1000),
        ];
    }
}