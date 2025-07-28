<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LinkerOrder>
 */
class LinkerOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'source' => $this->faker->randomElement(['rozetka', 'prom', 'hotline', 'allo']),
            'total' => $this->faker->randomFloat(2, 100, 5000),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
