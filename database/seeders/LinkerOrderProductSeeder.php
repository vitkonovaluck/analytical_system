<?php

namespace Database\Seeders;

use App\Models\LinkerOrderProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LinkerOrderProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LinkerOrderProduct::factory()->count(1000)->create();
    }
}
