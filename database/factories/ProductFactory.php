<?php

namespace Database\Factories;

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
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(),
            'category' => 'object',
            'quantity' => 15,
            'price' => 23.45,//$this->faker->float(),
            'description' => $this->faker->paragraph(),
            'imagepath' => '/fake.png'
        ];
    }
}
