<?php

namespace Database\Factories;

use App\Models\Sampah;
use Illuminate\Database\Eloquent\Factories\Factory;

class SampahFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sampah::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->word,
            'harga_per_kg' => $this->faker->numberBetween(1000, 10000),
        ];
    }
}

