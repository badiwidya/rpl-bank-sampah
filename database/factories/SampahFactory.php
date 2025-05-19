<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sampah>
 */
class SampahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->unique()->word(),
            'harga_per_kg' => fake()->randomFloat(2, 3, 5),
            'image_url' => fake()->image(dir: null, width: 480, height: 480)
        ];
    }
}
