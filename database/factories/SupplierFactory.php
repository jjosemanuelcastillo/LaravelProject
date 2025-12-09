<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),              // nombre de empresa
            'email' => $this->faker->companyEmail(),        // correo corporativo
            'phone' => $this->faker->phoneNumber(),         // teléfono aleatorio
            'address' => $this->faker->address(),           // dirección completa
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
