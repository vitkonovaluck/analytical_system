<?php

namespace Database\Seeders;

use App\Models\FirmaProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FirmaProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FirmaProduct::factory()->count(1000)->create();
    }
}
