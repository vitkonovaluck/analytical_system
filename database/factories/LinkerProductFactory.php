<?php

namespace Database\Factories;

use App\Models\FirmaProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LinkerProduct>
 */
class LinkerProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $id = 1;
        return [
            'name' => 'Linker Product '.$id++,
            'sku' => 'LNK-' . now()->format('YmdHis') . $this->faker->unique()->numberBetween(1000, 99999),
            'ean' => $this->faker->unique()->numerify('#############'),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'quantity' => $this->faker->numberBetween(0, 100),
            'firma_product_id' => $id,
        ];
    }
}
