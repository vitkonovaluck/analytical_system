<?php

namespace Database\Seeders;

use App\Models\LinkerProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LinkerProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LinkerProduct::factory()->count(900)->create();
    }
}
