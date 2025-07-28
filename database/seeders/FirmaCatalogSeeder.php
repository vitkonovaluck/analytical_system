<?php

namespace Database\Seeders;

use App\Models\FirmaCatalog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FirmaCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FirmaCatalog::factory()->count(50)->create();
    }
}
