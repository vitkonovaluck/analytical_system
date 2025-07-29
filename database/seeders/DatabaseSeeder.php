<?php

namespace Database\Seeders;

use App\Models\FirmaProduct;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            FirmaCatalogSeeder::class,
            FirmaProductSeeder::class,
            LinkerProductSeeder::class,
            LinkerOrderSeeder::class,
            LinkerOrderProductSeeder::class,
            TransferPricesSeeder::class,
        ]);


    }
}
