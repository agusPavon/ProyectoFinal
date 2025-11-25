<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cafe>
 */
class CafeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
{
    return [
        'name' => $this->faker->company . ' Café',
        'address' => $this->faker->streetAddress,
        'lat' => $this->faker->latitude(-34.7, -34.5), // ejemplo para AMBA
        'lng' => $this->faker->longitude(-58.5, -58.3),
    ];
}

}
