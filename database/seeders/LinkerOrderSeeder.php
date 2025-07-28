<?php

namespace Database\Seeders;

use App\Models\LinkerOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LinkerOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LinkerOrder::factory()->count(200)->create();
    }
}
