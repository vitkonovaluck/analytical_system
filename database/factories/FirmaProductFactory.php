<?php

namespace Database\Factories;

use App\Models\FirmaCatalog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FirmaProduct>
 */
class FirmaProductFactory extends Factory
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
            'name' => 'Firma Product '.$id++,
            'sku' => 'SKU-' . now()->format('YmdHis') . $this->faker->unique()->numberBetween(1, 999999),
            'ean' => $this->faker->unique()->numerify('#############'),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'quantity' => $this->faker->numberBetween(0, 100),
            'catalog_id' => FirmaCatalog::inRandomOrder()->first()->id,
        ];
    }
}
