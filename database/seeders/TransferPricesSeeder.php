<?php

namespace Database\Seeders;

use App\Models\FirmaProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransferPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        FirmaProduct::where('id', 'like', '%1')
            ->chunkById(200, function ($products) {
                foreach ($products as $product) {
                    $product->linkerProduct()->update(['price' => $product->price, 'quantity' => $product->quantity]);
                }
            });

        FirmaProduct::where('id', 'like', '%3')
            ->chunkById(200, function ($products) {
                foreach ($products as $product) {
                    $product->linkerProduct()->update(['price' => $product->price, 'quantity' => $product->quantity]);
                }
            });

        FirmaProduct::where('id', 'like', '%5')
            ->chunkById(200, function ($products) {
                foreach ($products as $product) {
                    $product->linkerProduct()->update(['price' => $product->price, 'quantity' => $product->quantity]);
                }
            });
    }
}
