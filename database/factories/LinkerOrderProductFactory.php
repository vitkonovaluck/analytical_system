<?php

namespace Database\Factories;

use App\Models\LinkerOrder;
use App\Models\LinkerProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LinkerOrderProduct>
 */
class LinkerOrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => LinkerOrder::inRandomOrder()->first()->id,
            'product_id' => LinkerProduct::inRandomOrder()->first()->id,
            'price' => $this->faker->randomFloat(2, 10, 500),
            'quantity' => $this->faker->numberBetween(1, 5),
        ];
    }
}
