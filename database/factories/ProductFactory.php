<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

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
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'category' => $this->faker->randomElement(\App\Enums\ProductCategory::cases()),
            'quantity' => $this->faker->randomNumber(5),
            'price' => $this->faker->randomFloat(2, 0, 999),
            'description' => $this->faker->paragraph(),
            'imagepath' => 'product.svg',
            'merchant_id' => User::factory()->merchant(),
        ];
    }
}
