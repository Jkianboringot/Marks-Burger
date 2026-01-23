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
            ['name' => 'burger', 'price' => 132],
            ['name' => 'footlong', 'price' => 112],
            ['name' => 'drinks', 'price' => 1332]
        ]);
    }
}
