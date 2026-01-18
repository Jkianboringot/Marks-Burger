<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            ['name' => 'burger', 'unit_cost' => 132, 'description' => 'good shit'],
            ['name' => 'footlong', 'unit_cost' => 112, 'description' => 'good shit'],
            ['name' => 'drinks', 'unit_cost' => 1332, 'description' => 'good shit']
        ]);
    }
}
