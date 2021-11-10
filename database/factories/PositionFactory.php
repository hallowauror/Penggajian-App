<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Position;

class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Position::class;

    public function definition()
    {
        return [
            'slug' => $this->faker->slug(),
            'jabatan' => $this->faker->jobTitle(),
            'gaji_pokok' => $this->faker->numberBetween($min = 100000, $max = 1000000),
            'tunjangan' => $this->faker->numberBetween($min = 100000, $max = 1000000)
        ];
    }
}
