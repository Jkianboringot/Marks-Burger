<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ingredient::insert([
            [
                'name' => 'patty',
                'unit_quantity' => 132,
                'threshold' => 4,
                'category_id' => 1,
                'unit_id' => 1
            ],
            [
                'name' => 'buns',
                'unit_quantity' => 112,
                'threshold' => 4,
                'category_id' => 1,
                'unit_id' => 1
            ],
            [
                'name' => 'cheese',
                'unit_quantity' => 1332,
                'threshold' => 4,
                'category_id' => 1,
                'unit_id' => 1
            ]
        ]);
    }
}
