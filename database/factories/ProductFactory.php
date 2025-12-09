<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true), // Ej: "Smart Watch"
            'description' => $this->faker->sentence(10),
            'image' => 'https://picsum.photos/seed/' . $this->faker->unique()->word() . '/300/200',
            'price' => $this->faker->randomFloat(2, 5, 500), // entre 5 y 500 €
            'stock_quantity' => $this->faker->numberBetween(1, 100),
            'category_id' => $this->faker->numberBetween(1, 5),
            'supplier_id' => $this->faker->numberBetween(1, 5),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
